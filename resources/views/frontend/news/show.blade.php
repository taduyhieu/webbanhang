@extends('frontend/layout/layout')
@section('content')

<div class="container-fluid bread">
    <div class="container">
        <div class="dropdown row">
            <button class="dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                {!! $new->cat_name !!}
            </button>
            <!--            <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                            <button class="dropdown-item" type="button">Action</button>
                            <button class="dropdown-item" type="button">Another action</button>
                            <button class="dropdown-item" type="button">Something else here</button>
                        </div>-->
        </div>
    </div>
</div>
<content>
    <div class="container bai-viet">
        <div class="row">
            <div class="content col-md-9">
                <div class="container">
                    <div class="row">
                        <h4>{!! $new->news_title !!}</h4> 
                        <hr>
                    </div>

                </div>
                <div class="container">
                    <div class="row">
                        <div class="side-bar-left col-md-3">
                            <div class="row">
                                <h4>Có thể quan tâm</h4>
                            </div>
                            <div class="row">
                                @if(isset($newsRelation) && count($newsRelation) > 0)
                                @foreach($newsRelation as $newsRela)
                                <div class="col-12 row">
                                    <a class="col-md-12 col-4" href="{!! URL::route('dashboard.news.show', array('slug'=>$newsRela->slug)) !!}">
                                        <img class="row" src="{!! url($newsRela->news_image) !!}" alt="">
                                    </a>
                                    <a class="col-md-12 col-8" href="{!! URL::route('dashboard.news.show', array('slug'=>$newsRela->slug)) !!}">
                                        <p class=" row">{!! $newsRela->news_title !!}</p>
                                    </a>
                                </div>
                                @endforeach
                                @endif
                                <div>
                                    <a><img src="{!! url('frontend/images/mit.png') !!}" alt=""></a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="content-right container row">
                                <div class="col-md-12 mb-3">
                                    <div class="form-group row">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text" id="btnGroupAddon"><img src="{!! url('frontend/images/google.png') !!}" alt=""></div>
                                            </div>
                                            <input type="text" class="" placeholder="Input group example" aria-label="Input group example" aria-describedby="btnGroupAddon">
                                            <button type="button" class="btn btn-default">Google+</button>
                                        </div>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text" id="btnGroupAddon"><img src="{!! url('frontend/images/facebook.png') !!}" alt=""></div>
                                            </div>
                                            <input type="text" class="" placeholder="Input group example" aria-label="Input group example" aria-describedby="btnGroupAddon">
                                            <button type="button" class="btn btn-default">Facebook</button>
                                        </div>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text" id="btnGroupAddon"><img src="{!! url('frontend/images/zalo.png') !!}" alt=""></div>
                                            </div>
                                            <input type="text" class="" placeholder="Input group example" aria-label="Input group example" aria-describedby="btnGroupAddon">
                                            <button type="button" class="btn btn-default">Zalo</button>
                                        </div>
                                    </div>     
                                </div>
                                <div class="container mt-0">
                                    <div class="row">
                                        <p class="news-sapo">{!! $new->news_sapo !!}</p>
                                    </div>

                                    <div class="row">
                                        {!! $new->news_content !!}
                                    </div>
                                    <div class="row">
                                        <div class="tag">
                                            Từ khóa :
                                            @foreach($tags as $tag)
                                            <a href="{!! url(getLang().'/tag/'.$tag->slug) !!}">#{!! $tag->name !!}</a>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <div class="form-group row">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text" id="btnGroupAddon"><img src="{!! url('frontend/images/google.png') !!}" alt=""></div>
                                            </div>
                                            <input type="text" class="" placeholder="Input group example" aria-label="Input group example" aria-describedby="btnGroupAddon">
                                            <button type="button" class="btn btn-default">Google+</button>
                                        </div>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text" id="btnGroupAddon"><img src="{!! url('frontend/images/facebook.png') !!}" alt=""></div>
                                            </div>
                                            <input type="text" class="" placeholder="Input group example" aria-label="Input group example" aria-describedby="btnGroupAddon">
                                            <button type="button" class="btn btn-default">Facebook</button>
                                        </div>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text" id="btnGroupAddon"><img src="{!! url('frontend/images/zalo.png') !!}" alt=""></div>
                                            </div>
                                            <input type="text" class="" placeholder="Input group example" aria-label="Input group example" aria-describedby="btnGroupAddon">
                                            <button type="button" class="btn btn-default">Zalo</button>
                                        </div>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text" id="btnGroupAddon"><img src="{!! url('frontend/images/print.png') !!}" alt=""></div>
                                            </div>
                                            <input type="text" class="" placeholder="Input group example" aria-label="Input group example" aria-describedby="btnGroupAddon">
                                            <button type="button" class="btn btn-default">Print</button>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-md-12 contact-info-post mb-3">
                                    <div class="row">
                                        <p>Theo dõi <span ><a href="" class="post-link">tin tức</a></span> báo Thanh Niên trên các mạng xã hội</p>
                                        <p>
                                            <span>
                                                <a href="#" class="post-link">Tin 24h - </a>
                                            </span>
                                            <span>
                                                <a href="#" class="post-link">Tin 360<sup>o</sup> - </a>
                                            </span>
                                            <span>
                                                <a href="#" class="post-link">Thị trường</a>
                                            </span>
                                        </p>
                                        <p>
                                            Liên hệ cung cấp thông tin và gửi tin bài cộng tác
                                        </p>
                                        <p>
                                            <span><i class="fa fa-phone" aria-hidden="true"></i></span>
                                            <span>Hotline:<b>0906 645 777</b></span>
                                        </p>
                                        <p class="post-link">
                                            <span><i class="fa fa-envelope-o" aria-hidden="true"></i>Email: </span>
                                            <span><a href="#" class="post-link">thoisu@thanhnien.vn</a></span>
                                        </p>
                                    </div>
                                </div>
                                <form id="news-comment-form" method="post" action="{{ route('dashboard.comment.store')}}">
                                    {!! csrf_field() !!}
                                    <div class="comment">

                                        <h4 class="row">Bình luận</h4>
                                        <div class="row">
                                            <div class="form-group col-md-6">
                                                <label for="usr">Họ tên:</label>
                                                <input type="text" class="form-control" id="name" name="name">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="ema">Email:</label>
                                                <input type="email" class="form-control" id="email" name="email">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-md-12">
                                                <label for="comment">Bình luận:</label>
                                                <textarea maxlength="500" class="form-control" rows="5" id="content" name="content" onkeyup="countChar(this)"></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-12 binh-luan">
                                            <div class="row">
                                                <button id="news-comment-submit" type="button">gửi</button>
                                                <div class="text-right">
                                                    <p>Bạn còn <span id="charNum">500</span>/500 ký tự</p>
                                                </div>
                                            </div>
                                        </div>
                                        <input type="hidden" name="news_id" value="{{ $new->news_id }}">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!--Banner position 4-->
                @include('frontend/side_bars/banner-postion-4')
                <!--End banner position 4-->

                <!--Reporting-->
                @include('frontend/side_bars/reporting')
                <!--End reporting-->

            </div>
            <div class="side-bar col-md-3">
                <div class="row">
                    <div class="img-right">
                        <!--Banner position 2-->
                        @include('frontend/side_bars/banner-postion-2')
                    </div>

                </div>
                <!--News read much-->
                @include('frontend/side_bars/reads')
                <!--End news read much-->

                <!--Video-->
                @include('frontend/side_bars/video')
                <!--End video-->

                <!--Conversation-->
                @include('frontend/side_bars/conversation')
                <!--End conversation-->

                <!--Follow news-->
                @include('frontend/side_bars/follow-news')
                <!--End follow news-->

                <div class="dang-tin row" >
                    <div class="col-md-12">
                        <div class="row">
                            <div>
                                <img src="{!! url('frontend/images/dangtin.png') !!}" class="img-responsive" alt="" width="100%">
                            </div>
                            <div><p><a href="#" title="">Đăng tin</a></p></div>
                        </div>
                    </div>
                </div>
                <!--Search bar-->
                @include('frontend/side_bars/search-bar')
                <!--End search bar-->
                <div class="support row">
                    <div class="col-md-12">
                        <div class="row">                        
                            <div>
                                <i class="fa fa-phone" aria-hidden="true"></i>
                            </div>

                            <div>
                                <p>
                                    <a href="#" title="">Hỗ trợ trực tuyến:1900 0000</a>
                                    <a href="#" title="">HOTLINE</a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="email-support row">
                    <div class="col-md-12">
                        <div class="row">                        
                            <div>
                                <i class="fa fa-envelope-o" aria-hidden="true"></i>
                            </div>
                            <div>
                                <p>
                                    <a href="#" title="">Email hỗ trợ: company@gmail.com</a>
                                    <a href="#" title="">email</a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <!--Survey-->
                @include('frontend/side_bars/survey')
                <!--End survey--> 
            </div>
        </div>
    </div> 
