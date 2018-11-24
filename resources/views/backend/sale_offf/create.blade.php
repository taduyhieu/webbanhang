@extends('backend/layout/layout')
@section('content')
{!! HTML::script('moment/js/moment.js') !!}
{!! HTML::style('/bootstrap_datetimepicker/bootstrap-datetimepicker.min.css') !!}
<!-- Content Header (Page header) -->
<script type="text/javascript">
    $(document).on("change", function () {
        $('#notification').show().delay(4000).fadeOut(700);

        $("input.checkbox").on("click", function() {
            console.log("hieu");
            if ($("input.checkbox:checked").length == $("input.checkbox").length) {
                $("#select_all").prop("checked", true);
            } else {
                $("#select_all").prop("checked", false);
            }
        });
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

    });
    var accessories = [];
    function deleteTag (id) {
        $("#" + id).remove();
        for (i = 0; i < accessories.length; i++) {
            if (accessories[i][0] == id) {
                accessories.splice(i, 1);
            }
        }
    }
    
    function checkAccessory(id){
        var x = Boolean(true);
        for (i = 0; i < accessories.length; i++) {
            if (accessories[i][0] == id) {
                x = Boolean(false);
                return x;
            }
        }
        return x;
    }
    $(document).ready(function(){
        $("#with_product").change(function(){
            var accessory_id = $(this).children("option:selected").val();
            var accessory_name = $(this).children("option:selected").text();

            if (accessory_id != 0 && checkAccessory(accessory_id)) {
                $("#set_with_product").append("<span class='badge badge-primary' style='background-color: #28a745;' id ='" + accessory_id + "'>" + accessory_name + "<a onclick='deleteTag(" + accessory_id + ");'><span class='glyphicon glyphicon-remove text-danger'></span></a></span>");
                var accessory = [accessory_id, accessory_name];
                accessories.push(accessory);
            }
        });


    });



