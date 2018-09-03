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
    <h1> Phân loại bất động sản
        <small> | Sửa</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{!! url(getLang(). '/admin/realestale-category') !!}"><i class="fa fa-play"></i> Phân loại bất động sản</a></li>
        <li class="active">Sửa</li>
    </ol>
</section>
<br>
<br>
<div class="container">

    {!! Form::open( array( 'route' => array(getLang().'.admin.realestale-category.update', $categoryrealestale->id), 'method' => 'PATCH')) !!}

    <!-- Title -->
    <div class="control-group {!! $errors->has('name') ? 'has-error' : '' !!}">
        <label class="control-label" for="name">Tiêu đề</label>

        <div class="controls">
            {!! Form::text('name', $categoryrealestale->name, array('class'=>'form-control', 'id' => 'name', 'placeholder'=>'Tiêu đề', 'value'=>Input::old('name'))) !!}
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
                <option value="0">Không chọn danh mục nào</option>
                @foreach($categoryrealestales as $id=>$categoryReal)
                    <option value="{!! $categoryReal->id !!}" style="font-weight: bold" @if($categoryrealestale->parent_id == $categoryReal->id) selected @endif>{!! $categoryReal->name !!}</option>
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
            {!! Form::text('order', $categoryrealestale->order, array('class'=>'form-control', 'id' => 'order', 'placeholder'=>'Thứ tự', 'value'=>Input::old('order'))) !!}
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
            {!! Form::text('meta_description', $categoryrealestale->meta_description, array('class'=>'form-control', 'id' => 'meta_description', 'placeholder'=>'Meta description', 'value'=>Input::old('meta_description'))) !!}
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
            {!! Form::text('meta_keyword', $categoryrealestale->meta_keyword, array('class'=>'form-control', 'id' => 'meta_keyword', 'placeholder'=>'Meta keyword', 'value'=>Input::old('meta_keyword'))) !!}
            @if ($errors->first('meta_keyword'))
            <span class="help-block">{!! $errors->first('meta_keyword') !!}</span>
            @endif
        </div>
    </div>
    <br>

    <!-- Form actions -->
    {!! Form::submit('Cập nhật', array('class' => 'btn btn-success')) !!}
    <a href="{!! url(getLang() . '/admin/realestale-category') !!}" class="btn btn-default">&nbsp;Hủy bỏ</a>
    {!! Form::close() !!}

</div>
 @include('backend.library.validate_special')
@stop