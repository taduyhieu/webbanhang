<?php

namespace Fully\Repositories\Categories;

use Fully\Services\Cache\CacheInterface;

/**
 * Class CacheDecorator.
 *
 * @author TDH <taduyhieucntt98@gmail.com>
 */
class CacheDecorator extends AbstractCategoriesDecorator
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
    protected $cacheKey = 'category';

    /**
     * @param CategoryInterface $category
     * @param CacheInterface    $cache
     */
    public function __construct(CategoriesInterface $category, CacheInterface $cache)
    {
        parent::__construct($category);
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

        $category = $this->category->find($id);

        $this->cache->put($key, $category);

        return $category;
    }

    /**
     * @return mixed
     */
    public function all()
    {
        $key = md5(getLang().$this->cacheKey.'.all.categories');

        if ($this->cache->has($key)) {
            return $this->cache->get($key);
        }

        $categories = $this->category->all();

        $this->cache->put($key, $categories);

        return $categories;
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
        $allkey = ($all) ? '.all' : '';
        $key = md5(getLang().$this->cacheKey.'.page.'.$page.'.'.$limit.$allkey);

        if ($this->cache->has($key)) {
            return $this->cache->get($key);
        }

        $paginated = $this->category->paginate($page, $limit, $all);
        $this->cache->put($key, $paginated);

        return $paginated;
    }

    /**
     * @param $slug
     *
     * @return mixed
     */
    public function getArticlesBySlug($slug)
    {
        return $this->category->getArticlesBySlug($slug);
    }

    /**
     * @param $id
     *
     * @return bool|mixed
     */
    public function hasChildItems($id)
    {
        $key = md5(getLang().$this->cacheKey.$id.'.has.child');

        if ($this->cache->has($key)) {
            return $this->cache->get($key);
        }

        $result = $this->category->hasChildItems($id);
        $this->cache->put($key, $result);

        return $result;
    }
}
