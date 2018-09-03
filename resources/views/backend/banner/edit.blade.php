@extends('backend/layout/layout')
@section('content')
{!! HTML::style('/bootstrap_datetimepicker/bootstrap-datetimepicker.min.css') !!}
{!! HTML::style('dropzone/css/basic.css') !!}
{!! HTML::style('jasny-bootstrap/css/jasny-bootstrap.min.css') !!}
{!! HTML::style('dropzone/css/dropzone.css') !!}
{!! HTML::script('dropzone/dropzone.js') !!}
{!! HTML::script('jasny-bootstrap/js/jasny-bootstrap.min.js') !!}
<script type="text/javascript">
    $(document).ready(function () {

        $("#video_id").keyup(function () {
            var id = $(this).val();
            var type = $('input[name=type]:checked').val();

            id = urlParser(id, type);

            $.ajax({
                type: "POST",
                url: "{!! url(getLang() . '/admin/video/get-video-detail') !!}",
                data: {"video_id": id, "type": type},
                headers: {
                    'X-CSRF-Token': $('meta[name="_token"]').attr('content')
                },
                success: function (response) {

                    //console.log(response);
                    $("#video_id").val(response.id);
                    $("#title").val(response.title);

                },
                error: function () {
                    //alert("error");
                }
            });

        });
    });
</script>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1> Banner
        <small> | Update Banner</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{!! url(getLang(). '/admin/banner') !!}"><i class="fa fa-play"></i> Banner</a></li>
        <li class="active">Update Banner</li>
    </ol>
</section>
<br>
<br>
<div class="container">
    
    @include('flash::message')
    {!! Form::open( array( 'route' => array(getLang().'.admin.banner.update', $banner->id), 
    'method' => 'PATCH', 'files' => true)) !!}

    <!-- Title -->
    <div class="control-group col-sm-11 {!! $errors->has('name') ? 'has-error' : '' !!}">
        <label class="control-label" for="title">Tiêu đề banner</label>

        <div class="controls">
            {!! Form::text('name', $banner->name, array('class'=>'form-control', 'id' => 'name', 'placeholder'=>'Tiêu đề banner', 'value'=>Input::old('name'))) !!}
            @if ($errors->first('name'))
            <span class="help-block">{!! $errors->first('name') !!}</span>
            @endif
        </div>
        <br>
    </div>
      
    <div class="control-group col-sm-11 {!! $errors->has('start_date') ? 'has-error' : '' !!}">
        <label class="control-label" for="title">Ngày bắt đầu chạy banner</label>  
        <div class="controls"> {!! Form::text('start_date', $banner->start_date, array('class'=>'input-group date form_datetime col-sm-12','placeholder'=>'Ngày bắt đầu chạy banner', 'data-date-format'=>'yyyy-mm-dd hh:ii:00', 'data-link-field'=>'dtp_input1', 'id' => 'start_date','value'=>Input::old('start_date'))) !!}
            @if ($errors->first('start_date'))
                <span class="help-block">{!! $errors->first('start_date') !!}</span> 
            @endif 
        </div>
        <br>
    </div>

    <div class="control-group col-sm-11 {!! $errors->has('end_date') ? 'has-error' : '' !!}">
        <label class="control-label" for="title">Ngày kết thúc chạy banner</label>  
        <div class="controls"> {!! Form::text('end_date', $banner->end_date, array('class'=>'input-group date form_datetime col-sm-12','placeholder'=>'Ngày kết thúc chạy banner','data-date-format'=>'yyyy-mm-dd HH:ii:00', 'data-link-field'=>'dtp_input1', 'id' => 'start_date','value'=>Input::old('end_date'))) !!}
            @if ($errors->first('end_date'))
                <span class="help-block">{!! $errors->first('end_date') !!}</span> 
            @endif 
        </div>
        <br>
    </div>

    <div class="control-group col-sm-11 {!! $errors->has('url') ? 'has-error' : '' !!}">
        <label class="control-label" for="title">Đường đẫn đến website</label>  
        <div class="controls">
            {!! Form::text('url', $banner->url, array('class'=>'form-control', 'id' => 'url', 'placeholder'=>'Đường đẫn đến website', 'value'=>Input::old('url'))) !!}
            @if ($errors->first('url'))
            <span class="help-block">{!! $errors->first('url') !!}</span>
            @endif
        </div>
        <br>
    </div>
    
    <!-- Select position -->
    <div class="control-group col-sm-11 {!! $errors->has('position') ? 'has-error' : '' !!}">
        <label class="control-label" for="position">Vị trí</label>
        <div class="controls">
            <select class="form-control" name="position">
                <option value="1" style="font-weight: bold" @if($banner->position == 1) selected @endif>Banner dưới Menu chính</option>
                <option value="2" style="font-weight: bold" @if($banner->position == 2) selected @endif>Banner phía bên cột phải thứ nhất</option>
                <option value="3" style="font-weight: bold" @if($banner->position == 3) selected @endif>Banner phía bên cột phải thứ hai</option>
                <option value="4" style="font-weight: bold" @if($banner->position == 4) selected @endif>Banner dưới khối tin đầu trang chủ</option>
            </select>
            @if ($errors->first('position')) 
            <span class="help-block">{!! $errors->first('position') !!}</span>
            @endif
        </div>
        <br>
    </div>

    <!-- Image -->
    <div class="fileinput fileinput-new control-group col-sm-11 {!! $errors->has('avatar') ? 'has-error' : '' !!}" data-provides="fileinput">
        <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 200px; height: 150px;">
            <img data-src="" {!! (($banner->path) ? "src='".url($banner->path)."'" : null) !!} alt="...">
        </div>
        <div> 
            @if ($errors->first('avatar')) 
                <span class="help-block">{!! $errors->first('avatar') !!}</span> 
            @endif
            <span class="btn btn-default btn-file">
                <span class="fileinput-new">{!! trans('fully.banner_select') !!}</span><span class="fileinput-exists">Đổi ảnh</span> {!! Form::file('avatar', array('class'=>'form-control', 'id' => 'avatar', 'placeholder'=>'Image')) !!}  
            </span>
        </div>
        <br>
    </div>
    
    <div class="control-group col-sm-11 {!! $errors->has('status') ? 'has-error' : '' !!}">
        <label class="control-label" for="title">Lựa chọn hiển thị trên web</label>  
        <div class="controls">
            {!! Form::checkbox('status', '1', $banner->status ? 'true' : '') !!}
            @if ($errors->first('status'))
            <span class="help-block">{!! $errors->first('status') !!}</span>
            @endif
        </div>
        <br>
    </div>

    <!-- Form actions -->
    <div class="control-group col-sm-4">
        <br/>
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