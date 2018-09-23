<?php

namespace Fully\Repositories\TagRealEstale;

use Fully\Services\Cache\CacheInterface;

/**
 * Class CacheDecorator.
 *
 * @author TDH <taduyhieucntt98@gmail.com>
 */
class CacheDecorator extends AbstractTagRealEstaleDecorator
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
    protected $cacheKey = 'tagRealEstale';

    /**
     * @param TagRealEstaleInterface $tagRealEstale
     * @param CacheInterface $cache
     */
    public function __construct(TagRealEstaleInterface $tagRealEstale, CacheInterface $cache)
    {
        parent::__construct($tagRealEstale);
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

        $tagRealEstale = $this->tagRealEstale->find($id);

        $this->cache->put($key, $tagRealEstale);

        return $tagRealEstale;
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

        $tagRealEstale = $this->tagRealEstale->getBySlug($slug);

        $this->cache->put($key, $tagRealEstale);

        return $tagRealEstale;
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

        $tagRealEstales = $this->tagRealEstale->all();

        $this->cache->put($key, $tagRealEstales);

        return $tagRealEstales;
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

        $paginated = $this->tagRealEstale->paginate($page, $limit, $all);

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
