@extends('backend/layout/layout')
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1> Tỉnh/thành phố
        <small> | Chi tiết</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{!! langRoute('admin.province.index') !!}"><i class="fa fa-globe"></i> Tỉnh/thành phố</a></li>
        <li class="active">Chi tiết</li>
    </ol>
</section>
<br>
<br>
<div class="container">
    <div class="col-lg-10">
        <div class="pull-left">
            <div class="btn-toolbar">
                <a href="{!! langRoute('admin.province.index') !!}"
                class="btn btn-primary"> <span class="glyphicon glyphicon-arrow-left"></span>&nbsp; Quay lại </a>
            </div>
        </div>
        <br> <br> <br>
        <table class="table table-striped">
            <tbody>
                <tr>
                    <td><strong>Tên</strong></td>
                    <td>{!! $province->name !!}</td>
                </tr>
                <tr>
                    <td><strong>Trạng thái</strong></td>

                    @if($province->active == 1)
                    <td>Active</td> 
                    @endif
                    @if($province->active == 2)
                    <td>Block</td>
                    @endif
                </tr>
                <tr>
                    <td><strong>Ngày tạo</strong></td>
                    <td>{!! $province->created_at !!}</td>
                </tr>
                 <tr>
                    <td><strong>Ngày sửa</strong></td>
                    <td>{!! $province->updated_at !!}</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
</div>
</div>
@stop