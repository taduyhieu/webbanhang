@extends('backend/layout/layout')
@section('content')
        <!-- Content Header (Page header) -->
<section class="content-header">
    <h1> Người dùng
        <small> | Chi tiết</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{!! langRoute('admin.user.index') !!}"><i class="fa fa-user"></i> Người dùng</a></li>
        <li class="active">Chi tiết</li>
    </ol>
</section>
<br>
<br>
<div class="container">
    <div class="col-lg-12">
        <div class="pull-left">
            <div class="btn-toolbar">
                <a href="{!! langRoute('admin.user.index') !!}"
                   class="btn btn-primary"> <span class="glyphicon glyphicon-arrow-left"></span>&nbsp;Quay lại </a>
            </div>
        </div>
        <br> <br> <br>
        <table class="table table-striped">
            <tbody>
            <tr>
                <td><strong>Ảnh đại diện</strong></td>
                <td><img src="{!! gravatarUrl($user->email) !!}" alt="{!! $user->email !!}"/></td>
            </tr>
            <tr>
                <td><strong>Tên đầy đủ</strong></td>
                <td>{!! $user->full_name !!}</td>
            </tr>
            <tr>
                <td><strong>Email</strong></td>
                <td>{!! $user->email !!}</td>
            </tr>
            <tr>
                <td><strong>Ngày tạo</strong></td>
                <td>{!! $user->created_at !!}</td>
            </tr>
            <tr>
                <td><strong>Lần đăng nhập cuối</strong></td>
                <td>{!! $user->last_login !!}</td>
            </tr>
            </tbody>
        </table>
    </div>
</div>
@stop