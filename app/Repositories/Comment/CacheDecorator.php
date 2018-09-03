<?php

namespace Fully\Repositories\Comment;

use Fully\Services\Cache\CacheInterface;

/**
 * Class CacheDecorator.
 *
 * @author THC <thanhhaconnection@gmail.com>
 */
class CacheDecorator extends AbstractCommentDecorator
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
    protected $cacheKey = 'comment';

    /**
     * @param CommentInterface $comment
     * @param CacheInterface $cache
     */
    public function __construct(CommentInterface $comment, CacheInterface $cache)
    {
        parent::__construct($comment);
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

        $comment = $this->comment->find($id);

        $this->cache->put($key, $comment);

        return $comment;
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

        $comment = $this->comment->getBySlug($slug);

        $this->cache->put($key, $comment);

        return $comment;
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

        $comments = $this->comment->all();

        $this->cache->put($key, $comments);

        return $comments;
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

        $paginated = $this->comment->paginate($page, $limit, $all);

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
