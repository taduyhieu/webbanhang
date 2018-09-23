<?php

namespace Fully\Repositories\Tag;

use Config;
use Fully\Models\Tag;
use Fully\Models\TagNews;
use Fully\Repositories\CrudableInterface;
use Fully\Repositories\RepositoryAbstract;
use Fully\Exceptions\Validation\ValidationException;

/**
 * Class TagRepository.
 *
 * @author TDH <taduyhieucntt98@gmail.com>
 */
class TagRepository extends RepositoryAbstract implements TagInterface, CrudableInterface {

    /**
     * @var
     */
    protected $perPage;

    /**
     * @var \Video
     */
    protected $tag;

    /**
     * Rules.
     *
     * @var array
     */
    protected static $rules = [
        'title' => 'required',
    ];

    /**
     * @param Tag $tag
     */
    public function __construct(Tag $tag) {
        $this->tag = $tag;
        $config = Config::get('fully');
        $this->perPage = $config['per_page'];
    }

    /**
     * @return mixed
     */
    public function all() {
        return $this->tag->get();
    }

    /**
     * Get paginated tags.
     *
     * @param int  $page  Number of videos per page
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

        $query = $this->tag->orderBy('created_at', 'DESC');

        $tags = $query->skip($limit * ($page - 1))
                ->take($limit)
                ->get();

        $result->totalItems = $this->totalTags();
        $result->items = $tags->all();

        return $result;
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function find($id) {
        $this->tag = $this->tag->findOrFail($id);

        // $this->video->setDetailsAttribute($this->getDetails($this->video->type, $this->video->video_id));

        return $this->tag;
    }

    /**
     * @param $attributes
     *
     * @return bool|mixed
     *
     * @throws \Fully\Exceptions\Validation\ValidationException
     */
    public function create($attributes) {
        if (isset($attributes)) {
            $this->tag->fill($attributes)->save();
            return true;
        }

        throw new ValidationException('Tag validation failed', $this->getErrors());
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
        $this->tag = $this->find($id);
        try {
            $this->tag->fill($attributes);
            $this->tag->resluggify();
            $this->tag->save();

            return true;
        } catch (Exception $e) {
            throw new ValidationException('Tag validation failed', $this->getErrors());
        }
    }

    /**
     * @param $id
     *
     * @return mixed|void
     */
    public function delete($id) {
        $tag = $this->tag->find($id);
        $tag->delete();
    }

    /**
     * Get total tag count.
     *
     * @return mixed
     */
    protected function totalTags() {
        return $this->tag->count();
    }

    public function findbySlug($slug) {
        return $this->tag->where('slug', $slug)->first();
    }

    public function getNewByTag($slug) {
        $tag = $this->tag->findbySlug($slug);
        $newsTags = $tag->getTagNews;
        $news = [];
        foreach ($newsTags as $newsTag)
            $news[] = $newsTag->getNews;
        return $news;
    }

}
