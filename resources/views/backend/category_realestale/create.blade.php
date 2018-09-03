@extends('backend/layout/layout')
@section('content')
{!! HTML::script('/assets/js/fully.js') !!}
<script type="text/javascript">
    $(document).ready(function () {

        $("#video_id").keyup(function () {

            $("#msg").append('<div class="msg-save" style="float:right; color:red;">Searching!</div>');
            $('.msg-save').delay(1000).fadeOut(500);

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

            return false;
        });
    });
</script>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1> Phân loại bất động sản
        <small> | Thêm mới</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{!! url(getLang(). '/admin/video') !!}"><i class="fa fa-play"></i> Phân loại bất động sản</a></li>
        <li class="active">Thêm mới</li>
    </ol>
</section>
<br>
<br>
<div class="container">
    <div class="pull-right">
        <div id="msg"></div>
    </div>
    {!! Form::open(array('action' => '\Fully\Http\Controllers\Admin\CategoryRealestaleController@store' )) !!}

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

    <!-- Parent Id -->
<!--    <div class="control-group {!! $errors->has('parent_id') ? 'has-error' : '' !!}">
        <label class="control-label" for="parent_id">Thuộc danh mục</label>
        <div class="controls">
            <select class="form-control" name="parent_id">
                <option value="0" selected>Không chọn danh mục nào</option>
                @foreach($categoryRealestales as $id=>$categoryRealestale)
                <option value="{!! $categoryRealestale->id !!}" style="font-weight: bold">{!! $categoryRealestale->name !!}</option>
                @endforeach
            </select>
            @if ($errors->first('parent_id')) 
            <span class="help-block">{!! $errors->first('parent_id') !!}</span>
            @endif
        </div>
    </div>
    <br>-->

    <!-- Thứ tự -->
    <div class="control-group {!! $errors->has('order') ? 'has-error' : '' !!}">
        <label class="control-label" for="order">Thứ tự</label>

        <div class="controls">
            {!! Form::text('order', null, array('class'=>'form-control', 'id' => 'order', 'placeholder'=>'Thứ tự', 'value'=>Input::old('order'))) !!}
            @if ($errors->first('order'))
            <span class="help-block">{!! $errors->first('order') !!}</span>
            @endif
        </div>
    </div>
    <br>

    <!-- Meta description -->
    <div class="control-group {!! $errors->has('meta_description') ? 'has-error' : '' !!}">
        <label class="control-label" for="meta_description">Meta description</label>

        <div class="controls">
            {!! Form::text('meta_description', null, array('class'=>'form-control', 'id' => 'meta_description', 'placeholder'=>'Meta description', 'value'=>Input::old('meta_description'))) !!}
            @if ($errors->first('meta_description'))
            <span class="help-block">{!! $errors->first('meta_description') !!}</span>
            @endif
        </div>
    </div>
    <br>

    <!-- Meta keyword -->
    <div class="control-group {!! $errors->has('meta_keyword') ? 'has-error' : '' !!}">
        <label class="control-label" for="meta_keyword">Meta keyword</label>

        <div class="controls">
            {!! Form::text('meta_keyword', null, array('class'=>'form-control', 'id' => 'meta_keyword', 'placeholder'=>'Meta keyword', 'value'=>Input::old('meta_keyword'))) !!}
            @if ($errors->first('meta_keyword'))
            <span class="help-block">{!! $errors->first('meta_keyword') !!}</span>
            @endif
        </div>
    </div>
    <br>

    <!-- Form actions -->
    <div class="control-group">
        {!! Form::submit('Lưu', array('class' => 'btn btn-success')) !!}
        <a href="{!! url(getLang() . '/admin/realestale-category') !!}" class="btn btn-default">&nbsp;Hủy bỏ</a>
        {!! Form::close() !!}
    </div>
</div>
@include('backend.library.validate_special')
@stop

