<?php

namespace Fully\Repositories\SaleOff;

/**
 * Class AbstractCategoriesDecorator.
 *
 * @author TDH <taduyhieucntt98@gmail.com>
 */
abstract class AbstractSaleOffDecorator implements SaleOffInterface
{
    /**
     * @var CategoryInterface
     */
    protected $saleoff;

    /**
     * @param CategoryInterface $category
     */
    public function __construct(SaleOffInterface $saleoff)
    {
        $this->saleoff = $saleoff;
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function find($id)
    {
        return $this->saleoff->find($id);
    }

    /**
     * @return mixed
     */
    public function all()
    {
        return $this->saleoff->all();
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
        return $this->saleoff->paginate($page = 1, $limit = 10, $all = false);
    }


    /**
    * @param $id
    *
    * @return bool
    */
    public function hasChildItems($id)
    {
        $this->saleoff->hasChildItems($id);
    }
}
