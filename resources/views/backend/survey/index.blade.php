@extends('backend/layout/layout')
@section('content')

<script type="text/javascript">

    $(document).ready(function () {

        $('#notification').show().delay(4000).fadeOut(700);
        // active settings
        $(".publish").bind("click", function (e) {
            var id = $(this).attr('id');
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: "{!! url(getLang() . '/admin/survey/" + id + "/active/') !!}",
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
        Khảo sát
    </h1>
    <ol class="breadcrumb">
        <li><a href="{!! URL::route('admin.dashboard') !!}">Dashboard</a></li>
        <li class="active"> Khảo sát</li>
    </ol>
</section>
<br>
<div class="container">
    <div class="row">
        @include('flash::message')
        <br>
        <div class="col-sm-6">
            <div class="btn-toolbar"><a href="{!! langRoute('admin.survey.create') !!}" class="btn btn-primary">
                    <span class="glyphicon glyphicon-plus"></span>&nbsp;Thêm mới </a></div>
        </div>
        <div class="col-sm-6">
            <form action="{{ route('admin.survey.search') }}" method="get" class="form-inline pull-right">
                <div class="input-group">
                    <input class="form-control" type="text" id="title_survey" name="title_survey" placeholder="Nhập tên" value="{{ $searchTitle }}">
                </div>
                <div class="form-group">
                    <span><input class="submit btn btn-default bg-btn-green" type="submit" value="Tìm kiếm"></span>
                </div>
            </form>
        </div>
    </div>
    <br>
    <div class="col-lg-12">
        @if($surveys->count())
        <div class="row">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Stt</th>
                        <th>Tên khảo sát</th>
                        <th>Trạng thái</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($surveys as $key => $survey )
                    <tr>
                        <td>{!! ++$key !!}</td>
                        <td> {!! link_to_route(getLang(). '.admin.survey.show', $survey->name, $survey->id, array( 'class'=> 'btn btn-link btn-xs' )) !!}
                        </td>
                        <td>
                            <a style="cursor: pointer;" id="{{ $survey->id }}" class="publish">
                                <img id="publish-image-{{ $survey->id }}" src="{!!url('/')!!}/assets/images/{!! ($survey->active) ? 'publish.png' : 'not_publish.png'  !!}">
                            </a>
                        </td>
                        <td>
                            <div class="btn-group">
                                <a class="btn btn-danger dropdown-toggle" data-toggle="dropdown" href="#">
                                    {{trans('fully.action')}} <span class="caret"></span> </a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="{!! langRoute('admin.survey.show', array($survey->id)) !!}">
                                            <span class="glyphicon glyphicon-eye-open"></span>&nbsp;Chi tiết
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{!! langRoute('admin.survey.edit', array($survey->id)) !!}">
                                            <span class="glyphicon glyphicon-edit"></span>&nbsp;Sửa
                                        </a>
                                    </li>
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
            {!! $surveys->render() !!}
        </ul>
    </div>
</div>
@stop