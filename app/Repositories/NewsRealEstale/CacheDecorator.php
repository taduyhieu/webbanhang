<?php

namespace Fully\Repositories\NewsRealEstale;

use Fully\Services\Cache\CacheInterface;

/**
 * Class CacheDecorator.
 *
 * @author TDH <taduyhieucntt98@gmail.com>
 */
class CacheDecorator extends AbstractNewsRealEstaleDecorator
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
    protected $cacheKey = 'newsRealEstale';

    /**
     * @param NewsInterface  $news
     * @param CacheInterface $cache
     */
    public function __construct(NewsRealEstaleInterface $newsRealEstale, CacheInterface $cache)
    {
        parent::__construct($newsRealEstale);
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

        $newsRealEstale = $this->newsRealEstale->find($id);

        $this->cache->put($key, $newsRealEstale);

        return $newsRealEstale;
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

        $newsRealEstale = $this->newsRealEstale->getBySlug($slug);

        $this->cache->put($key, $newsRealEstale);

        return $newsRealEstale;
    }

    /**
     * @return mixed
     */
    public function all()
    {
        $key = md5(getLang().$this->cacheKey.'.all.newsRealEstale');

        if ($this->cache->has($key)) {
            return $this->cache->get($key);
        }

        $newsRealEstales = $this->newsRealEstale->all();

        $this->cache->put($key, $newsRealEstales);

        return $newsRealEstales;
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
        $key = md5(getLang().$this->cacheKey.'page.'.$page.'.'.$limit.$allkey);

        if ($this->cache->has($key)) {
            return $this->cache->get($key);
        }

        $paginated = $this->newsRealEstale->paginate($page, $limit, $all);

        $this->cache->put($key, $paginated);

        return $paginated;
    }

    /**
     * @param $limit
     *
     * @return mixed
     */
    public function getLastNewsRealEstale($limit)
    {
        $key = md5(getLang().$limit.$this->cacheKey.'newsRealEstale');

        if ($this->cache->has($key)) {
            return $this->cache->get($key);
        }

        $newsRealEstale = $this->newsRealEstale->getLastNewsRealEstale($limit);

        $this->cache->put($key, $newsRealEstale);

        return $newsRealEstale;
    }
}
