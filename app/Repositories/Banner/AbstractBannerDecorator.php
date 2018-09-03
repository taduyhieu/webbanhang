<?php

namespace Fully\Repositories\Banner;

/**
 * Class AbstractBannerDecorator.
 *
 * @author THC <thanhhaconnection@gmail.com>
 */
abstract class AbstractBannerDecorator implements BannerInterface
{
    /**
     * @var BannerInterface
     */
    protected $banner;

    /**
     * @param BannerInterface $banner
     */
    public function __construct(BannerInterface $banner)
    {
        $this->banner = $banner;
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function find($id)
    {
        return $this->banner->find($id);
    }

    /**
     * @param $slug
     *
     * @return mixed
     */
    public function getBySlug($slug)
    {
        return $this->banner->getBySlug($slug);
    }

    /**
     * @return mixed
     */
    public function all()
    {
        return $this->banner->all();
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
        return $this->banner->paginate($page, $limit, $all);
    }
}
