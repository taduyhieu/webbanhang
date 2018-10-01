@extends('backend/layout/layout')
@section('content')
{!! HTML::script('moment/js/moment.js') !!}
<!-- Content Header (Page header) -->
<style>
#pink{
    background : pink;
}
</style>
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
                    <a href="{!! url('/'.getLang().'/admin/product-sale-off') !!}" class="btn btn-default">&nbsp;{!!trans('fully.cancel')!!}</a>
                    {!! Form::close() !!}
                </div>
            </div>
            <div class="col-sm-6">
                <div class="row">
           
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Stt</th>
                                <th>{!!trans('fully.product_name')!!}</th>
                                <th>{!!trans('fully.product_code')!!}</th>
                                <th>{!!trans('fully.root_price')!!}</th>
                                <th>{!!trans('fully.start_date')!!}</th>
                                <th>{!!trans('fully.end_date')!!}</th>
                                <th>{!!trans('fully.sale_of_percent')!!}</th>
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
        
        $("#listAgency, #listCate").on('change',function(){
            var idAgency = $("#listAgency option:selected").val();
            var idCate = $("#listCate option:selected").val();
            $( "#displayProduct>tr" ).remove();
            if (idAgency != "" && idCate != "") {
                $.ajax({
                    type: "POST",
                    url: "{!! url(getLang() . '/admin/product-sale-off/" + idAgency + "/" + idCate + "/product/') !!}",
                    headers: {
                        'X-CSRF-Token': $('meta[name="_token"]').attr('content')
                    },
                    success: function (response) {
                        console.log(response);
                        for (i = 0; i < response.length; i++) {
                            var obj=  response[i];
                            
                            for (var property in obj) {
                                if (property == "product_name") {
                                    product_name = obj[property];
                                }

                                if (property == "code") {
                                    code = obj[property];
                                }

                                if (property == "percent_sale_off") {
                                    percent_sale_off = obj[property];
                                }
                                
                                if (property == "start_date") {
                                    start_date = obj[property];
                                }

                                if (property == "end_date") {
                                    end_date = obj[property];
                                }

                                if (property == "price") {
                                    price = obj[property];
                                }

                                if (property == "status") {
                                    status = obj[property];
                                }
                            };
                            if (start_date === null) {
                                parsed = "<tr><td><input type='checkbox'></td>";
                            }
                            else{
                                parsed = "<tr id='pink'><td><input type='checkbox'></td>"
                            }
                            
                            parsed += "<td>" + (i + 1) + "</td>";
                            parsed += "<td>" + product_name + "</td>";
                            parsed += "<td>" + code + "</td>";
                            parsed += "<td>" + price + "</td>";
                            if (start_date === null) {
                                parsed += "<td >" + "<p id='checkkeyup'>Chưa đặt</p>" + "</td>";
                                parsed += "<td>" + "<p id='checkkeyup'>Chưa đặt</p>" + "</td>";
                                parsed += "<td>" + "<p id='checkkeyup'>Chưa đặt</p>" + "</td>";
                                parsed += "<td>" + "<p id='checkkeyup'>Chưa đặt</p>" + "</td>";
                            }
                            else{
                                parsed += "<td>" + moment(start_date).format('DD/MM/YYYY') + "</td>";
                                parsed += "<td>" + moment(end_date).format('DD/MM/YYYY') + "</td>";
                                parsed += "<td>" + percent_sale_off + "</td>";
                                parsed += "<td>" + status + "</td>";
                            }
                            
                            

                            parsed += "</tr>";
                            $("#displayProduct").append(parsed); 
                        }

                    },
                    error: function () {
                        alert("error");
                    }
                })
            }
        });
        
        $("#displayProduct").ready(function(){
            $("#checkkeyup").on("click",function(e){
                alert("hieu");
            });
        
        });
        

        
    });
</script>

<script>
    $(document).ready(function(){
        
    });
</script>
@stop
