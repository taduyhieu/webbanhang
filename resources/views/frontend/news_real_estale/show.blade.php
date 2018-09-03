@extends('frontend/layout/layout')
@section('content')
<?php $sessionLayout = Session::has('display-layout') ? Session::get('display-layout') : null ?>
@if(!$sessionLayout || $sessionLayout == 'pc')
{!! HTML::style("frontend/css/thong-tin.css") !!}
@else
{!! HTML::style("frontend/css/mobile/thong-tin.css") !!}
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
    <div class="container info">
        <div class="row">
            <div class="content-info col-md-8">
                <div class="detail-info">
                    <div class="list-inline row">
                        <h4 class="">{!! $newsRE->news_title !!}</h4>
                        <p class="">
                            Ngày đăng: @if(date('Y-m-d', strtotime($newsRE->news_publish_date)) == $dateNow)
                            Hôm nay
                            @else
                            {!! date('d/m/Y', strtotime($newsRE->news_publish_date)) !!}
                            @endif
                        </p>
                    </div>
                </div>
                <div class="detail-content row">
                    {!! $newsRE->news_content !!}
                </div>
                <div class="other-information row">
                    <div class="col-md-12">
                        <div class="contact-info">
                            <h4 class="text-center">Các thông tin khác</h4>
                            <p>Địa chỉ tài sản: {!! $newsRE->place !!}</p>
                            <p>SĐT liên hệ: {!! $newsRE->mobile !!}</p>  
                        </div>

                        <div class="other-information-detail row">
                            <div class="col-md-4">
                                <p class="title-th">
                                    <span>Mã tin</span>
                                    @if($newsRE->news_code)
                                    <span>{!! $newsRE->news_code !!}</span>
                                    @else
                                    <span><i class="fa fa-minus" aria-hidden="true"></i></span>
                                    @endif
                                </p>
                                <p class="title-td">
                                    <span>Loại tin</span>
                                    @if($newsRE->type == 0)
                                    <span>Miễn phí</span>
                                    @elseif($newsRE->type == 1)
                                    <span>Trả phí</span>
                                    @endif
                                </p>
                                <p class="title-td">
                                    <span>Loại BDS</span>
                                    <span>{!! $catNews->name !!}</span>
                                </p>
                                <p class="title-td">
                                    <span>Chiều ngang</span>
                                    @if($newsRE->width)
                                    <span>{!! $newsRE->width !!} m</span>
                                    @else
                                    <span><i class="fa fa-minus" aria-hidden="true"></i></span>
                                    @endif
                                </p>
                                <p class="title-td">
                                    <span>Chiều dài</span>
                                    @if($newsRE->length)
                                    <span>{!! $newsRE->length !!} m</span>
                                    @else
                                    <span><i class="fa fa-minus" aria-hidden="true"></i></span>
                                    @endif
                                </p>
                            </div>
                            <div class="col-md-4">
                                <p class="title-th ">
                                    <span>Hướng</span>
                                    @if($newsRE->direction)
                                    <span>
                                        @if($newsRE->direction == 0)
                                        @elseif($newsRE->direction == 1)
                                        Đông
                                        @elseif($newsRE->direction == 2)
                                        Tây
                                        @elseif($newsRE->direction == 3)
                                        Nam
                                        @elseif($newsRE->direction == 4)
                                        Bắc
                                        @elseif($newsRE->direction == 5)
                                        Đông Nam
                                        @elseif($newsRE->direction == 6)
                                        Đông Bắc
                                        @elseif($newsRE->direction == 7)
                                        Tây Nam
                                        @elseif($newsRE->direction == 8)
                                        Tây Bắc
                                        @endif
                                    </span>
                                    @else
                                    <span><i class="fa fa-minus" aria-hidden="true"></i></span>
                                    @endif
                                </p>
                                <p class="title-td ">
                                    <span>Đường trước nhà</span>
                                    <span><i class="fa fa-minus" aria-hidden="true"></i></span>
                                </p>
                                <p class="title-td ">
                                    <span>Pháp lý</span>
                                    @if($newsRE->legal_state)
                                    <span>{!! $newsRE->legal_state !!}</span>
                                    @else
                                    <span><i class="fa fa-minus" aria-hidden="true"></i></span>
                                    @endif
                                </p>
                                <p class="title-td ">
                                    <span>Số lầu</span>
                                    @if($newsRE->number_floor)
                                    <span>{!! $newsRE->number_floor !!}</span>
                                    @else
                                    <span><i class="fa fa-minus" aria-hidden="true"></i></span>
                                    @endif
                                </p>
                                <p class="title-td ">
                                    <span>Số phòng ngủ</span>
                                    @if($newsRE->number_bedroom)
                                    <span>{!! $newsRE->number_bedroom !!}</span>
                                    @else
                                    <span><i class="fa fa-minus" aria-hidden="true"></i></span>
                                    @endif
                                </p>
                            </div>
                            <div class="col-md-4">
                                <p class="title-th ">
                                    <span>Phòng ăn</span>
                                    @if($newsRE->dining_room)
                                    <span>{!! $newsRE->dining_room !!}</span>
                                    @else
                                    <span><i class="fa fa-minus" aria-hidden="true"></i></span>
                                    @endif
                                </p>
                                <p class="title-td ">
                                    <span>Nhà bếp</span>
                                    @if($newsRE->kitchen)
                                    <span>{!! $newsRE->kitchen !!}</span>
                                    @else
                                    <span><i class="fa fa-minus" aria-hidden="true"></i></span>
                                    @endif
                                </p>
                                <p class="title-td ">
                                    <span>Sân thượng</span>
                                    @if($newsRE->terrace == 1)
                                    <span>Có</span>
                                    @else
                                    <span><i class="fa fa-minus" aria-hidden="true"></i></span>
                                    @endif
                                </p>
                                <p class="title-td ">
                                    <span>Chỗ để xe hơi</span>
                                    @if($newsRE->car_place == 1)
                                    <span>Có</span>
                                    @else
                                    <span><i class="fa fa-minus" aria-hidden="true"></i></span>
                                    @endif
                                </p>
                                <p class="title-td ">
                                    <span>Chính chủ</span>
                                    @if($newsRE->owner == 1)
                                    <span>Có</span>
                                    @else
                                    <span><i class="fa fa-minus" aria-hidden="true"></i></span>
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="button-info row">
                    <a href="#" title=""><button type="button">Hình ảnh</button></a>
                    <a href="#" title=""><button type="button">Bản đồ</button></a>
                </div>
                <div class="slide-img row">
                    <div class="w3-content row">
                        @foreach($photos as $photo)
                        <img class="mySlides-info" src="{!! $photo->path !!}">
                        @endforeach
                        <div class="w3-row-padding w3-section owl-carousel" id="w3-carousel">
                            @foreach($photos as $key => $photo)
                            <div class="w3-col s4">
                                <img class="demo1 w3-opacity w3-hover-opacity-off" src="{!! $photo->path !!}" onclick="currentDiv({!! ++$key !!})">
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="description-slide">
                        <p>
                            Lưu ý: <br>
                            Các bạn đang xem tin đăng trong mục "{!! $newsRE->news_title !!}". Các thông tin rao vặt là do người đăng tin đăng tải toàn bộ thông tin. Chúng tôi hoàn toàn không chịu trách nhiệm về bất cứ thông tin nào liên qua đến các thông tin này. Chúng tôi luôn cố gắng để đưa các tin tức nhanh và chính xác nhất cho các bạn.
                        </p>
                    </div>
                </div>
                <div class="reflect row">
                    <div class="text-right">
                        <button type="button">Phản ánh tin vi phạm</button>
                    </div>
                </div>
                <div class="group-real-estate row">
                    <div class="title-real row">
                        <h4 class="text-center"><a href="#" title="" class="text-uppercase">Bất động sản nổi bật</a></h4>
                    </div>
                    <div class="group-img col-md-12 d-flex flex-wrap">
                        @foreach($listPublished as $list_published)
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-5 pd-xs-0">
                                    <a href="{!! URL::route('dashboard.realestale.show', array('slug'=>$list_published->slug)) !!}">
                                        <img src="{!! url().$list_published->news_image !!}" alt="140x100px">
                                    </a>
                                </div>
                                <?php
                                $priceLength = strlen((string) $list_published->price_all);
                                $price = ((string) $list_published->price_all);
                                ?>
                                <div class="col-md-7">
                                    <a href="{!! URL::route('dashboard.realestale.show', array('slug'=>$list_published->slug)) !!}" title="{!! $list_published->news_title !!}">
                                        <h4 class="text-uppercase">{!! $list_published->news_title !!}</h4>
                                    </a>
                                    <div class="d-inline-flex">
                                        <p>DT: <span>{!! $list_published->total_area !!}m<sup>2</sup></span></p>
                                        <p>Giá:
                                            @if($priceLength > 0 && $priceLength < 4)
                                            <span class="text-danger">{!! $price !!} triệu</span>
                                            @elseif($priceLength > 3 && $priceLength < 5)
                                            @if(substr($price, 1) == 000)
                                            <span class="text-danger">{!! substr($price, 0, 1) !!} tỷ</span>
                                            @else
                                            <span class="text-danger">{!! substr($price, 0, 1) !!} tỷ {!! substr($price, 1) !!} triệu</span>
                                            @endif
                                            @elseif($priceLength > 4 && $priceLength < 6)
                                            @if(substr($price, 2) == 000)
                                            <span class="text-danger">{!! substr($price, 0, 2) !!} tỷ</span>                                            
                                            @else
                                            <span class="text-danger">{!! substr($price, 0, 2) !!} tỷ {!! substr($price, 2) !!} triệu</span>
                                            @endif
                                            @elseif($priceLength > 5)
                                            @if(substr($price, 3) == 000)
                                            <span class="text-danger">{!! substr($price, 0, 3) !!} tỷ</span>                                            
                                            @else
                                            <span class="text-danger">{!! substr($price, 0, 3) !!} tỷ {!! substr($price, 3) !!} triệu</span>                 
                                            @endif
                                            @endif
                                        </p>
                                    </div>
                                    <p>{!! $list_published->place !!}</p>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="mx-auto">
                        {!! $listPublished->render()!!}
                    </div>
                </div>
            </div>
            <div class="side-bar col-md-4">
                <!--Search bar-->
                @include('frontend.side_bars.search-bar')
                <div class="dang-tin " >
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
                <div class="email-support ">
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
                <div class="sell-home">
                    <h4 class="text-center">Mua bán nhà đất, bất động sản</h4>
                    @if(isset($tagREChild) && $tagREChild->count() > 0)
                    <div class="category-sell-home">
                        <p><a href="{!! URL::route('dashboard.realestale.tag', array('slug'=>$tagREParent->slug)) !!}" title="">{!! $tagREParent->name !!}</a></p>
                        @foreach($tagREChild as $trec)
                        <p><a href="{!! URL::route('dashboard.realestale.tag', array('slug'=>$trec->slug)) !!}" title="">{!! $trec->name !!}</a></p>
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>
            <!--Banner position 4-->
            @include('frontend/side_bars/banner-postion-4')
            <!--End banner position 4-->
        </div>
    </div>
</content>
<!-- end content -->
<script>
    $(".mx-auto .pagination>li:first-child>a,.mx-auto .pagination>li:first-child>span").html('<i class="fa fa-caret-left" aria-hidden="true"></i>');
    $(".mx-auto .pagination>li:last-child>a,.mx-auto .pagination>li:last-child>span").html('<i class="fa fa-caret-right" aria-hidden="true"></i>');
</script>
{!! HTML::script("frontend/js/thong-tin.js") !!}
@stop