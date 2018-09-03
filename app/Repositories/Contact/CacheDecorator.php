<?php

namespace Fully\Repositories\Contact;

use Fully\Services\Cache\CacheInterface;

/**
 * Class CacheDecorator.
 *
 * @author THC <thanhhaconnection@gmail.com>
 */
class CacheDecorator extends AbstractContactDecorator
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
    protected $cacheKey = 'contact';

    /**
     * @param ContactInterface  $contact
     * @param CacheInterface $cache
     */
    public function __construct(ContactInterface $contact, CacheInterface $cache)
    {
        parent::__construct($contact);
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

        $contact = $this->contact->find($id);

        $this->cache->put($key, $contact);

        return $contact;
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

        $contact = $this->contact->getBySlug($slug);

        $this->cache->put($key, $contact);

        return $contact;
    }

    /**
     * @return mixed
     */
    public function all()
    {
        $key = md5(getLang().$this->cacheKey.'.all.contact');

        if ($this->cache->has($key)) {
            return $this->cache->get($key);
        }

        $contacts = $this->contact->all();

        $this->cache->put($key, $contacts);

        return $contacts;
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

        $paginated = $this->contact->paginate($page, $limit, $all);

        $this->cache->put($key, $paginated);

        return $paginated;
    }
}
