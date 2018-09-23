<?php

namespace Fully\Repositories\Categories;

/**
 * Class AbstractCategoriesDecorator.
 *
 * @author TDH <taduyhieucntt98@gmail.com>
 */
abstract class AbstractCategoriesDecorator implements CategoriesInterface
{
    /**
     * @var CategoryInterface
     */
    protected $category;

    /**
     * @param CategoryInterface $category
     */
    public function __construct(CategoriesInterface $category)
    {
        $this->category = $category;
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function find($id)
    {
        return $this->category->find($id);
    }

    /**
     * @return mixed
     */
    public function all()
    {
        return $this->category->all();
    }

    /**
     * @param int  $page
     * @param int  $limit
     * @param bool $all
     *
     * @return mixed
     */
    public function paginate($page = 1, $limit = 10, $all = false)
    {
        return $this->category->paginate($page = 1, $limit = 10, $all = false);
    }


    /**
    * @param $id
    *
    * @return bool
    */
    public function hasChildItems($id)
    {
        $this->category->hasChildItems($id);
    }
}
