@extends('frontend/layout/layout')
@section('content')

<?php $sessionLayout = Session::has('display-layout') ? Session::get('display-layout') : null ?>
@if(!$sessionLayout || $sessionLayout == 'pc')
{!! HTML::style("frontend/css/video.css") !!}
@else
{!! HTML::style("frontend/css/mobile/video.css") !!}
@endif
{!! HTML::script("frontend/js/home.js") !!}
<div class="clearfix"></div>
<content>
    <div class="container videos">
        <div class="row "><!-- justify-content-between -->
            <div class="col-md-7">
                <div class="video-main">
                    <div>
                        <iframe width="" height="" src="{!! $video->url_link !!}" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
                    </div>

                    <h4>{!! $video->title !!}</h4>
                    <p class="first">
                        <span>{!! $video->nameCategory !!}</span> - <span>{!! $video->created_at->format('d/m/Y') !!}</span>
                    </p>
                    <div><p class="last">{!! $video->content !!}</p></div>
                </div>
            </div> 
            <div class="col-md-5">
                <h4 class="trapezoid"><span>Tiêu điểm</span></h4>
                @foreach($videos as $key => $video)
                @if($key < 8)
                @if($key % 2 == 0)
                <div class="group-video row">
                    @endif
                    <div class="col-md-6">
                        <div class="wrapper">
                            <iframe width="" height="" src="{!! $video->url_link !!}" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
                        </div>
                        <a href="{!! url(getLang().'/video/detail/'.$video->slug) !!}">{!! $video->title !!}</a>
                        
                        <p>{!! $video->categoryName !!} - {!! $video->created_at->format('d/m/Y') !!}</p>
                    </div>
                    @if($key % 2 == 1)
                </div>
                @endif
                @else
                @if($key % 2 == 0)
                <div class="group-video row showVideo" style="display:none">
                    @endif
                    <div class="col-md-6 showVideo" style="display:none">
                        <div class="wrapper">
                            <iframe width="" height="" src="{!! $video->url_link !!}" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
                        </div>
                        <a href="{!! url(getLang().'/video/detail/'.$video->slug) !!}">{!! $video->title !!}</a>
                        <p>{!! $video->categoryName !!} - {!! $video->created_at->format('H:i') !!}, {!! $video->created_at->format('d/m/Y') !!}</p>
                    </div>
                    @if($key % 2 == 1)
                </div>
                @endif
                @endif
                <?php $temp = $key; ?>
                @endforeach
                @if($temp % 2 == 0)
            </div>
            @endif
            <div class="row download expandVideo">
                <button type="button" class="form-control" >Tải thêm video</button>
            </div>
            <div class="row download hiddenVideo" style="display: none;">
                <button type="button" class="form-control">Ẩn bớt video</button>
            </div>   
        </div>

    </div>
</div>
<div class="container select">
    <div class="btn-group-vertical">
        <div class="dropright">
            <button type="button" class="dropdown-toggle" data-toggle="dropdown">
                Chuyên mục
            </button>
            <ul class="dropdown-menu dropright">
                @foreach($categories as $category)
                <li class="dropdown-item dropdown-toggle" >
                    <a href="{!! url(getLang().'/video/'.$category->slug) !!}" class="">{!! $category->name !!}</a>
                    <div class="row">
                        <button type="button"><i class="fa fa-caret-left" aria-hidden="true"></i></button>
                        <button type="button"><i class="fa fa-caret-right" aria-hidden="true"></i></button>
                    </div>
                </li>
                @endforeach


            </ul>
        </div>
        @foreach($categories as $category)
        <button type="button" class="">{!! $category->name !!}</button>
        @endforeach
    </div>
</div>  
</content>
<!-- end content -->
{!! HTML::script("frontend/js/videos.js") !!}
<script type="text/javascript">
    $(document).ready(function () {
        $('.hiddenVideo').click(function () {
            $('.showVideo').hide();
            $('.expandVideo').show();
            $('.hiddenVideo').hide();
        });
        $('.expandVideo').click(function () {
            $('.showVideo').show();
            $('.expandVideo').hide();
            $('.hiddenVideo').show();
        });
    });
</script>
@stop
