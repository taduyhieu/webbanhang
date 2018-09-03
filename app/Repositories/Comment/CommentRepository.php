<?php

namespace Fully\Repositories\Comment;

use Config;
use Response;
use Carbon\Carbon;
use Fully\Models\Comment;
use Fully\Repositories\CrudableInterface;
use Fully\Repositories\RepositoryAbstract;
use Fully\Exceptions\Validation\ValidationException;

/**
 * Class CommentRepository.
 *
 * @author THC <thanhhaconnection@gmail.com>
 */
class CommentRepository extends RepositoryAbstract implements CommentInterface, CrudableInterface {

    /**
     * @var
     */
    protected $perPage;

    /**
     * @var \Comment
     */
    protected $comment;

    /**
     * Rules.
     *
     * @var array
     */
    protected static $rules = [
    ];

    /**
     * @param Comment $comment
     */
    public function __construct(Comment $comment) {
        $this->comment = $comment;
        $config = Config::get('fully');
        $this->perPage = $config['per_page'];
    }

    /**
     * @return mixed
     */
    public function all() {
        return $this->comment->get();
    }

    /**
     * Get paginated comments.
     *
     * @param int  $page  Number of comments per page
     * @param int  $limit Results per page
     * @param bool $all   Show published or all
     *
     * @return StdClass Object with $items and $totalItems for pagination
     */
    public function paginate($page = 1, $limit = 10, $all = false, $notLazy = false) {
        $result = new \StdClass();
        $result->page = $page;
        $result->limit = $limit;
        $result->totalItems = 0;
        $result->items = array();

        $query = $this->comment->orderBy('created_at', 'DESC');

        $comments = $query->skip($limit * ($page - 1))
                ->take($limit)
                ->get();

        $result->totalItems = $this->totalComments();
        $result->items = $comments->all();

        return $result;
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function find($id) {
        $this->comment = $this->comment->findOrFail($id);

        return $this->comment;
    }

    /**
     * @param $attributes
     *
     * @return bool|mixed
     *
     * @throws \Fully\Exceptions\Validation\ValidationException
     */
    public function create($attributes) {
        if ($this->isValid($attributes)) {
            $this->comment->lang = $this->getLang();
            $this->comment->fill($attributes)->save();
            $this->comment->resluggify();

            return true;
        }

        throw new ValidationException('Comment validation failed', $this->getErrors());
    }

    public function save($attributes) {
        $attributes['post_time'] = Carbon::now();

        $this->comment->fill($attributes)->save();

        return true;
    }

    /**
     * @param $id
     * @param $attributes
     *
     * @return bool|mixed
     *
     * @throws \Fully\Exceptions\Validation\ValidationException
     */
    public function update($id, $attributes) {
        $this->comment = $this->find($id);
        try {
            $this->comment->fill($attributes);
            $this->comment->save();
            return true;
        } catch (Exception $e) {
            throw new ValidationException('Comment validation failed', $this->getErrors());
        }
    }

    /**
     * @param $id
     *
     * @return mixed|void
     */
    public function delete($id) {
        $comment = $this->comment->find($id);
        $comment->delete();
    }

    /**
     * Get total comment count.
     *
     * @return mixed
     */
    protected function totalComments() {
        return $this->comment->count();
    }

    public function findFirst() {
        return $this->comment->orderBy('created_at', 'DESC')->first();
    }

    public function findFirstLimit($limit) {
        return $this->comment->orderBy('created_at', 'DESC')->take($limit)->get();
    }

    public function togglePublishComment($id) {
        $comment = $this->comment->find($id);
        $comment->show_status = ($comment->show_status) ? false : true;
        if ($comment->show_status == 1) {
            $comment->publish_time = Carbon::now();
        }
        $comment->save();
        return Response::json(array('result' => 'success', 'changed' => ($comment->show_status) ? 1 : 0));
    }
    
}
