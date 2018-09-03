@extends('...layout.layout')
@section('content')
{!! HTML::style('ckeditor/contents.css') !!}

<section id="error" class="container">
<h1>{{ trans('fully.error') }}</h1>
<p>{{ trans('fully.error_content') }}</p>
<a class="btn btn-success" href="{!! url('/') !!}"></a>{{ trans('fully.eror_back_home') }}
</section><!--/#error-->
@stop
