@extends('backend/layout/layout')
@section('content')
{!! HTML::style('dropzone/css/basic.css') !!}
{!! HTML::style('jasny-bootstrap/css/jasny-bootstrap.min.css') !!}
{!! HTML::style('dropzone/css/dropzone.css') !!}
{!! HTML::script('dropzone/dropzone.js') !!}
{!! HTML::script('ckeditor/ckeditor.js') !!}
{!! HTML::script('jasny-bootstrap/js/jasny-bootstrap.min.js') !!}

<script type="text/javascript">
    $(document).ready(function () {
        // Hide / Show 
        $('input[type=radio][name=type]').change(function() {
            if (this.value == 1) {
                $('#slider-display').show();
                $('#video-display').hide();
                $('#description').val();
                $('#image').val();
            }
            else if (this.value == 2) {
                $('#slider-display').hide();
                $('#video-display').show();
                $('#video-url').val();
            }
        });
    });
</script>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>  {!! trans('fully.slider_slider') !!}
        <small> | Sửa</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{!! url(getLang(). '/admin/slider') !!}"><i class="fa fa-tint"></i> {!! trans('fully.slider_slider') !!}</a></li>
        <li class="active">Sửa</li>
    </ol>
</section>
<br>
<br>
<div class="container">

    {!! Form::open( array( 'route' => array( getLang() . '.admin.slider.update', $slider->id), 'method' => 'PATCH', 'files'=>true)) !!}

    <!-- Title -->
    <div class="control-group {!! $errors->has('title') ? 'has-error' : '' !!}">
        <label class="control-label" for="title">Tiêu đề</label>

        <div class="controls">
            {!! Form::text('title', $slider->title, array('class'=>'form-control', 'id' => 'title', 'placeholder'=>'Title', 'value'=>Input::old('title'))) !!}
            @if ($errors->first('title'))
            <span class="help-block">{!! $errors->first('title') !!}</span>
            @endif
        </div>
    </div>
    <br>

    <!-- Order -->
    <div class="control-group {!! $errors->has('order') ? 'has-error' : '' !!}">
        <label class="control-label" for="order">Thứ tự</label>
        <div class="controls">
            {!! Form::text('order', $slider->order, array('class'=>'form-control', 'id' => 'order', 'placeholder'=>'Thứ tự', 'value'=>Input::old('order'))) !!}
            @if ($errors->first('order'))
            <span class="help-block">{!! $errors->first('order') !!}</span>
            @endif
        </div>
    </div>
    <br>
    
    <!-- Order -->
    <div class="control-group {!! $errors->has('description') ? 'has-error' : '' !!}">
        <label class="control-label" for="description">Mô tả</label>
        <div class="controls">
            {!! Form::text('description', $slider->description, array('class'=>'form-control', 'id' => 'order', 'placeholder'=>'Mô tả', 'value'=>Input::old('description'))) !!}
            @if ($errors->first('description'))
            <span class="help-block">{!! $errors->first('description') !!}</span>
            @endif
        </div>
    </div>
    <br>

    <div id="slider-display">
        <!-- Image -->
        <div class="fileinput fileinput-new control-group {!! $errors->has('image') ? 'has-error' : '' !!}" data-provides="fileinput">
            <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
                <img data-src="" {!! (($slider->path) ? "src='".url($slider->path)."'" : null) !!} alt="...">
            </div>
            <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"></div>
            <div>
                <div> <span class="btn btn-default btn-file"><span class="fileinput-new">Chọn ảnh</span><span class="fileinput-exists">Đổi ảnh</span>
            {!! Form::file('image', null, array('class'=>'form-control', 'id' => 'image', 'placeholder'=>'Image', 'value'=>Input::old('image'))) !!}
          @if ($errors->first('image')) <span class="help-block">{!! $errors->first('image') !!}</span> @endif </span> <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Xóa</a> </div>
            </div>
            <br>
        </div>
    </div>
    <!-- Form actions -->
    <div class="control-group col-sm-4">
        {!! Form::submit('Ghi lại', array('class' => 'btn btn-success')) !!}
        {!! Form::close() !!}
    </div>
@include('backend.library.validate_special')
@stop