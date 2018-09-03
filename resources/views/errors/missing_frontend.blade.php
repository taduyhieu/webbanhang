@extends('frontend/layout/layout')
@section('content')
<section >
	<div class="text-center">
    <br>
    <section id="error" class="container">
    <h1>404, Không tìm thấy trang</h1>
    <p>Bạn đang cố gắng tìm kiếm trang không tồn tại hoặc có sự cố xảy ra !</p>
    <a class="btn btn-success" href="{{ url('/') }}">Trở lại trang chủ</a>
    <div>
        <br>
    </div>
</div>
</section><!--/#error-->
@stop
