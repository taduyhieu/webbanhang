<?php

namespace Fully\Repositories\Agencies;

/**
 * Class AbstractCategoriesDecorator.
 *
 * @author TDH <taduyhieucntt98@gmail.com>
 */
abstract class AbstractAgenciesDecorator implements AgenciesInterface
{
    /**
     * @var CategoryInterface
     */
    protected $product;

    /**
     * @param CategoryInterface $category
     */
    public function __construct(AgenciesInterface $product)
    {
        $this->product = $product;
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function find($id)
    {
        return $this->product->find($id);
    }

    /**
     * @return mixed
     */
    public function all()
    {
        return $this->product->all();
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
        return $this->product->paginate($page = 1, $limit = 10, $all = false);
    }


    /**
    * @param $id
    *
    * @return bool
    */
    public function hasChildItems($id)
    {
        $this->product->hasChildItems($id);
    }
}
