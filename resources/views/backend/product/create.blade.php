@extends('backend/layout/layout')
@section('content')
{!! HTML::script('ckeditor/ckeditor.js') !!}
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1> {!!trans('fully.category')!!}
        <small> | {!!trans('fully.create')!!}</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{!! url(getLang(). '/admin/product') !!}"><i class="fa fa-list"></i> {!!trans('fully.category')!!}</a></li>
        <li class="active">{!!trans('fully.create')!!}</li>
    </ol>
</section>
<br>
<br>
<div class="container">

    {!! Form::open(array('action' => '\Fully\Http\Controllers\Admin\ProductController@store' )) !!}
    {!! csrf_field() !!}

    <!-- Title -->
    <div class="col-sm-11 text-row {!! $errors->has('title') ? 'has-error' : '' !!}">
        <label class="control-label" for="name">{!!trans('fully.product_name')!!}</label>

        <div class="controls">
            {!! Form::text('product_name', null, array('class'=>'form-control', 'id' => 'product_name', 'placeholder'=>trans('fully.product_name'), 'value'=>Input::old('product_name'))) !!}
            @if ($errors->first('product_name'))
            <span class="help-block">{!! $errors->first('product_name') !!}</span>
            @endif
        </div>
    </div>

    <!-- Code -->
    <div class="col-sm-11 text-row {!! $errors->has('code') ? 'has-error' : '' !!}">
        <label class="control-label" for="name">{!!trans('fully.product_code')!!}</label>

        <div class="controls">
            {!! Form::text('code', null, array('class'=>'form-control', 'id' => 'code', 'placeholder'=>trans('fully.product_code'), 'value'=>Input::old('code'))) !!}
            @if ($errors->first('code'))
            <span class="help-block">{!! $errors->first('code') !!}</span>
            @endif
        </div>
    </div>

    <!-- Content -->
    <div class="col-sm-11 control-group {!! $errors->has('content') ? 'has-error' : '' !!}">
        <label class="control-label" for="news_content">Nội dung (*)</label>

        <div class="controls"> {!! Form::textarea('content', null, array('class'=>'form-control h-25', 'id' => 'content', 'placeholder'=>trans('fully.product_content'), 'value'=>Input::old('content'))) !!}
            @if ($errors->first('content'))
            <span class="help-block">{!! $errors->first('content') !!}</span>
            @endif
        </div>
    </div>
    
    <!-- Agency -->
    <div class="col-sm-11 text-row {!! $errors->has('product_categories_id') ? 'has-error' : '' !!}">
        <label class="control-label" for="cat_parent_id">{!!trans('fully.product_agency')!!}</label>

        <div class="controls">
            <select class="form-control" name="cat_parent_id">
                <option value="0" selected>{!!trans('fully.category_choose')!!}</option>
                @foreach($categories as $value)
                <option value="{!! $value->id !!}">{!! $value->title !!}</option>
                @endforeach
            </select>
        </div>
    </div>

    <!-- Category -->
    <div class="col-sm-11 text-row {!! $errors->has('product_categories_id') ? 'has-error' : '' !!}">
        <label class="control-label" for="cat_parent_id">{!!trans('fully.product_category')!!}</label>

        <div class="controls">
            <select class="form-control" name="cat_parent_id">
                <option value="0" selected>{!!trans('fully.category_choose')!!}</option>
                @foreach($categories as $value)
                <option value="{!! $value->id !!}">{!! $value->title !!}</option>
                @endforeach
            </select>
        </div>
    </div>

    <!-- Quatity -->
    <div class="col-sm-11 text-row {!! $errors->has('code') ? 'has-error' : '' !!}">
        <label class="control-label" for="name">{!!trans('fully.product_quatities')!!}</label>

        <div class="controls">
            {!! Form::number('quatities', null, array('class'=>'form-control', 'id' => 'code', 'placeholder'=>trans('fully.product_quatities'), 'value'=>Input::old('quatities'))) !!}
            @if ($errors->first('quatities'))
            <span class="help-block">{!! $errors->first('quatities') !!}</span>
            @endif
        </div>
    </div>

    <!-- Price -->
    <div class="col-sm-11 text-row {!! $errors->has('code') ? 'has-error' : '' !!}">
        <label class="control-label" for="name">{!!trans('fully.product_price')!!}</label>

        <div class="controls">
            {!! Form::number('price', null, array('class'=>'form-control', 'id' => 'code', 'placeholder'=>trans('fully.product_price'), 'value'=>Input::old('price'))) !!}
            @if ($errors->first('price'))
            <span class="help-block">{!! $errors->first('price') !!}</span>
            @endif
        </div>
    </div>

    <!-- Color -->
    <div class="col-sm-11 text-row {!! $errors->has('code') ? 'has-error' : '' !!}">
        <label class="control-label" for="name">{!!trans('fully.product_color')!!}</label>

        <div class="controls">
            {!! Form::number('color', null, array('class'=>'form-control', 'id' => 'code', 'placeholder'=>trans('fully.product_color'), 'value'=>Input::old('color'))) !!}
            @if ($errors->first('color'))
            <span class="help-block">{!! $errors->first('color') !!}</span>
            @endif
        </div>
    </div>

    <!-- Description -->
    <div class="col-sm-11 control-group {!! $errors->has('description') ? 'has-error' : '' !!}">
        <label class="control-label" for="description">Mô tả (*)</label>

        <div class="controls"> {!! Form::textarea('description', null, array('class'=>'form-control', 'id' => 'description', 'placeholder'=>trans('fully.product_description'), 'value'=>Input::old('description'))) !!}
            @if ($errors->first('description'))
            <span class="help-block">{!! $errors->first('description') !!}</span>
            @endif
        </div>
    </div>

    <!-- Description short -->
    <div class="col-sm-11 control-group {!! $errors->has('description_short') ? 'has-error' : '' !!}">
        <label class="control-label" for="description_short">Mô tả ngắn (*)</label>

        <div class="controls"> {!! Form::textarea('content', null, array('class'=>'form-control', 'id' => 'description_short', 'placeholder'=>trans('fully.product_description_short'), 'value'=>Input::old('description_short'))) !!}
            @if ($errors->first('description_short'))
            <span class="help-block">{!! $errors->first('description_short') !!}</span>
            @endif
        </div>
    </div>

    <div class="col-sm-11">
        <br>
        <!-- Form actions -->
        {!! Form::submit(trans('fully.save'), array('class' => 'btn btn-success')) !!}
        <a href="{!! url('/'.getLang().'/admin/product') !!}" class="btn btn-default">&nbsp;{!!trans('fully.cancel')!!}</a>
        {!! Form::close() !!}
    </div>
</div>
<script type="text/javascript">
    window.onload = function () {
        CKEDITOR.replace('content', {
            "filebrowserBrowseUrl": "{!! url('filemanager/show') !!}",
            height: '250px',
        });
        CKEDITOR.replace('description', {
            "filebrowserBrowseUrl": "{!! url('filemanager/show') !!}",
            height: '700px',
        });
        CKEDITOR.replace('description_short', {
            "filebrowserBrowseUrl": "{!! url('filemanager/show') !!}",
            height: '400px',
        });
    };
</script>
@stop