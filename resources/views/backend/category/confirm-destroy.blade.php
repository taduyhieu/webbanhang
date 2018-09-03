@extends('backend/layout/layout')
@section('content')
<section class="content-header">
    <h1> {!!trans('fully.category')!!} <small> | {!!trans('fully.delete')!!}</small> </h1>
    <ol class="breadcrumb">
        <li><a href="{!! langRoute('admin.category.index') !!}"><i class="fa fa-list"></i> {!!trans('fully.category')!!}</a></li>
        <li class="active">{!!trans('fully.delete')!!}</li>
    </ol>
</section>
<br>
<br>
<br>
<div class="container">
    {!! Form::open( array( 'route' => array( getLang() . '.admin.category.destroy', $category->id ) ) ) !!}
    {!! Form::hidden( '_method', 'DELETE' ) !!}
    <div class="alert alert-warning">
        <div class="pull-left"><b>{!!trans('fully.confirm')!!}</b> <b>{!! $category->name !!} </b> ?
        </div>
        <div class="pull-right">
            {!! Form::submit( trans('fully.isYes'), array( 'class' => 'btn btn-danger' ) ) !!}
            {!! link_to( URL::previous(), trans('fully.isNo'), array( 'class' => 'btn btn-primary' ) ) !!}
        </div>
        <div class="clearfix"></div>
    </div>
    {!! Form::close() !!}
</div>
@stop