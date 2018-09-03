<?php

namespace Fully\Http\Controllers\Admin;
use Response;
use DB;
use Flash;
use Fully\Models\NewsHighLight;
use Illuminate\Http\Request;
use Fully\Http\Controllers\Controller;

class NewsHighLightController extends Controller {
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $searchTitle = "";
        $newsHL = NewsHighLight::orderBy('show_type', 'DESC')->orderBy('order','ASC')->orderBy('news_id', 'DECS')->paginate(10);

        foreach ($newsHL as $hl) {
            $hl->news_title = $hl->getNews()->value('news_title');
        }

        return view('backend.news_highlight.index', compact('newsHL', 'searchTitle'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request) {
        $newsIds = $request->input('update-news-id');
        DB::beginTransaction();
        try {
            if ($newsIds != null) {
                foreach ($newsIds as $id) {
                    $newsHL = NewsHighLight::findOrFail($id);
                    $newsHL->order = $request->order[$id];
                    $newsHL->save();
                    DB::commit();
                }
                Flash::message('Sửa bài viết thành công');
            } else {
                Flash::message('Chưa chọn bài viết');
            }
            return langRedirectRoute('admin.news-highlight.index');
        } catch (Exception $exc) {
            DB::rollback();
            return $exc->getTraceAsString('Đã có lỗi xảy ra. Mời sửa lại');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        //
    }

    public function search(Request $request) {
        $searchTitle = $request->title_new;
        if (isset($searchTitle)) {
            $newsHL = NewsHighLight::whereHas('getNews', function ($query) use($searchTitle) {
                        $query->where('news_title', 'like', $searchTitle . '%');
                    })->orderBy('news_id', 'DESC')->paginate(10);

            foreach ($newsHL as $hl) {
                $hl->news_title = $hl->getNews()->value('news_title');
            }
        }
        $newsHL->appends(['title_new' => $searchTitle]);
        return view('backend.news_highlight.index', compact('newsHL', 'searchTitle'));
    }
    
    /**
     * @param $id
     *
     * @return mixed
     */
    public function togglePublish($id) {
        $newsHL = NewsHighLight::find($id);
        $newsHL->show_type = ($newsHL->show_type) ? false : true;
        $newsHL->save();

        return Response::json(array('result' => 'success', 'changed' => ($newsHL->show_type) ? 1 : 0));
    }

}
