<?php

namespace Fully\Repositories\Video;

use Config;
use Fully\Models\Video;
use Fully\Models\Category;
use VideoApi;
use Fully\Repositories\CrudableInterface;
use Fully\Repositories\RepositoryAbstract;
use Fully\Exceptions\Validation\ValidationException;

/**
 * Class VideoRepository.
 *
 * @author TDH <taduyhieucntt98@gmail.com>
 */
class VideoRepository extends RepositoryAbstract implements VideoInterface, CrudableInterface {

    /**
     * @var
     */
    protected $perPage;

    /**
     * @var \Video
     */
    protected $video;

    /**
     * Rules.
     *
     * @var array
     */
    protected static $rules = [
        'title' => 'required',
    ];

    /**
     * @param Video $video
     */
    public function __construct(Video $video) {
        $this->video = $video;
        $config = Config::get('fully');
        $this->perPage = $config['per_page'];
    }

    /**
     * @return mixed
     */
    public function all() {
        return $this->video->get();
    }

    /**
     * Get paginated videos.
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

        $query = $this->video->orderBy('created_at', 'DESC')->where('lang', $this->getLang());

        $videos = $query->skip($limit * ($page - 1))
                ->take($limit)
                ->get();

        $result->totalItems = $this->totalVideos();
        $result->items = $videos->all();

        return $result;
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function find($id) {
        $this->video = $this->video->findOrFail($id);

        // $this->video->setDetailsAttribute($this->getDetails($this->video->type, $this->video->video_id));

        return $this->video;
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
            $this->video->lang = $this->getLang();
            $this->video->fill($attributes)->save();
            $this->video->resluggify();

            return true;
        }

        throw new ValidationException('Video validation failed', $this->getErrors());
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
        $this->video = $this->find($id);
        try {
            $this->video->fill($attributes);
            $this->video->resluggify();
            $this->video->save();
            return true;
        } catch (Exception $e) {
            throw new ValidationException('Video validation failed', $this->getErrors());
        }
    }

    /**
     * @param $id
     *
     * @return mixed|void
     */
    public function delete($id) {
        $video = $this->video->find($id);
        $video->delete();
    }

    /**
     * Get total video count.
     *
     * @return mixed
     */
    protected function totalVideos() {
        return $this->video->where('lang', $this->getLang())->count();
    }

    public function findFirst() {
        return $this->video->orderBy('created_at', 'DESC')->first();
    }

    public function findFirstLimit($limit) {
        $videos = $this->video->orderBy('created_at', 'DESC')->take($limit)->get();

        foreach ($videos as $video) {
            $catVideo = $video->getCategory->name;

            $video->categoryName = $catVideo;
        }
        return $videos;
    }

    public function getCategories($cat_id) {
        return Category::find($cat_id);
    }

    public function getCategoryBySlug($slug) {
        $category = Category::where('slug', $slug)->where('cat_parent_id', '>', 0)->first();
        return $this->video->where('cat_id', $category->id)->get();
    }

    public function getVideoBySlug($slug) {
        return $this->video->where('slug', $slug)->first();
    }

    public function getReporting() {
        $listVideo = $this->video->orderBy('created_at', 'DESC')->take(7)->offset(0)->get();
        $newReporting = null;
        if ($listVideo->count() >= 2) {
            $newReporting = $listVideo[0];
            $newReporting->cateName = $newReporting->getCategory->name;
            unset($listVideo[0]);
            $newReporting->subList = $listVideo;
            foreach ($newReporting->subList as $sub){
                $sub->cateName = $sub->getCategory->name;
            }
        }
        return $newReporting;
    }

}
