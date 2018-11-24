@extends('backend/layout/layout')
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1> {!!trans('fully.category')!!}
        <small> | {!!trans('fully.show')!!}</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{!! langRoute('admin.sale-off.index') !!}"><i class="fa fa-list"></i> {!!trans('fully.category')!!}</a></li>
        <li class="active">{!!trans('fully.show')!!}</li>
    </ol>
</section>
<br>
<br>
<div class="container">
    <div class="pull-left">
        <div class="btn-toolbar">
            <a href="{!! langRoute('admin.sale-off.index') !!}"
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
                <td><strong>{!!trans('fully.sale_name')!!}</strong></td>
                <td>{!! $saleofff->name !!}</td>
            </tr>
            <tr>
                <td><strong>{!!trans('fully.start_date')!!}</strong></td>
                <td>{!! $saleofff->start_date !!}</td>
            </tr>
            <tr>
                <td><strong>{!!trans('fully.end_date')!!}</strong></td>
                <td>{!! $saleofff->end_date !!}</td>
            </tr>
            <tr>
                <td><strong>Trạng thái</strong></td>
                <td>
                @if($saleofff->status == 1)
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