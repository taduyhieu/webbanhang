<?php

namespace Fully\Repositories\TagRealEstale;

/**
 * Class AbstractTagRealEstaleDecorator.
 *
 * @author THC <thanhhaconnection@gmail.com>
 */
abstract class AbstractTagRealEstaleDecorator implements TagRealEstaleInterface
{
    /**
     * @var TagRealEstaleInterface
     */
    protected $tagRealEstale;

    /**
     * @param TagInterface $tag
     */
    public function __construct(TagRealEstaleInterface $tag)
    {
        $this->tagRealEstale = $tagRealEstale;
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function find($id)
    {
        return $this->tagRealEstale->find($id);
    }

    /**
     * @param $slug
     *
     * @return mixed
     */
    public function getBySlug($slug)
    {
        return $this->tagRealEstale->getBySlug($slug);
    }

    /**
     * @return mixed
     */
    public function all()
    {
        return $this->tagRealEstale->all();
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
        return $this->tagRealEstale->paginate($page, $limit, $all);
    }
}
