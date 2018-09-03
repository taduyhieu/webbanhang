<?php

namespace Fully\Repositories\NewsRealEstale;

use Config;
use Fully\Models\NewsRealEstale;
use Fully\Models\TagNewsRealEstale;
use Fully\Models\MetadataRealEstale;
use Fully\Models\Payment;
use Fully\Models\Photo;
use DB;
use Response;
use Image;
use File;
use Sentinel;
use Carbon\Carbon;
use Fully\Repositories\RepositoryAbstract;
use Fully\Repositories\CrudableInterface;

//use Fully\Exceptions\Validation\ValidationException;

/**
 * Class NewsRepository.
 *
 * @author THC <thanhhaconnection@gmail.com>
 */
class NewsRealEstaleRepository extends RepositoryAbstract implements NewsRealEstaleInterface, CrudableInterface {

    /**
     * @var
     */
    protected $perPage;

    /**
     * @var \News
     */
    protected $newsRealEstale;

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

    /**
     * Image rules.
     *
     * @var array
     */
    protected static $photoRules = [
        'file' => 'mimes:jpg,jpeg,png|max:10000',
        'file.mimes' => 'Ảnh phải là loại jpg, jpeg, png',
        'file.max' => 'Dung lượng ảnh không quá 10MB',
    ];

    public function __construct(NewsRealEstale $newsRealEstale) {
        $config = Config::get('fully');
        $this->perPage = $config['per_page'];
        $this->width = $config['modules']['realestale-news']['image_size']['width'];

        $this->height = $config['modules']['realestale-news']['image_size']['height'];
        $this->imgDir = $config['modules']['realestale-news']['image_dir'];
        $this->newsRealEstale = $newsRealEstale;
    }

    /**
     * @return mixed
     */
    public function all() {
        return $this->newsRealEstale->orderBy('news_publish_date', 'DESC')
                        ->where('lang', $this->getLang())
                        ->get();
    }

    /**
     * @return mixed
     */
    public function lists() {
        return $this->newsRealEstale->where('lang', $this->getLang())->lists('news_title', 'news_id');
    }

    public function published() {
        return $this->newsRealEstale->where('lang', $this->getLang())->orderBy('type','DESC')
                                    ->orderBy('news_publish_date', 'DESC')
                                    ->Where('news_status','=', '4')->paginate(10);
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

        $query = $this->newsRealEstale->orderBy('news_create_date', 'DESC')->where('lang', $this->getLang());

        if (!$all) {
            $query->where('news_status', 4);
        }

        $newsRealEstale = $query->skip($limit * ($page - 1))
                ->take($limit)
                ->get();

        $result->totalItems = $this->totalNewsRealEstale($all);
        $result->items = $newsRealEstale->all();

        return $result;
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function find($id) {
        return $this->newsRealEstale->findOrFail($id);
    }

    /**
     * @param $slug
     *
     * @return mixed
     */
    public function getBySlug($slug) {
        return $this->newsRealEstale->where('slug', $slug)->first();
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

                        $this->newsRealEstale->news_image = $this->imgDir . $fileName;
                    }
                }

                //--------------------------------------------------------
                $this->newsRealEstale->news_code = str_random(10);
                $this->newsRealEstale->news_creater = Sentinel::getUser()->id;
                $this->newsRealEstale->lang = $this->getLang();

                $newsRealEstale = $this->newsRealEstale->fill($attributes);

                //Tag News
                $resultTag = $attributes['search-tag-news'];
                $listTagId = [];
                if ($resultTag) {
                    $listTagId = explode(",", $resultTag);
                }
                $listTagNewsRE = [];
                foreach ($listTagId as $tagId) {
                    $convertId = (int) str_replace(' ', '', $tagId);
                    if ($convertId > 0) {
                        $tagNewsRE = new TagNewsRealEstale();
                        $tagNewsRE->tag_realestale_id = $tagId;
                        $listTagNewsRE[] = $tagNewsRE;
                    }
                }
                // Meta data
                $metaTitle = $attributes['meta_title'];
                $metaDescription = $attributes['meta_description'];
                $metaKeyword = $attributes['meta_keyword'];

                $metaData = new MetadataRealEstale();
                $metaData->meta_title = $metaTitle;
                $metaData->meta_description = $metaDescription;
                $metaData->meta_keyword = $metaKeyword;

