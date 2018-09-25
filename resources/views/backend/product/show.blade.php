@extends('backend/layout/layout')
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1> {!!trans('fully.category')!!}
        <small> | {!!trans('fully.show')!!}</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{!! langRoute('admin.categories.index') !!}"><i class="fa fa-list"></i> {!!trans('fully.category')!!}</a></li>
        <li class="active">{!!trans('fully.show')!!}</li>
    </ol>
</section>
<br>
<br>
<div class="container">
    <div class="pull-left">
        <div class="btn-toolbar">
            <a href="{!! langRoute('admin.product.index') !!}"
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
                <td><strong>{!!trans('fully.product_name')!!}</strong></td>
                <td>{!! $product->product_name !!}</td>
            </tr>
            <tr>
                <td><strong>{!!trans('fully.product_code')!!}</strong></td>
                <td>{!! $product->code !!}</td>
            </tr>
            <tr>
                <td><strong>{!!trans('fully.product_content')!!}</strong></td>
                <td>{!! $product->content !!}</td>
            </tr>
            <tr>
                <td><strong>{!!trans('fully.product_category')!!}</strong></td>
                <td>{!! $product->category_name !!}</td>
            </tr>
            <tr>
                <td><strong>{!!trans('fully.quantity')!!}</strong></td>
                <td>{!! $product->quatities !!}</td>
            </tr>
            <tr>
                <td><strong>{!!trans('fully.product_price')!!}</strong></td>
                <td>{!! $product->price !!}</td>
            </tr>
            <tr>
                <td><strong>{!!trans('fully.product_color')!!}</strong></td>
                <td>{!! $product->color !!}</td>
            </tr>
            <tr>
                <td><strong>{!!trans('fully.product_agency')!!}</strong></td>
                <td>{!! $product->agency_name !!}</td>
            </tr>
            <tr>
                <td><strong>{!!trans('fully.product_description')!!}</strong></td>
                <td>{!! $product->description !!}</td>
            </tr>
            <tr>
                <td><strong>{!!trans('fully.product_description_short')!!}</strong></td>
                <td>{!! $product->description_short !!}</td>
            </tr>
            <tr>
                <td><strong>Trạng thái</strong></td>
                <td>
                @if($product->status == 1)
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