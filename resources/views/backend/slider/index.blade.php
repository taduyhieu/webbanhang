@extends('backend/layout/layout')
@section('content')
<script type="text/javascript">
    $(document).ready(function () {
        $('#notification').show().delay(4000).fadeOut(700);
    });
</script>
<section class="content-header">
    <h1> {!! trans('fully.slider_slider') !!}
    </h1>
    <ol class="breadcrumb">
        <li><a href="{!! url(getLang(). '/admin') !!}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">{!! trans('fully.slider_slider') !!}</li>
    </ol>
</section>
<br>
<div class="container">
    <div class="col-lg-12">
        @include('flash::message')
        <br>

        <div class="pull-left">
            <div class="btn-toolbar"><a href="{!! langRoute('admin.slider.create') !!}" class="btn btn-primary">
                    <span class="glyphicon glyphicon-plus"></span>&nbsp;{!! trans('fully.slider_new') !!} </a></div>
        </div>
        <br>
        <br>
        <br>
        @if($sliders->count())
        <?php $id=1;  ?>
        <div class="">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>STT</th>
                    <th>Tiêu đề</th>
                    <th>Đường dẫn</th>
                    <th>Thứ tự</th>
                    <th>Thao tác</th>
                </tr>
                </thead>
                <tbody>
                @foreach( $sliders as $slider )
                <tr>
                    <td>{!! $id++ !!}</td>
                    <td> {!! link_to_route(getLang(). '.admin.slider.show', $slider->title, $slider->id, array(
                                    'class' => 'btn btn-link btn-xs' )) !!}</td>
                    <td><a href="{!! $slider->video_url !!}">{!! $slider->path !!}</a></td>
                    <td>{!! $slider->order !!}</td>
                    <td>
                        <div class="btn-group">
                            <a class="btn btn-danger dropdown-toggle" data-toggle="dropdown" href="#">
                                Thao tác
                                <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a href="{!! langRoute('admin.slider.show', array($slider->id)) !!}">
                                        <span class="glyphicon glyphicon-eye-open"></span>&nbsp;Chi tiết
                                    </a>
                                </li>
                                <li>
                                    <a href="{!! langRoute('admin.slider.edit', array($slider->id)) !!}">
                                        <span class="glyphicon glyphicon-edit"></span>&nbsp;Sửa
                                    </a>
                                </li>
                                <li class="divider"></li>
                                <li>
                                    <a href="{!! URL::route('admin.slider.delete', array($slider->id)) !!}">
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
            {!! $sliders->render() !!}
        </ul>
    </div>
</div>
@stop