@extends('backend/layout/layout')
@section('content')
<script type="text/javascript">
    $(document).ready(function () {
        $('#notification').show().delay(4000).fadeOut(700);

        $('#select_all').on('click', function () {
            if (this.checked) {
                $('.checkbox').each(function () {
                    this.checked = true;
                });
            } else {
                $('.checkbox').each(function () {
                    this.checked = false;
                });
            }
        });

        $('.checkbox').on('click', function () {
            if ($('.checkbox:checked').length == $('.checkbox').length) {
                $('#select_all').prop('checked', true);
            } else {
                $('#select_all').prop('checked', false);
            }
        });

        // publish settings
        $(".publish").bind("click", function (e) {
            var id = $(this).attr('id');
            e.preventDefault();

            $.ajax({
                type: "POST",
                url: "{!! url(getLang() . '/admin/news-lens-re/" + id + "/toggle-publish/') !!}",
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
</script>

<section class="content-header">
    <h1>
        Quản lý bài viết ống kính BĐS
    </h1>
    <ol class="breadcrumb">
        <li><a href="{!! URL::route('admin.dashboard') !!}">Dashboard</a></li>
        <li class="active"> Quản lý bài viết ống kính BĐS</li>
    </ol>
</section>
<br>
<div class="container">
    <div class="row">
        @include('flash::message')
        <br>
        <div class="col-lg-6">
            <form action="{{ route('admin.news-lens-re.search') }}" method="get" class="form-inline pull-left">
                <div class="input-group">
                    <input class="form-control" type="text" id="title_new" name="title_new" placeholder="{{trans('fully.news_placeholder')}}" value="{{ $searchTitle }}">
                </div>
                <div class="form-group">
                    <span><input class="submit btn btn-default bg-btn-green" type="submit" value="Tìm kiếm"></span>
                </div>
            </form>
        </div>
    </div>
    <br>
    <div class="col-lg-12">
        @if($newsLensRE->count())
        <div class="row">
            {!! Form::open(array('action' => '\Fully\Http\Controllers\Admin\LensRealEstaleController@update', 'method' => 'PATCH')) !!}
            {!! csrf_field() !!}
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th><input type="checkbox" id="select_all"> Chọn tất cả</th>
                        <th>Tiêu đề</th>
                        <th>Thứ tự</th>
                        <th>Trạng thái hiển thị</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($newsLensRE as $news)
                    <tr>
                        <td><input type="checkbox" class="checkbox" name="update-news-id[]" value="{!! $news->id !!}"></td>
                        <td>{!! $news->news_title !!}</td>
                        <td><input class="form-control" type="text" name="order[{!! $news->id !!}]" value="{!! $news->order !!}"></td>
                        <td style="text-align: center">
                            <a href="" id="{!! $news->id !!}" class="publish">
                                <img id="publish-image-{!! $news->id !!}" src="{!!url('/')!!}/assets/images/{!! ($news->show_type) ? 'publish.png' : 'not_publish.png'  !!}">
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {!! Form::submit('Lưu ', array('class' => 'btn btn-success')) !!}
            {!! Form::close() !!}
        </div>
        @else
        <div class="alert alert-danger">{{trans('fully.not_found')}}</div>
        @endif 
    </div>
    <div class="pull-left">
        <ul class="pagination">
            {!! $newsLensRE->render() !!}
        </ul>
    </div>
</div>
@stop