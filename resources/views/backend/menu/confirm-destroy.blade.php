@extends('backend/layout/layout')
@section('content')

<section class="content-header">
    <h1> {{trans('fully.menu_form')}} <small> | {{trans('fully.menu_delete')}} </small> </h1>
    <ol class="breadcrumb">
        <li><a href="{!! url(getLang(). '/admin/menu') !!}">{{trans('fully.menu_form')}} </a></li>
        <li class="active">{{trans('fully.menu_add_item')}}</li>
    </ol>
</section>
<br>
<br>
<div class="col-lg-10">
    {!! Form::open( array( 'route' => array( getLang() . '.admin.menu.destroy', $menu->id ) ) ) !!}
    {!! Form::hidden( '_method', 'Delete' ) !!}
    <div class="alert alert-warning">
        <div class="pull-left"><b> {{trans('fully.menu_delete_content')}}</b> <b>{!! $menu->title !!} </b> ?
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
