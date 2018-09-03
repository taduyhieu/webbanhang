@extends('frontend/layout/layout')
@section('content')
<div class="container-fluid bread">
    <div class="container">
        <div class="dropdown row">
            <button class="dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Tìm kiếm
            </button>
        </div>
    </div>
</div>
<content>
    <div class="container thi-truong">
        <div class="row">
            <div class="content col-md-9">
                <div class="focal mt-4">
                    <div class="container">
                        <div class="row">
                            @foreach($news as $new)
                            <div class="group-img col-md-12 col-sm-12">
                                <div class="row">     
                                    <div class="col-md-6 col-6">
                                        <div class="">
                                            <a href="{!! URL::route('dashboard.news.show', array('slug'=>$new->slug)) !!}"><img src="{!! url($new->news_image) !!}" alt=""></a>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-6">
                                        <div class="">
                                            <a href="{!! URL::route('dashboard.news.show', array('slug'=>$new->slug)) !!}"><p>{!! $new->news_title !!}</p></a>

                                            <p>
                                                {!! mb_substr(strip_tags($new->news_content),0,120) !!} ... 
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="row">
                        <nav aria-label="Page navigation example">
                            <ul class="pagination" >
                                {!! $news->render() !!}
                            </ul>
                        </nav>
                    </div>
                </div>  
            </div>
            <div class="side-bar col-md-3">
                <div class="row">
                    <div class="img-right">
                        <!--Banner position 2-->
                        @include('frontend/side_bars/banner-postion-2')

                        <!--Banner position 3-->
                        @include('frontend/side_bars/banner-postion-3')
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
                            <div >
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
                            <div >

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
                            <div >

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
            </div>
        </div>
    </div> 
</content>
<!-- end content -->
@stop

