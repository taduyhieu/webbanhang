<div class="wrapper">
    <div class="row">
        <h4 class="text-center">Video</h4>
    </div>
    <div class="video-main row">
        @foreach($videos as $key => $video)
        @if($key == 0)
        <div class="">
            <iframe width="" height="136" src="{!! $video->url_link !!}" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe> 
        </div>
        <a href="{!! url(getLang().'/video/detail/'.$video->slug) !!}">{!! $video->title !!}</a>
        <p><span>{!! $video->created_at->format('d/m/Y') !!}</span></p>
        @endif
        @endforeach
    </div>
    <div class="group-video row">
        @foreach($videos as $key => $video)
        @if($key > 0)
        <div>
            <div class="row">
                <div class="col-md-5 col-5">

                    <iframe width="" height="49" src="{!! $video->url_link !!}" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>

                </div>
                <div class="sub-video-title col-md-7 col-7">
                    <a href="{!! URL::route('dashboard.video.show', array('slug'=>$video->slug)) !!}">
                        <a href="{!! url(getLang().'/video/detail/'.$video->slug) !!}">{!! $video->title !!}</a>
                    </a>
                </div>
            </div> 
        </div>
        @endif
        @endforeach
    </div>
</div>