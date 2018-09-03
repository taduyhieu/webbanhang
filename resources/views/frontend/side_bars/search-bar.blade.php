<div class="search-nc row">
    <div class="col-md-12">
        <div class="row">                        
            <div >
                <img src="{!! url('frontend/images/search-nc.png') !!}" class="img-responsive" alt="" width="100%">
            </div>
            <div class="search-news-re-title">
                <p>Tìm kiếm nâng cao</p>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="row">
            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item active">
                    <a class="nav-link" data-toggle="tab" href="#a1">Mua bán</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#a2">Cần thuê</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link"data-toggle="tab" href="#a3">Cho thuê</a>
                </li>
            </ul>
            <div class="tab-content">
                <div id="a1" class="tab-pane fade in active">
                    <form action="{{ route('dashboard.realestale.search') }}" method="POST" class="">
                        {!! csrf_field() !!}
                        <div class="container">
                            <div class="form-group row">
                                <select class="form-control" name="cat_realestale">
                                    @foreach($newsCate as $cate)
                                    <option @if($cate->id == 1) selected="selected" @endif value="{!! $cate->id !!}">{!! $cate->name !!}</option>
                                    @endforeach
                                </select>
                                <select class="form-control" id="city_id" name="city">
                                    <option value="" selected="selected">Chọn Tỉnh/Thành phố</option>
                                    @foreach($listCity as $city)
                                    <option value="{!! $city->id !!}">{!! $city->name !!}</option>
                                    @endforeach
                                </select>
                                <select class="form-control" id="district_id" name="district">
                                    <option value="" selected="selected">Chọn Quận/Huyện</option>
                                </select>
                                <select class="form-control" name="total_area">
                                    <option value="" selected="selected">Chọn diện tích</option>
                                    <option value="1">Dưới 50 m2</option>
                                    <option value="2">50-100 m2</option>
                                    <option value="3">Trên 100m2</option>
                                </select>
                                <select class="form-control" name="price_all">
                                    <option value="" selected="selected">Chọn mức giá</option>
                                    <option value="1">Dưới 1 tỉ</option>
                                    <option value="2">1 - 5 tỉ</option>
                                    <option value="3">Trên 5 tỉ</option>
                                </select>
                            </div>
                            <button type="submit">tìm kiếm</button>
                        </div>
                    </form>
                </div>

                <div id="a2" class="tab-pane fade">
                    <form action="{{ route('dashboard.realestale.search') }}" method="POST" class="">
                        {!! csrf_field() !!}
                        <div class="container">
                            <div class="form-group row">
                                <select class="form-control" name="cat_realestale">
                                    <option  selected="selected" value="{!! $catNeedHire->id !!}">{!! $catNeedHire->name !!}</option>
                                </select>
                                <select class="form-control" id="city_id_2" name="city">
                                    <option value="" selected="selected">Chọn Tỉnh/Thành phố</option>
                                    @foreach($listCity as $city)
                                    <option value="{!! $city->id !!}">{!! $city->name !!}</option>
                                    @endforeach
                                </select>
                                <select class="form-control" id="district_id_2" name="district">
                                    <option value="">Chọn Quận/Huyện</option>
                                </select>
                                <select class="form-control" name="total_area">
                                    <option value="" selected="selected">Chọn diện tích</option>
                                    <option value="1">Dưới 50 m2</option>
                                    <option value="2">50-100 m2</option>
                                    <option value="3">Trên 100m2</option>
                                </select>
                                <select class="form-control" name="price_all">
                                    <option value="" selected="selected">Chọn mức giá</option>
                                    <option value="1">Dưới 1 tỉ</option>
                                    <option value="2">1 - 5 tỉ</option>
                                    <option value="3">Trên 5 tỉ</option>
                                </select>
                            </div>
                            <button type="submit">tìm kiếm</button>
                        </div>
                    </form>
                </div>
                <div id="a3" class="tab-pane fade">
                    <form action="{{ route('dashboard.realestale.search') }}" method="POST" class="">
                        {!! csrf_field() !!}
                        <div class="container">
                            <div class="form-group row">
                                <select class="form-control" name="cat_realestale">
                                    <option value="" selected="selected" value="{!! $catHire->id !!}">{!! $catHire->name !!}</option>
                                </select>
                                <select class="form-control" id="city_id_3" name="city">
                                    <option value="" selected="selected">Chọn Tỉnh/Thành phố</option>
                                    @foreach($listCity as $city)
                                    <option value="{!! $city->id !!}">{!! $city->name !!}</option>
                                    @endforeach
                                </select>
                                <select class="form-control" id="district_id_3" name="district">
                                    <option>Chọn Quận/Huyện</option>
                                </select>
                                <select class="form-control" name="total_area">
                                    <option value="" selected="selected">Chọn diện tích</option>
                                    <option value="1">Dưới 50 m2</option>
                                    <option value="2">50-100 m2</option>
                                    <option value="3">Trên 100m2</option>
                                </select>
                                <select class="form-control" name="price_all">
                                    <option value="" selected="selected">Chọn mức giá</option>
                                    <option value="1">Dưới 1 tỉ</option>
                                    <option value="2">1 - 5 tỉ</option>
                                    <option value="3">Trên 5 tỉ</option>
                                </select>
                            </div>
                            <button type="submit">tìm kiếm</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    // Tab 1
    var linkDistrict = "{!! url(getLang() . '/san-giao-dich/district/listDistrict') !!}";
    $(function () {
        $('#city_id').change(function () {
            let district_id = $('#district_id');
            if (!$(this).val()) {
                district_id.attr('disabled', 'disabled');
            }
            let city_id = {'city_id': $(this).val()};
            $.get(linkDistrict, city_id, function (jsonData) {
                district_id.empty();
                district_id.append("<option value='' selected>Chọn Quận/Huyện</option>");
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

    // Tab 2
    var linkDistrict = "{!! url(getLang() . '/san-giao-dich/district/listDistrict') !!}";
    $(function () {
        $('#city_id_2').change(function () {
            let district_id = $('#district_id_2');
            if (!$(this).val()) {
                district_id.attr('disabled', 'disabled');
            }
            let city_id = {'city_id': $(this).val()};
            $.get(linkDistrict, city_id, function (jsonData) {
                district_id.empty();
                district_id.append("<option value='' selected>Chọn Quận/Huyện</option>");
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

    // Tab 3
    var linkDistrict = "{!! url(getLang() . '/san-giao-dich/district/listDistrict') !!}";
    $(function () {
        $('#city_id_3').change(function () {
            let district_id = $('#district_id_3');
            if (!$(this).val()) {
                district_id.attr('disabled', 'disabled');
            }
            let city_id = {'city_id': $(this).val()};
            $.get(linkDistrict, city_id, function (jsonData) {
                district_id.empty();
                district_id.append("<option value='' selected>Chọn Quận/Huyện</option>");
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

    $(document).ready(function () {
        $(function () {
            $("#district_id").attr('disabled', 'disabled');
            $("#district_id_2").attr('disabled', 'disabled');
            $("#district_id_3").attr('disabled', 'disabled');
        });
    });
</script>
