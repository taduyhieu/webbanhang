@extends('backend/layout/layout')
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1> {!!trans('fully.category')!!}
        <small> | {!!trans('fully.edit')!!}</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{!! url(getLang(). '/admin/category') !!}"><i class="fa fa-list"></i> {!!trans('fully.category')!!}</a></li>
        <li class="active">{!!trans('fully.edit')!!}</li>
    </ol>
</section>
<br>
<br>
<div class="container">

    {!! Form::open( array( 'route' => array( getLang() . '.admin.category.update', $category->id), 'method' => 'PATCH')) !!}
    <!-- Title -->
    <div class="col-sm-11 text-row{!! $errors->has('name') ? 'has-error' : '' !!}">
        <label class="control-label" for="name">{!!trans('fully.car_info_name')!!}</label>

        <div class="controls">
            {!! Form::text('name', $category->name, array('class'=>'form-control', 'id' => 'name', 'placeholder'=>trans('fully.car_info_name'), 'value'=>Input::old('name'))) !!}
            @if ($errors->first('name'))
            <span class="help-block">{!! $errors->first('name') !!}</span>
            @endif
        </div>
    </div>
    <br>

    <!-- Parent_id -->
    <div class="col-sm-11 {!! $errors->has('cat_parent_id') ? 'has-error' : '' !!}">
        <label class="control-label" for="cat_parent_id">{!!trans('fully.category')!!}</label>

        <div class="controls">
            <select class="form-control" name="cat_parent_id" value="{{ old('parent_id') }}">
                <option value="0" selected>{!!trans('fully.category_choose')!!}</option>
                @foreach($categories as $category_parent)
                <option value="{!! $category_parent->id !!}" @if($category->cat_parent_id == $category_parent->id) selected @endif>{!! $category_parent->name !!}</option>
                @endforeach
            </select>
        </div>
        <br>
    </div>
    
    <!--Order-->
    <div class="col-sm-11 text-row {!! $errors->has('order') ? 'has-error' : '' !!}">
        <label class="control-label" for="order">Thứ tự</label>

        <div class="controls">
            {!! Form::text('order', $category->order, array('class'=>'form-control', 'id' => 'order', 'placeholder'=>'Thứ tự', 'value'=>Input::old('order'))) !!}
            @if ($errors->first('order'))
            <span class="help-block">{!! $errors->first('order') !!}</span>
            @endif
        </div>
    </div>
    
    <!--Meta description-->
    <div class="col-sm-11 text-row {!! $errors->has('meta_description') ? 'has-error' : '' !!}">
        <label class="control-label" for="meta_description">Meta Description</label>

        <div class="controls">
            {!! Form::text('meta_description', $category->meta_description, array('class'=>'form-control', 'id' => 'meta_description', 'placeholder'=>'Meta Description', 'value'=>Input::old('meta_description'))) !!}
            @if ($errors->first('meta_description'))
            <span class="help-block">{!! $errors->first('meta_description') !!}</span>
            @endif
        </div>
    </div>
    
    <!--Meta Keyword-->
    <div class="col-sm-11 text-row {!! $errors->has('meta_keyword') ? 'has-error' : '' !!}">
        <label class="control-label" for="meta_keyword">Meta Keyword</label>

        <div class="controls">
            {!! Form::text('meta_keyword', $category->meta_keyword, array('class'=>'form-control', 'id' => 'meta_keyword', 'placeholder'=>'Meta Keyword', 'value'=>Input::old('meta_keyword'))) !!}
            @if ($errors->first('meta_keyword'))
            <span class="help-block">{!! $errors->first('meta_keyword') !!}</span>
            @endif
        </div>
    </div>

    <div class="col-sm-11">
    <!-- Form actions -->
    {!! Form::submit(trans('fully.save'), array('class' => 'btn btn-success')) !!}
    <a href="{!! url('/'.getLang().'/admin/category') !!}" class="btn btn-default">&nbsp;{!!trans('fully.cancel')!!}</a>
    {!! Form::close() !!}
    </div>

</div>
@stop