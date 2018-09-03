@extends('frontend/layout/layout')
@section('content')

<content>
    <div class="container">
        <div class="row">
            <div class="content col-md-9">
                <div class="content-top">
                    @if(isset($newsHome))
                    <div class="title">
                        <a href="{!! URL::route('dashboard.news.show', array('slug'=>$newsHome->slug)) !!}">
                            <h4>{!! $newsHome->news_title !!}</h4>
                        </a>
                    </div>
                    <div class="row">
                        <div class="col-md-5 news-main">
                            <p>{!! $newsHome->news_sapo !!}</p>
                            <br>
                            <hr>
                            @if(isset($newsHome->hotNews))
                            <p>
                                <img src="{!! url('frontend/images/icon-hot.gif') !!}" alt="" class="hot-new">
                                <a href="{!! URL::route('dashboard.news.show', array('slug'=>$newsHome->hotNews->slug)) !!}"><span>{!! $newsHome->hotNews->news_title !!}</span></a>
                            </p>
                            @endif
                        </div>
                        <div class="col-md-7 img-content-1">
                            <a href="{!! URL::route('dashboard.news.show', array('slug'=>$newsHome->slug)) !!}"><img src="{!! url($newsHome->news_image) !!}" alt=""></a>
                        </div>
                    </div>
                    @if(isset($newsHome->subList) && $newsHome->subList->count() > 0)
                    <div class="content-top-img col-12">
                        <div class="row">
                            @foreach($newsHome->subList as $key => $newschild)
                            <div class="col-md-4 col-sm-12">
                                <a class="col-md-12 col-sm-6 col-4" href="{!! URL::route('dashboard.news.show', array('slug'=>$newschild->slug)) !!}">
                                    <img  src="{!! url($newschild->news_image) !!}" alt="" class="">
                                </a>
                                <a class="news-title-related col-md-12 col-sm-6 col-8" href="{!! URL::route('dashboard.news.show', array('slug'=>$newschild->slug)) !!}">
                                    <p>{!! $newschild->news_title !!}</p>
                                </a>
                            </div>
                            @endforeach
                        </div>
                    </div>  
                    @endif
                    @endif

                    <!--Banner position 4-->
                    @include('frontend/side_bars/banner-postion-4')
                    <!--End banner position 4-->

                    <div class="container group-project">
                        <h4 class="text-center">Dự án nổi bật</h4>
                        <div class="row owl-carousel" id="project-slide">
                            @if(isset($newsProject) && $newsProject->count() > 0)
                            @foreach($newsProject as $np)
                            <div>
                                <div class="group-img col-md-12">
                                    <div>
                                        <a href="{!! URL::route('dashboard.news.show', array('slug'=>$np->slug)) !!}"><img src="{!! $np->news_image !!}" alt=""></a>
                                        <h4>{!! $np->news_title !!}</h4>
