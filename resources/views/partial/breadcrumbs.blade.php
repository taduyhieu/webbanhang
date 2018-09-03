<style>
    .breadcrumb i{
        padding: 5px 5px;
    }
    .breadcrumb a{
        color: inherit;
    }
    .breadcrumb li{
        color : #676767;
    }
</style>
@if ($breadcrumbs)
    <ul class="breadcrumb">
        @foreach ($breadcrumbs as $breadcrumb)
            @if ($breadcrumb->url && !$breadcrumb->last)
                <li class="breadcrumb-item"><a href="{{ $breadcrumb->url }}">{{ $breadcrumb->title }}</a>
                </li>
                <i class="fa fa-angle-right"></i>
            @else
            <li class="active">{{ $breadcrumb->title }}</li>
            @endif
        @endforeach
    </ul>
@endif
