@extends('backend/layout/layout')
@section('content')
{!! HTML::style('ckeditor/contents.css') !!}
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        {{trans('fully.news_header')}}
    </h1>
    <ol class="breadcrumb">
        <li><a href="{!! langRoute('admin.realestale-news.index') !!}">{{trans('fully.news_header')}} </a></li>
        <li class="active">{{trans('fully.news_header')}} </li>
    </ol>
</section>
<br>
<br>
<div class="container">
    <div class="col-lg-10">
        <div class="pull-left">
            <div class="btn-toolbar">
                <a href="{!! langRoute('admin.realestale-news.index') !!}"
                   class="btn btn-primary"> <span class="glyphicon glyphicon-arrow-left"></span>&nbsp;{{trans('fully.back')}} </a>
            </div>
        </div>
        <br> <br> <br>
        <table class="table table-striped">
            <tbody>
                <tr>
                    <td><strong>{{trans('fully.news_title')}}</strong></td>
                    <td>{!! $news->news_title !!}</td>
                </tr>
                <tr>
                    <td><strong>{{trans('fully.slug')}}</strong></td>
                    <td>{!! $news->slug !!}</td>
                </tr>
                <tr>
                    <td><strong>Xuất bản</strong></td>
                    <td>{!! $news->news_publisher !!}</td>
                </tr>
                <tr>
                    <td><strong>Người tạo</strong></td>
                    <td>{!! $newsCreater->full_name !!}</td>
                </tr>
                <tr>
                    <td><strong>Tác giả</strong></td>
                    <td>{!! $newsAuthor !!}</td>
                </tr>
                <tr>
                    <td><strong>Trạng thái</strong></td>
                    <td>
                        @if($news->news_status == 0)
                        Bài đợi biên tập
                        @elseif($news->news_status == 1)
                        Bài nhận biên tập
                        @elseif($news->news_status == 2)
                        Bài đã biên tập xong
                        @elseif($news->news_status == 3)    
                        Bài đã xét duyệt
                        @elseif($news->news_status == 4)
                        Bài đã xuất bản
                        @elseif($news->news_status == 5)
                        Bài đã trả lại
                        @elseif($news->news_status == 6)
                        Bài đã gỡ
                        @endif
                    </td>
                </tr>
                <tr>
                    <td><strong>Người phê duyệt</strong></td>
                    <td>{!! $newsApprover->full_name !!}</td>
                </tr>
                <tr>
                    <td><strong>{{trans('fully.conent')}}</strong></td>
                    <td>{!! $news->news_content !!}</td>
                </tr>
                <tr>
                    <td><strong>{{trans('fully.news_createddate')}}</strong></td>
                    <td>{!! $news->news_create_date !!}</td>
                </tr>
                <tr>
                    <td><strong>{{trans('fully.news_updateddate')}}</strong></td>
                    <td>{!! $news->news_modified_date !!}</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
</div>
</div>
@stop