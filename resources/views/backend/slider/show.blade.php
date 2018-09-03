@extends('backend/layout/layout')
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1> Slider
        <small> | Show Slider</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{!! langRoute('admin.slider.index') !!}><i class="fa fa-play"></i> Slider</a></li>
        <li class="active">Show Slider</li>
    </ol>
</section>
<br>
<br>
<div class="container">
    <div class="pull-left">
        <div class="btn-toolbar">
            <a href="{!! langRoute('admin.slider.index') !!}"
               class="btn btn-primary">
                <span class="glyphicon glyphicon-arrow-left"></span>&nbsp;Back
            </a>
        </div>
    </div>
    <br>
    <br>
    <br>
    <table class="table table-striped">
        <tbody>
        <tr>
            <td><strong>Title</strong></td>
            <td>{!! $slider->title !!}</td>
        </tr>
        <tr>
            <td><strong>Thứ tự</strong></td>
            <td>{!! $slider->order !!}</td>
        </tr>
        <tr>
            <td><strong>Mô tả</strong></td>
            <td>{!! $slider->description !!}</td>
        </tr>
        </tbody>
    </table>
</div>
</div>
</div>
@stop