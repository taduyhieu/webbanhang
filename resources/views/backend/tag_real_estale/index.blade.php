@extends('backend/layout/layout')
@section('content')
    <script type="text/javascript">
        $(document).ready(function () {
            $('#notification').show().delay(4000).fadeOut(700);
        });
    </script>
    <section class="content-header">
        <h1> Tag Bất động sản
            <small> | Control Panel</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{!! url(getLang(). '/admin') !!}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Tag Bất động sản</li>
        </ol>
    </section>
    <br>
    <div class="container">
        <div class="col-lg-12">
            @include('flash::message')
            <br>

            <div class="pull-left">
                <div class="btn-toolbar"><a href="{!! langRoute('admin.realestale-tag.create') !!}" class="btn btn-primary">
                        <span class="glyphicon glyphicon-plus"></span>&nbsp;Thêm mới </a></div>
            </div>
            <br> <br> <br>
            @if($tagRealEstales->count())
                <div class="">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>STT</th>
                            <th>Tiêu đề</th>
                            <th>Thuộc tag</th>
                            <th>Thao tác</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach( $tagRealEstales as $key => $tagRealEstale)
                            <tr>
                                <td>{!! ++$key !!}</td>
                                <td> {!! $tagRealEstale->name !!}</td>
                                <td>{!! $tagRealEstale->tagParentName !!}</td>
                                <td>
                                    <div class="btn-group">
                                        <a class="btn btn-danger dropdown-toggle" data-toggle="dropdown" href="#">
                                            Thao tác <span class="caret"></span> </a>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <a href="{!! langRoute('admin.realestale-tag.edit', array($tagRealEstale->id)) !!}">
                                                    <span class="glyphicon glyphicon-edit"></span>&nbsp;Sửa </a>
                                            </li>
<!--                                            <li class="divider"></li>
                                            <li>
                                                <a href="{!! URL::route('admin.realestale-tag.delete', array($tagRealEstale->id)) !!}">
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
                {!! $tagRealEstales->render() !!}
            </ul>
        </div>
    </div>
@stop