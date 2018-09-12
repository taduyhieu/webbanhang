@extends('backend/layout/layout')
@section('content')
{!! HTML::style('/bootstrap_datetimepicker/bootstrap-datetimepicker.min.css') !!}
{!! HTML::style('dropzone/css/basic.css') !!}
{!! HTML::style('jasny-bootstrap/css/jasny-bootstrap.min.css') !!}
{!! HTML::style('dropzone/css/dropzone.css') !!}
{!! HTML::script('dropzone/dropzone.js') !!}
{!! HTML::script('jasny-bootstrap/js/jasny-bootstrap.min.js') !!}
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1> Banner
        <small> | Thêm Banner</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{!! url(getLang(). '/admin/video') !!}"><i class="fa fa-play"></i> Banner</a></li>
        <li class="active">Thêm Banner</li>
    </ol>
</section>
<br>
<br>
<div class="container">
    @include('flash::message')
    <div class="pull-right">
        <div id="msg"></div>
    </div>
    {!! Form::open(array('action' => '\Fully\Http\Controllers\Admin\BannerController@store', 'files'=>true )) !!}
    <br>

    <!-- Title -->
    <div class="control-group col-sm-11 {!! $errors->has('name') ? 'has-error' : '' !!}">
        <label class="control-label" for="title">Tiêu đề banner</label>

        <div class="controls">
            {!! Form::text('name', null, array('class'=>'form-control', 'id' => 'name', 'placeholder'=>'Tiêu đề banner', 'value'=>Input::old('name'))) !!}
            @if ($errors->first('name'))
            <span class="help-block">{!! $errors->first('name') !!}</span>
            @endif
        </div>
        <br>
    </div>
    
    <div class="control-group col-sm-11 {!! $errors->has('start_date') ? 'has-error' : '' !!}">
        <label class="control-label" for="title">Ngày bắt đầu chạy banner</label>  
        <div class="controls"> {!! Form::text('start_date', null, array('class'=>'input-group date form_datetime col-sm-12','placeholder'=>'Ngày bắt đầu chạy banner', 'data-date-format'=>'yyyy-mm-dd hh:ii:00', 'data-link-field'=>'dtp_input1', 'id' => 'start_date','value'=>Input::old('start_date'))) !!}
            @if ($errors->first('start_date'))
                <span class="help-block">{!! $errors->first('start_date') !!}</span> 
            @endif 
        </div>
        <br>
    </div>
    

    <div class="control-group col-sm-11 {!! $errors->has('end_date') ? 'has-error' : '' !!}">
        <label class="control-label" for="title">Ngày kết thúc chạy banner</label>  
        <div class="controls"> {!! Form::text('end_date', null, array('class'=>'input-group date form_datetime col-sm-12','placeholder'=>'Ngày kết thúc chạy banner','data-date-format'=>'yyyy-mm-dd HH:ii:00', 'data-link-field'=>'dtp_input1', 'id' => 'start_date','value'=>Input::old('end_date'))) !!}
            @if ($errors->first('end_date'))
                <span class="help-block">{!! $errors->first('end_date') !!}</span> 
            @endif 
        </div>
        <br>
    </div>

    <div class="control-group col-sm-11 {!! $errors->has('url') ? 'has-error' : '' !!}">
        <label class="control-label" for="title">Đường đẫn đến website</label>  
        <div class="controls">
            {!! Form::text('url', null, array('class'=>'form-control', 'id' => 'url', 'placeholder'=>'Đường đẫn đến website', 'value'=>Input::old('url'))) !!}
            @if ($errors->first('url'))
            <span class="help-block">{!! $errors->first('url') !!}</span>
            @endif
        </div>
        <br>
    </div>

    <!-- Select position -->
    <!-- <div class="control-group col-sm-11 {!! $errors->has('position') ? 'has-error' : '' !!}">
        <label class="control-label" for="position">Vị trí</label>
        <div class="controls">
            <select class="form-control" name="position">
                <option value="1" style="font-weight: bold">Banner dưới Menu chính</option>
                <option value="2" style="font-weight: bold">Banner phía bên cột phải thứ nhất</option>
                <option value="3" style="font-weight: bold">Banner phía bên cột phải thứ hai</option>
                <option value="4" style="font-weight: bold">Banner dưới khối tin đầu trang chủ</option>
            </select>
            @if ($errors->first('position')) 
            <span class="help-block">{!! $errors->first('position') !!}</span>
            @endif
        </div>
        <br>
    </div> -->
    
    <!-- Image -->
    <div class="fileinput fileinput-new control-group col-sm-11 {!! $errors->has('avatar') ? 'has-error' : '' !!}" data-provides="fileinput">
         <br>
        <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 200px; height: 150px;">
        </div>
        <div> 
            @if ($errors->first('avatar')) 
                <span class="help-block">{!! $errors->first('avatar') !!}</span> 
            @endif
            <span class="btn btn-default btn-file">
                <span class="fileinput-new">{!! trans('fully.banner_select') !!}</span><span class="fileinput-exists">Đổi ảnh</span> {!! Form::file('avatar', null, array('class'=>'form-control', 'id' => 'avatar', 'placeholder'=>'Image')) !!} 
            </span>
            <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Xóa</a>
        </div>
        <br>
    </div>

    <div class="control-group col-sm-11 {!! $errors->has('status') ? 'has-error' : '' !!}">
        <label class="control-label" for="status">Lựa chọn hiển thị trên web</label>  
        <div class="controls">
            {!! Form::checkbox('status', '1') !!}
            @if ($errors->first('status'))
            <span class="help-block">{!! $errors->first('status') !!}</span>
            @endif
        </div>
    </div>

    <!-- Form actions -->
    <div class="control-group col-sm-4">
        </br>
        {!! Form::submit('Lưu', array('class' => 'btn btn-success')) !!}
        <a href="{!! url(getLang() . '/admin/banner') !!}" class="btn btn-default">&nbsp;Hủy bỏ</a>
        {!! Form::close() !!}
    </div>
{!! HTML::script('/bootstrap_datetimepicker/bootstrap-datetimepicker.js') !!}
{!! HTML::script('/bootstrap_datetimepicker/bootstrap-datetimepicker.fr.js') !!}
<script type="text/javascript">
    $('.form_datetime').datetimepicker({
        //language:  'fr',
        weekStart: 1,
        todayBtn:  1,
        autoclose: 1,
        todayHighlight: 1,
        startView: 2,
        forceParse: 0,
        showMeridian: 1
    });
    $('.form_date').datetimepicker({
        language:  'fr',
        weekStart: 1,
        todayBtn:  1,
        autoclose: 1,
        todayHighlight: 1,
        startView: 2,
        minView: 2,
        forceParse: 0
    });
    $('.form_time').datetimepicker({
        language:  'fr',
        weekStart: 1,
        todayBtn:  1,
        autoclose: 1,
        todayHighlight: 1,
        startView: 1,
        minView: 0,
        maxView: 1,
        forceParse: 0
    });
</script>
 @include('backend.library.validate_special')
@stop