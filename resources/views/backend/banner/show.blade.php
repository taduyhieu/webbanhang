@extends('backend/layout/layout')
@section('content')
{!! HTML::style('dropzone/css/basic.css') !!}
{!! HTML::style('jasny-bootstrap/css/jasny-bootstrap.min.css') !!}
{!! HTML::style('dropzone/css/dropzone.css') !!}
{!! HTML::script('dropzone/dropzone.js') !!}
{!! HTML::script('ckeditor/ckeditor.js') !!}
{!! HTML::script('jasny-bootstrap/js/jasny-bootstrap.min.js') !!}
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1> Banner
        <small> | Show Banner</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{!! langRoute('admin.banner.index') !!}><i class="fa fa-play"></i> Banner</a></li>
        <li class="active">Show Banner</li>
    </ol>
</section>
<br>
<br>
<div class="container">
    <div class="pull-left">
        <div class="btn-toolbar">
            <a href="{!! langRoute('admin.banner.index') !!}"
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
            <td><strong>Tên Banner</strong></td>
            <td>{!! $banner->name !!}</td>
        </tr>
        <tr>
            <td><strong>Avatar</strong></td>
            <td>
                <div class="fileinput fileinput-new control-group col-sm-11 {!! $errors->has('avatar') ? 'has-error' : '' !!}" data-provides="fileinput">
                    <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 100px; height: 75px;">
                        <img data-src="" {!! (($banner->path) ? "src='".url($banner->path)."'" : null) !!} alt="...">
                    </div>
                </div>  
            </td>
        </tr>
        <tr>
            <td><strong>Đường dẫn đến website</strong></td>
            <td>{!! $banner->url !!}</td>
        </tr>
        <tr>
            <td><strong>Thứ tự</strong></td>
            @if ($banner->position == 1)
                <td>Banner  dưới Menu chính</td>
            @endif

            @if ($banner->position == 2)
                <td>Banner phía bên cột phải thứ nhất</td>
            @endif

            @if ($banner->position == 3)
                <td>Banner phía bên cột phải thứ hai</td>
            @endif

            @if ($banner->position == 4)
                <td>Banner dưới khối tin đầu trang chủ</td>
            @endif

        </tr>
        <tr>
            <td><strong>Loại</strong></td>
            <td>{!! $banner->adv_type !!}</td>
        </tr>
        <tr>
            <td><strong>Ngày bắt đầu chạy banner</strong></td>
            <td>{!! date('d/m/Y H:i:s', strtotime($banner->start_date)) !!}</td>
        </tr>
        <tr>
            <td><strong>Ngày kết thúc chạy banner</strong></td>
            <td>{!! date('d/m/Y H:i:s', strtotime($banner->end_date)) !!}</td>
        </tr>
        <tr>
            <td><strong>Trạng thái</strong></td>
            <td>
                <a href="" id="{{ $banner->id }}" class="status">
                  <img id="publish-image-{{ $banner->id }}" src="{!!url('/')!!}/assets/images/{!! ($banner->status) ? 'publish.png' : 'not_publish.png'  !!}">
                </a>
            </td>
        </tr>
        </tbody>
    </table>
</div>
</div>
</div>
@stop