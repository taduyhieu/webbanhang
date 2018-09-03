@extends('backend/layout/layout')
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1> Phân loại bất động sản
        <small> | Chi tiết</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{!! langRoute('admin.realestale-category.index') !!}><i class="fa fa-play"></i> Phân loại bất động sản</a></li>
        <li class="active">Chi tiết</li>
    </ol>
</section>
<br>
<br>
<div class="container">
    <div class="pull-left">
        <div class="btn-toolbar">
            <a href="{!! langRoute('admin.realestale-category.index') !!}"
               class="btn btn-primary">
                <span class="glyphicon glyphicon-arrow-left"></span>&nbsp;Quay lại
            </a>
        </div>
    </div>
    <br>
    <br>
    <br>
    <table class="table table-striped">
        <tbody>
        <tr>
            <td><strong>Tiêu đề</strong></td>
            <td>{!! $categoryrealestale->name !!}</td>
        </tr>
        <tr>
            <td><strong>Thuộc danh mục</strong></td>
            @if(isset($parent))
            <td>{!! $parent->name !!}</td>
            @endif
        </tr>
        <tr>
            <td><strong>Thứ tự</strong></td>
            <td>{!! $categoryrealestale->order !!}</td>
        </tr>
        <tr>
            <td><strong>Meta description</strong></td>
            <td>{!! $categoryrealestale->meta_description !!}</td>
        </tr>
        <tr>
            <td><strong>Meta keyword</strong></td>
            <td>{!! $categoryrealestale->meta_keyword !!}</td>
        </tr>
        <tr>
            <td><strong>Ngày tạo</strong></td>
            <td>{!! date('d/m/Y H:i:s', strtotime($categoryrealestale->created_at)) !!}</td>
        </tr>
        <tr>
            <td><strong>Ngày cập nhật</strong></td>
            <td>{!! date('d/m/Y H:i:s', strtotime($categoryrealestale->updated_at)) !!}</td>
        </tr>
        </tbody>
    </table>
</div>
</div>
</div>
@stop