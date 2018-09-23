<?php

namespace Fully\Repositories\Tag;

/**
 * Class AbstractTagDecorator.
 *
 * @author TDH <taduyhieucntt98@gmail.com>
 */
abstract class AbstractTagDecorator implements TagInterface
{
    /**
     * @var TagInterface
     */
    protected $tag;

    /**
     * @param TagInterface $tag
     */
    public function __construct(TagInterface $tag)
    {
        $this->tag = $tag;
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function find($id)
    {
        return $this->tag->find($id);
    }

    /**
     * @param $slug
     *
     * @return mixed
     */
    public function getBySlug($slug)
    {
        return $this->tag->getBySlug($slug);
    }

    /**
     * @return mixed
     */
    public function all()
    {
        return $this->tag->all();
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
        return $this->tag->paginate($page, $limit, $all);
    }
}
