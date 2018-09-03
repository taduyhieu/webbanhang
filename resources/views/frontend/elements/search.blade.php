<div class="widget search">
     <form action="{!! url('tr/search') !!}" method="GET" role="search">
        <div class="input-group">
            <input type="text" class="form-control" value="{!! $q or null !!}" name="search" autocomplete="off" placeholder="{{ trans('fully.search') }}">
            <span class="input-group-btn">
                <button class="btn btn-danger" type="submit"><i class="icon-search"></i></button>
            </span>
        </div>
    </form>
</div>
<!--/.search-->