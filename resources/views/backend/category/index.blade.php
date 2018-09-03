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
                url: "{!! url(getLang() . '/admin/category/" + id + "/toggle-publish/') !!}",
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
            })
        });
    });
</script>
<section class="content-header">
    <h1> {!!trans('fully.category')!!}
        <small> | {!!trans('fully.menu_cat')!!}</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{!! url(getLang(). '/admin') !!}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">{!!trans('fully.category')!!}</li>
    </ol>
</section>
<br>
<div class="container">
    <div class="row">
        @include('flash::message')
        <br>
        <div class="col-sm-6">
            <div class="btn-toolbar"><a href="{!! langRoute('admin.category.create') !!}" class="btn btn-primary">
                    <span class="glyphicon glyphicon-plus"></span>&nbsp;{!!trans('fully.create')!!}</a></div>
        </div>
        <div class="col-sm-6">
            <form action="{{ route('admin.category.search') }}" method="get" class="form-inline pull-right">
                <div class="input-group">
                    <input class="form-control" type="text" id="title_category" name="title_category" placeholder="{!!trans('fully.input_name')!!}" value="{{ $searchTitle }}">
                </div>
                <div class="form-group">
                    <span><input class="submit btn btn-default bg-btn-green" type="submit" value="{!!trans('fully.input_search')!!}"></span>
                </div>
            </form>
        </div>
    </div>
    <br>
    <div class="col-lg-12">
        <div class="row">
            @if($categories->count())
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Stt</th>
                        <th>{!!trans('fully.car_info_name')!!}</th>
                        <th>{!!trans('fully.car_info_in')!!}</th>
                        <th>Thứ tự</th>
                        <th>Trạng thái</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach( $categories as $key => $category )
                    <tr>
                        <td>{!! ++$key !!}</td>
                        <td> {!! link_to_route( getLang() . '.admin.category.show', $category->name,
                            $category->id, array( 'class' => 'btn btn-link btn-xs' )) !!}
                        <td>
                            @if($category->cat_parent_id !== 0)
                            {!! $category->catParentName !!}
                            @endif
                        </td>
                        <td>{!! $category->order !!}</td>
                        <td>
                            <a href="#" id="{!! $category->id !!}" class="publish">
                                <img id="publish-image-{!! $category->id !!}" src="{!!url('/')!!}/assets/images/{!! ($category->status) ? 'publish.png' : 'not_publish.png'  !!}"/>
                            </a>
                        </td>
                        <td>
                            <div class="btn-group">
                                <a class="btn btn-danger dropdown-toggle" data-toggle="dropdown" href="#">
                                    {!!trans('fully.action')!!} <span class="caret"></span> </a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="{!! langRoute('admin.category.show', array($category->id)) !!}">
                                            <span class="glyphicon glyphicon-eye-open"></span>&nbsp;{!!trans('fully.show')!!} </a>
                                    </li>
                                    <li>
                                        <a href="{!! langRoute('admin.category.edit', array($category->id)) !!}">
                                            <span class="glyphicon glyphicon-edit"></span>&nbsp;{!!trans('fully.edit')!!}
                                        </a>
                                    </li>
                                    <li class="divider"></li>
                                    <li>
                                        <a href="{!! URL::route('admin.category.delete', array($category->id)) !!}">
                                            <span class="glyphicon glyphicon-remove-circle"></span>&nbsp;{!!trans('fully.delete')!!} </a>
                                    </li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <div class="alert alert-danger">{!!trans('fully.not_found')!!}</div>
            @endif
        </div>
    </div>
    <div class="pull-left">
        <ul class="pagination">
            {!! $categories->render() !!}
        </ul>
    </div>
</div>
@stop