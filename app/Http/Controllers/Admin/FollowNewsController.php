<?php

namespace Fully\Http\Controllers\Admin;

use Response;
use DB;
use Flash;
use Fully\Models\FollowNews;
use Illuminate\Http\Request;
use Fully\Http\Controllers\Controller;

class FollowNewsController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $searchTitle = "";
        $followNews = FollowNews::orderBy('show_type', 'DESC')->orderBy('order', 'ASC')->orderBy('news_id', 'DECS')->paginate(10);

        foreach ($followNews as $fn) {
            $fn->news_title = $fn->getNews()->value('news_title');
        }

        return view('backend.follow_news.index', compact('followNews', 'searchTitle'));
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
    public function update(Request $request, $id) {
        $newsIds = $request->input('update-news-id');
        DB::beginTransaction();
        try {
            if ($newsIds != null) {
                foreach ($newsIds as $id) {
                    $followNews = FollowNews::findOrFail($id);
                    $followNews->order = $request->order[$id];
                    $followNews->save();
                    DB::commit();
                }
                Flash::message('Sửa bài viết thành công');
            } else {
                Flash::message('Chưa chọn bài viết');
            }
            return langRedirectRoute('admin.news-follow.index');
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
            $followNews = FollowNews::whereHas('getNews', function ($query) use($searchTitle) {
                        $query->where('news_title', 'like', $searchTitle . '%');
                    })->orderBy('news_id', 'DESC')->paginate(10);

            foreach ($followNews as $fn) {
                $fn->news_title = $fn->getNews()->value('news_title');
            }
        }
        $followNews->appends(['title_new' => $searchTitle]);
        return view('backend.follow_news.index', compact('followNews', 'searchTitle'));
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function togglePublish($id) {
        $followNews = FollowNews::find($id);
        $followNews->show_type = ($followNews->show_type) ? false : true;
        $followNews->save();

        return Response::json(array('result' => 'success', 'changed' => ($followNews->show_type) ? 1 : 0));
    }

}
