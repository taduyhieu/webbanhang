@extends('backend/layout/layout')
@section('content')
{!! HTML::script('ckeditor/ckeditor.js') !!}
{!! HTML::style('backend/css/selectize.default.css') !!}
{!! HTML::style('assets/bootstrap/css/bootstrap-tagsinput.css') !!}
{!! HTML::style('jasny-bootstrap/css/jasny-bootstrap.min.css') !!}
{!! HTML::style('dropzone/css/basic.css') !!}
{!! HTML::style('dropzone/css/dropzone.css') !!}
{!! HTML::script('dropzone/dropzone.js') !!}
{!! HTML::script('assets/bootstrap/js/bootstrap-tagsinput.js') !!}
{!! HTML::script('assets/js/jquery.slug.js') !!}
{!! HTML::script('jasny-bootstrap/js/jasny-bootstrap.min.js') !!}
{!! HTML::script('backend/js/selectize.js') !!}

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<style>
    .selectize-input.items.not-full.has-options.has-items div{
        background-color:#f00 !important;
    }
    .selectize-dropdown-content>div>span {
        color: black;
        font-size: 15px;
    }
</style>

<script type="text/javascript">

    var linkDistrict = "{!! url(getLang() . '/admin/realestale-news/district/listDistrict') !!}";
    $(function () {
        $('#city_id').change(function () {
            let district_id = $('#district_id');
            if (!$(this).val()) {
                district_id.attr('disabled', 'disabled');
            }
            let city_id = {'city_id': $(this).val()};
            $.get(linkDistrict, city_id, function (jsonData) {
                district_id.empty();
                district_id.append("<option value='' selected>Chọn quận/ huyện</option>");
                if (!jsonData) {
                    return;
                }
                $.each(jsonData, function (key, value) {
                    district_id.append("<option value='" + value.id + "'>" + value.name + "</option>");
                });
                district_id.removeAttr('disabled');
            });
        });
    });

    jQuery(document).ready(function () {
        $(function () {
            $("#district_id").attr('disabled', 'disabled');
        });

        $('#search-tag-news').selectize({
            plugins: ['remove_button'],
            persist: false,
            maxItems: null,
            valueField: 'id',
            labelField: 'name',
            searchField: ['name'],
            options: [],
            render: {
                item: function (item, escape) {
                    return '<div>' +
                            (item.name ? '<span class="name">' + escape(item.name) + '</span>' : '') +
                            '</div>';
                },
                option: function (item, escape) {
                    var label = item.name || item.id;
                    return '<div>' +
                            '<span class="label">' + escape(label) + '</span>' +
                            '</div>';
                }
            },
            load: function (query, callback) {
                if (!query.length)
                    return callback();
                $.ajax({
                    url: '{!!url(getLang() . "/admin/realestale-news/tag/listTagRE?term=") !!}' + encodeURIComponent(query),
                    type: 'GET',
                    error: function () {
                        callback();
                    },
                    success: function (res) {
                        callback(res);
                    }
                });
            }
        });

        $('#price_all').keyup(function () {
            let price_text = $('#price_all').val();
            let price_all = parseFloat(price_text);
            let pricelength = price_text.length;
            if (price_all == 0) {
                return;
            }
            if (pricelength > 0 && pricelength < 4) {
                $('#price_all_text').html(price_all + '&nbsp' + 'Triệu');
            } else if (pricelength > 3) {
                let str1 = price_text.substring(0, pricelength - 3);
                let str2 = price_text.substring(pricelength - 3, pricelength);
                $('#price_all_text').html(str1 + '&nbsp' + 'Tỉ' + '&nbsp' + str2 + '&nbsp' + 'Triệu');
            }
        });

        $('#price_m2').keyup(function () {
            let price_m2_text = $('#price_m2').val();
            let price_m2 = parseFloat(price_m2_text);
            let pricelength = price_m2_text.length;
            if (price_m2 == 0) {
                return;
            }
            if (pricelength > 0 && pricelength < 4) {
                $('#price_m2_text').html(price_m2 + '&nbsp' + 'Triệu');
            } else if (pricelength > 3) {
                let str1 = price_m2_text.substring(0, pricelength - 3);
                let str2 = price_m2_text.substring(pricelength - 3, pricelength);
                $('#price_m2_text').html(str1 + '&nbsp' + 'Tỉ' + '&nbsp' + str2 + '&nbsp' + 'Triệu');
            }
        });
        
        // Add full address
        $('#btn-news-realestale-address').click(function () {
            let city = $('#city_id :selected').text();
            let district = $('#district_id :selected').text();
            let address = $('#realestale-address').val();
            if(!$('#realestale-address').val()){
                alert('Chưa nhập số nhà, tên đường, phường (xã, thôn, xóm)');
                return;
            }
            if(!$('#city_id').val()){
                alert('Chưa chọn tỉnh/ thành phố');
                return;
            }
            if(!$('#district_id').val()){
                alert('Chưa chọn quận/ huyện');
                return;
            }
            let fullAddress = address + ", " + district + ", " + city;
            $('#place').val(fullAddress);
            $('#address-modal').modal('hide');
        });

    });

