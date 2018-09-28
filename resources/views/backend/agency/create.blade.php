@extends('backend/layout/layout')
@section('content')
{!! HTML::script('ckeditor/ckeditor.js') !!}
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1> {!!trans('fully.agency')!!}
        <small> | {!!trans('fully.create')!!}</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{!! url(getLang(). '/admin/agency') !!}"><i class="fa fa-list"></i> {!!trans('fully.agency')!!}</a></li>
        <li class="active">{!!trans('fully.create')!!}</li>
    </ol>
</section>
<br>
<br>
<div class="container">

    {!! Form::open(array('action' => '\Fully\Http\Controllers\Admin\AgencyController@store' )) !!}
    {!! csrf_field() !!}

    <!-- Name -->
    <div class="col-sm-11 text-row {!! $errors->has('title') ? 'has-error' : '' !!}">
        <label class="control-label" for="name">{!!trans('fully.agency_name')!!}</label>

        <div class="controls">
            {!! Form::text('name', null, array('class'=>'form-control', 'id' => 'name', 'placeholder'=>trans('fully.agency_name'), 'value'=>Input::old('name'))) !!}
            @if ($errors->first('name'))
            <span class="help-block">{!! $errors->first('name') !!}</span>
            @endif
        </div>
    </div>

    <div class="col-sm-11">
        <br>
        <!-- Form actions -->
        {!! Form::submit(trans('fully.save'), array('class' => 'btn btn-success')) !!}
        <a href="{!! url('/'.getLang().'/admin/agency') !!}" class="btn btn-default">&nbsp;{!!trans('fully.cancel')!!}</a>
        {!! Form::close() !!}
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