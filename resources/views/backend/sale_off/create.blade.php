@extends('backend/layout/layout')
@section('content')
{!! HTML::script('ckeditor/ckeditor.js') !!}
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1> {!!trans('fully.category')!!}
        <small> | {!!trans('fully.create')!!}</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{!! url(getLang(). '/admin/product-sale-off') !!}"><i class="fa fa-list"></i> {!!trans('fully.category')!!}</a></li>
        <li class="active">{!!trans('fully.create')!!}</li>
    </ol>
</section>
<br>
<br>
<div class="container">
    <div class="container">
        <div class="row">
            <div class="col-sm-5">
                {!! Form::open(array('action' => '\Fully\Http\Controllers\Admin\SaleOffController@store' )) !!}
                {!! csrf_field() !!}

                <!-- Agency -->
                <div class="col-sm-12 text-row {!! $errors->has('cat_parent_id') ? 'has-error' : '' !!}">
                    <label class="control-label" for="cat_parent_id">{!!trans('fully.category')!!}</label>

                    <div class="controls">
                        <select class="form-control" name="cat_parent_id">
                            <option value="" selected>{!!trans('fully.category_choose')!!}</option>
                            @foreach($agencies as $value)
                            <option value="{!! $value->id !!}">{!! $value->name !!}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Category -->
                <div class="col-sm-12 text-row {!! $errors->has('cat_parent_id') ? 'has-error' : '' !!}">
                    <label class="control-label" for="cat_parent_id">{!!trans('fully.category')!!}</label>

                    <div class="controls">
                        <select class="form-control" name="cat_parent_id">
                            <option value="" selected>{!!trans('fully.category_choose')!!}</option>
                            @foreach($categories as $value)
                            <option value="{!! $value->id !!}">{!! $value->title !!}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Product -->
                <div class="col-sm-12 text-row {!! $errors->has('cat_parent_id') ? 'has-error' : '' !!}">
                    <label class="control-label" for="cat_parent_id">{!!trans('fully.product_name')!!}</label>

                    <div class="controls">
                        <select class="form-control" name="cat_parent_id">
                            <option value="" selected>{!!trans('fully.category_choose')!!}</option>
                            @foreach($products as $value)
                            <option value="{!! $value->id !!}">{!! $value->product_name !!}</option>
                            @endforeach
                        </select>
                    </div>
                </div>


                <!-- Code -->
                <div class="col-sm-12 text-row {!! $errors->has('code') ? 'has-error' : '' !!}">
                    <label class="control-label" for="name">{!!trans('fully.product_code')!!}</label>

                    <div class="controls">
                        {!! Form::text('code', null, array('class'=>'form-control', 'id' => 'code', 'placeholder'=>trans('fully.product_code'), 'value'=>Input::old('code'))) !!}
                        @if ($errors->first('code'))
                        <span class="help-block">{!! $errors->first('code') !!}</span>
                        @endif
                    </div>
                </div>

                

                <div class="col-sm-12">
                    <br>
                    <!-- Form actions -->
                    {!! Form::submit(trans('fully.save'), array('class' => 'btn btn-success')) !!}
                    <a href="{!! url('/'.getLang().'/admin/product') !!}" class="btn btn-default">&nbsp;{!!trans('fully.cancel')!!}</a>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
    
</div>
<script type="text/javascript">
    window.onload = function () {
        CKEDITOR.replace('content', {
            "filebrowserBrowseUrl": "{!! url('filemanager/show') !!}",
            height: '250px',
        });
        CKEDITOR.replace('description', {
            "filebrowserBrowseUrl": "{!! url('filemanager/show') !!}",
            height: '700px',
        });
        CKEDITOR.replace('description_short', {
            "filebrowserBrowseUrl": "{!! url('filemanager/show') !!}",
            height: '400px',
        });
    };
</script>
@stop