</script>

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1> Bài viết bất động sản <small> | {{trans('fully.news_new')}}</small> </h1>
    <ol class="breadcrumb">
        <li><a href="{!! url(getLang() . '/admin/news') !!}"><i class="fa fa-bookmark"></i> </a> Bài viết bất động sản</li>
        <li class="active">{{trans('fully.news_new')}}</li>
    </ol>
</section>
<br>
<br>
<div class="container">

    <div class="row">
        {!! Form::open(array('route' => array( getLang() . '.admin.realestale-news.store') , 'files'=>true, 'id'=>'news-realestale-form')) !!}
        {!! csrf_field() !!}
        <div class="col-md-6">
            <!-- Title -->
            <div class="control-group {!! $errors->has('news_title') ? 'has-error' : '' !!}">
                <label class="control-label" for="news_title">{{trans('fully.news_title')}} (*)</label>

                <div class="controls"> {!! Form::text('news_title', null, array('class'=>'form-control', 'id' => 'news_title', 'placeholder'=>trans('fully.news_title'), 'value'=>Input::old('news_title'))) !!}
                    @if ($errors->first('news_title')) 
                    <span class="help-block">{!! $errors->first('news_title') !!}</span> 
                    @endif
                </div>
            </div>
            <br>
            <!-- Select Category Real Estale-->
            <div class="control-group {!! $errors->has('cat_realestale_id') ? 'has-error' : '' !!}">
                <label class="control-label" for="cat_realestale_id">Loại tin (*)</label>
                <div class="controls">
                    <select class="form-control" name="cat_realestale_id">
                        <option value="" selected disabled="disabled">Chọn loại tin</option>
                        @foreach($catesRealEstale as $cate)
                        <option value="{!! $cate->id !!}" style="font-weight: bold">{!! $cate->name !!}</option>
                        @endforeach
                    </select>
                    @if ($errors->first('cat_realestale_id')) 
                    <span class="help-block">{!! $errors->first('cat_realestale_id') !!}</span>
                    @endif
                </div>
            </div>
            <br>

            <div>
                <label class="control-label" for="price_all">Chú ý: 1 = 1 triệu VND</label>
            </div>
            <div class="row">
                <!-- Price -->
                <div class="control-group col-md-6 {!! $errors->has('price_all') ? 'has-error' : '' !!}">
                    <label class="control-label" for="price_all">Giá (*)</label>
                    <label class="control-label" id="price_all_text" style="color: red; padding-left: 10px"></label>
                    <div class="controls"> {!! Form::text('price_all', null, array('class'=>'form-control', 'id' => 'price_all', 'placeholder'=>'', 'maxlength'=>'6', 'value'=>Input::old('price_all'), 'onkeypress'=>'return AllowNumbersOnly(event)')) !!}
                        @if ($errors->first('price_all'))
                        <span class="help-block">{!! $errors->first('price_all') !!}</span>
                        @endif
                    </div>
                </div>

                <!-- Price m2 -->
                <div class="control-group col-md-6 {!! $errors->has('price_m2') ? 'has-error' : '' !!}">
                    <label class="control-label" for="price_m2">Giá/m2</label>
                    <label class="control-label" id="price_m2_text" style="color: red; padding-left: 10px"></label>
                    <div class="controls"> {!! Form::text('price_m2', null, array('class'=>'form-control', 'id' => 'price_m2', 'placeholder'=>'', 'maxlength'=>'5', 'value'=>Input::old('price_m2'), 'onkeypress'=>'return AllowNumbersOnly(event)')) !!}
                        @if ($errors->first('price_m2'))
                        <span class="help-block">{!! $errors->first('price_m2') !!}</span>
                        @endif
                    </div>
                </div>
            </div>
            <br>

            <!-- Place -->
            <div class="control-group {!! $errors->has('place') ? 'has-error' : '' !!}">
                <label class="control-label" for="place">Địa chỉ (*)</label>

                <div class="controls"> {!! Form::text('place', null, array('class'=>'form-control', 'id' => 'place', 'placeholder'=>'Nhập địa chỉ', 'value'=>Input::old('place'), 'data-toggle'=>'modal', 'data-target'=>'#address-modal', 'readonly' )) !!}
                    @if ($errors->first('place'))
                    <span class="help-block">{!! $errors->first('place') !!}</span>
                    @endif
                </div>
            </div>
            <br>

            <!-- Modal -->
            <div id="address-modal" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Nhập địa chỉ</h4>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="control-group col-md-12 {!! $errors->has('address') ? 'has-error' : '' !!}">
                                    <label class="control-label" for="address">Số nhà, tên đường, phường (xã, thôn, xóm)</label>
                                    <div class="controls-group"> {!! Form::text('address', null, array('class'=>'form-control', 'id' => 'realestale-address', 'placeholder'=>'Số nhà, tên đường, phường (xã, thôn, xóm)', 'value'=>Input::old('address'),  )) !!}
                                        @if ($errors->first('address'))
                                        <span class="help-block">{!! $errors->first('address') !!}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <!-- City -->
                                <div class="control-group col-md-6 {!! $errors->has('city_id') ? 'has-error' : '' !!}">
                                    <label class="control-label" for="city_id">Tỉnh/ thành phố (*)</label>

                                    <div class="controls">
                                        <select class="form-control" name="city_id" id="city_id">
                                            <option value="" selected>Chọn tỉnh/ thành phố</option>
                                            @foreach($listCity as $city)
                                            <option value="{!! $city->id !!}">{!! $city->name !!}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->first('city_id'))
                                        <span class="help-block">{!! $errors->first('city_id') !!}</span>
                                        @endif
                                    </div>
                                </div>

                                <!-- District -->
                                <div class="control-group col-md-6 {!! $errors->has('district_id') ? 'has-error' : '' !!}">
                                    <label class="control-label" for="district_id">Quận/ huyện (*)</label>
                                    <div class="controls">
                                        <select class="form-control" name="district_id" id="district_id">
                                            <option value="" selected>Chọn quận/ huyện</option>
                                        </select>
                                        @if ($errors->first('district_id'))
                                        <span class="help-block">{!! $errors->first('district_id') !!}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>                           
                        </div>
                        <div class="modal-footer">
                            <button id="btn-news-realestale-address" class="btn btn-success" type="button">OK</button>
                        </div>
                    </div>
                </div>
            </div>
            <br>

            <div class="row">
                <!-- Total area -->
                <div class="control-group col-md-6 {!! $errors->has('total_area') ? 'has-error' : '' !!}">
                    <label class="control-label" for="total_area">Diện tích (*)</label>

                    <div class="controls"> {!! Form::text('total_area', null, array('class'=>'form-control', 'id' => 'total_area', 'placeholder'=>'m2', 'value'=>Input::old('total_area'), 'onkeypress'=>'return AllowNumbersOnly(event)')) !!}
                        @if ($errors->first('total_area'))
                        <span class="help-block">{!! $errors->first('total_area') !!}</span>
                        @endif
                    </div>
                </div>

                <!-- Number floor -->
                <div class="control-group col-md-6 {!! $errors->has('number_floor') ? 'has-error' : '' !!}">
                    <label class="control-label" for="number_floor">Số tầng</label>

                    <div class="controls"> {!! Form::text('number_floor', null, array('class'=>'form-control', 'id' => 'number_floor', 'placeholder'=>'0', 'value'=>Input::old('number_floor'), 'onkeypress'=>'return AllowNumbersOnly(event)')) !!}
                        @if ($errors->first('number_floor'))
                        <span class="help-block">{!! $errors->first('number_floor') !!}</span>
                        @endif
                    </div>
                </div>
            </div>
            <br>

            <div class="row">
                <!-- Number bedroom -->
                <div class="control-group col-md-6 {!! $errors->has('number_bedroom') ? 'has-error' : '' !!}">
                    <label class="control-label" for="number_bedroom">Số phòng ngủ</label>

                    <div class="controls"> {!! Form::text('number_bedroom', null, array('class'=>'form-control', 'id' => 'number_bedroom', 'placeholder'=>'0', 'value'=>Input::old('number_bedroom'), 'onkeypress'=>'return AllowNumbersOnly(event)')) !!}
                        @if ($errors->first('number_bedroom'))
                        <span class="help-block">{!! $errors->first('number_bedroom') !!}</span>
                        @endif
                    </div>
                </div>

                <!-- Number bathroom -->
                <div class="control-group col-md-6 {!! $errors->has('number_bathroom') ? 'has-error' : '' !!}">
                    <label class="control-label" for="number_bathroom">Số phòng tắm</label>

                    <div class="controls"> {!! Form::text('number_bathroom', null, array('class'=>'form-control', 'id' => 'number_bathroom', 'placeholder'=>'0', 'value'=>Input::old('number_bathroom'), 'onkeypress'=>'return AllowNumbersOnly(event)')) !!}
                        @if ($errors->first('number_bathroom'))
                        <span class="help-block">{!! $errors->first('number_bathroom') !!}</span>
                        @endif
                    </div>
                </div>
            </div>
            <br>

            <div class="row">
                <!-- Dining room -->
                <div class="control-group col-md-6 {!! $errors->has('dining_room') ? 'has-error' : '' !!}">
                    <label class="control-label" for="dining_room">Phòng ăn</label>

                    <div class="controls"> {!! Form::text('dining_room', null, array('class'=>'form-control', 'id' => 'dining_room', 'placeholder'=>'0', 'value'=>Input::old('dining_room'), 'onkeypress'=>'return AllowNumbersOnly(event)')) !!}
                        @if ($errors->first('dining_room'))
                        <span class="help-block">{!! $errors->first('dining_room') !!}</span>
                        @endif
                    </div>
                </div>

                <!-- Kitchen -->
                <div class="control-group col-md-6 {!! $errors->has('kitchen') ? 'has-error' : '' !!}">
                    <label class="control-label" for="kitchen">Nhà bếp</label>

                    <div class="controls"> {!! Form::text('kitchen', null, array('class'=>'form-control', 'id' => 'kitchen', 'placeholder'=>'0', 'value'=>Input::old('kitchen'), 'onkeypress'=>'return AllowNumbersOnly(event)')) !!}
                        @if ($errors->first('kitchen'))
                        <span class="help-block">{!! $errors->first('kitchen') !!}</span>
                        @endif
                    </div>
                </div>
            </div>
            <br>

            <!-- Content -->
            <div class="control-group {!! $errors->has('news_content') ? 'has-error' : '' !!}">
                <label class="control-label" for="news_content">Nội dung (*)</label>

                <div class="controls"> {!! Form::textarea('news_content', null, array('class'=>'form-control', 'id' => 'news_content', 'placeholder'=>trans('fully.news_content'), 'value'=>Input::old('news_content'))) !!}
                    @if ($errors->first('news_content'))
                    <span class="help-block">{!! $errors->first('news_content') !!}</span>
                    @endif
                </div>
            </div>
            <br>
        </div>
        <div class="col-md-6">
            <div class="row">
                <!-- Length -->
                <div class="control-group col-md-6 {!! $errors->has('length') ? 'has-error' : '' !!}">
                    <label class="control-label" for="length">Chiều dài</label>

                    <div class="controls"> {!! Form::text('length', null, array('class'=>'form-control', 'id' => 'length', 'placeholder'=>'m', 'value'=>Input::old('length'), 'onkeypress'=>'return AllowNumbersOnly(event)' )) !!}
                        @if ($errors->first('length'))
                        <span class="help-block">{!! $errors->first('length') !!}</span>
                        @endif
                    </div>
                </div>

                <!-- Width -->
                <div class="control-group col-md-6 {!! $errors->has('width') ? 'has-error' : '' !!}">
                    <label class="control-label" for="width">Chiều ngang</label>

                    <div class="controls"> {!! Form::text('width', null, array('class'=>'form-control', 'id' => 'width', 'placeholder'=>'m', 'value'=>Input::old('width'), 'onkeypress'=>'return AllowNumbersOnly(event)')) !!}
                        @if ($errors->first('width'))
                        <span class="help-block">{!! $errors->first('width') !!}</span>
                        @endif
                    </div>
                </div>
            </div>
            <br>

            <div class="row">
                <!-- Feature -->
                <div class="control-group col-md-6 {!! $errors->has('feature') ? 'has-error' : '' !!}">
                    <label class="control-label" for="feature">Đặc điểm nhà đất</label>

                    <div class="controls"> {!! Form::text('feature', null, array('class'=>'form-control', 'id' => 'feature', 'placeholder'=>'', 'value'=>Input::old('feature'))) !!}
                        @if ($errors->first('feature'))
                        <span class="help-block">{!! $errors->first('feature') !!}</span>
                        @endif
                    </div>
                </div>

                <!-- Direction -->
                <div class="control-group col-md-6 {!! $errors->has('direction') ? 'has-error' : '' !!}">
                    <label class="control-label" for="direction">Hướng nhà đất</label>
                    {!! Form::select('direction', ['Chọn hướng','Đông', 'Tây', 'Nam', 'Bắc', 'Đông Nam', 'Đông Bắc', 'Tây Nam', 'Tây Bắc'], null, ['class'=>'form-control', 'id'=>'direction'] ) !!}
                </div>
            </div>
            <br>

            <div class="row">
                <!-- Project -->
                <div class="control-group col-md-6 {!! $errors->has('project') ? 'has-error' : '' !!}">
                    <label class="control-label" for="project">Thuộc dự án</label>

                    <div class="controls"> {!! Form::text('project', null, array('class'=>'form-control', 'id' => 'project', 'placeholder'=>'', 'value'=>Input::old('project'))) !!}
                        @if ($errors->first('project'))
                        <span class="help-block">{!! $errors->first('project') !!}</span>
                        @endif
                    </div>
                </div>

                <!-- Utilities -->
                <div class="control-group col-md-6 {!! $errors->has('utilities') ? 'has-error' : '' !!}">
                    <label class="control-label" for="utilities">Tiện ích</label>

                    <div class="controls"> {!! Form::text('utilities', null, array('class'=>'form-control', 'id' => 'utilities', 'placeholder'=>'Hồ bơi, ban công, sân vườn, ...', 'value'=>Input::old('utilities'))) !!}
                        @if ($errors->first('utilities'))
                        <span class="help-block">{!! $errors->first('utilities') !!}</span>
                        @endif
                    </div>
                </div>
            </div>
            <br>

            <div class="row">
                <!-- Environment -->
                <div class="control-group col-md-6 {!! $errors->has('environment') ? 'has-error' : '' !!}">
                    <label class="control-label" for="environment">Môi trường xung quanh</label>

                    <div class="controls"> {!! Form::text('environment', null, array('class'=>'form-control', 'id' => 'environment', 'placeholder'=>'Trường học, siêu thị, bệnh viện, ...', 'value'=>Input::old('environment'))) !!}
                        @if ($errors->first('environment'))
                        <span class="help-block">{!! $errors->first('environment') !!}</span>
                        @endif
                    </div>
                </div>

                <!-- Legal state -->
                <div class="control-group col-md-6 {!! $errors->has('legal_state') ? 'has-error' : '' !!}">
                    <label class="control-label" for="legal_state">Tình trạng pháp lý</label>
                    {!! Form::select('legal_state', ['Chọn', 'Sổ đỏ/ Sổ hồng', 'Giấy tờ hợp lệ', 'Giấy phép XD', 'Giấy phép KD'], null, ['class'=>'form-control', 'id'=>'legal_state'] ) !!}
                </div>
            </div>
            <br>

            <div class="row">
                <!-- Mobile -->
                <div class="control-group col-md-6 {!! $errors->has('mobile') ? 'has-error' : '' !!}">
                    <label class="control-label" for="mobile">SĐT liên hệ</label>

                    <div class="controls"> {!! Form::text('mobile', null, array('class'=>'form-control', 'id' => 'mobile', 'placeholder'=>'', 'value'=>Input::old('mobile'))) !!}
                        @if ($errors->first('mobile'))
                        <span class="help-block">{!! $errors->first('mobile') !!}</span>
                        @endif
                    </div>
                </div>
            </div>
            <br>

            <div class="row">
                <div class="control-group col-md-4 {!! $errors->has('terrace') ? 'has-error' : '' !!}">
                    {!! Form::checkbox('terrace', '1', null) !!} <label class="control-label" for="terrace">Sân thượng</label>
                </div>
                <div class="control-group col-md-4 {!! $errors->has('car_place') ? 'has-error' : '' !!}">
                    {!! Form::checkbox('car_place', '1', null) !!} <label class="control-label" for="car_place">Chỗ để xe hơi</label>
                </div>
                <div class="control-group col-md-4 {!! $errors->has('owner') ? 'has-error' : '' !!}">
                    {!! Form::checkbox('owner', '1', null) !!} <label class="control-label" for="owner">Chính chủ</label>
                </div>
            </div>
            <br>

            <!-- Select tag -->
            <div class="control-group {!! $errors->has('search-tag-news') ? 'has-error' : '' !!}">
                <label class="control-label" for="search-tag-news">Tag</label>
                <div class="controls">
                    <input type="text" name="search-tag-news" id="search-tag-news" placeholder="Nhập tag">
                    @if ($errors->first('search-tag-news')) 
                    <span class="help-block">{!! $errors->first('search-tag-news') !!}</span>
                    @endif
                </div>
            </div>
            <br>

            <!--Type-->
            <div class="control-group {!! $errors->has('type') ? 'has-error' : '' !!}">
                <label class="control-label" for="type">Chọn loại bài viết</label>
                <div class="controls">
                    {!! Form::select('type', ['0' => 'Miễn phí','1' => 'Trả phí'], null, ['class'=>'form-control', 'id'=>'type']) !!}
                    @if ($errors->first('type')) 
                    <span class="help-block">{!! $errors->first('type') !!}</span>
                    @endif
                </div>
            </div>
            <br>

            <label class="control-label" for="search-tag-news">SEO bài viết</label>
            <br>
            <!-- Meta title -->
            <div class="control-group {!! $errors->has('meta_title') ? 'has-error' : '' !!}">
                <label class="control-label" for="meta_title">Meta title</label>

                <div class="controls"> {!! Form::text('meta_title', null, array('class'=>'form-control', 'id' => 'meta_title', 'value'=>Input::old('meta_title'))) !!}
                    @if ($errors->first('meta_title'))
                    <span class="help-block">{!! $errors->first('meta_title') !!}</span>
                    @endif
                </div>
            </div>
            <br>

            <!-- Meta description -->
            <div class="control-group {!! $errors->has('meta_description') ? 'has-error' : '' !!}">
                <label class="control-label" for="meta_description">Meta description</label>

                <div class="controls"> {!! Form::text('meta_description', null, array('class'=>'form-control', 'id' => 'meta_description', 'value'=>Input::old('meta_description'))) !!}
                    @if ($errors->first('meta_description'))
                    <span class="help-block">{!! $errors->first('meta_description') !!}</span>
                    @endif
                </div>
            </div>
            <br>

            <!-- Meta keyword -->
            <div class="control-group {!! $errors->has('meta_keyword') ? 'has-error' : '' !!}">
                <label class="control-label" for="meta_keyword">Meta keyword</label>

                <div class="controls"> {!! Form::text('meta_keyword', null, array('class'=>'form-control', 'id' => 'meta_keyword', 'value'=>Input::old('meta_keyword'))) !!}
                    @if ($errors->first('meta_keyword'))
                    <span class="help-block">{!! $errors->first('meta_keyword') !!}</span>
                    @endif
                </div>
            </div>
            <br>

            <!-- Image -->
            <div class="fileinput fileinput-new control-group {!! $errors->has('news_image') ? 'has-error' : '' !!}" data-provides="fileinput">
                <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 200px; height: 150px;"></div>
                <div> 
                    <span class="btn btn-default btn-file"><span class="fileinput-new">{{trans('fully.choose_pic')}}</span><span class="fileinput-exists">{{trans('fully.change')}}</span> {!! Form::file('news_image', null, array('class'=>'form-control', 'id' => 'news_image', 'placeholder'=>'Ảnh', 'value'=>Input::old('news_image'))) !!}
                        @if ($errors->first('news_image')) 
                        <span class="help-block">{!! $errors->first('news_image') !!}</span>
                        @endif
                    </span>
                    <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">{{trans('fully.delete')}}</a>
                </div>
            </div>
            <br>
            <br>
            <div>
                {!! Form::submit('Bước tiếp theo', array('class' => 'btn btn-success')) !!}
                <a href="{!! url(getLang() . '/admin/realestale-news') !!}" class="btn btn-default">&nbsp;Hủy bỏ</a>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    window.onload = function () {
        CKEDITOR.replace('news_content', {
            "filebrowserBrowseUrl": "{!! url('filemanager/show') !!}",
        });
    };
    function AllowNumbersOnly(e) {
        var charCode = (e.which) ? e.which : e.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            e.preventDefault();
        }
    }
</script>
@include('backend.library.validate_special')
@stop