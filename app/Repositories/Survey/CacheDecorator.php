<?php

namespace Fully\Repositories\Survey;

use Fully\Services\Cache\CacheInterface;

/**
 * Class CacheDecorator.
 *
 * @author THC <thanhhaconnection@gmail.com>
 */
class CacheDecorator extends AbstractSurveyDecorator
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
    protected $cacheKey = 'survey';

    /**
     * @param SurveyInterface  $survey
     * @param CacheInterface $cache
     */
    public function __construct(SurveyInterface $survey, CacheInterface $cache)
    {
        parent::__construct($survey);
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

        $survey = $this->survey->find($id);

        $this->cache->put($key, $survey);

        return $survey;
    }

    /**
     * @return mixed
     */
    public function all()
    {
        $key = md5(getLang().$this->cacheKey.'.all.survey');

        if ($this->cache->has($key)) {
            return $this->cache->get($key);
        }

        $surveys = $this->survey->all();

        $this->cache->put($key, $surveys);

        return $surveys;
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

        $paginated = $this->survey->paginate($page, $limit, $all);

        $this->cache->put($key, $paginated);

        return $paginated;
    }

}
