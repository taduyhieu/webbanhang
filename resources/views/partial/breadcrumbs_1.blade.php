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
    <nav class="breadcrumb">
        @foreach ($breadcrumbs as $breadcrumb)
            @if ($breadcrumb->url && !$breadcrumb->last)
                <span class="breadcrumb-item"><a href="{{ $breadcrumb->url }}">{{ $breadcrumb->title }}</a>
                </span>
                <i class="fa fa-angle-right"></i>
            @else
            <span class="active">{{ $breadcrumb->title }}</span>
            @endif
        @endforeach
    </nav>
@endif
