@extends('backend/layout/layout')
@section('content')
<script type="text/javascript">
    $(document).ready(function () {
        $('#notification').show().delay(4000).fadeOut(700);
    });
</script>
<section class="content-header">
    <h1> Người dùng
        <small> | Control Panel</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{!! url(getLang(). '/admin/user') !!}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Người dùng</li>
    </ol>
</section>
<br>
<div class="container">
    <div class="col-lg-12">
        @include('flash::message')
        <br>

        <div class="pull-left">
            <div class="btn-toolbar">
                <a href="{!! langRoute('admin.user.create') !!}" class="btn btn-primary">
                    <span class="glyphicon glyphicon-plus"></span>&nbsp;Thêm mới
                </a>
            </div>
        </div>
        <br>
        <br>
        <br>
        @if($users->count())
        <div class="">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Tên</th>
                    <th>Email</th>
                    <th>Đăng nhập cuối</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach( $users as $user )
                <tr>
                    <td> {!! link_to_route(getLang(). '.admin.user.show', $user->user_name, $user->id, array( 'class' => 'btn btn-link btn-xs' )) !!}
                    <td>{!! $user->email !!}</td>
                    <td>{!! $user->last_login !!}</td>
                    <td>
                        <div class="btn-group">
                            <a class="btn btn-danger dropdown-toggle" data-toggle="dropdown" href="#">
                                Thao tác
                                <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a href="{!! langRoute('admin.user.show', array($user->id)) !!}">
                                        <span class="glyphicon glyphicon-eye-open"></span>&nbsp;Chi tiết
                                    </a>
                                </li>
                                <li>
                                    <a href="{!! langRoute('admin.user.edit', array($user->id)) !!}">
                                        <span class="glyphicon glyphicon-edit"></span>&nbsp;Sửa
                                    </a>
                                </li>
<!--                                <li class="divider"></li>
                                <li>
                                    <a href="{!! URL::route('admin.user.delete', array($user->id)) !!}">
                                        <span class="glyphicon glyphicon-remove-circle"></span>&nbsp;Xóa
                                    </a>
                                </li>-->
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
            {!! $users->render() !!}
        </ul>
    </div>
</div>
@stop