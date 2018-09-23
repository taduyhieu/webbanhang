<?php

namespace Fully\Repositories\Banner;

use Config;
use Fully\Models\Banner;
use VideoApi;
use Response;
use Image;
use Input;
use Fully\Repositories\CrudableInterface;
use Fully\Repositories\Banner\BannerInterface;
use Fully\Repositories\RepositoryAbstract;
use Fully\Exceptions\Validation\ValidationException;

/**
 * Class BannerRepository.
 *
 * @author TDH <taduyhieucntt98@gmail.com>
 */
class BannerRepository extends RepositoryAbstract implements BannerInterface, CrudableInterface
{
    /**
     * @var
     */
    protected $perPage;

    /**
     * @var \Banner
     */
    protected $banner;

    /**
     * Rules.
     *
     * @var array
     */
    protected static $rules = [
    ];

    /**
     * @param Banner $banner
     */
    public function __construct(Banner $banner)
    {
        $this->banner = $banner;
        $config = Config::get('fully');
        $this->perPage = $config['per_page'];
    }

    /**
     * @return mixed
     */
    public function all()
    {
        return $this->banner->get();
    }

    /**
     * Get paginated banners.
     *
     * @param int  $page  Number of banners per page
     * @param int  $limit Results per page
     * @param bool $all   Show published or all
     *
     * @return StdClass Object with $items and $totalItems for pagination
     */
    public function paginate($page = 1, $limit = 10, $all = false, $notLazy = false)
    {
        $result = new \StdClass();
        $result->page = $page;
        $result->limit = $limit;
        $result->totalItems = 0;
        $result->items = array();

        $query = $this->banner->orderBy('created_date', 'DESC');

        $banners = $query->skip($limit * ($page - 1))
            ->take($limit)
            ->get();

        $result->totalItems = $this->totalBanners();
        $result->items = $banners->all();

        return $result;
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function find($id)
    {
        $this->banner = $this->banner->findOrFail($id);


        return $this->banner;
    }

    /**
     * @param $attributes
     *
     * @return bool|mixed
     *
     * @throws \Fully\Exceptions\Validation\ValidationException
     */
    public function create($attributes)
    {
        $formData = Input::all();
        $file = $formData['avatar'];
        $avatar = $attributes['avatar']->getClientOriginalName();
        $path = "/uploads/banner/".$attributes['avatar']->getClientOriginalName();
        $file_name = $attributes['avatar']->getClientOriginalName();
        $file_size = $attributes['avatar']->getClientSize();
        $attributes['avatar'] = $avatar;
        $attributes['path'] = $path;
        $attributes['file_size'] = $file_size;
        $attributes['file_name'] = $file_name;
        $imgDir = '/uploads/banner/';
        $destinationPath = public_path().$imgDir;
        $upload_success = $file->move($destinationPath, $file_name);
        if (isset($attributes)) {
            $this->banner->fill($attributes)->save();
            return true;
        }

        throw new ValidationException('Banner validation failed', $this->getErrors());
    }

    /**
     * @param $id
     * @param $attributes
     *
     * @return bool|mixed
     *
     * @throws \Fully\Exceptions\Validation\ValidationException
     */
    public function update($id, $attributes)
    {
        $this->banner = $this->find($id);
        $formData = Input::all();
        if (isset($formData['avatar'])) {
            $file = $formData['avatar'];
            $avatar = $attributes['avatar']->getClientOriginalName();
            $path = "/uploads/banner/".$attributes['avatar']->getClientOriginalName();
            $file_name = $attributes['avatar']->getClientOriginalName();
            $file_size = $attributes['avatar']->getClientSize();
            $attributes['avatar'] = $avatar;
            $attributes['path'] = $path;
            $attributes['file_size'] = $file_size;
            $attributes['file_name'] = $file_name;
            $imgDir = '/uploads/banner/';
            $destinationPath = public_path().$imgDir;
            $upload_success = $file->move($destinationPath, $file_name);
            if ($this->isValid($attributes)) {
                $this->banner->fill($attributes)->save();
                return true;
            }
            throw new ValidationException('Banner validation failed', $this->getErrors());
        }
        if (isset($attributes)) {
            $this->banner->fill($attributes)->save();
            return true;
        }
        throw new ValidationException('Banner validation failed', $this->getErrors());
    }

    /**
     * @param $id
     *
     * @return mixed|void
     */
    public function delete($id)
    {
        $banner = $this->banner->find($id);
        $banner->delete();
    }

    /**
     * Get total banner count.
     *
     * @return mixed
     */
    protected function totalBanners()
    {
        return $this->banner->count();
    }
    /**
     * @param $id
     *
     * @return mixed
     */
    public function togglePublish($id) {
        $banner = $this->banner->find($id);
        if ($banner->status == 0) {
            $isExists = $this->banner->where('start_date', '>=', $banner->start_date)->where('end_date', '<=', $banner->end_date)->where('position', '=', $banner->position)->where('status', '=', 1)->exists();
            if($isExists) {
                return Response::json(array('result' => 'fail'));
            }

            $isExists = $this->banner->where('start_date', '<', $banner->start_date)->where('end_date', '>', $banner->start_date)->where('position', '=', $banner->position)->where('status', '=', 1)->exists();
            if($isExists) {
                return Response::json(array('result' => 'fail'));
            }

            $isExists = $this->banner->where('start_date', '<', $banner->end_date)->where('end_date', '>', $banner->end_date)->where('position', '=', $banner->position)->where('status', '=', 1)->exists();
            if($isExists) {
                return Response::json(array('result' => 'fail'));
            }
        }
        $banner->status = ($banner->status) ? '0' : '1';
        $banner->save();

        return Response::json(array('result' => 'success', 'changed' => ($banner->status) ? '1' : '0'));
    }
    public function searchBannersByName($searchName) {
         return $this->banner->where('name', 'like', '%' . $searchName . '%')
                 ->orderBy('position', 'ASC')
                 ->paginate(10);
    }
    public function getBannerByPosition($timeCurrent)
    {
        $banners = new Banner;
        $banners->first = $this->banner->where('position','=',1)->where('start_date','<=',$timeCurrent)->where('end_date','>=', $timeCurrent)->where('status','=',1)->orderBy('updated_at', 'DESC')->first();
        $banners->second = $this->banner->where('position','=',2)->where('start_date','<=',$timeCurrent)->where('end_date','>=', $timeCurrent)->where('status','=',1)->orderBy('updated_at', 'DESC')->first();
        $banners->third = $this->banner->where('position','=',3)->where('start_date','<=',$timeCurrent)->where('end_date','>=', $timeCurrent)->where('status','=',1)->orderBy('updated_at', 'DESC')->first();
        $banners->fourth = $this->banner->where('position','=',4)->where('start_date','<=',$timeCurrent)->where('end_date','>=', $timeCurrent)->where('status','=',1)->orderBy('updated_at', 'DESC')->first();
        return $banners;
    }
}
