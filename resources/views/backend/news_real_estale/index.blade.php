@extends('backend/layout/layout')
@section('content')

<script type="text/javascript">
    $(document).ready(function () {

        $('#notification').show().delay(4000).fadeOut(700);
        
    });
     // Validate
    $(function () {
        $('#search-news-submit').click(function () {
            if (!$('#title_new').val() && !$('#cat_id').val()) {
                alert('Chưa nhập tiêu đề bài viết hoặc danh mục');
                return;
            }
            if ($('#title_new').val() || $('#cat_id').val()) {
                $('#search-news-form').submit();
            }
        });
    });
</script>

<section class="content-header">
    <h1>
        Bài viết bất động sản
    </h1>
    <ol class="breadcrumb">
        <li><a href="{!! URL::route('admin.dashboard') !!}">Dashboard</a></li>
        <li class="active"> Bài viết bất động sản</li>
    </ol>
</section>
<br>
<div class="container">
    <div class="row">
        @include('flash::message')
        <br>
        <div class="col-sm-6">
            <div class="btn-toolbar"><a href="{!! langRoute('admin.realestale-news.create') !!}" class="btn btn-primary">
                    <span class="glyphicon glyphicon-plus"></span>&nbsp;Thêm mới</a></div>
        </div>
        <div class="col-sm-6">
            <form action="{{ route('admin.realestale-news.search') }}" id="search-news-form" method="get" class="form-inline pull-right">
                <select class="form-control" name="cat_id" id="cat_id">
                    <option value="" selected>Chọn danh mục</option>
                    @foreach($cateRealEstale as $cat)
                        <option value="{!! $cat->id !!}" style="font-weight: bold">{!! $cat->name !!}</option>
                    @endforeach
                </select>
                <div class="input-group">
                    <input class="form-control" type="text" id="title_new" name="title_new" placeholder="{{trans('fully.news_placeholder')}}" value="{{ $searchTitle }}">
                </div>
                <div class="form-group">
                    <button id="search-news-submit" class="submit btn btn-default bg-btn-green" type="button">Tìm kiếm</button>
                </div>
            </form>
        </div>
    </div>
    <br>
    <div class="col-lg-12">
        @if($newsRealEstale->count())
        <div class="row">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Stt</th>
                        <th>{!! trans('fully.news_title') !!}</th>
                        <th>{!! trans('fully.news_setting') !!}</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($newsRealEstale as $key => $newsRE )
                    <tr>
                        <td>{!! ++$key !!}</td>
                        <td> {!! link_to_route(getLang(). '.admin.realestale-news.show', $newsRE->news_title, $newsRE->id, array( 'class'=> 'btn btn-link btn-xs' )) !!}
                        </td>
                        <td>
                            @if($newsRE->news_status == 0)
                                Bài đợi biên tập
                            @elseif($newsRE->news_status == 1)
                                Bài nhận biên tập
                            @elseif($newsRE->news_status == 2)
                                Bài đã biên tập xong
                            @elseif($newsRE->news_status == 3)    
                                Bài đã xét duyệt
                            @elseif($newsRE->news_status == 4)
                                Bài đã xuất bản
                            @elseif($newsRE->news_status == 5)
                                Bài đã trả lại
                            @elseif($newsRE->news_status == 6)
                                Bài đã gỡ
                            @endif
                        </td>
                        <td>
                            <div class="btn-group">
                                <a class="btn btn-danger dropdown-toggle" data-toggle="dropdown" href="#">
                                    {{trans('fully.action')}} <span class="caret"></span> </a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="{!! langRoute('admin.realestale-news.show', array($newsRE->id)) !!}">
                                            <span class="glyphicon glyphicon-eye-open"></span>&nbsp;{{trans('fully.show')}}
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{!! langRoute('admin.realestale-news.edit', array($newsRE->id)) !!}">
                                            <span class="glyphicon glyphicon-edit"></span>&nbsp;{{trans('fully.edit')}} 
                                        </a>
                                    </li>
                                    <li class="divider"></li>
                                    <li>
                                        <a href="{!! URL::route('admin.realestale-news.delete', array($newsRE->id)) !!}">
                                            <span class="glyphicon glyphicon-remove-circle"></span>&nbsp;{{trans('fully.delete')}}
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="alert alert-danger">{{trans('fully.not_found')}}</div>
        @endif </div>
    <div class="pull-left">
        <ul class="pagination">
            {!! $newsRealEstale->render() !!}
        </ul>
    </div>
</div>
@stop