@extends('backend/layout/layout')
@section('content')
<section class="content-header">
    <h1> {{trans('fully.photo_title')}}
        <small> | {{trans('fully.delete')}}</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{!! langRoute('admin.photo-gallery.index') !!}"><i class="fa fa-desktop"></i>{{trans('fully.photo_title')}}</a></li>
        <li class="active">{{trans('fully.delete')}}</li>
    </ol>
</section>
<br>
<br>
<br>
<div class="col-lg-10">
    {!! Form::open( array(  'route' => array(getLang(). '.admin.photo-gallery.destroy', $photo_gallery->id ) ) ) !!}
    {!! csrf_field() !!}
    {!! Form::hidden('_method', 'DELETE') !!}
    <div class="alert alert-warning">
        <div class="pull-left"> {{trans('fully.photo_delete_content')}} <b>{!! $photo_gallery->title !!} </b> ?
        </div>
        <div class="pull-right">
            {!! Form::submit(trans('fully.isYes'), array('class' => 'btn btn-danger')) !!}
            {!! link_to( URL::previous(), trans('fully.isNo'), array( 'class' => 'btn btn-primary' ) ) !!}
        </div>
        <div class="clearfix"></div>
    </div>
    {!! Form::close() !!}
</div>
@stop