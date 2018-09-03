<div class="news">
    <div class="row">
        <h4 class="text-center">Theo dòng thời sự</h4>
        @if(isset($listFollowNews) && $listFollowNews->count() > 0)
        @foreach($listFollowNews as $fn)
        <div class="new row">
            <div class="col-md-5 col-4">
                <div class="img-block">
                    <a href="{!! URL::route('dashboard.news.show', array('slug'=>$fn->slug)) !!}"><img src="{!! url($fn->news_image) !!}" alt=""></a>
                </div>     
            </div>
            <div class="col-md-7 col-8">
                <a href="{!! URL::route('dashboard.news.show', array('slug'=>$fn->slug)) !!}"><p>{!! $fn->news_title !!}</p></a>
            </div>
        </div>
        @endforeach
        @endif
    </div>
</div>