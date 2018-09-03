@if(isset($banners->third))
<a href="{!! url($banners->third->url) !!}" target="_blank"><img src="{!! url($banners->third->path) !!}" class="img-sidebar2" alt=""></a>
@else
<img src="{!! url('assets/images/default.jpg') !!}" class="img-sidebar2" alt="">
@endif