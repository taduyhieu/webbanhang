@extends('backend/layout/layout')
@section('content')
<script type="text/javascript">
    $(document).ready(function () {

        $('.type').change(function () {
                var selected = $('input[class="type"]:checked').val();
                if (selected == "custom") {
                    $('.modules').css('display', 'none');
                    $('.url').css('display', 'block');
                }
                else {
                    $('.modules').css('display', 'block');
                    $('.url').css('display', 'none');
                }
            }
        );

        $(".type").trigger("change");
    });
</script>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1> {!! trans('fully.menu_form') !!} <small> | {!! trans('fully.menu_edit') !!}</small> </h1>
    <ol class="breadcrumb">
        <li><a href="{!! url(getLang(). '/admin/menu') !!}">{!! trans('fully.menu_form') !!}</a></li>
        <li class="active">{!! trans('fully.menu_edit') !!}</li>
    </ol>
</section>
<br>
<br>
<div class="container">

    {!! Form::open( array( 'route' => array(getLang(). '.admin.menu.update', $menu->id), 'method' => 'PATCH')) !!}
    <!-- Title -->
    <div class="control-group {!! $errors->has('title') ? 'has-error' : '' !!}">
        <label class="control-label" for="title">{!! trans('fully.menu_title') !!}</label>

        <div class="controls">
            {!! Form::text('title', $menu->title, array('class'=>'form-control', 'id' => 'title', 'placeholder'=>trans('fully.menu_title'), 'value'=>Input::old('title'))) !!}
            @if ($errors->first('title'))
            <span class="help-block">{!! $errors->first('title') !!}</span>
            @endif
        </div>
        <br>
    </div>
    
    {!! Form::hidden('type', 'module', array('id'=>'module', 'class'=>'type')) !!}
    
    <!-- Type -->
<!--    <label class="control-label" for="title">{!! trans('fully.menu_type') !!}</label>

    <div class="controls">
        <div class="radio">
            <label>
                {!! Form::radio('type', 'module', (($menu->type == 'module') ? true : false), array('id'=>'module', 'class'=>'type')) !!}
                <span>{!! trans('fully.menu_type_module') !!}</span>
            </label>
        </div>
        <div class="radio">
            <label>
                {!! Form::radio('type', 'custom', (($menu->type == 'custom') ? true : false), array('id'=>'custom', 'class'=>'type')) !!}
                <span>{!! trans('fully.menu_type_custom') !!}</span>
            </label>
        </div>
        <br>
    </div>-->

    <!-- Modules -->
    <div class="control-group {!! $errors->has('options') ? 'has-error' : '' !!} modules">
        <label class="control-label" for="title">{!! trans('fully.menu_option') !!}</label>

        <div class="controls">
            
            {!! Form::select('option', $options, $menu->module, array('class'=>'form-control', 'id' => 'options', 'value'=>Input::old('options'))) !!}
            @if ($errors->first('options'))
            <span class="help-block">{!! $errors->first('options') !!}</span>
            @endif
        </div>
        <br>
    </div>

    <!-- URL -->
<!--    <div style="display:none" class="control-group {!! $errors->has('url') ? 'has-error' : '' !!} url">
        <label class="control-label" for="first-name">URL</label>

        <div class="controls">
            {!! Form::text('url',$menu->url, array('class'=>'form-control', 'id' => 'url', 'placeholder'=>'Url', 'value'=>Input::old('url'))) !!}
            @if ($errors->first('url'))
            <span class="help-block">{!! $errors->first('url') !!}</span>
            @endif
        </div>
    </div>-->
    <br>
    <!-- Form actions -->
    {!! Form::submit(trans('fully.menu_save'), array('class' => 'btn btn-success')) !!}
    {!! Form::close() !!}

</div>
@stop
