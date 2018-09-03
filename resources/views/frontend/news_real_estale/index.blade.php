@extends('frontend/layout/layout')
@section('content')
<?php $sessionLayout = Session::has('display-layout') ? Session::get('display-layout') : null ?>
@if(!$sessionLayout || $sessionLayout == 'pc')
{!! HTML::style("frontend/css/muaban.css") !!}
@else
{!! HTML::style("frontend/css/mobile/muaban.css") !!}
@endif
<div class="container-fluid bread">
    <div class="container">
        <div class="dropdown row">
            <button class="dropdown-toggle" type="button" aria-haspopup="true" aria-expanded="false">
                Sàn giao dịch
            </button>
            <!--            <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                            <button class="dropdown-item" type="button"><a href="#" title="">Action</a></button>
                            <button class="dropdown-item" type="button"><a href="#" title="">Action</a></button>
                            <button class="dropdown-item" type="button"><a href="#" title="">Action</a></button>
                        </div>-->
        </div>
    </div>
</div>
<content>
    <div class="container sale">
        <div class="row">
            <div class="content-sale col-md-8">
                @if(isset($newsRE) && $newsRE->count() > 0)
                @foreach($newsRE as $news)
                <div class="row group-sale">
                    <div class="col-md-12 title-list-inline">
                        <div class="list-inline">
                            <a href="{!! URL::route('dashboard.realestale.show', array('slug'=>$news->slug)) !!}">
                                <p class="pull-left">{!! $news->news_title !!}</p>
                            </a>
                            <p class="pull-right">
                                @if(date('Y-m-d', strtotime($news->news_publish_date)) == $dateNow)
                                Hôm nay
                                @else
                                {!! date('d/m/Y H:i:s', strtotime($news->news_publish_date)) !!}
                                @endif
                            </p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="img-sale">
                            <a href="{!! URL::route('dashboard.realestale.show', array('slug'=>$news->slug)) !!}" title=""><img src="{!! $news->news_image !!}" alt=""></a>
                        </div>
                    </div>
                    <div class="col-md-9 sale-des-detail">
                        <div class="des-detail">
                            <p>{!! mb_substr(strip_tags($news->news_content),0,120) !!} ...
                                <a href="{!! URL::route('dashboard.realestale.show', array('slug'=>$news->slug)) !!}" title="" class="text-detail"><span>&lt;</span>Xem chi tiết <span>&gt;</span>
                                </a>
                            </p>
                        </div>
                        <div class="col-md-12 group-select-apartment">
                            <div class="row">
                                <p>
                                    <img src="{!! url('frontend/images/kc.png') !!}" class="img-sale1" alt="">
                                    <span>{!! $news->width !!} M</span>
                                </p>
                                <p>
                                    <img src="{!! url('frontend/images/tang.png') !!}" class="img-sale1" alt="">
                                    <span>{!! $news->number_floor !!} lầu</span>
                                </p>
                                <p>
                                    <img src="{!! url('frontend/images/room.png') !!}" class="img-sale1" alt="">
                                    <span>{!! $news->number_bedroom !!} phòng ngủ</span>
                                </p>
                            </div>
                            <div class="row">
                                <p>Diện tích : {!! $news->total_area !!} m<sup>2</sup></p>
                                <p>Kích thước:  </p>
                                <p>Hướng: 
                                    @if($news->direction == 0)
                                    @elseif($news->direction == 1)
                                    Đông
                                    @elseif($news->direction == 2)
                                    Tây
                                    @elseif($news->direction == 3)
                                    Nam
                                    @elseif($news->direction == 4)
                                    Bắc
                                    @elseif($news->direction == 5)
                                    Đông Nam
                                    @elseif($news->direction == 6)
                                    Đông Bắc
                                    @elseif($news->direction == 7)
                                    Tây Nam
                                    @elseif($news->direction == 8)
                                    Tây Bắc
                                    @endif
                                </p>
                            </div>
                            <?php
                            $priceLength = strlen((string) $news->price_all);
                            $price = ((string) $news->price_all);
                            ?>
                            <div class="row price">
                                <p class="col-md-4">Giá 
                                    @if($priceLength > 0 && $priceLength < 4)
                                    <span>{!! $price !!} triệu</span>
                                    @elseif($priceLength > 3 && $priceLength < 5)
                                    @if(substr($price, 1) == 000)
                                    <span>{!! substr($price, 0, 1) !!} tỷ</span>
                                    @else
                                    <span>{!! substr($price, 0, 1) !!} tỷ {!! substr($price, 1) !!} triệu</span>
                                    @endif
                                    @elseif($priceLength > 4 && $priceLength < 6)
                                    @if(substr($price, 2) == 000)
                                    <span>{!! substr($price, 0, 2) !!} tỷ</span>                                            
                                    @else
                                    <span>{!! substr($price, 0, 2) !!} tỷ {!! substr($price, 2) !!} triệu</span>
                                    @endif
                                    @elseif($priceLength > 5)
                                    @if(substr($price, 3) == 000)
                                    <span>{!! substr($price, 0, 3) !!} tỷ</span>                                            
                                    @else
                                    <span>{!! substr($price, 0, 3) !!} tỷ {!! substr($price, 3) !!} triệu</span>                 
                                    @endif
                                    @endif
                                </p>
                                <p class="col-md-8">{!! $news->place !!}</p>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
                @else
                <div class="alert alert-danger">Không tìm thấy tin nào theo yêu cầu của bạn</div>
                @endif
                @if(isset($newsRE) && $newsRE->count() > 0)
                <div class="row paginate">
                    <nav aria-label="Page navigation example">
                        <ul class="pagination">
                            {!! $newsRE->render() !!}
                        </ul>
                    </nav>
                </div>
                @endif
            </div>
            <div class="side-bar col-md-4">
                <!--Search bar-->
                @include('frontend.side_bars.search-bar')
                <div class="dang-tin">
                    <div class="col-md-12">
                        <div class="row">                        
                            <div >
                                <img src="{!! url('frontend/images/dangtin.png') !!}" class="img-responsive" alt="" width="100%">
                            </div>
                            <div><p><a href="#" title="">Đăng tin</a></p></div>
                        </div>
                    </div>
                </div>
                <div class="support ">
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
                <div class="email-support ">
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
                <div class="sell-home">
                    <h4 class="text-center">Mua bán nhà đất, bất động sản</h4>
                    @if(isset($tagRealEstale) && $tagRealEstale->count() > 0)
                    <div class="category-sell-home">
                        @foreach($tagRealEstale as $tre)
                        <p><a href="{!! URL::route('dashboard.realestale.tag', array('slug'=>$tre->slug)) !!}" title="">{!! $tre->name !!}</a></p>
                        @endforeach
                    </div>
                    @endif
                </div>
                <!--Survey-->
                @include('frontend/side_bars/survey')
                <!--End survey-->
            </div>
            <!--Banner position 4-->
            @include('frontend/side_bars/banner-postion-4')
            <!--End banner position 4-->
        </div>
    </div>

</content>

<!-- end content -->
@stop