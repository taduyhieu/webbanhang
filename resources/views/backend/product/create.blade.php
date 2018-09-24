@extends('backend/layout/layout')
@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1> {!!trans('fully.category')!!}
        <small> | {!!trans('fully.create')!!}</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{!! url(getLang(). '/admin/category') !!}"><i class="fa fa-list"></i> {!!trans('fully.category')!!}</a></li>
        <li class="active">{!!trans('fully.create')!!}</li>
    </ol>
</section>
<br>
<br>
<div class="container">

    {!! Form::open(array('action' => '\Fully\Http\Controllers\Admin\CategoriesController@store' )) !!}
    {!! csrf_field() !!}

    <!-- Title -->
    <div class="col-sm-11 text-row {!! $errors->has('title') ? 'has-error' : '' !!}">
        <label class="control-label" for="name">{!!trans('fully.cate_name')!!}</label>

        <div class="controls">
            {!! Form::text('title', null, array('class'=>'form-control', 'id' => 'title', 'placeholder'=>trans('fully.cate_name'), 'value'=>Input::old('title'))) !!}
            @if ($errors->first('title'))
            <span class="help-block">{!! $errors->first('title') !!}</span>
            @endif
        </div>
    </div>

    <!-- Parent_id -->
    <div class="col-sm-11 text-row {!! $errors->has('cat_parent_id') ? 'has-error' : '' !!}">
        <label class="control-label" for="cat_parent_id">{!!trans('fully.category')!!}</label>

        <div class="controls">
            <select class="form-control" name="cat_parent_id">
                <option value="" selected>{!!trans('fully.category_choose')!!}</option>
                @foreach($categories as $value)
                <option value="{!! $value->id !!}">{!! $value->title !!}</option>
                @endforeach
            </select>
        </div>
    </div>

    <!-- Url_link -->
    <div class="col-sm-11 text-row{!! $errors->has('url_link') ? 'has-error' : '' !!}">
        <label class="control-label" for="url">{!!trans('fully.cate_info_url')!!}</label>

        <div class="controls">
            {!! Form::text('url_link', null, array('class'=>'form-control', 'id' => 'url_link', 'placeholder'=>trans('fully.cate_info_url'), 'value'=>Input::old('url_link'))) !!}
            @if ($errors->first('url_link'))
            <span class="help-block">{!! $errors->first('url_link') !!}</span>
            @endif
        </div>
    </div>
    <br>

    <div class="col-sm-11">
        <br>
        <!-- Form actions -->
        {!! Form::submit(trans('fully.save'), array('class' => 'btn btn-success')) !!}
        <a href="{!! url('/'.getLang().'/admin/categories') !!}" class="btn btn-default">&nbsp;{!!trans('fully.cancel')!!}</a>
        {!! Form::close() !!}
    </div>
</div>
@stop