@extends('backend/layout/layout')
@section('content')

<script type="text/javascript">
    $(document).ready(function () {
        $('#notification').show().delay(4000).fadeOut(700);

        // publish settings
        $(".publish").bind("click", function (e) {
            var id = $(this).attr('id');
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: "{!! url(getLang() . '/admin/news-show-comment/" + id + "/toggle-publish/') !!}",
                headers: {
                    'X-CSRF-Token': $('meta[name="_token"]').attr('content')
                },
                success: function (response) {
                    if (response['result'] == 'success') {
                        var imagePath = (response['changed'] == 1) ? "{!!url('/')!!}/assets/images/publish.png" : "{!!url('/')!!}/assets/images/not_publish.png";
                        $("#publish-image-" + id).attr('src', imagePath);
                    }
                },
                error: function () {
                    alert("error");
                }
            });
        });
    });

    // Validate
    $(function () {
        $('#search-news-submit').click(function () {
            if (!$('#title_new').val() && !$('#cat_id').val() && !$('#status_id').val()) {
                alert('Chưa nhập tiêu đề bài viết hoặc danh mục hoặc trạng thái bài viết');
                return;
            }
            if ($('#title_new').val() || $('#cat_id').val() || $('#status_id').val()) {
                $('#search-news-form').submit();
            }

        });
    });

</script>

<section class="content-header">
    <h1>
        {{trans('fully.news_header')}}
    </h1>
    <ol class="breadcrumb">
        <li><a href="{!! URL::route('admin.dashboard') !!}">Dashboard</a></li>
        <li class="active"> {{trans('fully.news_header')}}</li>
    </ol>
</section>
<br>
<div class="container">
    <div class="row">
        @include('flash::message')
        <br>
        <div class="col-sm-4">
            <div class="btn-toolbar"><a href="{!! langRoute('admin.news.create') !!}" class="btn btn-primary">
                    <span class="glyphicon glyphicon-plus"></span>&nbsp;{!! trans('fully.news_new') !!} </a></div>
        </div>
        <div class="col-sm-8">
            <form id="search-news-form" action="{{ route('admin.news.search') }}" method="get" class="form-inline pull-right">
                <select class="form-control" name="status_id" id="status_id">
                    <option value="" selected>Chọn trạng thái</option>
                    <option value="0" style="font-weight: bold">Bài đợi biên tập</option>
                    <option value="1" style="font-weight: bold">Bài nhận biên tập</option>
                    <option value="2" style="font-weight: bold">Bài đã biên tập xong</option>
                    <option value="3" style="font-weight: bold">Bài đã xét duyệt</option>
                    <option value="4" style="font-weight: bold">Bài đã xuất bản</option>
                    <option value="5" style="font-weight: bold">Bài đã trả lại</option>
                    <option value="6" style="font-weight: bold">Bài đã gỡ</option>  
                </select>
                
                <select class="form-control" name="cat_id" id="cat_id">
                    <option value="" selected>Chọn danh mục</option>
                    @foreach($cate as $cat)
                    <option value="{!! $cat->id !!}" style="font-weight: bold">{!! $cat->name !!}</option>
                    @endforeach
                </select>
                
                <div class="input-group">
                    <input class="form-control" type="text" id="title_new" name="title_new" placeholder="{{trans('fully.news_placeholder')}}" value="{{ $searchTitle }}">
                </div>
                <div class="form-group">
                    <button id="search-news-submit" class="submit btn btn-default bg-btn-green" type="button">Tìm kiếm</button>
                </div>
            </form>
        </div>
    </div>
    <br>
    <div class="col-lg-12">
        @if($news->count() > 0)
        <div class="row">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Stt</th>
                        <th>{!! trans('fully.news_title') !!}</th>
                        <th>Hiển thị đối thoại</th>
                        <th>{!! trans('fully.news_setting') !!}</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($news as $key => $new)
                    <tr>
                        <td>{!! ++$key !!}</td>
                        <td> {!! link_to_route(getLang(). '.admin.news.show', $new->news_title, $new->news_id, array( 'class'=> 'btn btn-link btn-xs' )) !!}
                        </td>
                        <td>
                            <a href="#" id="{{ $new->news_id }}" class="publish">
                                <img id="publish-image-{{ $new->news_id }}" src="{!!url('/')!!}/assets/images/{!! ($new->is_comment_show) ? 'publish.png' : 'not_publish.png'  !!}">
                            </a>
                        </td>
                        <td>
                            @if($new->news_status == 0)
                            Bài đợi biên tập
                            @elseif($new->news_status == 1)
                            Bài nhận biên tập
                            @elseif($new->news_status == 2)
                            Bài đã biên tập xong
                            @elseif($new->news_status == 3)    
                            Bài đã xét duyệt
                            @elseif($new->news_status == 4)
                            Bài đã xuất bản
                            @elseif($new->news_status == 5)
                            Bài đã trả lại
                            @elseif($new->news_status == 6)
                            Bài đã gỡ
                            @endif
                        </td>
                        <td>
                            <div class="btn-group">
                                <a class="btn btn-danger dropdown-toggle" data-toggle="dropdown" href="#">
                                    {{trans('fully.action')}} <span class="caret"></span> </a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="{!! langRoute('admin.news.show', array($new->news_id)) !!}">
                                            <span class="glyphicon glyphicon-eye-open"></span>&nbsp;{{trans('fully.show')}}
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{!! URL::route('admin.news.comment.listComment',array($new->news_id)) !!}">
                                            <span class="glyphicon glyphicon-eye-open"></span>&nbsp;{{trans('fully.showComment')}}
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{!! URL::route('admin.news.history', array($new->news_id)) !!}">
                                            <i class="fa fa-history"></i>&nbsp;Lịch sử bài viết
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{!! langRoute('admin.news.edit', array($new->news_id)) !!}">
                                            <span class="glyphicon glyphicon-edit"></span>&nbsp;{{trans('fully.edit')}} 
                                        </a>
                                    </li>

                                    <!--                                    <li class="divider"></li>
                                                                        <li>
                                                                            <a href="{!! URL::route('admin.news.delete', array($new->news_id)) !!}">
                                                                                <span class="glyphicon glyphicon-remove-circle"></span>&nbsp;{{trans('fully.delete')}}
                                                                            </a>
                                                                        </li>-->
                                </ul>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="alert alert-danger">{{trans('fully.not_found')}}</div>
        @endif </div>
    <div class="pull-left">
        <ul class="pagination">
            {!! $news->render() !!}
        </ul>
    </div>
</div>
@stop