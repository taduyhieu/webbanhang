@extends('backend/layout/layout')
@section('content')
<!-- Content Header (Page header) -->
<script type="text/javascript">
    $(document).ready(function () {
        $('#notification').show().delay(4000).fadeOut(700);

        // publish settings
        $(".publish").bind("click", function (e) {
            var id = $(this).attr('id');
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: "{!! url(getLang() . '/admin/categories/" + id + "/toggle-publish/') !!}",
                headers: {
                    'X-CSRF-Token': $('meta[name="_token"]').attr('content')
                },
                success: function (response) {
                    if (response['result'] == 'success') {
                        var imagePath = (response['changed'] == 1) ? "{!!url('/')!!}/assets/images/publish.png" : "{!!url('/')!!}/assets/images/not_publish.png";
                        $("#publish-image-" + id).attr('src', imagePath);
                    }
                },
                error: function () {
                    alert("error");
                }
            })
        });
    });
</script>
<section class="content-header">
    <h1> {!!trans('fully.category')!!}
        <small> | {!!trans('fully.edit')!!}</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{!! url(getLang(). '/admin/categories') !!}"><i class="fa fa-list"></i> {!!trans('fully.category')!!}</a></li>
        <li class="active">{!!trans('fully.edit')!!}</li>
    </ol>
</section>
<br>
<br>
<div class="container">

    {!! Form::open( array( 'route' => array( getLang() . '.admin.categories.update', $category->id), 'method' => 'PATCH')) !!}
    <!-- Title -->
    <div class="col-sm-11 text-row{!! $errors->has('name') ? 'has-error' : '' !!}">
        <label class="control-label" for="name">{!!trans('fully.cate_name')!!}</label>

        <div class="controls">
            {!! Form::text('title', $category->title, array('class'=>'form-control', 'id' => 'title', 'placeholder'=>trans('fully.cate_info_name'), 'value'=>Input::old('title'))) !!}
            @if ($errors->first('title'))
            <span class="help-block">{!! $errors->first('title') !!}</span>
            @endif
        </div>
    </div>
    <br>

    <!-- Parent_id -->
    <div class="col-sm-11 text-row {!! $errors->has('cat_parent_id') ? 'has-error' : '' !!}">
        <label class="control-label" for="cat_parent_id">{!!trans('fully.category')!!}</label>

        <div class="controls">
            <select class="form-control" name="cat_parent_id">
                <option value="" selected>{!!trans('fully.category_choose')!!}</option>
                @foreach($categories as $value)
                @if($category->id != $value->id)
                <option value="{!! $value->id !!}">{!! $value->title !!}</option>
                @endif               
                @endforeach
            </select>
        </div>
    </div>

    <!-- Url_link -->
    <div class="col-sm-11 text-row{!! $errors->has('url_link') ? 'has-error' : '' !!}">
        <label class="control-label" for="url">{!!trans('fully.cate_info_url')!!}</label>

        <div class="controls">
            {!! Form::text('url_link', $category->url_link, array('class'=>'form-control', 'id' => 'url_link', 'placeholder'=>trans('fully.cate_info_url'), 'value'=>Input::old('url_link'))) !!}
            @if ($errors->first('url_link'))
            <span class="help-block">{!! $errors->first('url_link') !!}</span>
            @endif
        </div>
    </div>
    <br>
    
    <!-- Status -->
    <div class="col-sm-11 text-row{!! $errors->has('url_link') ? 'has-error' : '' !!}">
        <label class="control-label" for="url">{!!trans('fully.status')!!}</label>

        <div class="controls">
            <a href="#" id="{!! $category->id !!}" class="publish">
            <img id="publish-image-{!! $category->id !!}" src="{!!url('/')!!}/assets/images/{!! ($category->status) ? 'publish.png' : 'not_publish.png'  !!}"/></a>
        </div>
    </div>
    <br>

    <div class="col-sm-11">
    <!-- Form actions -->
    {!! Form::submit(trans('fully.save'), array('class' => 'btn btn-success')) !!}
    <a href="{!! url('/'.getLang().'/admin/categories') !!}" class="btn btn-default">&nbsp;{!!trans('fully.cancel')!!}</a>
    {!! Form::close() !!}
    </div>

</div>
@stop