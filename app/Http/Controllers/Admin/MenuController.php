<?php

namespace Fully\Http\Controllers\Admin;

use Fully\Http\Controllers\Controller;
use View;
use Validator;
use Redirect;
use Input;
use Fully\Models\Menu;
use Fully\Models\Category;
use URL;
use Exception;
use Response;
use Flash;

/**
 * Class MenuController.
 *
 * @author TDH <taduyhieucntt98@gmail.com>
 */
class MenuController extends Controller {

    protected $menu;

    public function __construct(Menu $menu) {
        $this->menu = $menu;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        $items = $this->menu->orderBy('order', 'asc')->where('lang', getLang())->get();
        $menus = $this->menu->getMenuHTML($items);

        return view('backend.menu.index', compact('menus'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        $options = $this->menu->getMenuOptions();

        return view('backend.menu.create', compact('options'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store() {
        $formData = Input::all();

        if ($formData['type'] == 'module') {
            $option = $formData['option'];
            $url = $this->menu->getUrl($option);
            $formData['url'] = $url;
        }

        $host = $_SERVER['SERVER_NAME'];
        $urlInfo = parse_url($formData['url']);

        $rules = array(
            'title' => 'required',
            'url' => 'required',
        );

        $validation = Validator::make($formData, $rules);

        if ($validation->fails()) {
            return langRedirectRoute('admin.menu.create')->withErrors($validation)->withInput();
        }

        $this->menu->fill($formData);
        $this->menu->order = $this->menu->getMaxOrder() + 1;

        if (isset($urlInfo['host'])) {
            $url = ($host == $urlInfo['host']) ? $urlInfo['path'] : $formData['url'];
        } else {
            $url = ($formData['type'] == 'module') ? $formData['url'] : 'http://' . $formData['url'];
        }

        $this->menu->lang = getLang();
        $this->menu->url = $url;
        $this->menu->save();

        Flash::message(trans('fully.mes_menu_add'));

        return langRedirectRoute('admin.menu.index');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id) {
        return view('menu.show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id) {
        $options = $this->menu->getMenuOptions();
        $menu = $this->menu->find($id);
        $menu->module = $this->getModule($menu->url);
        return view('backend.menu.edit', compact('menu', 'options'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function update($id) {
        $formData = Input::all();

        if ($formData['type'] == 'module') {
            $option = $formData['option'];
            $url = $this->menu->getUrl($option);
            $formData['url'] = $url;
        }

        $host = $_SERVER['SERVER_NAME'];
        $urlInfo = parse_url($formData['url']);

        $rules = array(
            'title' => 'required',
            'url' => 'required',
        );

        $validation = Validator::make($formData, $rules);

        if ($validation->fails()) {
            return langRedirectRoute('admin.menu.create')->withErrors($validation)->withInput();
        }

        $this->menu = $this->menu->find($id);
        $this->menu->fill($formData);

        if (isset($urlInfo['host'])) {
            $url = ($host == $urlInfo['host']) ? $urlInfo['path'] : $formData['url'];
        } else {
            $url = ($formData['type'] == 'module') ? $formData['url'] : 'http://' . $formData['url'];
        }

        $this->menu->url = $url;
        $this->menu->save();

        Flash::message(trans('fully.mes_menu_update'));

        return langRedirectRoute('admin.menu.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy($id) {
        if ($this->menu->hasChildItems($id)) {

            //throw new Exception("This menu has sub-menus. Can't delete!");
            Flash::message(trans('fully.mes_menu_log'));

            return Redirect::action('App\Controllers\Admin\MenuController@index');
        }

        $this->menu = $this->menu->find($id);
        $this->menu->delete();
        Flash::message(trans('fully.mes_menu_del'));

        return langRedirectRoute('admin.menu.index');
    }

    public function confirmDestroy($id) {
        $menu = $this->menu->find($id);

        return view('backend.menu.confirm-destroy', compact('menu'));
    }

    public function save() {
        $this->menu->changeParentById($this->menu->parseJsonArray(json_decode(Input::get('json'), true)));

        return Response::json(array('result' => 'success'));
    }

    public function togglePublish($id) {
        $this->menu = $this->menu->find($id);
        $this->menu->is_published = ($this->menu->is_published) ? false : true;
        $this->menu->save();

        return Response::json(array('result' => 'success', 'changed' => ($this->menu->is_published) ? 1 : 0));
    }

    public function getModule($optionUrl) {
        $module = '';
        switch ($optionUrl) {
            case '':
                $module = 'home';
                break;
            case 'video':
                $module = 'video';
                break;
            case 'san-giao-dich':
                $module = 'real-estale';
                break;
            default:
                $currentSlug = str_replace('/', '', str_replace("danh-muc", "", $optionUrl));
                $cate = Category::findBySlug($currentSlug);
                $module ='Fully\Models\Category-' . $cate->id;
                break;
        }
        return $module;
    }

}
