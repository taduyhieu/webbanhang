<div class="container">
    <div class="row">
        <div class="img-sale-info">
            @if(isset($banners->fourth))
            <a href="{!! url($banners->fourth->url) !!}" target="_blank"><img src="{!! url($banners->fourth->path) !!}" class="img-sales-1" alt=""></a>
            @else
            <a href=""><img src="{!! url('assets/images/default.jpg') !!}" class="img-sales-1" alt=""></a>
            @endif
        </div>
    </div>
</div>