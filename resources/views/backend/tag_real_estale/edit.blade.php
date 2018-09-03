@extends('backend/layout/layout')
@section('content')
{!! HTML::script('/assets/js/fully.js') !!}
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1> Tag Bất động sản
        <small> | Sửa</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{!! url(getLang(). '/admin/realestale-tag') !!}"><i class="fa fa-play"></i> Tag Bất động sản</a></li>
        <li class="active">Sửa</li>
    </ol>
</section>
<br>
<br>
<div class="container">

    {!! Form::open( array( 'route' => array(getLang().'.admin.realestale-tag.update', $tagRealEstale->id), 'method' => 'PATCH')) !!}

    <!-- Title -->
    <div class="control-group {!! $errors->has('name') ? 'has-error' : '' !!}">
        <label class="control-label" for="title">Tiêu đề</label>

        <div class="controls">
            {!! Form::text('name', $tagRealEstale->name, array('class'=>'form-control', 'id' => 'name', 'placeholder'=>'Tiêu đề', 'value'=>Input::old('name'))) !!}
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
                <option value="{!! $tag->id !!}" @if($tagRealEstale->tag_parent_id == $tag->id) selected @endif>{!! $tag->name !!}</option>
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