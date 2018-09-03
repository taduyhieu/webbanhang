@extends('backend/layout/layout')
@section('content')
{!! HTML::script('/assets/js/fully.js') !!}

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1> Tag
        <small> | Thêm mới</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{!! url(getLang(). '/admin/news-tag') !!}"><i class="fa fa-play"></i> Tag</a></li>
        <li class="active">Thêm mới</li>
    </ol>
</section>
<br>
<br>
<div class="container">
    <div class="pull-right">
        <div id="msg"></div>
    </div>
    {!! Form::open(array('action' => '\Fully\Http\Controllers\Admin\TagRealEstaleController@store' )) !!}
    {!! csrf_field() !!}
    <!-- Title -->
    <div class="control-group {!! $errors->has('name') ? 'has-error' : '' !!}">
        <label class="control-label" for="name">Tiêu đề</label>

        <div class="controls">
            {!! Form::text('name', null, array('class'=>'form-control', 'id' => 'name', 'placeholder'=>'Tiêu đề', 'value'=>Input::old('name'))) !!}
            @if ($errors->first('name'))
            <span class="help-block">{!! $errors->first('name') !!}</span>
            @endif
        </div>
    </div>
    <br>
    
    <!-- Parent id -->
    <div class="control-group {!! $errors->has('tag_parent_id') ? 'has-error' : '' !!}">
        <label class="control-label" for="tag_parent_id">Danh sách tag</label>
        <div class="controls">
            <select class="form-control" name="tag_parent_id">
                <option value="0" selected>Chọn danh sách tag</option>
                @foreach($tagParent as $tag)
                <option value="{!! $tag->id !!}">{!! $tag->name !!}</option>
                @endforeach
            </select>
        </div>
    </div>
    <br>

    <!-- Form actions -->
    {!! Form::submit('Lưu', array('class' => 'btn btn-success')) !!}
    <a href="{!! url(getLang() . '/admin/realestale-tag') !!}" class="btn btn-default">&nbsp;Hủy bỏ</a>
    {!! Form::close() !!}
</div>
@include('backend.library.validate_special')
@stop