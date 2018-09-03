@extends('backend/layout/layout')
@section('content')
    <script type="text/javascript">
        $(document).ready(function () {
            $('#notification').show().delay(4000).fadeOut(700);
            $(".status").click(function(event) {
              event.preventDefault();
              var id = $(this).attr('id'); 
              $.ajax({
                type: "POST",
                url: "{!! url(getLang().'/admin/news/comment/" + id + "/toggle-publish') !!}",

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
        <h1> Bình luận
            <small> | Bình luận Panel</small>
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

            <br> <br> <br>
            @if($comments->count())
                
                <?php $id=1; ?>
                <div class="">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>STT</th>
                            <th>Người tạo</th>
                            <th>Nội dung comment</th>
                            <th>Thời gian đăng</th>
                            <th>Thời gian hiển thị</th>
                            <th>Trạng thái</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach( $comments as $comment )
                            <tr>
                                <td>{!! $id++ !!}</td>
                                <td><strong>{!! $comment->name !!}</strong></td>
                                <td>{!! $comment->content !!}</td>
                                <td>{!! date('d/m/Y H:i:s', strtotime($comment->post_time)) !!}</td>
                                <td>{!! date('d/m/Y H:i:s', strtotime($comment->publish_time)) !!}</td>
                                <td>
                                    <a href="" id="{{ $comment->id }}" class="status">
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
                                            <li>
                                                <a href="{!! langRoute('admin.news-comment.edit', array($comment->id)) !!}">
                                                    <span class="glyphicon glyphicon-edit"></span>&nbsp;Sửa </a>
                                            </li>
                                            {{--<li class="divider"></li>
                                            <li>
                                                <a target="_blank" href="{!! URL::route('dashboard.news-comment.show', array('slug'=>$comment->slug)) !!}">
                                                    <span class="glyphicon glyphicon-eye-open"></span>&nbsp;Xem trên web
                                                </a>
                                            </li>--}}
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
                    </table>
                </div>
            
        </div>
    </div>
@stop