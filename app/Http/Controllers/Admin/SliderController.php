<?php

namespace Fully\Http\Controllers\Admin;

use Fully\Http\Controllers\Controller;
use Illuminate\Http\Request;
use View;
use Input;
use Fully\Models\Slider;
use Validator;
use Response;
use File;
use Image;
use Config;
use Flash;
use DB;

/**
 * Class SliderController.
 *
 * @author TDH <taduyhieucntt98@gmail.com>
 */
class SliderController extends Controller
{
    protected $width;
    protected $height;
    protected $imgDir;

    public function __construct()
    {
        View::share('active', 'plugins');

        $config = Config::get('fully');
        $this->width = $config['modules']['slider']['image_size']['width'];
        $this->height = $config['modules']['slider']['image_size']['height'];
        $this->imgDir = $config['modules']['slider']['image_dir'];
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $sliders = Slider::orderBy('created_at', 'DESC')->paginate(10);

        return view('backend.slider.index', compact('sliders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {   
        return view('backend.slider.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $formData = Input::all();
        $slider = new Slider();

        $upload_success = null;
        // Validate
        $this->validate($request, [
            'title' => 'required|min:3',
            'order' => 'required|integer|unique:sliders,order',
            'description' => 'required',
            'image' => 'required',
        ],[
            'title.required' =>  'Bắt buộc nhập tiêu đề',
            'title.min'      =>  'Tiêu đề phải hơn 3 kí tự',
            'order.required' =>  'Bắt buộc nhập thứ tự',
            'order.integer' =>  'Bắt buộc nhập số nguyên',
            'order.unique'      =>  'Thứ tự đã tồn tại',
            'description.required' =>  'Bắt buộc nhập mô tả',
            'image.required' =>  'Bắt buộc thêm ảnh',
        ]);

        try {
            if (isset($formData['image'])) {
                $file = $formData['image'];

                $destinationPath = public_path().$this->imgDir;
                $fileName = $file->getClientOriginalName();
                $fileSize = $file->getClientSize();

                $upload_success = $file->move($destinationPath, $fileName);

            // resizing an uploaded file
                Image::make($destinationPath.$fileName)->resize($this->width, $this->height)->save($destinationPath.$fileName);

                $slider->file_name = $fileName;
                $slider->file_size = $fileSize;

                $slider->path = $this->imgDir.$fileName;
            }

            $slider->title = $formData['title'];
            $slider->order = $formData['order'];
            $slider->description = $formData['description'];
            $slider->lang = getLang();
            $slider->save();

            Flash::message(trans('fully.mes_add_succes'));

            return langRedirectRoute('admin.slider.index');
        } catch (Exception $e) {
            Flash::message(trans('fully.mes_slider_log'));
            return langRedirectRoute('admin.slider.create')->withInput();
        }
        
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
        $slider = Slider::findOrFail($id);

        return view('backend.slider.edit', compact('slider'));
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
        $formData = Input::all();
        $slider = Slider::findOrFail($id);
        // Validate
        $this->validate($request, [
            'title' => 'required|min:3',
            'order' => 'required|integer',
        ],[
            'title.required' =>  trans('Bắt buộc nhập tiêu đề'),
            'title.min'      =>  trans('Tiêu đề phải hơn 3 kí tự'),
            'order.required' =>  trans('Bắt buộc nhập thứ tự'),
            'order.integer' =>  trans('Bắt buộc nhập số nguyên'),
        ]);

        if (isset($formData['image'])) {
            if ($file = $formData['image']) {

                // delete old image
                $destinationPath = public_path().$this->imgDir;
                File::delete($destinationPath.$slider->file_name);

                $destinationPath = public_path().$this->imgDir;
                $fileName = $file->getClientOriginalName();
                $fileSize = $file->getClientSize();

                $upload_success = $file->move($destinationPath, $fileName);

                if ($upload_success) {

                    // resizing an uploaded file
                    Image::make($destinationPath.$fileName)->resize($this->width, $this->height)->save($destinationPath.$fileName);
                    
                    $slider->file_name = $fileName;
                    $slider->file_size = $fileSize;
                    $slider->path = $this->imgDir.$fileName;
                }
            }
        }
        $slider->title = $formData['title'];
        $slider->order = $formData['order'];
        $slider->description = $formData['description'];
        $slider->save();

        Flash::message(trans('fully.mes_update_succes'));

        return langRedirectRoute('admin.slider.index');
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
        $slider = Slider::find($id);

        return view('backend.slider.show', compact('slider'));
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
        $slider = Slider::where('id',$id)->findOrFail($id);
        $destinationPath = public_path().$this->imgDir;

        File::delete($destinationPath.$slider->file_name);
        $slider->delete();

        Flash::message(trans('fully.mes_del_succes'));

        return langRedirectRoute('admin.slider.index');
    }

    public function confirmDestroy($id)
    {
        $slider = Slider::findOrFail($id);

        return view('backend.slider.confirm-destroy', compact('slider'));
    }
}
