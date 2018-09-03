@if(isset($banners->second))
<a href="{!! url($banners->second->url) !!}" target="_blank"><img src="{!! url($banners->second->path) !!}" class="img-sidebar1" alt=""></a>
@else
<img src="{!! url('assets/images/default.jpg') !!}" class="img-sidebar1" alt="">
@endif