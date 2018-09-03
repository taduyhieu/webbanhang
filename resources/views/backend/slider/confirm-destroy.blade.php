@extends('backend/layout/layout')
@section('content')
<section class="content-header">
    <h1> {!! trans('fully.slider_slider') !!}
        <small> | Xóa</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{!! langRoute('admin.slider.index') !!}"><i class="fa fa-dashboard"></i> {!! trans('fully.slider_slider') !!}</a></li>
        <li class="active">Xóa</li>
    </ol>
</section>
<br>
<br>
<br>
<div class="col-lg-10">
    {!! Form::open( array(  'route' => array(getLang(). '.admin.slider.destroy', $slider->id ) ) ) !!}
    {!! Form::hidden( '_method', 'DELETE' ) !!}
    <div class="alert alert-warning">
        <div class="pull-left"><b> Bạn có muốn xóa </b> <b>{!! $slider->title !!} </b> ?
        </div>
        <div class="pull-right">
            {!! Form::submit( 'Có', array( 'class' => 'btn btn-danger' ) ) !!}
            {!! link_to( URL::previous(), 'Không', array( 'class' => 'btn btn-primary' ) ) !!}
        </div>
        <div class="clearfix"></div>
    </div>
    {!! Form::close() !!}
</div>
@stop