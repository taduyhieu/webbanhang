@extends('backend/layout/layout')
@section('content')
<script type="text/javascript">
    $(document).ready(function () {
        $('#notification').show().delay(4000).fadeOut(700);
        $(".status").click(function (event) {
            event.preventDefault();
            var id = $(this).attr('id');
            $.ajax({
                type: "POST",
                url: "{!! url(getLang().'/admin/banner/" + id + "/toggle-publish') !!}",

                headers: {
                    'X-CSRF-Token': $('meta[name="_token"]').attr('content')
                },
                success: function (response) {
                    if (response['result'] == 'fail') {
                        alert("Đã tồn tại banner ở cùng vị trí trong cùng thời gian ");
                    }
                    if (response['result'] == 'success') {
                        var imagePath = (response['changed'] == 1) ? "{!!url('/')!!}/assets/images/publish.png" : "{!!url('/')!!}/assets/images/not_publish.png";
                        $("#publish-image-" + id).attr('src', imagePath);
                    }
                },
                error: function () {
                    alert("error");
                }
            });
        });
    });
</script>
<section class="content-header">
    <h1> Banner
        <small> | Control Panel</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{!! url(getLang(). '/admin') !!}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Banner</li>
    </ol>
</section>
<br>
<div class="container">
    <div class="row">
        <br>
        <div class="col-sm-6">
            <div class="btn-toolbar"><a href="{!! langRoute('admin.banner.create') !!}" class="btn btn-primary">
                    <span class="glyphicon glyphicon-plus"></span>&nbsp;{!! trans('fully.news_new') !!} </a></div>
        </div>
        <div class="col-sm-6">
            <form action="{{ route('admin.banner.search') }}" method="get" class="form-inline pull-right">
                <div class="input-group">
                    <input class="form-control" type="text" id="searchName" name="searchName" placeholder="{{trans('fully.news_placeholder')}}" value="{!! $searchName !!}">
                </div>
                <div class="form-group">
                    <span><input class="submit btn btn-default bg-btn-green" type="submit" value="Tìm kiếm"></span>
                </div>
            </form>
        </div>
    </div>
    <br>
    <div class="col-lg-12">
        @include('flash::message')
        @if($banners->count() > 0)
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Tiêu đề Banner</th>
                        <th>Ngày bắt đầu chạy Banner</th>
                        <th>Ngày kết thúc chạy Banner</th>
                        <th>Vị trí</th>
                        <th>Thao tác</th>
                        <th>Trạng thái</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach( $banners as $i => $banner )
                    <tr>
                        <td>{!! ++$i!!}</td>
                        <td> {!! link_to_route(getLang(). '.admin.banner.show', $banner->name, $banner->id, array(
                            'class' => 'btn btn-link btn-xs' )) !!}</td>
                        <td>{!! date('d/m/Y H:i:s', strtotime($banner->start_date)) !!}</td>
                        <td>{!! date('d/m/Y H:i:s', strtotime($banner->end_date)) !!}</td>
                        <td>
                            @if($banner->position == 1)
                            Banner dưới Menu chính
                            @endif
                            @if($banner->position == 2)
                            Banner phía bên cột phải thứ nhất
                            @endif
                            @if($banner->position == 3)
                            Banner phía bên cột phải thứ hai
                            @endif
                            @if($banner->position == 4)
                            Banner dưới khối tin đầu trang chủ
                            @endif
                        </td>
                        <td>
                            <div class="btn-group">
                                <a class="btn btn-danger dropdown-toggle" data-toggle="dropdown" href="#">
                                    Thao tác <span class="caret"></span> </a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="{!! langRoute('admin.banner.show', array($banner->id)) !!}">
                                            <span class="glyphicon glyphicon-eye-open"></span>&nbsp;Chi tiết
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{!! langRoute('admin.banner.edit', array($banner->id)) !!}">
                                            <span class="glyphicon glyphicon-edit"></span>&nbsp;Sửa </a>
                                    </li>
                                    <li class="divider"></li>
                                    <li>
                                        <a href="{!! URL::route('admin.banner.delete', array($banner->id)) !!}">
                                            <span class="glyphicon glyphicon-remove-circle"></span>&nbsp;Xóa</a>
                                    </li>
                                    {{--<li class="divider"></li>
                                    <li>
                                        <a target="_blank" href="{!! URL::route('dashboard.banner.show', array('slug'=>$banner->slug)) !!}">
                                            <span class="glyphicon glyphicon-eye-open"></span>&nbsp;Xem trên web
                                        </a>
                                    </li>--}}
                                </ul>
                            </div>
                        </td>
                        <td>
                            <a href="" id="{{ $banner->id }}" class="status">
                                <img id="publish-image-{{ $banner->id }}" src="{!!url('/')!!}/assets/images/{!! ($banner->status) ? 'publish.png' : 'not_publish.png'  !!}">
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @else
        <div class="alert alert-danger">Không tìm thấy kết quả</div>
        @endif
    </div>
    <div class="pull-left">
        <ul class="pagination">
            {!! $banners->render() !!}
        </ul>
    </div>
</div>
@stop