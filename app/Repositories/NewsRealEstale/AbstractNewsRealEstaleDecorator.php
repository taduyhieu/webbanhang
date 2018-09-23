<?php

namespace Fully\Repositories\NewsRealEstale;

/**
 * Class AbstractNewsRealEstaleDecorator.
 *
 * @author TDH <taduyhieucntt98@gmail.com>
 */
abstract class AbstractNewsRealEstaleDecorator implements NewsRealEstaleInterface
{
    /**
     * @var NewsRealEstaleInterface
     */
    protected $newsRealEstale;

    /**
     * @param NewsRealEstaleInterface $newsRealEstale
     */
    public function __construct(NewsRealEstaleInterface $newsRealEstale)
    {
        $this->newsRealEstale = $newsRealEstale;
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function find($id)
    {
        return $this->newsRealEstale->find($id);
    }

    /**
     * @param $slug
     *
     * @return mixed
     */
    public function getBySlug($slug)
    {
        return $this->newsRealEstale->getBySlug($slug);
    }

    /**
     * @return mixed
     */
    public function all()
    {
        return $this->newsRealEstale->all();
    }

    /**
     * @param null $perPage
     * @param bool $all
     *
     * @return mixed
     */
    public function paginate($page = 1, $limit = 10, $all = false)
    {
        return $this->newsRealEstale->paginate($page, $limit, $all);
    }
}
