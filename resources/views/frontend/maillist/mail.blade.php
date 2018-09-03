@extends('frontend/maillist/layout')
@section('content')
{!! HTML::style('ckeditor/contents.css') !!}
<script type="text/javascript">
    $(document).ready(function () {
        $('#notification').show().delay(4000).fadeOut(700);
    });
</script>
<div class="container">
     <br>
    @if( isset($product_name) && $product_name != null )
		<label >{{ trans('fully.mail_1') }}:</label>
    @else
	 	<label >{{ trans('fully.mail_2') }}:</label>
 	@endif
	 <br>
	{!! Form::open() !!}
	@if( isset($product_name) && $product_name != null )
	<div class="row">
		<div class="col-md-12">
			{!! Form::label( trans('fully.customer_contact_name') ) !!}:
			{!! $customer_name !!}
		</div>
	</div>
	@endif

	<div class="row">
		<div class="col-md-12">
			{!! Form::label( trans('fully.customer_contact_name') ) !!}:
			{!! $customer_name !!}
		</div>
	</div>
	
	<div class="row">
		<div class="col-md-6 ">
			{!! Form::label( trans('fully.phone') ) !!}:
			{!! $phone_number !!}
		</div>

		<div class="col-md-6 ">
			{!! Form::label( trans('fully.email') ) !!}:
			{!! $email !!}
		</div>
	</div>
	
	<div class="row">
		<div class="col-md-12 ">
			{!! Form::label( trans('fully.address') ) !!}:
			{!! $address !!}
		</div>
	</div>

	<div class="row">
		<div class="col-md-12">
			{!! Form::label(trans('fully.message')) !!}:
			{!! $content !!}
		</div>
	</div>
	
	{!! Form::close() !!}
</div>

@stop