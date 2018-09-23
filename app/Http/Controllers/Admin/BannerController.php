<?php

namespace Fully\Http\Controllers\Admin;

use View;
use Flash;
use Input;
use Config;
use Image;
use Response;
use VideoApi;
use Redirect;
use Fully\Models\Banner as Banners;
use Illuminate\Http\Request;
use Fully\Services\Pagination;
use Fully\Http\Controllers\Controller;
use Fully\Repositories\Banner\BannerInterface;
use Fully\Exceptions\Validation\ValidationException;
use Fully\Repositories\Banner\BannerRepository as Banner;
use Exception;

/**
 * Class VideoController.
 *
 * @author TDH <taduyhieucntt98@gmail.com>
 */
class BannerController extends Controller
{
    protected $banner;
    protected $perPage;
    protected $width;
    protected $height;
    protected $imgDir;

    public function __construct(BannerInterface $banner)
    {
        $this->banner = $banner;
        $this->perPage = config('fully.per_page');
        $config = Config::get('fully');
        $this->width = $config['modules']['banner']['image_size']['width'];
        $this->height = $config['modules']['banner']['image_size']['height'];
        $this->imgDir = $config['modules']['banner']['image_dir'];

    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $searchName = "";
        $pagiData = $this->banner->paginate(Input::get('page', 1), $this->perPage, true);
        $banners = Pagination::makeLengthAware($pagiData->items, $pagiData->totalItems, $this->perPage);
        return view('backend.banner.index', compact('banners','searchName'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('backend.banner.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|min:3',
            'start_date' => 'required',
            'end_date' => 'required|after:start_date',
            'url' => 'required',
            'avatar' => 'required',
        ],[
            'name.required' =>  'Bắt buộc nhập tiêu đề',
            'name.min'      =>  'Tiêu đề phải hơn 3 kí tự',
            'start_date.required' =>  'Bắt buộc chọn ngày bắt đầu chạy banner',
            'end_date.required' =>  'Bắt buộc chọn ngày kết thúc chạy banner',
            'end_date.after' =>  'Ngày bắt đầu chạy banner phải trước ngày kết thúc',
            'url.required' =>  'Bắt thêm đường dẫn đến website',
            'avatar.required' =>  'Bắt buộc thêm avatar',
        ]);

        try {
            $startDate = $request['start_date'];
            $endDate = $request['end_date'];
            $status = $request['status'];

            $this->banner->create(Input::all());
            Flash::message(trans('fully.mes_add_succes'));

            return langRedirectRoute('admin.banner.index');
        } catch (Exception $e) {
            Flash::message(trans('fully.mes_slider_log'));
            return langRedirectRoute('admin.banner.create')->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $banner = $this->banner->find($id);

        return view('backend.banner.show', compact('banner'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $banner = $this->banner->find($id);

        return view('backend.banner.edit', compact('banner'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function update($id, Request $request)
    {
        $this->validate($request, [
            'name' => 'required|min:3',
            'start_date' => 'required',
            'end_date' => 'required|after:start_date',
            'url' => 'required',
        ],[
            'name.required' =>  'Bắt buộc nhập tiêu đề',
            'name.min'      =>  'Tiêu đề phải hơn 3 kí tự',
            'start_date.required' =>  'Bắt buộc chọn ngày bắt đầu chạy banner',
            'end_date.required' =>  'Bắt buộc chọn ngày kết thúc chạy banner',
            'end_date.after' =>  'Ngày bắt đầu chạy banner phải trước ngày kết thúc',
            'url.required' =>  'Bắt thêm đường dẫn đến website',
        ]);

        try
        {
            if ($request['status'] == 1) {
                $startDate = $request['start_date'];
                $endDate = $request['end_date'];
                $position = $request['position'];
                $status = $request['status'];
                
            }
            $this->banner->update($id, Input::all());
            Flash::message(trans('fully.mes_update_succes'));

            return langRedirectRoute('admin.banner.index');
        } catch(ValidationException $e)
        {
            return langRedirectRoute('admin.banner.edit')->withInput()->withErrors($e->getErrors());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $this->banner->delete($id);
        Flash::message(trans('fully.mes_del_succes'));

        return langRedirectRoute('admin.banner.index');
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function confirmDestroy($id)
    {
        $banner = $this->banner->find($id);

        return view('backend.banner.confirm-destroy', compact('banner'));
    }

    public function getVideoDetail()
    {
        $videoId = Input::get('video_id');
        $type = Input::get('type');
        
        if($type == 'youtube')
        {
            $response = VideoApi::setType($type)->setKey(Config::get('fully.youtube_api_key'))->getVideoDetail($videoId);
        }
        else
        {
            $response = VideoApi::setType($type)->getVideoDetail($videoId);
        }

        return Response::json($response);
    }
    public function togglePublish($id) {
        return $this->banner->togglePublish($id);
    }
    public function search(Request $request) {
        $searchName = $request->searchName;
        if (isset($searchName)) {
            $banners = $this->banner->searchBannersByName($searchName);
        }
        $banners->appends(['searchName' => $searchName]);
        return view('backend.banner.index', compact('banners', 'searchName'));
    }
}
