<?php

namespace Fully\Http\Controllers\Admin;

use View;
use Input;
use Flash;
use Response;
use Redirect;
use Fully\Models\User;
use Fully\Models\TagRealEstale;
use Fully\Models\City;
use Fully\Models\District;
use Fully\Services\Pagination;
use Fully\Repositories\NewsRealEstale\NewsRealEstaleInterface;
use Fully\Repositories\CategoryRealestale\CategoryRealestaleInterface;
use Illuminate\Http\Request;
use Fully\Http\Controllers\Controller;

class NewsRealEstaleController extends Controller {

    protected $newsRealEstale;
    protected $perPage;

    public function __construct(NewsRealEstaleInterface $newsRealEstale, CategoryRealestaleInterface $categoryRealEstale) {
        View::share('active', 'modules');
        $this->newsRealEstale = $newsRealEstale;
        $this->categoryRealEstale = $categoryRealEstale;
        $this->perPage = config('fully.modules.realestale-news.per_page');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $searchTitle = "";
        $pagiData = $this->newsRealEstale->paginate(Input::get('page', 1), $this->perPage, true);
        $cateRealEstale = $this->categoryRealEstale->all();
        $newsRealEstale = Pagination::makeLengthAware($pagiData->items, $pagiData->totalItems, $this->perPage);

        return view('backend.news_real_estale.index', compact('newsRealEstale', 'searchTitle', 'cateRealEstale'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $catesRealEstale = $this->categoryRealEstale->getCategoryRealEstaleAll();
        $listCity = City::all();

        return view('backend.news_real_estale.create', compact('catesRealEstale', 'listCity'));
    }

    // get Tag
    public function getListTagRealEstale(Request $request) {
        $term = $request->term;
        $tags = TagRealEstale::where('name', 'LIKE', $term . '%')->take(50)->select('id', 'name', 'slug')->get();

        return Response::JSON($tags);
    }

    // get all district
    public function getListDistrictByCity() {
        try {
            $cityId = Input::get('city_id');
            if (!$cityId) {
                return;
            }
            $district = District::where('city_id', $cityId)->select('id', 'name')->get();
            return Response::json($district);
        } catch (Exception $ex) {
            
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $this->validate($request, [
            'news_title' => 'required|max:255|unique:news_realestale,news_title',
            'news_content' => 'required',
            'price_all' => 'required|max:100',
            'price_m2' => 'max:100',
            'total_area' => 'required',
            'cat_realestale_id' => 'required',
            'city_id' => 'required',
            'district_id' => 'required',
            'length' => 'max:10',
            'width' => 'max:10',
            'dining_room' => 'max:4',
            'kitchen' => 'max:4',
            'number_floor' => 'max:4',
            'number_bedroom' => 'max:4',
            'number_bathroom' => 'max:4',
            'feature' => 'max:255',
            'direction' => 'max:255',
            'project' => 'max:255',
            'utilities' => 'max:255',
            'environment' => 'max:255',
            'legal_state' => 'max:255',
            'place' => 'max:255',
            'mobile' => 'max:255',
                ], [
            'news_title.required' => 'Tiêu đề không để trống',
            'news_content.required' => 'Nội dung không để trống',
            'price_all.required' => 'Giá không để trống',
            'price_all.max' => 'Giá tối đa không quá 100 kí tự',
            'price_m2.max' => 'Giá/m2 tối đa không quá 100 kí tự',
            'total_area.required' => 'Diện tích không để trống',
            'cat_realestale_id.required' => 'Chưa chọn danh mục',
            'city_id.required' => 'Chưa chọn tỉnh/ thành phố',
            'district_id.required' => 'Chưa chọn quận/ huyện',
            'news_title.unique' => 'Tiêu đề đã tồn tại',
            'length.max' => 'Chiều dài tối đa không quá 10 số',
            'width.max' => 'Chiều ngang tối đa không quá 10 số',
            'dining_room.max' => 'Tối đa nhập 4 số',
            'kitchen.max' => 'Tối đa nhập 4 số',
            'number_floor.max' => 'Tối đa nhập 4 số',
            'number_bedroom.max' => 'Tối đa nhập 4 số',
            'number_bathroom.max' => 'Tối đa nhập 4 số',
            'max' => 'Tối đa nhập 255 kí tự',
        ]);
        try {
            $id = $this->newsRealEstale->create(Input::all());
            
            return Redirect::to('/'.getLang().'/admin/realestale-news/'.$id.'/create');

//            return langRedirectRoute('admin.realestale-news.index');
        } catch (ValidationException $e) {
            return langRedirectRoute('admin.realestale-news.create')->withInput()->withErrors($e->getErrors());
        }
    }
    
    public function uploadPhotosCreate($id) {
        $newsRealEstale = $this->newsRealEstale->find($id);
        
        return view('backend.news_real_estale.create_2', compact('newsRealEstale'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        $newsRealEstale = $this->newsRealEstale->find($id);
        $newsCreater = User::where('id', $newsRealEstale->news_creater)->first();
        $newsApprover = User::where('id', $newsRealEstale->news_approver)->first();

        return view('backend.news_real_estale.show', compact('newsRealEstale', 'newsCreater', 'newsApprover'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $newsRealEstale = $this->newsRealEstale->find($id);
        $catesRealEstale = $this->categoryRealEstale->getCategoryRealEstaleAll();

        $tagNews = $newsRealEstale->getTagNewsRealEstales;

        $listTags = [];
        foreach ($tagNews as $tn) {
            $listTags[] = $tn->getTagRealEstale;
        }

        $metaData = $newsRealEstale->getMetadataRealEstale;
        
        $listCity = City::all();

        return view('backend.news_real_estale.edit', compact('newsRealEstale', 'catesRealEstale', 'listTags', 'metaData', 'listCity'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        $this->validate($request, [
            'news_title' => 'required|max:255|unique:news_realestale,news_title,' . $id,
            'news_content' => 'required',
            'price_all' => 'required|max:100',
            'price_m2' => 'max:100',
            'total_area' => 'required',
            'cat_realestale_id' => 'required',
            'city_id' => 'required',
            'district_id' => 'required',
            'length' => 'max:10',
            'width' => 'max:10',
            'dining_room' => 'max:4',
            'kitchen' => 'max:4',
            'number_floor' => 'max:4',
            'number_bedroom' => 'max:4',
            'number_bathroom' => 'max:4',
            'feature' => 'max:255',
            'direction' => 'max:255',
            'project' => 'max:255',
            'utilities' => 'max:255',
            'environment' => 'max:255',
            'legal_state' => 'max:255',
            'place' => 'max:255',
            'mobile' => 'max:255',
                ], [
            'news_title.required' => 'Tiêu đề không để trống',
            'news_content.required' => 'Nội dung không để trống',
            'price_all.required' => 'Giá không để trống',
            'price_all.max' => 'Giá tối đa không quá 100 kí tự',
            'price_m2.max' => 'Giá/m2 tối đa không quá 100 kí tự',
            'total_area.required' => 'Diện tích không để trống',
            'cat_realestale_id.required' => 'Chưa chọn danh mục',
            'city_id.required' => 'Chưa chọn tỉnh/ thành phố',
            'district_id.required' => 'Chưa chọn quận/ huyện',
            'news_title.unique' => 'Tiêu đề đã tồn tại',
            'length.max' => 'Chiều dài tối đa không quá 10 số',
            'width.max' => 'Chiều ngang tối đa không quá 10 số',
            'dining_room.max' => 'Tối đa nhập 4 số',
            'kitchen.max' => 'Tối đa nhập 4 số',
            'number_floor.max' => 'Tối đa nhập 4 số',
            'number_bedroom.max' => 'Tối đa nhập 4 số',
            'number_bathroom.max' => 'Tối đa nhập 4 số',
            'max' => 'Tối đa nhập 255 kí tự',
        ]);
        try {
            $message = $this->newsRealEstale->update($id, Input::all());
            Flash::message($message);

            return langRedirectRoute('admin.realestale-news.index');
        } catch (ValidationException $e) {
            return langRedirectRoute('admin.realestale-news.edit')->withInput()->withErrors($e->getErrors());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $this->newsRealEstale->delete($id);
        Flash::message(trans('fully.mes_del_succes'));

        return langRedirectRoute('admin.realestale-news.index');
    }

    public function confirmDestroy($id) {
        $newsRealEstale = $this->newsRealEstale->find($id);

        return view('backend.news_real_estale.confirm-destroy', compact('newsRealEstale'));
    }

    public function search(Request $request) {
        $searchTitle = $request->title_new;
        $searchCate = $request->cat_id;
        if($searchTitle != "" && $searchCate != ""){
            $newsRealEstale = $this->newsRealEstale->searchNewsByCateRealAndTitle($searchCate, $searchTitle);
        }
        else if($searchCate != "") {
            $newsRealEstale = $this->newsRealEstale->searchNewsByCateReal($searchCate);
        }
        else if ($searchTitle != "") {
            $newsRealEstale = $this->newsRealEstale->searchNews($searchTitle);
        }
        $cateRealEstale = $this->categoryRealEstale->all();
        $newsRealEstale->appends(['title_new' => $searchTitle]);
        return view('backend.news_real_estale.index', compact('newsRealEstale', 'searchTitle', 'cateRealEstale'));
    }

    public function upload($id) {
        try {
            $this->newsRealEstale->upload($id, Input::file());

            return Response::json('Thành công', 200);
        } catch (ValidationException $e) {
            return Response::json('error: ' . $e->getErrors(), 400);
        }
    }

    public function deleteImage() {
        return $this->newsRealEstale->deletePhoto(Input::get('file'));
    }

}