                $userWallet = Sentinel::getUser()->wallet_money;
                $userId = Sentinel::getUser()->id;
                $cost = \doubleval(200000);

                // Payment
                if ($attributes['type'] == 1) {
                    $payment = new Payment();
                    $payment->user_id = $userId;
                    if ($userWallet < $cost) {
                        return 'Số tiền trong ví không đủ để đăng bài';
                    } else {
                        $payment->cost = $cost;
                    }
                }

                $newsRealEstale->save();
                $newsRealEstale->getTagNewsRealEstales()->saveMany($listTagNewsRE);
                $newsRealEstale->getMetadataRealEstale()->save($metaData);
                if (isset($payment)) {
                    $newsRealEstale->getPayments()->save($payment);
                    // Wallet
                    $user = Sentinel::findById($userId);
                    $user->wallet_money = $userWallet - $cost;
                    Sentinel::update($user, []);
                }

                DB::commit();
                return $newsRealEstale->id;
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
            $this->newsRealEstale = $this->find($id);

            if ($this->isValid($attributes)) {

                //-------------------------------------------------------
                if (isset($attributes['news_image'])) {
                    $file = $attributes['news_image'];

                    // delete old image
                    $destinationPath = public_path() . $this->imgDir;
                    File::delete($destinationPath . $this->newsRealEstale->news_image);

                    $destinationPath = public_path() . $this->imgDir;
                    $fileName = $file->getClientOriginalName();

                    $upload_success = $file->move($destinationPath, $fileName);

                    if ($upload_success) {

                        // resizing an uploaded file
                        Image::make($destinationPath . $fileName)
                                ->resize($this->width, $this->height)
                                ->save($destinationPath . $fileName);

                        $this->newsRealEstale->news_image = $this->imgDir . $fileName;
                    }
                }
                //-------------------------------------------------------

                if ($attributes['news_status'] == 4) {
                    $this->newsRealEstale->news_approver = Sentinel::getUser()->id;
                    $this->newsRealEstale->news_publisher = Sentinel::getUser()->id;
                    $this->newsRealEstale->news_publish_date = Carbon::now();
                }

                $newsRealEstale = $this->newsRealEstale->fill($attributes);
                $newsRealEstale->resluggify();

                // Refund money news
                if ($attributes['news_status'] == 6) {
                    $paymentNewsUser = $newsRealEstale->getPayments;
                    $user = $paymentNewsUser->getUser;

                    $user->wallet_money += $paymentNewsUser->cost;
                    $paymentNewsUser->cost -= $paymentNewsUser->cost;
                    $user->save();
                }

                //Tag News
                $resultTag = $attributes['search-tag-news'];
                $listTagId = [];
                if ($resultTag) {
                    $listTagId = explode(",", $resultTag);
                }
                $listTagNews = [];
                foreach ($listTagId as $tagId) {
                    $convertId = (int) str_replace(' ', '', $tagId);
                    if ($convertId > 0) {
                        $tagNews = new TagNewsRealEstale();
                        $tagNews->tag_realestale_id = $tagId;
                        $listTagNews[] = $tagNews;
                    }
                }

                // Meta data
                $metaTitle = $attributes['meta_title'];
                $metaDescription = $attributes['meta_description'];
                $metaKeyword = $attributes['meta_keyword'];
                $metaData = $newsRealEstale->getMetadataRealEstale;
                if ($metaData) {
                    $metaData->meta_title = $metaTitle;
                    $metaData->meta_description = $metaDescription;
                    $metaData->meta_keyword = $metaKeyword;
                } else {
                    $metaData = new MetadataRealEstale();
                    $metaData->meta_title = $metaTitle;
                    $metaData->meta_description = $metaDescription;
                    $metaData->meta_keyword = $metaKeyword;
                }
            }

            $newsRealEstale->save();
            $newsRealEstale->getTagNewsRealEstales()->delete();
            $newsRealEstale->getTagNewsRealEstales()->saveMany($listTagNews);
            if (isset($paymentNewsUser)) {
                $newsRealEstale->getPayments()->save($paymentNewsUser);
            }
            $newsRealEstale->getMetadataRealEstale()->save($metaData);