<!--                                        <p>
                                            <i class="fa fa-map-marker" aria-hidden="true"></i>
                                            <span>47 Nguyễn Tuân - Thanh Xuân - Hà Nội</span>
                                        </p>   -->
                                    </div>
                                </div>
                                <div class="col-md-12 open-date">
                                    <div class="row">
                                        <button type="button" class="btn">&nbsp;</button>
                                        <a href="{!! URL::route('dashboard.news.show', array('slug'=>$np->slug)) !!}" class="btn"><i class="fa fa-angle-right" aria-hidden="true"></i></a>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            @endif
                        </div>  
                    </div>
                </div>
                <div class="focal">
                    <h4 class="trapezoid"><span>Tiêu điểm</span></h4>
                    <div class="container">
                        @if(isset($listNewsHL))
                        <div class="row">
                            @foreach($listNewsHL as $newsHL)
                            <div class="group-img col-md-12">
                                <div class="row">
                                    <div class="col-md-6 col-4">
                                        <div class="">
                                            <a href="{!! URL::route('dashboard.news.show', array('slug'=>$newsHL->slug)) !!}"><img src="{!! url($newsHL->news_image) !!}" alt=""></a>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-8">
                                        <div class="focal-title">
                                            <a href="{!! URL::route('dashboard.news.show', array('slug'=>$newsHL->slug)) !!}" title="{!! $newsHL->news_title !!}"><p>{!! mb_substr(strip_tags(str_limit($newsHL->news_title,60,'...')),0,70) !!}</p></a>
                                            <p></p>
                                            <p>{!! mb_substr(strip_tags(str_limit($newsHL->news_content,150,'...')),0,160) !!}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @endif
                    </div>
                </div>
                <div class="container option">
                    <div class="row">
                        <div class="col-md-12">
                            @if(isset($firstCats))
                            <div class="row">
                                @foreach($firstCats as $firstCat)
                                <div class="col-md-6">
                                    <div class="thi-truong">
                                        @if($firstCat->id == 1006)
                                        <div class="row">
                                            <a class="category-title" href="{!! URL::route('dashboard.category', array('slug'=>$firstCat->slug)) !!}"><h4 class="trapezoid"><span>Quy hoạch</span></h4></a>
                                        </div>
                                        @else
                                        <div class="row">
                                            <a class="category-title" href="{!! URL::route('dashboard.category', array('slug'=>$firstCat->slug)) !!}"><h4 class="trapezoid"><span>{!! $firstCat->name !!}</span></h4></a>
                                        </div>
                                        @endif
                                        @foreach($firstCat->lastNews as $key => $lastNews)
                                        @if($key == 0)
                                        <div class="row">
                                            <!-- <div class="mart-main"> -->
                                            <div class="col-md-6">
                                                <div class="row">
                                                    <div>
                                                        <a href="{!! URL::route('dashboard.news.show', array('slug'=>$lastNews->slug)) !!}">
                                                            @if($lastNews->news_image)
                                                            <img src="{!! url($lastNews->news_image) !!}" alt="">
                                                            @else
                                                            <img src="{!! url('assets/images/news_thumb.png') !!}" alt="">
                                                            @endif
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <a class="news-title" href="{!! URL::route('dashboard.news.show', array('slug'=>$lastNews->slug)) !!}"><p>{!! mb_substr(strip_tags($lastNews->news_title),0,67)!!}</p></a>
                                                <p>

                                                </p>
                                            </div>
                                            <p>{!! mb_substr(strip_tags($lastNews->news_content),0,160) !!}...</p>
                                        </div>
                                        @else
                                        <div class="row">
                                            <div class="col-md-4 col-sm-4 col-3">
                                                <div class="row">
                                                    <div>
                                                        <a href="{!! URL::route('dashboard.news.show', array('slug'=>$lastNews->slug)) !!}">
                                                            @if($lastNews->news_image)
                                                            <img src="{!! url($lastNews->news_image) !!}" alt="">
                                                            @else
                                                            <img src="{!! url('assets/images/news_thumb.png') !!}" alt="">
                                                            @endif
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-8 col-sm-8 col-8">
                                                <a class="news-title" href="{!! URL::route('dashboard.news.show', array('slug'=>$lastNews->slug)) !!}"><p>{!! mb_substr(strip_tags($lastNews->news_title),0,65) !!}</p></a>
                                            </div>
                                        </div>
                                        @endif
                                        @endforeach
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="tin-rao container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <h4 class="trapezoid"><span>Tin rao bán</span></h4>
                            </div>
                        </div>
                        <div class="col-md-12">
                            @if(isset($listNewsRE))
                            @foreach($listNewsRE as $newsRE)
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="row">
                                        <div>
                                            <a target="_blank" href="{!! URL::route('dashboard.realestale.show', array('slug'=>$newsRE->slug)) !!}">
                                                <img src="{!! $newsRE->news_image !!}" alt="">
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <?php
                                $priceLength = strlen((string) $newsRE->price_all);
                                $price = ((string) $newsRE->price_all);
                                $str1 = substr($price, 0, 1);
                                $str2 = substr($price, 1);
                                ?>
                                <div class="news-real-estale-title col-md-9">
                                    <a target="_blank" href="{!! URL::route('dashboard.realestale.show', array('slug'=>$newsRE->slug)) !!}">
                                        <p>{!! $newsRE->news_title !!}</p>
                                    </a>
                                    <p>Giá : 
                                        @if($priceLength > 0 && $priceLength < 4)
                                        <span>{!! $price !!} triệu</span>
                                        @elseif($priceLength > 3)
                                        <span>{!! $str1 !!} tỷ {!! $str2 !!} triệu</span>
                                        @endif
                                    </p>
                                    <p>Diện tích : <span>{!! $newsRE->total_area !!} m²</span> </p>
                                    <p>Quận/huyện : <span>{!! $newsRE->district !!}, {!! $newsRE->city !!}</span></p>
                                    <p>Đăng ngày - <span>{!! date('d/m/Y', strtotime($newsRE->news_publish_date)) !!}</span></p>
                                    <!--Đăng bởi admin -->
                                </div>
                            </div>
                            @endforeach
                            @endif
                        </div>
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
    <div class="container-fluid">

    </div>  
</content>
<!-- end content -->
<div class="bat-dong-san container-fluid">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h4 class="text-center">ỐNG KÍNH BẤT ĐỘNG SẢN</h4>
            </div>
            <div class="row">
                @if(isset($newsLensRE) && $newsLensRE->count() > 0)
                <div class="col-md-8">
                    <div class="">
                        <div>
                            <a href="{!! URL::route('dashboard.news.show', array('slug'=>$newsLensRE->slug)) !!}"><img src="{!! url($newsLensRE->news_image) !!}" alt=""></a>
                            <a href="{!! URL::route('dashboard.news.show', array('slug'=>$newsLensRE->slug)) !!}"><p>{!! $newsLensRE->news_title !!}</p></a>
                        </div>
                    </div>
                </div>
                @endif
                <div class="col-md-4">
                    @if(isset($newsLensRE->subList) && $newsLensRE->subList->count() > 0)
                    @foreach($newsLensRE->subList as $subList)
                    <div class="row">
                        <div class="col-md-12">
                            <div>
                                <a href="{!! URL::route('dashboard.news.show', array('slug'=>$subList->slug)) !!}"><img src="{!! url($subList->news_image) !!}" alt=""></a>
                                <a href="{!! URL::route('dashboard.news.show', array('slug'=>$subList->slug)) !!}"><p>{!! $subList->news_title !!}</p></a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
<section class="partner">
    <div class="container">
        <div class="row"> 
            <div class="col-md-12 partner-title">
                <div class="row">
                    <h4 class="trapezoid"><span>đối tác</span></h4>
                </div>
            </div>

            <div class="owl-carousel" id="img-partner">
                @foreach ($sliders as $slider)
                <div><img src="{!! url($slider->path) !!}" alt="a"></div>
                @endforeach
            </div>
        </div>
    </div>
</section>
@stop

