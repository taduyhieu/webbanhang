<?php

namespace Fully\Repositories\CategoryRealestale;

/**
 * Class AbstractCategoryRealestaleDecorator.
 *
 * @author THC <thanhhaconnection@gmail.com>
 */
abstract class AbstractCategoryRealestaleDecorator implements CategoryRealestaleInterface
{
    /**
     * @var CategoryRealestaleInterface
     */
    protected $categoryReal;

    /**
     * @param CategoryRealestaleInterface $categoryReal
     */
    public function __construct(CategoryRealestaleInterface $categoryReal)
    {
        $this->categoryReal = $categoryReal;
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function find($id)
    {
        return $this->categoryReal->find($id);
    }

    /**
     * @param $slug
     *
     * @return mixed
     */
    public function getBySlug($slug)
    {
        return $this->categoryReal->getBySlug($slug);
    }

    /**
     * @return mixed
     */
    public function all()
    {
        return $this->categoryReal->all();
    }

    /**
     * Paginator
     * @param int $page
     * @param int $limit
     * @param bool $all
     * @return mixed
     */
    public function paginate($page = 1, $limit = 10, $all = false)
    {
        return $this->categoryReal->paginate($page, $limit, $all);
    }
}
