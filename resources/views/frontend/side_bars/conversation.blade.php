<div class="row">
    <div class="doi-thoai col-12">
        <h4 class="text-center">Đối thoại</h4>
        @if(isset($newsCommentShow) && $newsCommentShow->count() > 0)
        <div class="col-md-12">
            <a href="{!! URL::route('dashboard.news.show', array('slug'=>$newsCommentShow->slug)) !!}"><p>"{!! $newsCommentShow->news_title !!}"</p></a>
            <p><span>{!! date('H:i', strtotime($newsCommentShow->news_publish_date)) !!} | {!! date('d/m/Y', strtotime($newsCommentShow->news_publish_date)) !!}</span> | <span>{!! $newsCommentShow->commentsCount !!} phản hồi</span></p>
            @if(isset($newsCommentShow->comments) && $newsCommentShow->comments->count() > 0)
            @foreach($newsCommentShow->comments as $cmt)
            <div class="box-talk col-md-12">
                <p>{!! $cmt->name !!}</p>
                <p><span>{!! date('H:i', strtotime($cmt->publish_time)) !!},</span> <span>{!! date('d|m|Y', strtotime($cmt->publish_time)) !!}</span></p>
                <p>"{!! $cmt->content !!}"</p>
            </div>
            @endforeach
            @endif
        </div>
        <button type="button" class="btn btn-default text-center" data-toggle="modal" data-target="#modalForm">Gửi phản hồi</button>
        @endif
        <!-- Modal -->
        <div class="modal fade" id="modalForm" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Bình luận</h4>
                    </div>
                    <form id="news-comment-form" method="post" action="{{ route('dashboard.comment.store')}}">
                        {!! csrf_field() !!}
                        <div class="modal-body">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="name">Họ tên:</label>
                                    <input type="text" class="form-control" id="name" name="name">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="email">Email:</label>
                                    <input type="email" class="form-control" id="email" name="email">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label for="comment">Comment:</label>
                                    <textarea class="form-control" rows="5" id="content" name="content" onkeyup="countChar(this)"></textarea>
                                </div>
                            </div>
                            <div class="col-md-12 binh-luan">
                                <div class="row">
                                    <button id="news-comment-submit" type="button" style="border: 1px solid #2cb994; border-radius: 5%; width: 65px; background: #2cb994; color: #fff; text-transform: uppercase; height: 30px; cursor: pointer;">Gửi</button>
                                    <div class="text-right" style="width: 70%; font-style: italic; color: #bfbfbf; margin-left: 50px;">
                                        <p>Bạn còn <span id="charNum">500</span>/500 ký tự</p>   
                                    </div>
                                </div>
                            </div>
                            @if(isset($newsCommentShow))
                            <input type="hidden" name="news_id" value="{{ $newsCommentShow->news_id }}">
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">

    function countChar(val) {
        var len = val.value.length;
        if (len > 500) {
            val.value = val.value.substring(0, 500);
        } else {
            $('#charNum').text(500 - len);
        }
    }
    ;

    // Validate
    $(function () {
        $('#news-comment-submit').click(function () {

            if (!$('#name').val()) {
                alert('Chưa nhập tên');
                return;
            }
            if (!$('#email').val()) {
                alert('Chưa nhập email');
                return;
            } else {
                var email = $('#email').val();
                var filter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
                if (!filter.test(email)) {
                    alert('Chưa đúng định dạng thư điện tử');
                    return;
                }
            }

            if (!$('#content').val()) {
                alert('Chưa nhập nội dung bình luận');
                return;
            }

            $('#news-comment-form').submit();
            alert('Bình luận của bạn đã được gửi !');
        });
    });
</script>