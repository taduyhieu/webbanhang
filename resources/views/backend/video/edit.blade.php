@extends('backend/layout/layout')
@section('content')
{!! HTML::script('/assets/js/fully.js') !!}
{!! HTML::script('ckeditor/ckeditor.js') !!}
{!! HTML::style('backend/css/selectize.default.css') !!}
{!! HTML::style('assets/bootstrap/css/bootstrap-tagsinput.css') !!}
{!! HTML::style('jasny-bootstrap/css/jasny-bootstrap.min.css') !!}
{!! HTML::script('assets/bootstrap/js/bootstrap-tagsinput.js') !!}
{!! HTML::script('assets/js/jquery.slug.js') !!}
{!! HTML::script('jasny-bootstrap/js/jasny-bootstrap.min.js') !!}
{!! HTML::script('backend/js/selectize.js') !!}
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
    <h1> Video
        <small> | Update Video</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{!! url(getLang(). '/admin/video') !!}"><i class="fa fa-play"></i> Video</a></li>
        <li class="active">Update Video</li>
    </ol>
</section>
<br>
<br>
<div class="container">

    {!! Form::open( array( 'route' => array(getLang().'.admin.video.update', $video->id), 'method' => 'PATCH')) !!}

    <!-- Title -->
    <div class="control-group col-sm-10 {!! $errors->has('title') ? 'has-error' : '' !!}">
        <label class="control-label" for="title">Tiêu đề</label>

        <div class="controls">
            {!! Form::text('title', $video->title, array('class'=>'form-control', 'id' => 'title', 'placeholder'=>'Tiêu đề', 'value'=>Input::old('title'))) !!}
            @if ($errors->first('title'))
            <span class="help-block">{!! $errors->first('title') !!}</span>
            @endif
        </div>
        <br>
    </div>
    
     <!-- Id -->
    <div class="control-group col-sm-10 {!! $errors->has('title') ? 'has-error' : '' !!}">
        <label class="control-label" for="video_id">Đường dẫn url</label>

        <div class="controls">
            {!! Form::text('url_link', $video->url_link, array('class'=>'form-control', 'id' => 'url_link', 'placeholder'=>'Đường dẫn url', 'value'=>Input::old('url_link'))) !!}
            @if ($errors->first('url_link'))
            <span class="help-block">{!! $errors->first('url_link') !!}</span>
            @endif
        </div>
        <br>
    </div>
    <br>
    
    <!-- Select Category -->
    <div class="control-group col-sm-10 {!! $errors->has('cat_parent_id') ? 'has-error' : '' !!}">
        <label class="control-label" for="cat_id">Danh mục</label>
        <div class="controls">
            <select class="form-control" name="cat_id">
                @foreach($categories as $category)
                    <option value="{!! $category->id !!}" @if ($category->id == $video->cat_id) selected @endif  style="font-weight: bold">{!! $category->name !!}</option>
                @endforeach
            </select>
            @if ($errors->first('cat_id')) 
            <span class="help-block">{!! $errors->first('cat_id') !!}</span>
            @endif
        </div>
        <br>
    </div>

    <!-- Content -->
    <div class="control-group col-sm-10 {!! $errors->has('content') ? 'has-error' : '' !!}">
        <label class="control-label" for="content">Nội dung</label>

        <div class="controls"> {!! Form::textarea('content', $video->content, array('class'=>'form-control', 'id' => 'content',
            'placeholder'=>trans('fully.comment_content'), 'value'=>Input::old('content'))) !!}
            @if ($errors->first('content'))
            <span class="help-block">{!! $errors->first('content') !!}</span>
            @endif
        </div>
        <br>
    </div>

    <!-- Form actions -->
    <div class="control-group col-sm-10">
        <br>
        {!! Form::submit('Lưu', array('class' => 'btn btn-success')) !!}
        <a href="{!! url(getLang() . '/admin/video') !!}" class="btn btn-default">&nbsp;Hủy bỏ</a>
        {!! Form::close() !!}

    </div>
    <br>
</div>
<script type="text/javascript">
    window.onload = function () {
        CKEDITOR.replace('content', {
            "filebrowserBrowseUrl": "{!! url('filemanager/show') !!}",
        });
    };
</script>
 @include('backend.library.validate_special')
@stop