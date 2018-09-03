@extends('frontend/layout/layout')
@section('content')
<?php $sessionLayout = Session::has('display-layout') ? Session::get('display-layout') : null ?>
@if(!$sessionLayout || $sessionLayout == 'pc')
{!! HTML::style("frontend/css/contact.css") !!}
@else
{!! HTML::style("frontend/css/mobile/contact.css") !!}
@endif
{!! HTML::style('ckeditor/contents.css') !!}
<script type="text/javascript">
    $(document).ready(function () {
        $('#notification').show().delay(4000).fadeOut(700);
    });
</script>
<div class="clearfix"></div>
<section class="contact-body">
    <div class="container">
        <div class="row">
            <div class="contact-content col-md-12 col-lg-12 col-sm-12">
                @yield('partial/breadcrumbs', Breadcrumbs::render('contact'))
                @if( isset($contactInfo) )
                <h4>{!! $contactInfo->company_name !!}</h4>
                <div class="contact-title col-md-2 col-sm-2 col-lg-2">
                    <p>{{ trans('fully.address') }}:</p>
                </div>
                <div class="contact-info-row col-md-10 col-sm-10 col-lg-10">
                    <p>{!! $contactInfo->address !!}</p>
                </div>
                <div class="contact-title col-md-2 col-sm-2 col-lg-2">
                    <p>{{ trans('fully.phone') }}:</p>
                </div>
                <div class="contact-info-row col-md-10 col-sm-10 col-lg-10">
                    <p>{!! $contactInfo->phone_number !!}</p>
                </div>
                <div class="contact-title col-md-2 col-sm-2 col-lg-2">
                    <p>{{ trans('fully.email') }}:</p>
                </div>
                <div class="contact-info-row col-md-10 col-sm-10 col-lg-10">
                    <p>{!! $contactInfo->email !!}</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</section>
<section class="contact-form">
    <div class="container">
        <div class="row">
            <div class="form-input col-md-4 col-lg-4 col-sm-12">
                <h5>{{ trans('fully.info_contact') }}</h5>
                @include('flash::message')
                {!! Form::open(['route'=>'dashboard.customer-contact.post']) !!}
                {!! csrf_field() !!}
                <div class="text-input col-md-12 col-lg-12 col-sm-12 {{ $errors->has('customer_name') ? 'has-error' : '' }}">
                    {!! Form::text('customer_name', old('customer_name'), ['class'=>'form-control', 'placeholder'=>trans('fully.first_name_and_last_name')]) !!}
                    <span class="text-danger">{{ $errors->first('customer_name') }}</span>
                </div>
                <div class="text-input col-md-12 col-lg-12 col-sm-12 {{ $errors->has('phone_number') ? 'has-error' : '' }}">
                    {!! Form::text('phone_number', old('phone_number'), ['class'=>'form-control', 'placeholder'=>trans('fully.phone'),'onkeypress'=>'return AllowNumbersOnly(event)']) !!}
                    <span class="text-danger">{{ $errors->first('phone_number') }}</span>
                </div>
                <div class="text-input col-md-12 col-lg-12 col-sm-12 {{ $errors->has('email') ? 'has-error' : '' }}">
                    {!! Form::text('email', old('email'), ['class'=>'form-control', 'placeholder'=>trans('fully.email')]) !!}
                    <span class="text-danger">{{ $errors->first('email') }}</span>
                </div>
                <div class="text-input col-md-12 col-lg-12 col-sm-12 {{ $errors->has('address') ? 'has-error' : '' }}">
                    {!! Form::text('address', old('address'), ['class'=>'form-control', 'placeholder'=>trans('fully.address')]) !!}
                    <span class="text-danger">{{ $errors->first('address') }}</span>
                </div>
                <div class="text-input text-content col-md-12 col-lg-12 col-sm-12 {{ $errors->has('content') ? 'has-error' : '' }}">
                    {!! Form::textarea('content', old('content'), ['class'=>'form-control textarea-content', 'placeholder'=>trans('fully.conent')]) !!}
                    <span class="text-danger">{{ $errors->first('content') }}</span>
                </div>             
                <div class="text-input col-md-12 col-lg-12 col-sm-12 {{ $errors->has('g-recaptcha-response') ? 'has-error' : '' }}">
                    {!! Recaptcha::render() !!}
                    <span class="text-danger">{{ $errors->first('g-recaptcha-response') }}</span>
                </div>
                <button class="btn btn-send">Gửi</button>
                {!! Form::close() !!}
            </div>  
            <div class="col-md-8 col-lg-8 col-sm-12">
                @if( isset($contactInfo->url_map) )
                <iframe width="100%" height="100%" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="{!! $contactInfo->url_map!!}"></iframe>
                @endif
            </div>
        </div>
    </div>
</section>
<div class="clearfix"></div>
<script type="text/javascript">

    function AllowNumbersOnly(e) {
        var charCode = (e.which) ? e.which : e.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            e.preventDefault();
        }
    }

</script>
@stop