<meta charset="utf-8">
<header id="header" class="home">
    <div class="container-fluid">
        <div class="container top">
            <div class="row" >
                <div class="top-header col-xs-12">
                    <div class="top-left col-md-4 col-xs-4">
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
                    </div>
                    <div class="top-center col-md-4 col-xs-4">
                        <p>{!! $dayOfWeek !!}, ngày {!! $dateNow->day!!}, tháng {!! $dateNow->month!!}, năm {!! $dateNow->year!!}, {!! $dateNow->hour!!}:{!! $dateNow->minute!!}:{!! $dateNow->second!!}</p>
                    </div>
                    <div class="top-right col-md-4 col-xs-4">
                        <div class="row">
                            <p><img src="{!! url('frontend/images/dang-tin.png') !!}" alt=""><span>Đăng tin</span></p>
                            <p><a href="{!! url('admin/login') !!}" title="">Đăng nhập</a> | <a href="" data-toggle="modal" data-target="#modal-user-register">Đăng ký</a></p>
                            <!-- Modal -->
                            <div id="modal-user-register" class="modal fade modal-user-register" role="dialog" data-backdrop="static" data-keyboard="false">
                                <div class="modal-dialog user-register-form">
                                    <form id="user-register-form" method="post" action="vi/user/register/store">
                                        {!! csrf_field() !!}
                                        <!-- Modal content-->
                                        <div class="modal-content register-content">
                                            <div class="modal-body register-body">
                                                <h4 class="modal-title register-title mb-5">Đăng ký tài khoản</h4>
                                                <div class="col-md-12">
                                                    <div class="row mb-2">
                                                        <div class="col-md-5">
                                                            <label class="control-label register-label" for="user_name">Tên truy cập (*)</label>
                                                        </div>
                                                        <div class="col-md-7">
                                                            <input class="register-input form-control" type="text" maxlength="50" id="user_name" name="user_name">
                                                        </div>
                                                        <div class="register-hint hint-user-name">
                                                            <ul>
                                                                <li><span>Tên truy cập là chữ hoặc số viết liền không dấu, không bao gồm ký tự đặc biệt.</span></li>
                                                                <li><span>Hoặc nhập số điện thoại làm tên đăng nhập để không bị trùng với tài khoản khác.</span></li>
                                                                <li><span>Tên truy cập từ 3 đến 45 ký tự.</span></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-2">
                                                        <div class="col-md-5">
                                                            <label class="control-label register-label" for="password">Mật khẩu (*)</label>
                                                        </div>
                                                        <div class="col-md-7">
                                                            <input class="register-input form-control" type="password" maxlength="30" id="password" name="password">
                                                        </div>
                                                        <div class="register-hint hint-password">
                                                            <ul>
                                                                <li><span>Mật khẩu từ 6 đến 30 ký tự.</span></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-2">
                                                        <div class="col-md-5">
                                                            <label class="control-label register-label" for="confirm-password">Xác nhận mật khẩu (*)</label>
                                                        </div>
                                                        <div class="col-md-7">
                                                            <input class="register-input form-control" type="password" maxlength="30" id="confirm-password" name="confirm-password">
                                                        </div>
                                                    </div>
                                                    <div class="row mb-2">
                                                        <div class="col-md-5">
                                                            <label class="control-label register-label" for="full_name">Họ tên (*)</label>
                                                        </div>
                                                        <div class="col-md-7">
                                                            <input class="register-input form-control" type="text" maxlength="50" id="full_name" name="full_name">
                                                        </div>
                                                    </div>
                                                    <div class="row mb-2">
                                                        <div class="col-md-5">
                                                            <label class="control-label register-label" for="mobile">Số điện thoại (*)</label>
                                                        </div>
                                                        <div class="col-md-7">
                                                            <input class="register-input form-control" type="text" maxlength="12" id="mobile" name="mobile">
                                                        </div>
                                                    </div>
                                                    <div class="row mb-2">
                                                        <div class="col-md-5">
                                                            <label class="control-label register-label" for="email-register">Email (*)</label>
                                                        </div>
                                                        <div class="col-md-7">
                                                            <input class="register-input form-control" type="text" maxlength="50" id="email-register" name="email-register">
                                                        </div>
                                                    </div>
                                                    <div class="row mt-3 button-control">
                                                        <button id="user-register-submit-btn" type="button" class="btn btn-success">Đăng ký</button>
                                                        <button type="button" class="btn btn-success ml-2 close-button" data-dismiss="modal">Thoát</button>
                                                    </div>
                                                    <input type="hidden" value="{!! $roles->id !!}" name="user-r">
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container logo">
        <div class="row">
            <div class="text-center title-top">
                <a href="{!! url() !!}"><h2>Diễn đàn bất động sản</h2></a>
                <p>Báo Diễn đàn Doanh nghiệp</p>
            </div>

        </div>
    </div>
    <div class="container menu">
        <div class="row">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">

                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                    <div class="navbar-nav">
                        @foreach($items as $item_menu)
                        <a class="nav-link {{ setActiveMenu($item_menu->url) }}" href="{{ url().'/'.getLang().'/'.$item_menu->url}}">{{ $item_menu->title }}</a>
                        @endforeach
                    </div>
                    <div class="navbar-nav d-flex justify-content-end">
                        <a href="#" class="search" title="" data-toggle="modal" data-target="#myModal">
                            <img src="{!! url('frontend/images/search-blue.png')!!}" alt="#">
                        </a>
                        <a href="#" title="" data-toggle="collapse" data-target="#navbarToggleExternalContent" aria-controls="navbarToggleExternalContent" aria-expanded="false" aria-label="Toggle navigation">
                            <img src="{!! url('frontend/images/icon-bar.png') !!}" class="img-responsive" alt="">
                        </a>
                        <div class="collapse icon-bar-coll" id="navbarToggleExternalContent">
                            <ul class="nav vertical-menu">
                                @if(isset($newsToday) && $newsToday->count() > 0)
                                @foreach($newsToday as $nt)
                                <img src="{!! url('frontend/images/icon-new.gif') !!}" alt="" class="news-new">
                                <li class="nav-link"><a href="{!! URL::route('dashboard.news.show', array('slug'=>$nt->slug)) !!}">{!! $nt->news_title !!}</a></li>
                                @endforeach
                                @else
                                <li class="nav-link"><p>Không có tin mới</p></li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
            </nav>
            <!-- chuyển đổi pc and mobile -->
            <?php $sessionLayout = Session::has('display-layout') ? Session::get('display-layout') : null ?>
            <nav class="navbar pc-mobile">
                @if(!$sessionLayout || $sessionLayout == 'pc')
                <a href="" title="" id="mobile_link"><img src="{!! url('assets/images/if_mobile.png') !!}" alt="" class="mobile_img"></a>
                @else
                <a href="" title="" id="pc_link" data-theme=""><img src="{!! url('assets/images/if_pc.png') !!}" alt="" class="pc_img"></a>
                @endif
            </nav>
            <!-- end chuyển đổi pc and mobile -->
        </div>
        <div class="row">
            <div class="poster">
                @if($banners->first)
                <a href="{!! url($banners->first->url) !!}" target="_blank"><img src="{!! url($banners->first->path) !!}" alt=""></a>
                @else
                <a href=""><img src="{!! url('assets/images/default.jpg') !!}" alt=""></a>
                @endif
            </div>
        </div>
    </div>
</header><!-- /header -->
<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <form id="news-search-form" method="post" action="{{ route('dashboard.search')}}">
            {!! csrf_field() !!}
            <div class="modal-content">
                <div class="modal-header">
                    <p>Nhập tìm kiếm </p>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <input type="text" class="search col-12 col-sm-12" id="search" name="search">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" id="search-title" data-dismiss="modal">Gửi</button>
                </div>
            </div>
        </form>
    </div>
</div>
{!! HTML::script("frontend/js/user-register.js") !!}
<script type="text/javascript">
    $("#mobile_link").delegate(".mobile_img", "click", function () {
        setSessionDisplay('mobile');
        return false;
    });
    $("#pc_link").delegate(".pc_img", "click", function () {
        setSessionDisplay('pc');
        return false;

    });
    function setSessionDisplay(value) {
        $.ajax({
            type: "POST",
            url: "{!! url(getLang() . '/session/setvalue/display') !!}",
            data: {value: value},
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (resp) {
                if (resp == 'success') {
                    location.reload();
                }
            },
            error: function () {
                return;
            }
        });
    }
    $(function () {
        $('#search-title').click(function () {
            $('#news-search-form').submit();
        });
    });

</script>