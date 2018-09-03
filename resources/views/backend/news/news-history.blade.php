@extends('backend/layout/layout')
@section('content')
{!! HTML::style('ckeditor/contents.css') !!}
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Lịch sử bài viết
    </h1>
    <ol class="breadcrumb">
        <li><a href="{!! langRoute('admin.news.index') !!}">Lịch sử bài viết </a></li>
        <li class="active">Lịch sử bài viết </li>
    </ol>
</section>
<br>
<br>
<div class="container">
    <div class="col-lg-12">
        <div class="pull-left">
            <div class="btn-toolbar">
                <a href="{!! langRoute('admin.news.index') !!}"
                   class="btn btn-primary"><span class="glyphicon glyphicon-arrow-left"></span>&nbsp;{{trans('fully.back')}} </a>
            </div>
        </div>
        <br> <br> <br>
        <div class="row">
            {!! $compareContent !!}
        </div>
    </div>
</div>
@stop