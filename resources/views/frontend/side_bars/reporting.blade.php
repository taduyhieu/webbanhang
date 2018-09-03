<div class="reportage">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h4 class="text-center">Phóng sự</h4>
            </div>
            @if(isset($reporting) && $reporting->count() > 0)
            <div class="col-md-6">
                <div class="video-main">
                    <div class="wrapper">
                        <iframe width="" height="" src="{!! $reporting->url_link !!}" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
                    </div>
                    <a href="{!! URL::route('dashboard.video.show-detail', array('slug'=>$reporting->slug)) !!}">
                        <h4>{!! $reporting->title !!}</h4>
                    </a>
                    <p>
                        <span>{!! $reporting->cateName !!}</span> - <span>{!! $reporting->created_at->format('d|m|Y') !!}</span>
                    </p>
                    <p>{!! $reporting->content !!}</p>
                </div>
            </div>
            @endif

            @if(isset($reporting->subList) && $reporting->subList->count() > 0)
            <div class="col-md-6 group-img d-flex flex-wrap">
                @foreach($reporting->subList as $sub)
                <div class="reportage-sublist-title col-md-6 col-6">
                    <div class="wrapper">
                        <iframe width="100%" height="100%" src="{!! $sub->url_link !!}" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
                        <a href="{!! URL::route('dashboard.video.show-detail', array('slug'=>$sub->slug)) !!}">
                            <p>{!! $sub->title !!}</p>
                        </a>
                    </div>
                </div>
                @endforeach
            </div>           
            @endif
        </div>
    </div>
</div>