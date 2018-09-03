@extends('backend/layout/layout')
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        {{trans('fully.comment_header')}}
    </h1>
    <ol class="breadcrumb">
        <li><a href="{!! URL::route('admin.news.comment.listComment') !!}">{{trans('fully.comment_header')}} </a></li>
        <li class="active">{{trans('fully.comment_header')}} </li>
    </ol>
</section>
<br>
<br>
<div class="container">
    <div class="col-lg-10">
        <div class="pull-left">
            <div class="btn-toolbar">
                <a href="{!! langRoute('admin.news-comment.index') !!}"
                   class="btn btn-primary"> <span class="glyphicon glyphicon-arrow-left"></span>&nbsp;{{trans('fully.back')}} </a>
            </div>
        </div>
        <br> <br> <br>
        <table class="table table-striped">
            <tbody>
                <tr>
                    <td><strong>Bình luận thuộc về bài viết</strong></td>
                    <td>{!! $comment->news_title !!}</td>
                </tr>
                <tr>
                    <td><strong>{{trans('fully.user_comment')}}</strong></td>
                    <td>{!! $comment->name !!}</td>
                </tr>
                <tr>
                    <td><strong>{{trans('fully.comment_content')}}</strong></td>
                    <td>{!! $comment->content !!}</td>
                </tr>
                <tr>
                    <td><strong>{{trans('fully.comment_post_time')}}</strong></td>
                    <td>{!! date('d/m/Y H:i:s', strtotime($comment->post_time)) !!}</td>
                </tr>
                <tr>
                    <td><strong>{{trans('fully.comment_publish_time')}}</strong></td>
                    <td>{!! date('d/m/Y H:i:s', strtotime($comment->publish_time)) !!}</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@stop