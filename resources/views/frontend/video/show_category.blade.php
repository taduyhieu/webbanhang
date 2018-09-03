@extends('frontend/layout/layout')
@section('content')
<?php $sessionLayout = Session::has('display-layout') ? Session::get('display-layout') : null ?>
@if(!$sessionLayout || $sessionLayout == 'pc')
{!! HTML::style("frontend/css/video.css") !!}
{!! HTML::style("frontend/css/new.css") !!}
@else
{!! HTML::style("frontend/css/mobile/video.css") !!}
{!! HTML::style("frontend/css/mobile/new.css") !!}
@endif
{!! HTML::script("frontend/js/home.js") !!}
<style type="text/css" media="screen">
</style>
<div class="clearfix"></div>
<content>
        <div class="container news">
            <div class="row">  
                <div class="col-md-2 fixed"  id="fixed">
                    <div class="row">
                        <ul class="list-inline-item nav-pills nav">
                            <li><a class="text-uppercase active" data-toggle="pill" href="#new-tab1" title="">Chuyên mục</a></li>
                            @foreach($categories as $category)
                                <li><a href="{{ url().'/'.getLang().'/video/'.$category->slug}}" class="{{ setActive('video/'.$category->slug) }}" title="">{!! $category->name !!}</a></li>
                            @endforeach
                        </ul>
                    </div>  
                </div>
                <div class="col-md-10 offset tab-content" >
                    <div class="row tab-pane fade in active" id="new-tab1">
                        @foreach($videos as $key => $video)
                        @if($key % 4 == 0)
                            <div class="group-img row">
                        @endif
                        
                            <div class="col-md-3 col-sm-6">
                                <div class="img-block-new">
                                    <iframe width="" height="" src="{!! $video->url_link !!}" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
                                    <h6 class="mt-1">
                                        <a href="{!! url(getLang().'/video/detail/'.$video->slug) !!}">{!! $video->title !!}</a>
                                    </h6>
                                    <p class="times">
                                        <i class="fa fa-clock-o" aria-hidden="true"></i>
                                        <span>{!! $video->created_at->format('d/m/Y') !!}</span>
                                    </p>
                                </div>
                            </div> 
                        @if($key % 4 == 3)
                            </div>
                        @endif  
                        @endforeach
                    </div>
                </div>
            </div>
        </div> 
    </div>
</content>
<!-- end content -->
{!! HTML::script("frontend/js/videos.js") !!}
<script type="text/javascript">
    window.onscroll = function() {myFunction()};
   

    var navbar = document.getElementById("fixed");
    var sticky = navbar.offsetTop;

    function myFunction() {
      if (window.pageYOffset >= sticky) {
        navbar.classList.add("sticky")
      } else {
        navbar.classList.remove("sticky");
      }
    }
  
    $(document).ready(function() {
        var s = $(".offset");
        var pos = s.position();                    
        $(window).scroll(function() {
            var windowpos = $(window).scrollTop();
            if (windowpos >= pos.top & windowpos <=1000) {
                s.addClass("offset-md-2");
            } else {
                s.removeClass("offset-md-2"); 
            }
        });
    });
</script>
@stop
