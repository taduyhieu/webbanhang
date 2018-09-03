<div class="reads">
    <div class="row">
        <h4 class="text-center">Đọc nhiều</h4> 
    </div>
    <div class="table">
        <ul class="nav">
            @if(isset($newsReads) && $newsReads->count() > 0)
            @foreach($newsReads as $key => $nr)
            <li class="row">
                <a href="{!! URL::route('dashboard.news.show', array('slug'=>$nr->slug)) !!}" title="" class="col-md-10 col-10">
                    {!! $nr->news_title !!}
                </a> 
                <p class="col-md-2 col-2">{!! ++$key !!}</p> 
            </li>
            @endforeach
            @endif
        </ul>
    </div>
</div>