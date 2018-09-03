@extends('backend/layout/layout')
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1> {!!trans('fully.category')!!}
        <small> | {!!trans('fully.show')!!}</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{!! langRoute('admin.category.index') !!}"><i class="fa fa-list"></i> {!!trans('fully.category')!!}</a></li>
        <li class="active">{!!trans('fully.show')!!}</li>
    </ol>
</section>
<br>
<br>
<div class="container">
    <div class="pull-left">
        <div class="btn-toolbar">
            <a href="{!! langRoute('admin.category.index') !!}"
               class="btn btn-primary">
                <span class="glyphicon glyphicon-arrow-left"></span>&nbsp;{!!trans('fully.back')!!}
            </a>
        </div>
    </div>
    <br>
    <br>
    <br>
    <table class="table table-striped">
        <tbody>
            <tr>
                <td><strong>{!!trans('fully.car_info_name')!!}</strong></td>
                <td>{!! $category->name !!}</td>
            </tr>
            <tr>
                <td><strong>{!!trans('fully.car_info_in')!!}</strong></td>
                <td>{!! $category->categoryParent !!}</td>
            </tr>
            <tr>
                <td><strong>Thứ tự</strong></td>
                <td>{!! $category->order !!}</td>
            </tr>
            <tr>
                <td><strong>Meta description</strong></td>
                <td>{!! $category->meta_description !!}</td>
            </tr>
            <tr>
                <td><strong>Meta keyword</strong></td>
                <td>{!! $category->meta_keyword !!}</td>
            </tr>
            <tr>
                <td><strong>Trạng thái</strong></td>
                <td>
                @if($category->status == 1)
                Active
                @else
                Block
                @endif
                </td>
            </tr>
        </tbody>
    </table>
</div>
</div>
</div>
@stop