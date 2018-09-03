<?php

namespace Fully\Repositories\Author;

use Fully\Services\Cache\CacheInterface;

/**
 * Class CacheDecorator.
 *
 * @author THC <thanhhaconnection@gmail.com>
 */
class CacheDecorator extends AbstractAuthorDecorator
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
    protected $cacheKey = 'author';

    /**
     * @param AuthorInterface  $author
     * @param CacheInterface $cache
     */
    public function __construct(AuthorInterface $author, CacheInterface $cache)
    {
        parent::__construct($author);
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

        $author = $this->author->find($id);

        $this->cache->put($key, $author);

        return $author;
    }

    /**
     * @return mixed
     */
    public function all()
    {
        $key = md5(getLang().$this->cacheKey.'.all.author');

        if ($this->cache->has($key)) {
            return $this->cache->get($key);
        }

        $authors = $this->news->all();

        $this->cache->put($key, $authors);

        return $authors;
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

        $paginated = $this->author->paginate($page, $limit, $all);

        $this->cache->put($key, $paginated);

        return $paginated;
    }

}
