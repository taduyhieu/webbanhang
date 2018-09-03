@extends('backend/layout/layout')
@section('content')
    <script type="text/javascript">
        $(document).ready(function () {
            $('#notification').show().delay(4000).fadeOut(700);
        });
    </script>
    <section class="content-header">
        <h1> Tag
            <small> | Control Panel</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{!! url(getLang(). '/admin') !!}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Tag</li>
        </ol>
    </section>
    <br>
    <div class="container">
        <div class="col-lg-12">
            @include('flash::message')
            <br>

            <div class="pull-left">
                <div class="btn-toolbar"><a href="{!! langRoute('admin.news-tag.create') !!}" class="btn btn-primary">
                        <span class="glyphicon glyphicon-plus"></span>&nbsp;Thêm mới </a></div>
            </div>
            <br> <br> <br>
            @if($tags->count())
                <div class="">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>STT</th>
                            <th>Tiêu đề</th>
                            <th>Thao tác</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach( $tags as $key => $tag)
                            <tr>
                                <td>{!! ++$key !!}</td>
                                <td> {!! $tag->name !!}</td>
                                <td>
                                    <div class="btn-group">
                                        <a class="btn btn-danger dropdown-toggle" data-toggle="dropdown" href="#">
                                            Thao tác <span class="caret"></span> </a>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <a href="{!! langRoute('admin.news-tag.edit', array($tag->id)) !!}">
                                                    <span class="glyphicon glyphicon-edit"></span>&nbsp;Sửa </a>
                                            </li>
<!--                                            <li class="divider"></li>
                                            <li>
                                                <a href="{!! URL::route('admin.news-tag.delete', array($tag->id)) !!}">
                                                    <span class="glyphicon glyphicon-remove-circle"></span>&nbsp;Xóa</a>
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
                <div class="alert alert-danger">Không tìm thấy kết quả</div>
            @endif
        </div>
        <div class="pull-left">
            <ul class="pagination">
                {!! $tags->render() !!}
            </ul>
        </div>
    </div>
@stop