<?php

namespace Fully\Repositories\Comment;

/**
 * Class AbstractCommentDecorator.
 *
 * @author TDH <taduyhieucntt98@gmail.com>
 */
abstract class AbstractCommentDecorator implements CommentInterface
{
    /**
     * @var CommentInterface
     */
    protected $comment;

    /**
     * @param CommentInterface $comment
     */
    public function __construct(CommentInterface $comment)
    {
        $this->comment = $comment;
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function find($id)
    {
        return $this->comment->find($id);
    }

    /**
     * @param $slug
     *
     * @return mixed
     */
    public function getBySlug($slug)
    {
        return $this->comment->getBySlug($slug);
    }

    /**
     * @return mixed
     */
    public function all()
    {
        return $this->comment->all();
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
        return $this->comment->paginate($page, $limit, $all);
    }
}
