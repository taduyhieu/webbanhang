<?php

namespace Fully\Repositories\CategoryRealestaleInterface;

use Fully\Services\Cache\CacheInterface;

/**
 * Class CacheDecorator.
 *
 * @author TDH <taduyhieucntt98@gmail.com>
 */
class CacheDecorator extends AbstractCategoryRealestaleInterfaceDecorator
{
    /**
     * @var \Fully\Services\Cache\CacheInterface
     */
    protected $cache;

    /**
     * Cache key.
     *
     * @var string
     */
    protected $cacheKey = 'categoryReal';

    /**
     * @param CategoryRealestaleInterface $categoryReal
     * @param CacheInterface $cache
     */
    public function __construct(CategoryRealestaleInterfaceInterface $categoryReal, CacheInterface $cache)
    {
        parent::__construct($video);
        $this->cache = $cache;
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function find($id)
    {
        $key = md5(getLang().$this->cacheKey.'.id.'.$id);

        if ($this->cache->has($key)) {
            return $this->cache->get($key);
        }

        $categoryReal = $this->categoryReal->find($id);

        $this->cache->put($key, $categoryReal);

        return $categoryReal;
    }

    /**
     * @param $slug
     *
     * @return mixed
     */
    public function getBySlug($slug)
    {
        $key = md5(getLang().$this->cacheKey.'.slug.'.$slug);

        if ($this->cache->has($key)) {
            return $this->cache->get($key);
        }

        $categoryReal = $this->categoryReal->getBySlug($slug);

        $this->cache->put($key, $categoryReal);

        return $categoryReal;
    }

    /**
     * @return mixed
     */
    public function all()
    {
        $key = md5(getLang().$this->cacheKey.'.all.videos');

        if ($this->cache->has($key)) {
            return $this->cache->get($key);
        }

        $categoryReals = $this->categoryReal->all();

        $this->cache->put($key, $categoryReals);

        return $categoryReals;
    }

    /**
     * @param null $page
     * @param bool $all
     *
     * @return mixed
     */
    public function paginate($page = 1, $limit = 10, $all = false)
    {
        $allkey = ($all) ? '.all' : '';
        $key = md5(getLang().$this->cacheKey.'.page.'.$page.'.'.$limit.$allkey);

        if ($this->cache->has($key)) {
            return $this->cache->get($key);
        }

        $paginated = $this->categoryReal->paginate($page, $limit, $all);

        $this->cache->put($key, $paginated);

        return $paginated;
    }

    /**
     * @param $tag
     *
     * @return mixed|void
     */
    public function findByTag($tag)
    {
    }
}
