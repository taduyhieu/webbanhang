<?php

namespace Fully\Repositories\Categories;

use Config;
use Fully\Models\Product;
use Fully\Models\NewsCate;
use Fully\Repositories\RepositoryAbstract;
use Fully\Repositories\CrudableInterface;
use Fully\Exceptions\Validation\ValidationException;
use Response;

/**
 * Class CategoryRepository.
 *
 * @author TDH <taduyhieucntt98@gmail.com>
 */
class ProductRepository extends RepositoryAbstract implements ProductInterface, CrudableInterface {

    /**
     * @var
     */
    protected $perPage;

    /**
     * @var \Category
     */
    protected $product;

    /**
     * Rules.
     *
     * @var array
     */
    protected static $rules = [
    ];

    /**
     * @param Category $category
     */
    public function __construct(Product $product) {
        $this->product = $product;
        $config = Config::get('fully');
        $this->perPage = $config['per_page'];
    }

    /**
     * @return mixed
     */
    public function all() {
        return $this->product->where('lang', $this->getLang())->get();
    }

    public function getCategory($id) {
        return $this->product->where('lang', $this->getLang())->Where('id', $id)->first();
    }

    public function getCategoryAll() {
        return $this->product->where('lang', $this->getLang())->where('cat_parent_id', 0)->where('status', 1)->select('id', 'name')->get();
    }

    public function getCatParent() {
        return $this->product->where('cat_parent_id', 0)->select('id', 'title')->get();
    }

    // public function getCatSub($cat_parent_id) {
    //     return $this->category->where('cat_parent_id', $cat_parent_id)->select('id', 'name')->get();
    // }

    // public function searchCatByName($searchTitle) {
    //     return $this->category->where('name', 'like', '%' . $searchTitle . '%')->orderBy('cat_parent_id')
    //                     ->paginate(10);
    // }

    // public function getNewsByCategory($cat_id) {
    //     $cate = Category::find($cat_id);
    //     $cate->news = $cate->getNews;
    //     return $cate;
    // }

    // public function getLastNewsByCategory($cat_id) {
    //     $cate = Category::find($cat_id);
    //     $lastNews = $cate->getNews()->orderBy('news_publish_date', 'desc')->take(3)->offset(0)->get();
    //     return $lastNews;
    // }

    // public function getNewsByCate($slug) {
    //     $catBySlug = Category::where('slug', $slug)->first();

    //     // news cate show
    //     $newsCate = null;
    //     $listNewsCate = NewsCate::where('cat_id', $catBySlug->id)->orderBy('order', 'ASC')->where('show_type', 1)->take(2)->offset(0)->get();
    //     foreach ($listNewsCate as $newsTop) {
    //         $newsTop->news_title = $newsTop->getNews->news_title;
    //         $newsTop->news_content = $newsTop->getNews->news_content;
    //         $newsTop->news_sapo = $newsTop->getNews->news_sapo;
    //         $newsTop->slug = $newsTop->getNews->slug;
    //         $newsTop->news_image = $newsTop->getNews->news_image;
    //     }
    //     if ($listNewsCate->count() >= 1) {
    //         $newsCate = $listNewsCate[0];
    //         $newsCate->subNews = $listNewsCate[1];
    //         unset($listNewsCate[0]);
    //         unset($listNewsCate[1]);
    //     }

    //     $newsByCat = $catBySlug->getNews()->orderBy('news_publish_date', 'DESC')->paginate(9);
    //     $newsByCatAll = [];
    //     $newsByCatAll[0] = $newsCate;
    //     $newsByCatAll[1] = $newsByCat;
    //     $newsByCatAll[2] = $catBySlug;
    //     return $newsByCatAll;
    // }

    /**
     * @param int  $page
     * @param int  $limit
     * @param bool $all
     *
     * @return mixed|\StdClass
     */
    public function paginate($page = 1, $limit = 10, $all = false) {
        $result = new \StdClass();
        $result->page = $page;
        $result->limit = $limit;
        $result->totalItems = 0;
        $result->items = array();

        $query = $this->product;

        $products = $query->skip($limit * ($page - 1))->take($limit)->where('lang', $this->getLang())->get();

        $result->totalItems = $this->totalCategories();
        $result->items = $products->all();

        return $result;
    }

    /**
     * @return mixed
     */
    public function lists() {
        return $this->product->where('lang', $this->getLang())->lists('name', 'id');
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function find($id) {
        return $this->product->findOrFail($id);
    }

    /**
     * @param $slug
     *
     * @return mixed
     */
    public function getNewsBySlug($slug) {
        return $this->product->where('slug', $slug)->where('lang', $this->getLang())->first()->news()->paginate($this->perPage);
    }

    /**
     * @param $slug
     *
     * @return mixed
     */
    public function getBySlug($slug) {
        return $this->product->where('slug', $slug)->first();
    }

    /**
     * @param $attributes
     *
     * @return bool|mixed
     *
     * @throws \Fully\Exceptions\Validation\ValidationException
     */
    public function create($attributes) {
        if ($this->isValid($attributes)) {
            $this->product->lang = $this->getLang();
            $this->product->fill($attributes)->save();

            return true;
        }

        throw new ValidationException('Category validation failed', $this->getErrors());
    }

    /**
     * @param $id
     * @param $attributes
     *
     * @return bool|mixed
     *
     * @throws \Fully\Exceptions\Validation\ValidationException
     */
    public function update($id, $attributes) {
        $this->product = $this->find($id);

        if ($this->isValid($attributes)) {
            $this->product->resluggify();
            $this->product->fill($attributes)->save();

            return true;
        }

        throw new ValidationException('Category validation failed', $this->getErrors());
    }

    /**
     * @param $id
     *
     * @return mixed|void
     */
    public function delete($id) {
        $this->product = $this->product->find($id);
        $this->product->delete();
    }

    /**
     * Get total category count.
     *
     * @return mixed
     */
    protected function totalCategories() {
        return $this->product->where('lang', $this->getLang())->count();
    }

    /**
     * @param $id
     *
     * @return bool
     */
    public function hasChildItems($id) {
        $count = $this->product->where('cat_parent_id', $id)->where('lang', $this->getLang())->get()->count();
        if ($count === 0) {
            return false;
        }

        return true;
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function togglePublish($id) {
        $product = $this->product->find($id);
        $product->status = ($product->status) ? false : true;
        $product->save();

        return Response::json(array('result' => 'success', 'changed' => ($product->status) ? 1 : 0));
    }

    public function getFirstCategory($limit) {
        return $this->caproducttegory->orderBy('order', 'ASC')->where('lang', $this->getLang())->take($limit)->offset(0)->get();
    }

    public function getCategoryByParentId($parent_id) {
        $products = $this->product->where('cat_parent_id', $parent_id)->get();
        return $products;
    }

}
