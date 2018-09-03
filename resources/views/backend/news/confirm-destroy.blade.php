@extends('backend/layout/layout')
@section('content')
<section class="content-header">
    <h1> {{trans('fully.news_header')}} <small> | {{trans('fully.delete')}}</small> </h1>
    <ol class="breadcrumb">
        <li><a href="{!! url(getLang() . '/admin/news') !!}"><i class="fa fa-bookmark"></i> {{trans('fully.news_header')}}</a></li>
        <li class="active">{{trans('fully.delete')}}</li>
    </ol>
</section>
<br>
<br>
<div class="col-lg-10">
    {!! Form::open( array(  'route' => array(getLang(). '.admin.news.destroy', $news->news_id ) ) ) !!}
    {!! Form::hidden( '_method', 'DELETE' ) !!}
    <div class="alert alert-warning">
        <div class="pull-left">{{trans('fully.news_delete_content')}} <b>{!! $news->news_title !!} </b> ? </div>
        <div class="pull-right"> {!! Form::submit(trans('fully.isYes'), array( 'class' => 'btn btn-danger' ) ) !!}
            {!! link_to( URL::previous(),trans('fully.isNo'), array( 'class' => 'btn btn-primary' ) ) !!} </div>
        <div class="clearfix"></div>
    </div>
    {!! Form::close() !!} </div>
@stop