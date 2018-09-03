<?php

namespace Fully\Repositories\News;

use Config;
use Fully\Models\News;
use Fully\Models\NewsHistory;
use Fully\Models\NewsHighLight;
use Fully\Models\NewsHome;
use Fully\Models\NewsCate;
use Fully\Models\LensRealEstale;
use Fully\Models\FollowNews;
use Fully\Models\TagNews;
use Fully\Models\Tag;
use Fully\Models\Metadata;
use SebastianBergmann\Diff\Differ;
use DB;
use Response;
use Image;
use File;
use Sentinel;
use Carbon\Carbon;
use Fully\Repositories\RepositoryAbstract;
use Fully\Repositories\CrudableInterface;
use Fully\Exceptions\Validation\ValidationException;

/**
 * Class NewsRepository.
 *
 * @author THC <thanhhaconnection@gmail.com>
 */
class NewsRepository extends RepositoryAbstract implements NewsInterface, CrudableInterface {

    /**
     * @var
     */
    protected $perPage;

    /**
     * @var \News
     */
    protected $news;

    /**
     * @var
     */
    protected $width;

    /**
     * @var
     */
    protected $height;

    /**
     * @var
     */
    protected $imgDir;

    /**
     * Rules.
     *
     * @var array
     */
    protected static $rules = [
    ];

    public function __construct(News $news) {
        $config = Config::get('fully');
        $this->perPage = $config['per_page'];
        $this->width = $config['modules']['news']['image_size']['width'];
        $this->height = $config['modules']['news']['image_size']['height'];
        $this->imgDir = $config['modules']['news']['image_dir'];
        $this->news = $news;
    }

    /**
     * @return mixed
     */
    public function all() {
        return $this->news->orderBy('news_publish_date', 'DESC')
                        ->where('lang', $this->getLang())
                        ->get();
    }

    /**
     * @return mixed
     */
    public function lists() {
        return $this->news->where('lang', $this->getLang())->lists('news_title', 'news_id');
    }

    public function getNews($category_id) {
        return $this->news->where('lang', $this->getLang())->Where('categories_id', $category_id)->paginate(5);
    }

    /*
      public function paginate($perPage = null, $all = false) {

      if ($all)
      return $this->news->orderBy('created_at', 'DESC')
      ->paginate(($perPage) ? $perPage : $this->perPage);

      return $this->news->orderBy('created_at', 'DESC')
      ->where('is_published', 1)
      ->paginate(($perPage) ? $perPage : $this->perPage);
      }
     */

