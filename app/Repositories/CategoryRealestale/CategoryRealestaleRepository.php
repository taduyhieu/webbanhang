<?php

namespace Fully\Repositories\CategoryRealestale;

use Config;
use Fully\Models\CategoryRealestale;
use Fully\Repositories\CrudableInterface;
use Fully\Repositories\RepositoryAbstract;
use Fully\Exceptions\Validation\ValidationException;

/**
 * Class CategoryRealestaleRepository.
 *
 * @author TDH <taduyhieucntt98@gmail.com>
 */
class CategoryRealestaleRepository extends RepositoryAbstract implements CategoryRealestaleInterface, CrudableInterface {

    /**
     * @var
     */
    protected $perPage;

    /**
     * @var \CategoryRealestale
     */
    protected $categoryReal;

    /**
     * Rules.
     *
     * @var array
     */
    protected static $rules = [
    ];

    /**
     * @param CategoryRealestale $categoryReal
     */
    public function __construct(CategoryRealestale $categoryReal) {
        $this->categoryReal = $categoryReal;
        $config = Config::get('fully');
        $this->perPage = $config['per_page'];
    }

    /**
     * @return mixed
     */
    public function all() {
        return $this->categoryReal->get();
    }

    /**
     * Get paginated categoryReals.
     *
     * @param int  $page  Number of categoryReals per page
     * @param int  $limit Results per page
     * @param bool $all   Show published or all
     *
     * @return StdClass Object with $items and $totalItems for pagination
     */
    public function paginate($page = 1, $limit = 10, $all = false, $notLazy = false) {
        $result = new \StdClass();
        $result->page = $page;
        $result->limit = $limit;
        $result->totalItems = 0;
        $result->items = array();

        $query = $this->categoryReal->orderBy('created_at', 'DESC')->where('lang', $this->getLang());

        $categoryReals = $query->skip($limit * ($page - 1))
                ->take($limit)
                ->get();

        $result->totalItems = $this->totalCategoryReals();
        $result->items = $categoryReals->all();

        return $result;
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function find($id) {
        $this->categoryReal = $this->categoryReal->findOrFail($id);

        return $this->categoryReal;
    }

    public function getCategoryParent($parent_id) {
        if ($parent_id > 0) {
            $cateParent = $this->categoryReal->where('id', $parent_id)->first();
        } else {
            $cateParent = null;
        }
        return $cateParent;
    }

    /**
     * @param $attributes
     *
     * @return bool|mixed
     *
     * @throws \Fully\Exceptions\Validation\ValidationException
     */
    public function create($attributes) {
        if (isset($attributes)) {
            $this->categoryReal->lang = $this->getLang();
            $this->categoryReal->fill($attributes)->save();

            return true;
        }

        throw new ValidationException('CategoryReal validation failed', $this->getErrors());
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
        $this->categoryReal = $this->find($id);

        if (isset($attributes)) {
            $catReal = $this->categoryReal->fill($attributes);
            $catReal->resluggify();
            $catReal->save();
            return true;
        }

        throw new ValidationException('CategoryReal validation failed', $this->getErrors());
    }

    /**
     * @param $id
     *
     * @return mixed|void
     */
    public function delete($id) {
        $cat_real = $this->categoryReal->find($id);
        $cat_real->delete();
    }

    /**
     * Get total categoryReal count.
     *
     * @return mixed
     */
    protected function totalCategoryReals() {
        return $this->categoryReal->where('lang', $this->getLang())->count();
    }

    // Cần mua, cần bán
    public function getCategoryRealestaleLimit() {
        return $this->categoryReal->orderBy('id', 'ASC')->take(2)->offset(0)->select('id', 'name')->get();
    }

    // Cần thuê
    public function getCategoryRealestaleNeedHire() {
        return $this->categoryReal->orderBy('id', 'ASC')->take(1)->offset(3)->select('id', 'name')->first();
    }
    
    // Cho thuê
    public function getCategoryRealestaleHire() {
        return $this->categoryReal->orderBy('id', 'ASC')->take(1)->offset(2)->select('id', 'name')->first();
    }

    public function getCategoryRealEstaleAll() {
        return $this->categoryReal->where('lang', $this->getLang())->select('id', 'name')->get();
    }

}