            DB::commit();
            return trans('fully.mes_update_succes');
        } catch (Exception $ex) {
            DB::rollback();
            return 'Đã có lỗi xảy ra. Mời sửa lại bài viết';
        }
    }

    /**
     * @param $id
     * @param $attributes
     *
     * @return bool
     *
     * @throws \Fully\Exceptions\Validation\ValidationException
     */
    public function upload($id, $attributes) {
        if ($this->isValid($attributes, self::$photoRules)) {
            $file = $attributes['file'];

            $destinationPath = public_path() . $this->imgDir;
            $fileName = $file->getClientOriginalName();
            $fileSize = $file->getClientSize();

            $upload_success = $file->move($destinationPath, $fileName);

            if ($upload_success) {

                // resizing an uploaded file
                Image::make($destinationPath . $fileName)
                        ->resize($this->width, $this->height)
                        ->save($destinationPath . 'thumb_' . $fileName);

                $newsPhotos = $this->newsRealEstale->find($id);
                $image = new Photo();
                $image->file_name = $fileName;
                $image->file_size = $fileSize;
                $image->title = explode('.', $fileName)[0];
                $image->path = $this->imgDir . $fileName;
                $image->type = 'newsrealestale';
                $newsPhotos->getPhotos()->save($image);

                return true;
            }
        }
        throw new ValidationException('Không thể tải ảnh lên. Mời thử lại', $this->getErrors());
    }

    /**
     * @param $id
     * @param $attributes
     *
     * @return bool
     *
     * @throws \Fully\Exceptions\Validation\ValidationException
     */
    public function uploadMultiplePhotos($attributes, $id) {

        if ($this->isValid($attributes, self::$photoRules)) {
            $file = $attributes['file'];

            $destinationPath = public_path() . $this->imgDir;
            $fileName = $file->getClientOriginalName();
            $fileSize = $file->getClientSize();

            $upload_success = $file->move($destinationPath, $fileName);

            if ($upload_success) {

                // resizing an uploaded file
                Image::make($destinationPath . $fileName)
                        ->resize($this->width, $this->height)
                        ->save($destinationPath . 'thumb_' . $fileName);

                $newsPhotos = $this->newsRealEstale->find($id);
                $image = new Photo();
                $image->file_name = $fileName;
                $image->file_size = $fileSize;
                $image->title = explode('.', $fileName)[0];
                $image->path = $this->imgDir . $fileName;
                $image->type = 'newsrealestale';
                $newsPhotos->getPhotos()->save($image);

                return true;
            }
        }
        throw new ValidationException('Không thể tải ảnh lên. Mời thử lại', $this->getErrors());
    }

    /**
     * @param $fileName
     *
     * @return mixed
     */
    public function deletePhoto($fileName) {
        Photo::where('file_name', '=', $fileName)->delete();
        $destinationPath = public_path() . $this->imgDir;
        File::delete($destinationPath . $fileName);
        File::delete($destinationPath . 'thumb_' . $fileName);

        return Response::json('Thành công', 200);
    }

    /**
     * @param $id
     *
     * @return mixed|void
     */
    public function delete($id) {
        $this->newsRealEstale->find($id)->delete();
    }

    /**
     * Get total news count.
     *
     * @param bool $all
     *
     * @return mixed
     */
    protected function totalNewsRealEstale($all = false) {
        if (!$all) {
            return $this->newsRealEstale->where('news_status', 4)->where('lang', $this->getLang())->count();
        }

        return $this->newsRealEstale->where('lang', $this->getLang())->count();
    }

    /**
     * @param $limit
     *
     * @return mixed
     */
    public function getLastNewsRealEstale($limit) {
        $listNewsRE = $this->newsRealEstale->orderBy('news_publish_date', 'desc')->where('lang', $this->getLang())->take($limit)->offset(0)->get();
        foreach ($listNewsRE as $news) {
            $district = $news->getDistrict;
            $city = $news->getDistrict->getCity;
            $news->district = $district->name;
            $news->city = $city->name;
        }
        return $listNewsRE;
    }

    public function searchNews($searchTitle) {
        return $this->newsRealEstale->where('news_title', 'like', '%'.$searchTitle . '%')
                        ->orWhere('news_code', 'like', '%'.$searchTitle . '%')
                        ->where('lang', $this->getLang())
                        ->orderBy('news_create_date', 'DESC')
                        ->paginate(10);
    }
    
    public function searchNewsByCateReal($searchCate) {
        return $this->newsRealEstale->where('cat_realestale_id', $searchCate)
                        ->where('lang', $this->getLang())
                        ->orderBy('news_create_date', 'DESC')
                        ->paginate(10);
    }
    public function searchNewsByCateRealAndTitle($searchCate, $searchTitle) {
        return $this->newsRealEstale->where('news_title', 'like', '%'.$searchTitle . '%')
                        ->where('cat_realestale_id', $searchCate)
                        ->where('lang', $this->getLang())
                        ->orderBy('news_create_date', 'DESC')
                        ->paginate(10);
    }
    
    public function getListNewsFE() {
        $listNews = $this->newsRealEstale->where('news_status', 4)->orderBy('news_publish_date', 'DESC')->paginate(13);
        return $listNews;
    }

    public function searchNewsFrontend($attributes) {
        $cat_re_id = $attributes['cat_realestale'] ? $attributes['cat_realestale'] : null;
        $city_id = isset($attributes['city']) ? $attributes['city'] : null;
        $district_id = isset($attributes['district']) ? $attributes['district'] : null;
        $total_area = isset($attributes['total_area']) ? $attributes['total_area'] : null;
        $price_all = isset($attributes['price_all']) ? $attributes['price_all'] : null;
        
        // get news by cat realestale id
        if ($cat_re_id && !$city_id && !$district_id && !$total_area && !$price_all) {
            $result = $this->newsRealEstale->where('cat_realestale_id', $cat_re_id)
                    ->orderBy('news_publish_date', 'DESC')
                    ->orderBy('type', 'DESC')
                    ->paginate(13);
            return $result;
        }
        // get news by cat realestale id and city id
        if ($cat_re_id && $city_id && !$district_id && !$total_area && !$price_all) {
            $result = $this->newsRealEstale->where('cat_realestale_id', $cat_re_id)
                    ->where('city_id', $city_id)->orderBy('news_publish_date', 'DESC')
                    ->orderBy('type', 'DESC')
                    ->paginate(13);
            return $result;
        }
        // get news by cat realestale id and total area
        if ($cat_re_id && !$city_id && !$district_id && $total_area && !$price_all) {
            if ($total_area == 1) {
                $result = $this->newsRealEstale->where('cat_realestale_id', $cat_re_id)
                        ->where('total_area', '<', 50)
                        ->orderBy('news_publish_date', 'DESC')
                        ->orderBy('type', 'DESC')
                        ->paginate(13);
                return $result;
            } else if ($total_area == 2) {
                $result = $this->newsRealEstale->where('cat_realestale_id', $cat_re_id)
                        ->whereBetween('total_area', [50, 100])
                        ->orderBy('news_publish_date', 'DESC')
                        ->orderBy('type', 'DESC')
                        ->paginate(13);
                return $result;
            } else if ($total_area == 3) {
                $result = $this->newsRealEstale->where('cat_realestale_id', $cat_re_id)
                        ->where('total_area', '>', 100)
                        ->orderBy('news_publish_date', 'DESC')
                        ->orderBy('type', 'DESC')
                        ->paginate(13);
                return $result;
            }
        }
        // get news by cat realestale id and price all
        if ($cat_re_id && !$city_id && !$district_id && !$total_area && $price_all) {
            if ($price_all == 1) {
                $result = $this->newsRealEstale->where('cat_realestale_id', $cat_re_id)
                        ->where('price_all', '<', 1000)
                        ->orderBy('news_publish_date', 'DESC')
                        ->orderBy('type', 'DESC')
                        ->paginate(13);
                return $result;
            } else if ($price_all == 2) {
                $result = $this->newsRealEstale->where('cat_realestale_id', $cat_re_id)
                        ->whereBetween('price_all', [1000, 5000])
                        ->orderBy('news_publish_date', 'DESC')
                        ->orderBy('type', 'DESC')
                        ->paginate(13);
                return $result;
            } else if ($price_all == 3) {
                $result = $this->newsRealEstale->where('cat_realestale_id', $cat_re_id)
                        ->where('price_all', '>', 5000)
                        ->orderBy('news_publish_date', 'DESC')
                        ->orderBy('type', 'DESC')
                        ->paginate(13);
                return $result;
            }
        }
        // get news by cat realestale id, city id and total area
        if ($cat_re_id && $city_id && !$district_id && $total_area && !$price_all) {
            if ($total_area == 1) {
                $result = $this->newsRealEstale->where('cat_realestale_id', $cat_re_id)
                        ->where('city_id', $city_id)
                        ->where('total_area', '<', 50)
                        ->orderBy('news_publish_date', 'DESC')
                        ->orderBy('type', 'DESC')
                        ->paginate(13);
                return $result;
            } else if ($total_area == 2) {
                $result = $this->newsRealEstale->where('cat_realestale_id', $cat_re_id)
                        ->where('city_id', $city_id)
                        ->whereBetween('total_area', [50, 100])
                        ->orderBy('news_publish_date', 'DESC')
                        ->orderBy('type', 'DESC')
                        ->paginate(13);
                return $result;
            } else if ($total_area == 3) {
                $result = $this->newsRealEstale->where('cat_realestale_id', $cat_re_id)
                        ->where('city_id', $city_id)
                        ->where('total_area', '>', 100)
                        ->orderBy('news_publish_date', 'DESC')
                        ->orderBy('type', 'DESC')
                        ->paginate(13);
                return $result;
            }
        }
        // get news by cat realestale id, city id and price all
        if ($cat_re_id && $city_id && !$district_id && !$total_area && $price_all) {
            if ($price_all == 1) {
                $result = $this->newsRealEstale->where('cat_realestale_id', $cat_re_id)
                        ->where('city_id', $city_id)
                        ->where('price_all', '<', 1000)
                        ->orderBy('news_publish_date', 'DESC')
                        ->orderBy('type', 'DESC')
                        ->paginate(13);
                return $result;
            } else if ($price_all == 2) {
                $result = $this->newsRealEstale->where('cat_realestale_id', $cat_re_id)
                        ->where('city_id', $city_id)
                        ->whereBetween('price_all', [1000, 5000])
                        ->orderBy('news_publish_date', 'DESC')
                        ->orderBy('type', 'DESC')
                        ->paginate(13);
                return $result;
            } else if ($price_all == 3) {
                $result = $this->newsRealEstale->where('cat_realestale_id', $cat_re_id)
                        ->where('city_id', $city_id)
                        ->where('price_all', '>', 5000)
                        ->orderBy('news_publish_date', 'DESC')
                        ->orderBy('type', 'DESC')
                        ->paginate(13);
                return $result;
            }
        }

        // get news by cat realestale id, city id, district id
        if ($cat_re_id && $city_id && $district_id && !$total_area && !$price_all) {
            $result = $this->newsRealEstale->where('cat_realestale_id', $cat_re_id)
                    ->where('city_id', $city_id)->where('district_id', $district_id)
                    ->orderBy('news_publish_date', 'DESC')
                    ->orderBy('type', 'DESC')
                    ->paginate(13);
            return $result;
        }
        // get news by cat realestale id, city id, district id, total area
        if ($cat_re_id && $city_id && $district_id && $total_area && !$price_all) {
            if ($total_area == 1) {
                $result = $this->newsRealEstale->where('cat_realestale_id', $cat_re_id)
                        ->where('city_id', $city_id)->where('district_id', $district_id)
                        ->where('total_area', '<', 50)
                        ->orderBy('news_publish_date', 'DESC')
                        ->orderBy('type', 'DESC')
                        ->paginate(13);
                return $result;
            } else if ($total_area == 2) {
                $result = $this->newsRealEstale->where('cat_realestale_id', $cat_re_id)
                        ->where('city_id', $city_id)->where('district_id', $district_id)
                        ->whereBetween('total_area', [50, 100])
                        ->orderBy('news_publish_date', 'DESC')
                        ->orderBy('type', 'DESC')
                        ->paginate(13);
                return $result;
            } else if ($total_area == 3) {
                $result = $this->newsRealEstale->where('cat_realestale_id', $cat_re_id)
                        ->where('city_id', $city_id)->where('district_id', $district_id)
                        ->where('total_area', '>', 100)
                        ->orderBy('news_publish_date', 'DESC')
                        ->orderBy('type', 'DESC')
                        ->paginate(13);
                return $result;
            }
        }
        // get news by cat realestale id, city id, district id, total area, price all
        if ($cat_re_id && $city_id && $district_id && $total_area && $price_all) {
            // total area = 1
            if ($total_area == 1 && $price_all == 1) {
                $result = $this->newsRealEstale->where('cat_realestale_id', $cat_re_id)
                        ->where('city_id', $city_id)->where('district_id', $district_id)
                        ->where('total_area', '<', 50)
                        ->where('price_all', '<', 1000)
                        ->orderBy('news_publish_date', 'DESC')
                        ->orderBy('type', 'DESC')
                        ->paginate(13);
                return $result;
            } else if ($total_area == 1 && $price_all == 2) {
                $result = $this->newsRealEstale->where('cat_realestale_id', $cat_re_id)
                        ->where('city_id', $city_id)->where('district_id', $district_id)
                        ->where('total_area', '<', 50)
                        ->whereBetween('price_all', [1000, 5000])
                        ->orderBy('news_publish_date', 'DESC')
                        ->orderBy('type', 'DESC')
                        ->paginate(13);
                return $result;
            } else if ($total_area == 1 && $price_all == 3) {
                $result = $this->newsRealEstale->where('cat_realestale_id', $cat_re_id)
                        ->where('city_id', $city_id)->where('district_id', $district_id)
                        ->where('total_area', '<', 50)
                        ->where('price_all', '>', 5000)
                        ->orderBy('news_publish_date', 'DESC')
                        ->orderBy('type', 'DESC')
                        ->paginate(13);
                return $result;
            }
            // total area = 2
            if ($total_area == 2 && $price_all == 1) {
                $result = $this->newsRealEstale->where('cat_realestale_id', $cat_re_id)
                        ->where('city_id', $city_id)->where('district_id', $district_id)
                        ->whereBetween('total_area', [50, 100])
                        ->where('price_all', '<', 1000)
                        ->orderBy('news_publish_date', 'DESC')
                        ->orderBy('type', 'DESC')
                        ->paginate(13);
                return $result;
            } else if ($total_area == 2 && $price_all == 2) {
                $result = $this->newsRealEstale->where('cat_realestale_id', $cat_re_id)
                        ->where('city_id', $city_id)->where('district_id', $district_id)
                        ->whereBetween('total_area', [50, 100])
                        ->whereBetween('price_all', [1000, 5000])
                        ->orderBy('news_publish_date', 'DESC')
                        ->orderBy('type', 'DESC')
                        ->paginate(13);
                return $result;
            } else if ($total_area == 2 && $price_all == 3) {
                $result = $this->newsRealEstale->where('cat_realestale_id', $cat_re_id)
                        ->where('city_id', $city_id)->where('district_id', $district_id)
                        ->whereBetween('total_area', [50, 100])
                        ->where('price_all', '>', 5000)
                        ->orderBy('news_publish_date', 'DESC')
                        ->orderBy('type', 'DESC')
                        ->paginate(13);
                return $result;
            }
            // total area = 3
            if ($total_area == 3 && $price_all == 1) {
                $result = $this->newsRealEstale->where('cat_realestale_id', $cat_re_id)
                        ->where('city_id', $city_id)->where('district_id', $district_id)
                        ->where('total_area', '>', 100)
                        ->where('price_all', '<', 1000)
                        ->orderBy('news_publish_date', 'DESC')
                        ->orderBy('type', 'DESC')
                        ->paginate(13);
                return $result;
            } else if ($total_area == 3 && $price_all == 2) {
                $result = $this->newsRealEstale->where('cat_realestale_id', $cat_re_id)
                        ->where('city_id', $city_id)->where('district_id', $district_id)
                        ->where('total_area', '>', 100)
                        ->whereBetween('price_all', [1000, 5000])
                        ->orderBy('news_publish_date', 'DESC')
                        ->orderBy('type', 'DESC')
                        ->paginate(13);
                return $result;
            } else if ($total_area == 3 && $price_all == 3) {
                $result = $this->newsRealEstale->where('cat_realestale_id', $cat_re_id)
                        ->where('city_id', $city_id)->where('district_id', $district_id)
                        ->where('total_area', '>', 100)
                        ->where('price_all', '>', 5000)
                        ->orderBy('news_publish_date', 'DESC')
                        ->orderBy('type', 'DESC')
                        ->paginate(13);
                return $result;
            }
        }
    }

}
