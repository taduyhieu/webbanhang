@extends('backend/layout/layout')
@section('content')
<script type="text/javascript">
    $(document).ready(function () {
        $('#notification').show().delay(4000).fadeOut(700);

        // publish settings
        $(".publish").bind("click", function (e) {
            var id = $(this).attr('id');
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: "{!! url(getLang() . '/admin/comment/" + id + "/toggle-publish/') !!}",
                headers: {
                    'X-CSRF-Token': $('meta[name="_token"]').attr('content')
                },
                success: function (response) {
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
    <h1> Bình luận
        <small> | Control Panel</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{!! url(getLang(). '/admin') !!}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Bình luận</li>
    </ol>
</section>
<br>
<div class="container">
    <div class="col-lg-12">
        @include('flash::message')
        <div class="pull-right">
            <form action="{{ route('admin.news-comment.search') }}" method="get" class="form-inline">
                <div class="input-group">
                    <input class="form-control" type="text" id="title_new" name="title_new" placeholder="Tiêu đề bài viết" value="{{ $searchTitle }}">
                </div>
                <div class="form-group">
                    <span><input class="submit btn btn-default bg-btn-green" type="submit" value="Tìm kiếm"></span>
                </div>
            </form>
        </div>
        <br><br><br>
        @if($comments->count() > 0)
        <?php $i = 1; ?>
        <div class="">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Người bình luận</th>
                        <th>Bài viết</th>
                        <th>Ngày đăng</th>
                        <th>Ngày duyệt</th>
                        <th>Trạng thái</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach( $comments as $comment )
                    <tr>
                        <td>{!! $i++ !!}</td>
                        <td> {!! link_to_route(getLang(). '.admin.news-comment.show', $comment->name, $comment->id, array('class' => 'btn btn-link btn-xs' )) !!}</td>
                        <td>{!! $comment->news_title !!}</td>
                        <td>{!! date('d/m/Y H:i:s', strtotime($comment->post_time)) !!}</td>
                        <td>{!! date('d/m/Y H:i:s', strtotime($comment->publish_time)) !!}</td>
                        <td>
                            <a href="" id="{{ $comment->id }}" class="publish">
                                <img id="publish-image-{{ $comment->id }}" src="{!!url('/')!!}/assets/images/{!! ($comment->show_status) ? 'publish.png' : 'not_publish.png'  !!}">
                            </a>
                        </td>
                        <td>
                            <div class="btn-group">
                                <a class="btn btn-danger dropdown-toggle" data-toggle="dropdown" href="#">
                                    Thao tác <span class="caret"></span> </a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="{!! langRoute('admin.news-comment.show', array($comment->id)) !!}">
                                            <span class="glyphicon glyphicon-eye-open"></span>&nbsp;Chi tiết
                                        </a>
                                    </li>
                                    <li class="divider"></li>
                                    <li>
                                        <a href="{!! URL::route('admin.news-comment.delete', array($comment->id)) !!}">
                                            <span class="glyphicon glyphicon-remove-circle"></span>&nbsp;Xóa</a>
                                    </li>

                                    <!--                                    <li>
                                                                            <a href="{!! langRoute('admin.news-comment.edit', array($comment->id)) !!}">
                                                                                <span class="glyphicon glyphicon-edit"></span>&nbsp;Sửa </a>
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
            {!! $comments->render() !!}
        </ul>
    </div>
</div>
@stop