</content>
{!! HTML::script("frontend/js/popper.min.js") !!}
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
            else if (!$('#email').val()) {
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
                else if (!$('#content').val()) {
                    alert('Chưa nhập nội dung bình luận');
                    return;
                }

            $('#news-comment-form').submit();
            alert('Bình luận của bạn đã được gửi !');
        });
    });
    var myVideo = document.getElementById("video1");
    var myVideo2 = document.getElementById("video2");
    var myVideo3 = document.getElementById("video3");
    /*video phóng sự*/
    var myVideoR1 = document.getElementById("video-r1");
    var myVideoR2 = document.getElementById("video-r2");
    var myVideoR3 = document.getElementById("video-r3");
    var myVideoR4 = document.getElementById("video-r4");
    var myVideoR5 = document.getElementById("video-r5");
    var myVideoR6 = document.getElementById("video-r6");
    var myVideoR7 = document.getElementById("video-r7");

    /*end video phóng sự*/
    function playPause() {
        if (myVideo.paused)
            myVideo.play();
        else
            myVideo.pause();
    }
    function playPause2() {
        if (myVideo2.paused)
            myVideo2.play();
        else
            myVideo2.pause();
    }
    function playPause3() {
        if (myVideo3.paused)
            myVideo3.play();
        else
            myVideo3.pause();
    }
    /*=-----------*/
    function playPauseR1() {
        if (myVideoR1.paused)
            myVideoR1.play();
        else
            myVideoR1.pause();
    }
    function playPauseR2() {
        if (myVideoR2.paused)
            myVideoR2.play();
        else
            myVideoR2.pause();
    }
    function playPauseR3() {
        if (myVideoR3.paused)
            myVideoR3.play();
        else
            myVideoR3.pause();
    }
    function playPauseR4() {
        if (myVideoR4.paused)
            myVideoR4.play();
        else
            myVideoR4.pause();

    }
    function playPauseR5() {
        if (myVideoR5.paused)
            myVideoR5.play();
        else
            myVideoR5.pause();

    }
    function playPauseR6() {
        if (myVideoR6.paused)
            myVideoR6.play();
        else
            myVideoR6.pause();

    }
    function playPauseR7() {
        if (myVideoR7.paused)
            myVideoR7.play();
        else
            myVideoR7.pause();

    }

    /*----------*/

</script>
@stop