</script>
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

                <!-- Name -->
                <div class="col-sm-12 text-row {!! $errors->has('cat_parent_id') ? 'has-error' : '' !!}">
                    <label class="control-label" for="name">{!!trans('fully.sale_name')!!}</label>
                    <input type="text" class="form-control" name="name" placeholder="Nhập tên khuyến mãi">
                </div>
                <!-- Start_date -->
                <div class="col-sm-12 {!! $errors->has('start_date') ? 'has-error' : '' !!}">
                    <label class="control-label" for="title">Ngày bắt đầu khuyến mãi</label>  
                    <div class="controls"> {!! Form::text('start_date', null, array('class'=>'input-group date form_datetime col-sm-12','placeholder'=>'Nhập ngày bắt đầu khuyến mãi', 'data-date-format'=>'yyyy-mm-dd hh:ii:00', 'data-link-field'=>'dtp_input1', 'id' => 'start_date','value'=>Input::old('start_date'))) !!}
                        @if ($errors->first('start_date'))
                        <span class="help-block">{!! $errors->first('start_date') !!}</span> 
                        @endif 
                    </div>
                    <br>
                </div>

                <!-- End_date -->
                <div class="col-sm-12 {!! $errors->has('start_date') ? 'has-error' : '' !!}">
                    <label class="control-label" for="title">Ngày kết thúc khuyến mãi</label>  
                    <div class="controls"> {!! Form::text('start_date', null, array('class'=>'input-group date form_datetime col-sm-12','placeholder'=>'Nhập ngày kết thúc khuyến mãi', 'data-date-format'=>'yyyy-mm-dd hh:ii:00', 'data-link-field'=>'dtp_input1', 'id' => 'start_date','value'=>Input::old('start_date'))) !!}
                        @if ($errors->first('start_date'))
                        <span class="help-block">{!! $errors->first('start_date') !!}</span> 
                        @endif 
                    </div>
                    <br>
                </div>

                <!-- Percent -->
                <div class="col-sm-12 text-row {!! $errors->has('percent') ? 'has-error' : '' !!}">
                    <label class="control-label" for="percant">{!!trans('fully.sale_percent')!!}</label>
                    <input type="text" class="form-control" name="percent" placeholder="Nhập phần trăm khuyễn mãi">
                </div>

                <!-- with_product -->
                <div class="col-sm-12 text-row {!! $errors->has('with_product') ? 'has-error' : '' !!}" id="set_with_product">
                    <label class="control-label" for="cat_parent_id">{!!trans('fully.with_product')!!}</label>

                    <div class="controls">
                        <select class="form-control" name="with_product" id="with_product">
                            <option value="0" selected>Chọn sản phẩm tặng kèm</option>
                            @foreach ($accessories as $accessory)
                            <option value="{!! $accessory->id !!}">{!! $accessory->product_name !!}</option>
                            @endforeach
                        </select>

                    </div>
                    <br/>
                </div>

                <div class="col-sm-12">
                    <br>
                    <!-- Form actions -->
                    {!! Form::submit(trans('fully.save'), array('class' => 'btn btn-success')) !!}
                    <a href="{!! url('/'.getLang().'/admin/sale-off') !!}" class="btn btn-default">&nbsp;{!!trans('fully.cancel')!!}</a>
                    {!! Form::close() !!}
                </div>
            </div>
            <div class="col-sm-6">
                <div class="row">
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
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th><input type="checkbox" id="select_all"></th>
                                <th>Stt</th>
                                <th>{!!trans('fully.product_name')!!}</th>
                                <th>{!!trans('fully.product_code')!!}</th>
                                <th>{!!trans('fully.root_price')!!}</th>
                                <!-- <th>{!!trans('fully.start_date')!!}</th>
                                <th>{!!trans('fully.end_date')!!}</th>
                                <th>{!!trans('fully.sale_of_percent')!!}</th> -->
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
            $("#select_all").prop("checked", false);
            var idAgency = $("#listAgency option:selected").val();
            var idCate = $("#listCate option:selected").val();
            $( "#displayProduct>tr" ).remove();
            if (idAgency != "" && idCate != "") {
                $.ajax({
                    type: "POST",
                    url: "{!! url(getLang() . '/admin/sale-off/" + idAgency + "/" + idCate + "/product/') !!}",
                    headers: {
                        'X-CSRF-Token': $('meta[name="_token"]').attr('content')
                    },
                    success: function (response) {
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
                                parsed = "<tr><td><input type=\"checkbox\" class=\"checkbox\" name=\"checkbox\"></td>";
                            }
                            else{
                                parsed = "<tr id='pink'><td><input type=\"checkbox\" class=\"checkbox\" name=\"checkbox\"></td>"
                            }
                            
                            parsed += "<td>" + (i + 1) + "</td>";
                            parsed += "<td>" + product_name + "</td>";
                            parsed += "<td>" + code + "</td>";
                            parsed += "<td>" + price + "</td>";
                            // if (start_date === null) {
                            //     parsed += "<td >" + "<input type=\"text\" name=\"firstname\" maxlength=\"18\" size=\"8\">" + "</td>";
                            //     parsed += "<td >" + "<input type=\"text\" name=\"firstname\" maxlength=\"18\" size=\"8\">" + "</td>";
                            //     parsed += "<td >" + "<input type=\"text\" name=\"firstname\" maxlength=\"18\" size=\"8\">" + "</td>";
                            //     parsed += "<td >" + "" + "</td>";
                            // }
                            // else{
                            //     parsed += "<td >" + "<input type=\"text\" name=\"firstname\" maxlength=\"18\" size=\"8\">" + "</td>";
                            //     parsed += "<td >" + "<input type=\"text\" name=\"firstname\" maxlength=\"18\" size=\"8\">" + "</td>";
                            //     parsed += "<td >" + "<input type=\"text\" name=\"firstname\" maxlength=\"18\" size=\"8\">" + "</td>";
                                parsed += "<td >" + "1" + "</td>";
                            // }
                            
                            

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
});
</script>
{!! HTML::script('/bootstrap_datetimepicker/bootstrap-datetimepicker.js') !!}
{!! HTML::script('/bootstrap_datetimepicker/bootstrap-datetimepicker.fr.js') !!}
<script type="text/javascript">
    $('.form_datetime').datetimepicker({
        //language:  'fr',
        weekStart: 1,
        todayBtn:  1,
        autoclose: 1,
        todayHighlight: 1,
        startView: 2,
        forceParse: 0,
        showMeridian: 1
    });
    $('.form_date').datetimepicker({
        language:  'fr',
        weekStart: 1,
        todayBtn:  1,
        autoclose: 1,
        todayHighlight: 1,
        startView: 2,
        minView: 2,
        forceParse: 0
    });
    $('.form_time').datetimepicker({
        language:  'fr',
        weekStart: 1,
        todayBtn:  1,
        autoclose: 1,
        todayHighlight: 1,
        startView: 1,
        minView: 0,
        maxView: 1,
        forceParse: 0
    });
</script>
@stop