    /**
     * Get paginated news.
     *
     * @param int  $page  Number of news per page
     * @param int  $limit Results per page
     * @param bool $all   Show published or all
     *
     * @return StdClass Object with $items and $totalItems for pagination
     */
    public function paginate($page = 1, $limit = 10, $all = false) {
        $result = new \StdClass();
        $result->page = $page;
        $result->limit = $limit;
        $result->totalItems = 0;
        $result->items = array();

        $query = $this->news->orderBy('news_create_date', 'DESC')->where('lang', $this->getLang());

        $news = $query->skip($limit * ($page - 1))
                ->take($limit)
                ->get();

        $result->totalItems = $this->totalNews($all);
        $result->items = $news->all();

        return $result;
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function find($id) {
        return $this->news->findOrFail($id);
    }

    /**
     * @param $slug
     *
     * @return mixed
     */
    public function getBySlug($slug) {
        return $this->news->where('slug', $slug)->first();
    }

    /**
     * @param $attributes
     *
     * @return bool|mixed
     *
     * @throws \Fully\Exceptions\Validation\ValidationException
     */
    public function create($attributes) {
        DB::beginTransaction();
        try {
            if ($this->isValid($attributes)) {

                //--------------------------------------------------------

                $file = null;

                if (isset($attributes['news_image'])) {
                    $file = $attributes['news_image'];
                }

                if ($file) {
                    $destinationPath = public_path() . $this->imgDir;
                    $fileName = $file->getClientOriginalName();
                    $upload_success = $file->move($destinationPath, $fileName);

                    if ($upload_success) {

                        // resizing an uploaded file
                        Image::make($destinationPath . $fileName)
                                ->resize($this->width, $this->height)
                                ->save($destinationPath . $fileName);

                        $this->news->news_image = $this->imgDir . $fileName;
                    }
                }

                //--------------------------------------------------------
                $news_id = Carbon::now();
                $this->news->news_id = date_format($news_id, "YmdHis");
                $this->news->news_creater = Sentinel::getUser()->id;
                $this->news->lang = $this->getLang();

                $news = $this->news->fill($attributes);
                $resultTag = $attributes['search-tag-news'];
                //Tag News
                $listTagId = [];
                if ($resultTag) {
                    $listTagId = explode(",", $resultTag);
                }
                $listTagNews = [];
                foreach ($listTagId as $tagId) {
                    $convertId = (int) str_replace(' ', '', $tagId);
                    if ($convertId > 0) {
                        $tagNews = new TagNews();
                        $tagNews->tag_id = $tagId;
                        $listTagNews[] = $tagNews;
                    }
                }

                // Meta data
                $metaTitle = $attributes['meta_title'];
                $metaDescription = $attributes['meta_description'];
                $metaKeyword = $attributes['meta_keyword'];
                $metaData = new Metadata();
                $metaData->news_id = $news->news_id;
                $metaData->meta_title = $metaTitle;
                $metaData->meta_description = $metaDescription;
                $metaData->meta_keyword = $metaKeyword;

                $attributes['news_id'] = $news->news_id;
                $attributes['news_image'] = $this->news->news_image;
                $attributes['news_creater'] = $this->news->news_creater;
                $attributes['lang'] = $this->news->lang;

                $newsHistory = new NewsHistory();
                $newsHistory->fill($attributes);

                $news->save();

                $news->getNewsHistory()->save($newsHistory);
                $news->getTagNews()->saveMany($listTagNews);
                $news->getMetaData()->save($metaData);

                DB::commit();
                return trans('fully.mes_add_succes');
            }
        } catch (Exception $ex) {
            DB::rollback();
            return 'Đã có lỗi xảy ra. Mời tạo lại bài viết';
        }
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
        DB::beginTransaction();
        try {
            $this->news = $this->find($id);

            if ($this->isValid($attributes)) {

                //-------------------------------------------------------
                if (isset($attributes['news_image'])) {
                    $file = $attributes['news_image'];

                    // delete old image
                    $destinationPath = public_path() . $this->imgDir;
                    File::delete($destinationPath . $this->news->news_image);

                    $destinationPath = public_path() . $this->imgDir;
                    $fileName = $file->getClientOriginalName();

                    $upload_success = $file->move($destinationPath, $fileName);

                    if ($upload_success) {

                        // resizing an uploaded file
                        Image::make($destinationPath . $fileName)
                                ->resize($this->width, $this->height)
                                ->save($destinationPath . $fileName);

                        $this->news->news_image = $this->imgDir . $fileName;
                    }
                }
                //-------------------------------------------------------

                if ($attributes['news_status'] == 4) {
                    $this->news->news_approver = Sentinel::getUser()->id;
                    $this->news->news_publish_date = Carbon::now();
                }

                $news = $this->news->fill($attributes);
                $news->resluggify();

                $resultTag = $attributes['search-tag-news'];
                //Tag News
                $listTagId = [];
                if ($resultTag) {
                    $listTagId = explode(",", $resultTag);
                }
                $listTagNews = [];
                foreach ($listTagId as $tagId) {
                    $convertId = (int) str_replace(' ', '', $tagId);
                    if ($convertId > 0) {
                        $tagNews = new TagNews();
                        $tagNews->tag_id = $tagId;
                        $listTagNews[] = $tagNews;
                    }
                }

                //News Highlight
                if (isset($attributes['news_highlight']) && $attributes['news_highlight'] == 1) {
                    $newsHighlight = new NewsHighLight();
                    $newsHighlight->news_id = $news->news_id;
                    $newsHighlight->save();
                }
                // News home
                if (isset($attributes['news_home']) && $attributes['news_home'] == 1) {
                    $newsHome = new NewsHome();
                    $newsHome->news_id = $news->news_id;
                    $newsHome->save();
                }
                // News cate
                if (isset($attributes['news_cate']) && $attributes['news_cate'] == 1) {
                    $newsCate = new NewsCate();
                    $newsCate->news_id = $news->news_id;
                    $newsCate->cat_id = $attributes['cat_id'];
                    $newsCate->save();
                }

                // News lens real estale
                if (isset($attributes['news_lens_re']) && $attributes['news_lens_re'] == 1) {
                    $newsLensRE = new LensRealEstale();
                    $newsLensRE->news_id = $news->news_id;
                    $newsLensRE->cat_id = $attributes['cat_id'];
                    $newsLensRE->save();
                }

                // News follow
                if (isset($attributes['follow_news']) && $attributes['follow_news'] == 1) {
                    $followNews = new FollowNews();
                    $followNews->news_id = $news->news_id;
                    $followNews->cat_id = $attributes['cat_id'];
                    $followNews->save();
                }

                // Meta data
                $metaTitle = $attributes['meta_title'];
                $metaDescription = $attributes['meta_description'];
                $metaKeyword = $attributes['meta_keyword'];
                $metaData = $news->getMetaData;
                if ($metaData) {
                    $metaData->meta_title = $metaTitle;
                    $metaData->meta_description = $metaDescription;
                    $metaData->meta_keyword = $metaKeyword;
                } else {
                    $metaData = new Metadata();
                    $metaData->news_id = $news->news_id;
                    $metaData->meta_title = $metaTitle;
                    $metaData->meta_description = $metaDescription;
                    $metaData->meta_keyword = $metaKeyword;
                }

                $attributes['news_id'] = $news->news_id;
                $attributes['news_image'] = $this->news->news_image;
                $attributes['news_creater'] = $this->news->news_creater;
                $attributes['lang'] = $this->news->lang;

                $newsHistory = new NewsHistory();
                $newsHistory->fill($attributes);

                $news->save();

                $news->getTagNews()->delete();
                $news->getTagNews()->saveMany($listTagNews);
                $news->getNewsHistory()->save($newsHistory);
                $news->getMetaData()->save($metaData);
                DB::commit();
                return trans('fully.mes_update_succes');
            }
        } catch (Exception $ex) {
            DB::rollback();
            return 'Đã có lỗi xảy ra. Mời sửa lại bài viết';
        }
    }

    /**
     * @param $id
     *
     * @return mixed|void
     */
    public function delete($id) {
        $this->news->find($id)->delete();
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function togglePublish($id) {
        $news = $this->news->find($id);
        $news->news_publisher = ($news->news_publisher) ? false : true;
        $news->save();

        return Response::json(array('result' => 'success', 'changed' => ($news->news_publisher) ? 1 : 0));
    }

    public function togglePublishComment($id) {
        $news = $this->news->find($id);
        $news->is_comment_show = ($news->is_comment_show) ? false : true;
        $news->save();

        return Response::json(array('result' => 'success', 'changed' => ($news->is_comment_show) ? 1 : 0));
    }

    /**
     * Get total news count.
     *
     * @param bool $all
     *
     * @return mixed
     */
    protected function totalNews($all = false) {
        if (!$all) {
            return $this->news->where('news_publish_date', 1)->where('lang', $this->getLang())->count();
        }

        return $this->news->where('lang', $this->getLang())->count();
    }

    /**
     * @param $limit
     *
     * @return mixed
     */
    public function getLastNews($limit) {
        return $this->news->orderBy('news_publish_date', 'desc')->where('lang', $this->getLang())->take($limit)->offset(0)->get();
    }

    public function searchNewsByName($searchTitle) {
        return $this->news->where('news_title', 'like', '%' . $searchTitle . '%')
                        ->orderBy('news_create_date', 'DESC')
                        ->where('lang', $this->getLang())
                        ->paginate(10);
    }

    public function searchNewsByCate($catId) {
        return $this->news->where('cat_id', $catId)
                        ->orderBy('news_create_date', 'DESC')
                        ->where('lang', $this->getLang())
                        ->paginate(10);
    }

    public function searchNewsByCateAndName($catId, $searchTitle) {
        return $this->news->where('cat_id', $catId)
                        ->where('news_title', 'like', $searchTitle . '%')
                        ->orderBy('news_create_date', 'DESC')
                        ->where('lang', $this->getLang())
                        ->paginate(10);
    }

    public function findAllComment($id) {
        $new = $this->news->find($id);
        return $new->getComments()->paginate(10);
    }

    // Get news read much
    public function getNewsReads() {
        return $this->news->orderBy('view_count', 'DESC')->where('lang', $this->getLang())->take(5)->offset(0)->get();
    }

    public function showCommentsHome() {
        $newsShow = $this->news->where('is_comment_show', 1)->first();
        if($newsShow) {
            $newsShow->comments = $newsShow->getComments()->where('show_status', 1)->orderBy('publish_time', 'DESC')->take(3)->offset(0)->get();

            $newsShow->commentsCount = $newsShow->getComments()->count();
        }
        
        return $newsShow;
    }

    // get news relation show in news detail
    public function getNewsRelataion($news_relation) {
        $listNewsId = $news_relation ? explode(",", $news_relation) : [];
        rsort($listNewsId);

        if ($listNewsId && count($listNewsId) > 0) {
            foreach ($listNewsId as $id) {
                $listNewsRelation[] = $this->news->where('news_id', $id)->select('news_title', 'slug', 'news_image')->first();
            }
        } else {
            $listNewsRelation = [];
        }

        return $listNewsRelation;
    }

    public function getTagNews($news_id) {
        $tagNews = News::find($news_id)->getTagNews;
        $tags = [];
        foreach ($tagNews as $tagNew) {
            $tags[] = $tagNew->getTag;
        }
        return $tags;
    }

    public function getNewsToday() {
        $dateNow = date_format(Carbon::now(), "Y-m-d");
        $newsToday = $this->news->whereDate('news_publish_date', '=', $dateNow)->get();
        return $newsToday;
    }

    public function compareNewsHistory($news_id) {
        $newsCurrent = $this->news->findOrFail($news_id);
        $newsHistoryNew = $newsCurrent->getNewsHistory()->orderBy('news_create_date', 'DESC')->first();
        $newsHistory = $newsCurrent->getNewsHistory()->orderBy('news_create_date', 'ASC')->first();
        $newsDiff = new Differ;
        $contentCompare = $newsDiff->diff($newsHistory->news_content, $newsHistoryNew->news_content);
        return $contentCompare;
    }

    public function searchNewsByStatus($statusId) {
        return $this->news->where('news_status', $statusId)
                        ->orderBy('news_create_date', 'DESC')
                        ->where('lang', $this->getLang())
                        ->paginate(10);
    }

    public function searchNewsByStatusAndName($statusId, $searchTitle) {
        return $this->news->where('news_title', 'like', '%' . $searchTitle . '%')
                        ->where('news_status', $statusId)
                        ->orderBy('news_create_date', 'DESC')
                        ->where('lang', $this->getLang())
                        ->paginate(10);
    }

    public function searchNewsByStatusAndCateAndName($statusId, $catId, $searchTitle) {
        return $this->news->where('news_title', 'like', '%' . $searchTitle . '%')
                        ->where('cat_id', $catId)
                        ->where('news_status', $statusId)
                        ->orderBy('news_create_date', 'DESC')
                        ->where('lang', $this->getLang())
                        ->paginate(10);
    }

}
