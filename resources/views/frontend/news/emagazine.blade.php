<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>{!! "VCCI" !!}</title>
        <meta name="author" content="THC">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        {!! HTML::style("frontend/css/bootstrap.min.css") !!}
        {!! HTML::style("frontend/css/font-awesome.min.css") !!}
        {!! HTML::style("frontend/css/emagazine.css") !!}
    </head>
    <body>
        <div class="container-fluid top-menu">
            <div class="row">
                <div class="col-md-7">
                    <h4 class="align-content-xl-end"><span>e</span>Magazine</h4>
                </div>

                <div class="pull-right button-top list-inline col-md-5">
                    <button type="button" class="btn-primary btn"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i> Like 11</button>
                    <button type="button" class="btn-primary btn">Share</button>
                </div>
            </div>
        </div>
        <div class="wrapper-magazine">
            <div class="container">
                <div class="img-top col w-100">
                    <img src="{!! $new->news_image !!}" alt="" class="img-fluid">
                </div>
            </div>
            <div class="magazine container">
                <div class="row">
                    <div class="content col">
                        {!! $new->news_content !!}
                    </div>
                    <div class="magazine-footer">
                        <div class="cl">
                            <div class="pull-left">
                                <div><strong>Tác giả: </strong> Quang Minh - Đinh Thanh </div>
                            </div>
                            <div class="pull-right">
                                <div><i class="fa fa-clock-o"></i> 13/03/2018</div>
                            </div>
                            <div class="cl"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>