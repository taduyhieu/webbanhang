<?php

namespace Fully\Repositories\SaleOfff;

use Config;
use Response;
use Fully\Models\SaleOfff;
use Fully\Models\Product;
use Fully\Models\NewsCate;
use Fully\Repositories\RepositoryAbstract;
use Fully\Repositories\CrudableInterface;
use Fully\Exceptions\Validation\ValidationException;


/**
 * Class CategoryRepository.
 *
 * @author TDH <taduyhieucntt98@gmail.com>
 */
class SaleOfffRepository extends RepositoryAbstract implements SaleOfffInterface, CrudableInterface {

    /**
     * @var
     */
    protected $perPage;

    /**
     * @var \Category
     */
    protected $category;

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
    public function __construct(SaleOfff $category) {
        $this->category = $category;
        $config = Config::get('fully');
        $this->perPage = $config['per_page'];
    }

    /**
     * @return mixed
     */
    public function all() {
        return $this->category->where('lang', $this->getLang())->get();
    }

    public function getCategory($id) {
        return $this->category->where('lang', $this->getLang())->Where('id', $id)->first();
    }

    public function getCategoryAll() {
        return $this->category->where('lang', $this->getLang())->where('cat_parent_id', 0)->where('status', 1)->select('id', 'name')->get();
    }

    public function getCatParent() {
        return $this->category->where('cat_parent_id', 0)->select('id', 'title')->get();
    }

    public function getCatSub($cat_parent_id) {
        return $this->category->where('cat_parent_id', $cat_parent_id)->select('id', 'name')->get();
    }

    public function searchCatByName($searchTitle) {
        return $this->category->where('name', 'like', '%' . $searchTitle . '%')->orderBy('cat_parent_id')
                        ->paginate(10);
    }

    public function getNewsByCategory($cat_id) {
        $cate = Category::find($cat_id);
        $cate->news = $cate->getNews;
        return $cate;
    }

    public function getLastNewsByCategory($cat_id) {
        $cate = Category::find($cat_id);
        $lastNews = $cate->getNews()->orderBy('news_publish_date', 'desc')->take(3)->offset(0)->get();
        return $lastNews;
    }

    public function getNewsByCate($slug) {
        $catBySlug = Category::where('slug', $slug)->first();

        // news cate show
        $newsCate = null;
        $listNewsCate = NewsCate::where('cat_id', $catBySlug->id)->orderBy('order', 'ASC')->where('show_type', 1)->take(2)->offset(0)->get();
        foreach ($listNewsCate as $newsTop) {
            $newsTop->news_title = $newsTop->getNews->news_title;
            $newsTop->news_content = $newsTop->getNews->news_content;
            $newsTop->news_sapo = $newsTop->getNews->news_sapo;
            $newsTop->slug = $newsTop->getNews->slug;
            $newsTop->news_image = $newsTop->getNews->news_image;
        }
        if ($listNewsCate->count() >= 1) {
            $newsCate = $listNewsCate[0];
            $newsCate->subNews = $listNewsCate[1];
            unset($listNewsCate[0]);
            unset($listNewsCate[1]);
        }

        $newsByCat = $catBySlug->getNews()->orderBy('news_publish_date', 'DESC')->paginate(9);
        $newsByCatAll = [];
        $newsByCatAll[0] = $newsCate;
        $newsByCatAll[1] = $newsByCat;
        $newsByCatAll[2] = $catBySlug;
        return $newsByCatAll;
    }

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

        $query = $this->category;

        $categories = $query->skip($limit * ($page - 1))->take($limit)->where('lang', $this->getLang())->get();

        $result->totalItems = $this->totalCategories();
        $result->items = $categories->all();

        return $result;
    }

    /**
     * @return mixed
     */
    public function lists() {
        return $this->category->where('lang', $this->getLang())->lists('name', 'id');
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function find($id) {
        return $this->category->find($id);
    }

    /**
     * @param $slug
     *
     * @return mixed
     */
    public function getNewsBySlug($slug) {
        return $this->category->where('slug', $slug)->where('lang', $this->getLang())->first()->news()->paginate($this->perPage);
    }

    /**
     * @param $slug
     *
     * @return mixed
     */
    public function getBySlug($slug) {
        return $this->category->where('slug', $slug)->first();
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
            $this->category->lang = $this->getLang();
            $this->category->fill($attributes)->save();
            $this->category->resluggify();

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
        $this->category = $this->find($id);

        if ($this->isValid($attributes)) {
            $this->category->fill($attributes);
            $this->category->resluggify();
            $this->category->save();
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
        $this->category = $this->category->find($id);
        // $this->category->articles()->delete($id);
        $this->category->delete();
    }

    /**
     * Get total category count.
     *
     * @return mixed
     */
    protected function totalCategories() {
        return $this->category->where('lang', $this->getLang())->count();
    }

    /**
     * @param $id
     *
     * @return bool
     */
    public function hasChildItems($id) {
        $count = $this->category->where('cat_parent_id', $id)->where('lang', $this->getLang())->get()->count();
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
        $category = $this->category->find($id);
        $category->status = ($category->status) ? false : true;
        $category->save();

        return Response::json(array('result' => 'success', 'changed' => ($category->status) ? 1 : 0));
    }

    public function getFirstCategory($limit) {
        return $this->category->orderBy('order', 'ASC')->where('lang', $this->getLang())->take($limit)->offset(0)->get();
    }

    public function getCategoryByParentId($id1, $id2) {
        $products = Product::where('agency_product_id', $id1)->where('product_categories_id', $id2)->get();
        $saleoffs = DB::table('saleoff_product')->get();
        $saleoffList = DB::table('saleofff')->get();
        foreach ($products as $product) {
            // $check = false;
            foreach ($saleoffs as $saleoff) {
                if ($product->id == $saleoff->id_product) {
                    // $check = true;
                    $product->start_date = $saleoff->start_date;
                    $product->end_date = $saleoff->end_date;
                    $product->percent_sale_off = $saleoff->percent_sale_off;
                    $product->status = $saleoff->status;
                }
            }
            // if ($check == false) {
            //     $product->start_date = null;
            //     $product->end_date = null;
            //     $product->percent_sale_off = null;
            //     $product->status = null;
            // }
        }
        return Response::json($products);
    }

}
