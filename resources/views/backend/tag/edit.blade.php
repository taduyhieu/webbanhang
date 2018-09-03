@extends('backend/layout/layout')
@section('content')
{!! HTML::script('/assets/js/fully.js') !!}
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1> Tag
        <small> | Sửa Tag</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{!! url(getLang(). '/admin/news-tag') !!}"><i class="fa fa-play"></i> Tag</a></li>
        <li class="active">Sửa Tag</li>
    </ol>
</section>
<br>
<br>
<div class="container">

    {!! Form::open( array( 'route' => array(getLang().'.admin.news-tag.update', $tag->id), 'method' => 'PATCH')) !!}

    <!-- Title -->
    <div class="control-group {!! $errors->has('name') ? 'has-error' : '' !!}">
        <label class="control-label" for="title">Tiêu đề</label>

        <div class="controls">
            {!! Form::text('name', $tag->name, array('class'=>'form-control', 'id' => 'name', 'placeholder'=>'Tiêu đề', 'value'=>Input::old('name'))) !!}
            @if ($errors->first('name'))
            <span class="help-block">{!! $errors->first('name') !!}</span>
            @endif
        </div>
    </div>
    <br>

    <!-- Form actions -->
    {!! Form::submit('Lưu', array('class' => 'btn btn-success')) !!}
    <a href="{!! url(getLang() . '/admin/news-tag') !!}" class="btn btn-default">&nbsp;Hủy bỏ</a>
    {!! Form::close() !!}
</div>
 @include('backend.library.validate_special')
@stop