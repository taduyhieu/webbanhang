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
    {!! Form::open(array('action' => '\Fully\Http\Controllers\Admin\TagController@store' )) !!}

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

    <!-- Form actions -->
    {!! Form::submit('Lưu', array('class' => 'btn btn-success')) !!}
    <a href="{!! url(getLang() . '/admin/news-tag') !!}" class="btn btn-default">&nbsp;Hủy bỏ</a>
    {!! Form::close() !!}
</div>
@include('backend.library.validate_special')
@stop