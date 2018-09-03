@extends('backend/layout/layout')
@section('content')
<script type="text/javascript">
    $(document).ready(function () {
        $('#notification').show().delay(4000).fadeOut(700);
    });
</script>
<section class="content-header">
    <h1> Tác giả
        <small> | Control panel</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{!! url(getLang(). '/admin') !!}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Tác giả</li>
    </ol>
</section>
<br>
<div class="container">
    <div class="col-lg-10">
        @include('flash::message')
        <br>

        <div class="pull-left">
            <div class="btn-toolbar"><a href="{!! langRoute('admin.author.create') !!}" class="btn btn-primary">
                    <span class="glyphicon glyphicon-plus"></span>&nbsp;Thêm mới </a></div>
        </div>
        <br>
        <br>
        <br>
        @if($authors->count())
        <div class="">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Stt</th>
                        <th>Tên tác giả</th>
                        <th>Trạng thái</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach( $authors as $key => $author )
                    <tr>
                        <td>{!! ++$key !!}</td>
                        <td>
                            {!! $author->name !!}
                        </td>
                        <td>
                            @if($author->status == 1)
                            Hoạt động
                            @else
                            Khóa
                            @endif
                        </td>
                        <td>
                            <div class="btn-group">
                                <a class="btn btn-danger dropdown-toggle" data-toggle="dropdown" href="#">
                                    Thao tác
                                    <span class="caret"></span>
                                </a>
                                <ul class="dropdown-menu">
<!--                                    <li>
                                        <a href="{!! langRoute('admin.author.show', array($author->id)) !!}">
                                            <span class="glyphicon glyphicon-eye-open"></span>&nbsp;Chi tiết
                                        </a>
                                    </li>-->
                                    <li>
                                        <a href="{!! langRoute('admin.author.edit', array( $author->id)) !!}">
                                            <span class="glyphicon glyphicon-edit"></span>&nbsp;Sửa
                                        </a>
                                    </li>
                                    <li class="divider"></li>
                                    <li>
                                        <a href="{!! URL::route('admin.author.delete', array($author->id)) !!}">
                                            <span class="glyphicon glyphicon-remove-circle"></span>&nbsp;Xóa
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="alert alert-danger">Không tìm thấy dữ liệu</div>
        @endif
    </div>
    <div class="pull-left">
        <ul class="pagination">
            {!! $authors->render() !!}
        </ul>
    </div>
</div>
@stop