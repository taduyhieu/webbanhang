@extends('backend/layout/layout')
@section('content')
    <?php  
        // echo("<pre>");
        // print_r($videos);
        // die();
    ?>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#notification').show().delay(4000).fadeOut(700);
        });
    </script>
    <section class="content-header">
        <h1>  Phân loại bất động sản
            <small> | Control Panel</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{!! url(getLang(). '/admin') !!}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active"> Phân loại bất động sản</li>
        </ol>
    </section>
    <br>
    <div class="container">
        <div class="col-lg-12">
            @include('flash::message')
            <br>

            <div class="pull-left">
                <div class="btn-toolbar"><a href="{!! langRoute('admin.realestale-category.create') !!}" class="btn btn-primary">
                        <span class="glyphicon glyphicon-plus"></span>&nbsp;Thêm mới </a></div>
            </div>
            <br> <br> <br>
            @if($categoryRealestales->count())
                <?php $id=1; ?>
                <div class="">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>STT</th>
                            <th>Tiêu đề</th>
                            <th>Thứ tự</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach( $categoryRealestales as $key => $categoryrealestale )
                            <tr>
                                <td>{!! ++$key !!}</td>
                                <td> {!! link_to_route(getLang(). '.admin.realestale-category.show', $categoryrealestale->name, $categoryrealestale->id, array(
                                    'class' => 'btn btn-link btn-xs' )) !!}</td>
                                <td>{!! $categoryrealestale->order !!}</td>
                                <td>
                                    <div class="btn-group">
                                        <a class="btn btn-danger dropdown-toggle" data-toggle="dropdown" href="#">
                                            Thao tác <span class="caret"></span> </a>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <a href="{!! langRoute('admin.realestale-category.show', array($categoryrealestale->id)) !!}">
                                                    <span class="glyphicon glyphicon-eye-open"></span>&nbsp;Chi tiết
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{!! langRoute('admin.realestale-category.edit', array($categoryrealestale->id)) !!}">
                                                    <span class="glyphicon glyphicon-edit"></span>&nbsp;Sửa </a>
                                            </li>
<!--                                            <li class="divider"></li>
                                            <li>
                                                <a href="{!! URL::route('admin.realestale-category.delete', array($categoryrealestale->id)) !!}">
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
                {!! $categoryRealestales->render() !!}
            </ul>
        </div>
    </div>
@stop