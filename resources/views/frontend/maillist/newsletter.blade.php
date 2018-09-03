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
	<label >{{ trans('fully.mail_ask') }}:</label>
	<br>
        <div class="col-sm-12">
            {{ $email }}
        </div>
</div>

@stop