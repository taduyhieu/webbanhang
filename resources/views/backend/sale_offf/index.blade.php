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
                url: "{!! url(getLang() . '/admin/product-sale-off/" + id + "/toggle-publish/') !!}",
                headers: {
                    'X-CSRF-Token': $('meta[name="_token"]').attr('content')
                },
                success: function (response) {
                    console.log(response);
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
        <small> | {!!trans('fully.menu_product')!!}</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{!! url(getLang(). '/admin') !!}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">{!!trans('fully.product')!!}</li>
    </ol>
</section>
<br>
<div class="container">
    <div class="row">
        @include('flash::message')
        <br>
        <div class="col-sm-6">
            <div class="btn-toolbar"><a href="{!! langRoute('admin.sale-off.create') !!}" class="btn btn-primary">
                    <span class="glyphicon glyphicon-plus"></span>&nbsp;{!!trans('fully.create')!!}</a></div>
        </div>
        <div class="col-sm-6">
            <form action="{{ route('admin.categories.search') }}" method="get" class="form-inline pull-right">
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
            @if($saleofffs->count())
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>{!!trans('fully.sale_name')!!}</th>
                        <th>{!!trans('fully.start_date')!!}</th>
                        <th>{!!trans('fully.end_date')!!}</th>
                        <th>Trạng thái</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach( $saleofffs as $key => $value)
                    <tr>
                        <td>{!! ++$key !!}</td>
                        <td> {!! link_to_route( getLang() . '.admin.sale-off.show', $value->name,
                            $value->id, array( 'class' => 'btn btn-link btn-xs' )) !!}
                        <td>{!! $value->start_date !!}</td>
                        <td>{!! $value->end_date !!}</td>
                        <td>
                            <a href="" id="{!! $value->id !!}" class="publish">
                                <img id="publish-image-{!! $value->id !!}" src="{!!url('/')!!}/assets/images/{!! ($value->status) ? 'publish.png' : 'not_publish.png'  !!}"/>
                            </a>
                        </td>
                        <td>
                            <div class="btn-group">
                                <a class="btn btn-danger dropdown-toggle" data-toggle="dropdown" href="#">
                                    {!!trans('fully.action')!!} <span class="caret"></span> </a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="{!! langRoute('admin.sale-off.show', array($value->id)) !!}">
                                            <span class="glyphicon glyphicon-eye-open"></span>&nbsp;{!!trans('fully.show')!!} </a>
                                    </li>
                                    <li>
                                        <a href="{!! langRoute('admin.product-sale-off.edit', array($value->id)) !!}">
                                            <span class="glyphicon glyphicon-edit"></span>&nbsp;{!!trans('fully.edit')!!}
                                        </a>
                                    </li>
                                    <li class="divider"></li>
                                    <li>
                                        <a href="{!! URL::route('admin.product-sale-off.delete', array($value->id)) !!}">
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
            {!! $saleofffs->render() !!}
        </ul>
    </div>
</div>
@stop