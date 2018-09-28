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
    <h1> {!!trans('fully.agency')!!}
        <small> | {!!trans('fully.edit')!!}</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{!! url(getLang(). '/admin/agency') !!}"><i class="fa fa-list"></i> {!!trans('fully.agency')!!}</a></li>
        <li class="active">{!!trans('fully.edit')!!}</li>
    </ol>
</section>
<br>
<br>
<div class="container">

    {!! Form::open( array( 'route' => array( getLang() . '.admin.agency.update', $agency->id), 'method' => 'PATCH')) !!}
    <!-- Title -->
    <div class="col-sm-11 text-row{!! $errors->has('name') ? 'has-error' : '' !!}">
        <label class="control-label" for="name">{!!trans('fully.agency_name')!!}</label>

        <div class="controls">
            {!! Form::text('name', $agency->name, array('class'=>'form-control', 'id' => 'name', 'placeholder'=>trans('fully.agency_name'), 'value'=>Input::old('name'))) !!}
            @if ($errors->first('name'))
            <span class="help-block">{!! $errors->first('name') !!}</span>
            @endif
        </div>
    </div>
    <br>
    
    <!-- Status -->
    <div class="col-sm-11 text-row{!! $errors->has('url_link') ? 'has-error' : '' !!}">
        <label class="control-label" for="url">{!!trans('fully.status')!!}</label>

        <div class="controls">
            <a href="#" id="{!! $agency->id !!}" class="publish">
            <img id="publish-image-{!! $agency->id !!}" src="{!!url('/')!!}/assets/images/{!! ($agency->status) ? 'publish.png' : 'not_publish.png'  !!}"/></a>
        </div>
    </div>
    <br>

    <div class="col-sm-11">
    <!-- Form actions -->
    {!! Form::submit(trans('fully.save'), array('class' => 'btn btn-success')) !!}
    <a href="{!! url('/'.getLang().'/admin/agency') !!}" class="btn btn-default">&nbsp;{!!trans('fully.cancel')!!}</a>
    {!! Form::close() !!}
    </div>

</div>
@stop