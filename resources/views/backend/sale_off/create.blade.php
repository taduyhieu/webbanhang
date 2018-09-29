@extends('backend/layout/layout')
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1> {!!trans('fully.category')!!}
        <small> | {!!trans('fully.create')!!}</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{!! url(getLang(). '/admin/product-sale-off') !!}"><i class="fa fa-list"></i> {!!trans('fully.category')!!}</a></li>
        <li class="active">{!!trans('fully.create')!!}</li>
    </ol>
</section>
<br>
<br>
<div class="container">
    <div class="container">
        <div class="row">
            <div class="col-sm-5">
                {!! Form::open(array('action' => '\Fully\Http\Controllers\Admin\SaleOffController@store' )) !!}
                {!! csrf_field() !!}

                <!-- Agency -->
                <div class="col-sm-12 text-row {!! $errors->has('cat_parent_id') ? 'has-error' : '' !!}">
                    <label class="control-label" for="cat_parent_id">{!!trans('fully.agency')!!}</label>

                    <div class="controls" id="listAgency">
                        <select class="form-control" name="cat_parent_id">
                            <option value="" selected>{!!trans('fully.agency_choose')!!}</option>
                            @foreach($agencies as $value)
                            <option value="{!! $value->id !!}">{!! $value->name !!}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Category -->
                <div class="col-sm-12 text-row {!! $errors->has('cat_parent_id') ? 'has-error' : '' !!}">
                    <label class="control-label" for="cat_parent_id">{!!trans('fully.category')!!}</label>

                    <div class="controls" id="listCate">
                        <select class="form-control" name="cat_parent_id">
                            <option value="" selected>{!!trans('fully.category_choose')!!}</option>
                            @foreach($categories as $value)
                            <option value="{!! $value->id !!}">{!! $value->title !!}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Product -->
                <!-- <div class="col-sm-12 text-row {!! $errors->has('cat_parent_id') ? 'has-error' : '' !!}">
                    <label class="control-label" for="cat_parent_id">{!!trans('fully.product_name')!!}</label>

                    <div class="controls">
                        <select class="form-control" name="cat_parent_id">
                            <option value="" selected>{!!trans('fully.category_choose')!!}</option>
                            @foreach($products as $value)
                            <option value="{!! $value->id !!}">{!! $value->product_name !!}</option>
                            @endforeach
                        </select>
                    </div>
                </div> -->


                <!-- Code -->
                <!-- <div class="col-sm-12 text-row {!! $errors->has('code') ? 'has-error' : '' !!}">
                    <label class="control-label" for="name">{!!trans('fully.product_code')!!}</label>

                    <div class="controls">
                        {!! Form::text('code', null, array('class'=>'form-control', 'id' => 'code', 'placeholder'=>trans('fully.product_code'), 'value'=>Input::old('code'))) !!}
                        @if ($errors->first('code'))
                        <span class="help-block">{!! $errors->first('code') !!}</span>
                        @endif
                    </div>
                </div>
 -->
                

                <div class="col-sm-12">
                    <br>
                    <!-- Form actions -->
                    {!! Form::submit(trans('fully.save'), array('class' => 'btn btn-success')) !!}
                    <a href="{!! url('/'.getLang().'/admin/product') !!}" class="btn btn-default">&nbsp;{!!trans('fully.cancel')!!}</a>
                    {!! Form::close() !!}
                </div>
            </div>
            <div class="col-sm-6">
                <div class="row">
           
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Stt</th>
                                <th>{!!trans('fully.product_name')!!}</th>
                                <th>{!!trans('fully.product_code')!!}</th>
                                <th>{!!trans('fully.start_date')!!}</th>
                                <th>{!!trans('fully.end_date')!!}</th>
                                <th>{!!trans('fully.sale_of_percent')!!}</th>
                                <th>{!!trans('fully.root_price')!!}</th>
                                <th>Trạng thái</th>
                            </tr>
                        </thead>
                        <tbody id="displayProduct">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
</div>
<script type="text/javascript">
    $(document).ready(function(){
        $('#listAgency').on('change',function(){
            $('#listCate').on('change',function(){
                var idAgency = $("#listAgency option:selected").val();
                var idCate = $("#listCate option:selected").val();
                $.ajax({
                    type: "POST",
                    url: "{!! url(getLang() . '/admin/product-sale-off/" + idAgency + "/" + idCate + "/product/') !!}",
                    headers: {
                        'X-CSRF-Token': $('meta[name="_token"]').attr('content')
                    },
                    success: function (response) {
                        // console.log(response);
                        for (i = 0; i < response.length; i++) {
                            var obj=  response[i];
                            parsed = "<tr>";
                            $.each( obj, function( key, value ) {
                                if (key == "id") {
                                    parsed += "<td>" + (i + 1) + "</td>";
                                }
                                if (key == "product_name") {
                                    parsed += "<td>" + value + "</td>";
                                }
                                if (key == "code") {
                                    parsed += "<td>" + value + "</td>";
                                }
                            });
                            parsed += "</tr>";
                            $("#displayProduct").append(parsed); 
                        }                           
                    },
                    error: function () {
                        alert("error");
                    }
                })
            });
        });
        $('#listCate').on('change',function(){
            $('#listAgency').on('change',function(){
                var idAgency = $("#listAgency option:selected").val();
                var idCate = $("#listCate option:selected").val();
                $.ajax({
                    type: "POST",
                    url: "{!! url(getLang() . '/admin/product-sale-off/" + idAgency + "/" + idCate + "/product/') !!}",
                    headers: {
                        'X-CSRF-Token': $('meta[name="_token"]').attr('content')
                    },
                    success: function (response) {
                        for (i = 0; i < response.length; i++) {
                            var obj=  response[i];
                            parsed = "<tr>";
                            $.each( obj, function( key, value ) {
                                if (key == "id") {
                                    parsed += "<td>" + (i + 1) + "</td>";
                                }
                                if (key == "product_name") {
                                    parsed += "<td>" + value + "</td>";
                                }
                                if (key == "code") {
                                    parsed += "<td>" + value + "</td>";
                                }
                            });
                            parsed += "</tr>";
                            $("#displayProduct").append(parsed); 
                        }                           
                    },
                    error: function () {
                        alert("error");
                    }
                })
            });
        });
        

    });
</script>
@stop
