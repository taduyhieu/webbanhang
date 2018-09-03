@extends('backend/layout/layout')
@section('content')
    {!! HTML::script('ckeditor/ckeditor.js') !!}
    {!! HTML::style('assets/bootstrap/css/bootstrap-tagsinput.css') !!}
    {!! HTML::style('jasny-bootstrap/css/jasny-bootstrap.min.css') !!}
    {!! HTML::script('assets/bootstrap/js/bootstrap-tagsinput.js') !!}
    {!! HTML::script('assets/js/jquery.slug.js') !!}
    {!! HTML::script('jasny-bootstrap/js/jasny-bootstrap.min.js') !!}
    {!! HTML::style('bootstrap_datepicker/css/datepicker.css') !!}
    {!! HTML::script('bootstrap_datepicker/js/bootstrap-datepicker.js') !!}
    {!! HTML::script('bootstrap_datepicker/js/locales/bootstrap-datepicker.tr.js') !!}
    <script type="text/javascript">
        $(document).ready(function () {
            $("#title").slug();

        });
    </script>
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1> {{ trans('fully.contact_form') }}<small> | {{ trans('fully.edit') }}</small> </h1>
        <ol class="breadcrumb">
            <li><a href="{!! url(getLang() . '/admin/contact') !!}"><i class="fa fa-bookmark"></i> {{ trans('fully.contact_form') }}</a></li>
            <li class="active">{{ trans('fully.edit') }}</li>
        </ol>
    </section>
    <br>
    <br>
    <div class="container">
        {!! Form::open( array( 'route' => array( getLang() . '.admin.contact.update', $contact->id), 'method' => 'PATCH', 'files'=>true)) !!}
            <!-- Company name -->
        <div class="control-group {!! $errors->has('company_name') ? 'has-error' : '' !!}">
            <label class="control-label" for="title">{{ trans('fully.contact_name') }}</label>

            <div class="controls"> {!! Form::text('company_name', $contact->company_name, array('class'=>'form-control', 'id' => 'company_name', 'placeholder'=>trans('fully.contact_name'), 'value'=>Input::old('company_name'))) !!}
                @if ($errors->first('company_name')) <span class="help-block">{!! $errors->first('company_name') !!}</span> @endif
            </div>
        </div>
        <br>

        <!-- Address -->
        <div class="control-group {!! $errors->has('address') ? 'has-error' : '' !!}">
            <label class="control-label" for="address">{{ trans('fully.address') }}</label>

            <div class="controls"> {!! Form::text('address', $contact->address, array('class'=>'form-control', 'id' => 'address', 'placeholder'=>trans('fully.address'), 'value'=>Input::old('address'))) !!}
                @if ($errors->first('address'))
                <span class="help-block">{!! $errors->first('address') !!}</span> @endif </div>
        </div>
        <br>

        <!-- Phone number -->
        <div class="control-group {!! $errors->has('phone_number') ? 'has-error' : '' !!}">
            <label class="control-label" for="phone_number">{{ trans('fully.phone') }}</label>

            <div class="controls"> {!! Form::text('phone_number', $contact->phone_number, array('class'=>'form-control', 'id' => 'phone_number', 'placeholder'=>trans('fully.phone'), 'value'=>Input::old('phone_number'))) !!}
                @if ($errors->first('phone_number'))
                <span class="help-block">{!! $errors->first('phone_number') !!}</span> @endif </div>
        </div>
        <br>

        <!-- Email -->
        <div class="control-group {!! $errors->has('email') ? 'has-error' : '' !!}">
            <label class="control-label" for="email">{{ trans('fully.email') }}</label>

            <div class="controls"> {!! Form::text('email', $contact->email, array('class'=>'form-control', 'id' => 'email',
                'placeholder'=>trans('fully.email'), 'value'=>Input::old('email'))) !!}
                @if ($errors->first('email')) <span class="help-block">{!! $errors->first('email') !!}</span> @endif
            </div>
        </div>
        <br>

        <!-- url map -->
        <div class="control-group {!! $errors->has('url_map') ? 'has-error' : '' !!}">
            <label class="control-label" for="url_map">Url map</label>
            
            <div class="controls"> {!! Form::textarea('url_map', $contact->url_map, array('class'=>'form-control', 'id' => 'url_map', 'placeholder'=>'Url map', 'value'=>Input::old('url_map'))) !!}
                @if ($errors->first('url_map')) <span class="help-block">{!! $errors->first('url_map') !!}</span> @endif
            </div>
        </div>
        <br>
            <!-- Published -->
            <div class="control-group {!! $errors->has('is_published') ? 'has-error' : '' !!}">
                <div class="controls">
                    <label class="">{!! Form::checkbox('is_published', 'is_published',$contact->is_published) !!}
                       {{ trans('fully.public_img') }} ?</label>
                    @if ($errors->first('is_published'))
                        <span class="help-block">{!! $errors->first('is_published') !!}</span>
                    @endif
                </div>
            </div>
            <br>
            {!! Form::submit(trans('fully.save'), array('class' => 'btn btn-success')) !!}
            {!! Form::close() !!}
    </div>
@stop