@extends('backend/layout/layout')
@section('content')
{!! HTML::script('/assets/js/fully.js') !!}
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
    <h1> Bình luận
        <small> | Sửa </small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{!! url(getLang(). '/admin/news-comment') !!}"><i class="fa fa-play"></i> Bình luận</a></li>
        <li class="active">Sửa</li>
    </ol>
</section>
<br>
<br>
<div class="container">

    {!! Form::open( array( 'route' => array(getLang().'.admin.news-comment.update', $comment->id), 'method' => 'PATCH')) !!}

    <!-- Conntent -->
    <div class="control-group {!! $errors->has('title') ? 'has-error' : '' !!}">
        <label class="control-label" for="title">Nội dung</label>

        <div class="controls">
            {!! Form::text('content', $comment->content, array('class'=>'form-control', 'id' => 'content', 'placeholder'=>'Content', 'value'=>Input::old('content'))) !!}
            @if ($errors->first('content'))
            <span class="help-block">{!! $errors->first('content') !!}</span>
            @endif
        </div>
    </div>
    <br>

    <!-- Form actions -->
    {!! Form::submit('Lưu', array('class' => 'btn btn-success')) !!}
    <a href="{!! url(getLang() . '/admin/news') !!}" class="btn btn-default">&nbsp;Hủy bỏ</a>
    {!! Form::close() !!}

</div>
 @include('backend.library.validate_special')
@stop