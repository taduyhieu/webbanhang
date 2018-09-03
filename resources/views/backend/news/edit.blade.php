@extends('backend/layout/layout')
@section('content')
{!! HTML::script('ckeditor/ckeditor.js') !!}
{!! HTML::style('backend/css/selectize.default.css') !!}
{!! HTML::style('assets/bootstrap/css/bootstrap-tagsinput.css') !!}
{!! HTML::style('jasny-bootstrap/css/jasny-bootstrap.min.css') !!}
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
    $(document).ready(function () {

    });

    $(window).load(function () {

        $('.fileinput').fileinput();
        $('#reset').click(function () {

            $('.fileinput').fileinput('reset');
            return false;
        });

        /*
         $('.fileinput').fileinput();
         $('#reset').click(function() {
         $('form')[0].reset();
         });
         $('#reset_trigger').click(function() {
         $('.fileinput').trigger('reset.bs.fileinput');
         });
         $('#reset_form').click(function() {
         $('form')[0].reset();
         });
         */
    });

    jQuery(document).ready(function () {

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
                    url: '{!!url(getLang() . "/admin/news/tag/listTag?term=") !!}' + encodeURIComponent(query),
                    type: 'GET',
                    error: function () {
                        callback();
                    },
                    success: function (res) {
                        callback(res);
                    }
                });
            },
            onInitialize: function () {
                let selectize = this;
                let data = <?php echo json_encode($listTags) ?>;
                selectize.addOption(data); // This is will add to option
                let selected_items = [];
                $.each(data, function (i, obj) {
                    selected_items.push(obj.id);
                });
                selectize.setValue(selected_items);
            }
        });

        $('#news_relation').selectize({
            plugins: ['remove_button'],
            persist: false,
            maxItems: null,
            valueField: 'news_id',
            labelField: 'news_title',
            searchField: ['news_title'],
            options: [],
            render: {
                item: function (item, escape) {
                    return '<div>' +
                            (item.news_title ? '<span class="news_title">' + escape(item.news_title) + '</span>' : '') +
                            '</div>';
                },
                option: function (item, escape) {
                    var label = item.news_title || item.news_id;
                    return '<div>' +
                            '<span class="label">' + escape(label) + '</span>' +
                            '</div>';
                }
            },
            load: function (query, callback) {
                if (!query.length)
                    return callback();
                $.ajax({
                    url: '{!!url(getLang() . "/admin/news/relation/listNewsRelation?term=") !!}' + encodeURIComponent(query),
                    type: 'GET',
                    error: function () {
                        callback();
                    },
                    success: function (res) {
                        callback(res);
                    }
                });
            },
            onInitialize: function () {
                let selectize = this;
                let data = <?php echo json_encode($listNewsRelation) ?>;
                selectize.addOption(data); // This is will add to option
                let selected_items = [];
                $.each(data, function (i, obj) {
                    selected_items.push(obj.news_id);
                });
                selectize.setValue(selected_items);
            }
        });
    });

</script>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1> {{trans('fully.news_header')}} <small>| {{trans('fully.edit')}}</small> </h1>
    <ol class="breadcrumb">
        <li><a href="{!! url(getLang() . '/admin/news') !!}"><i class="fa fa-bookmark"></i> {{trans('fully.news_header')}} </a></li>
        <li class="active"> {{trans('fully.edit')}}</li>
    </ol>
</section>
<br>
<br>
<div class="container">
    <div class="row">
        {!! Form::open( array( 'route' => array( getLang() . '.admin.news.update', $news->news_id), 'method' => 'PATCH', 'files'=>true)) !!}
        {!! csrf_field() !!}
        <div class="col-md-6">
            <!-- Title -->
            <div class="control-group {!! $errors->has('news_title') ? 'has-error' : '' !!}">
                <label class="control-label" for="news_title">{{trans('fully.news_title')}} (*)</label>

                <div class="controls"> {!! Form::text('news_title', $news->news_title, array('class'=>'form-control', 'id' => 'news_title', 'placeholder'=>trans('fully.news_title'), 'value'=>Input::old('news_title'))) !!}
                    @if ($errors->first('news_title')) <span class="help-block">{!! $errors->first('news_title') !!}</span> @endif
                </div>
            </div>
            <br>

            <!-- SAPO -->
            <div class="control-group {!! $errors->has('news_sapo') ? 'has-error' : '' !!}">
                <label class="control-label" for="news_sapo">SAPO</label>

                <div class="controls"> {!! Form::text('news_sapo', $news->news_sapo, array('class'=>'form-control', 'id' => 'news_sapo', 'value'=>Input::old('news_sapo'))) !!}
                    @if ($errors->first('news_sapo'))
                    <span class="help-block">{!! $errors->first('news_sapo') !!}</span>
                    @endif
                </div>
            </div>
            <br>

            <!-- Select author -->
            <div class="control-group {!! $errors->has('news_author') ? 'has-error' : '' !!}">
                <label class="control-label" for="news_author">Tác giả</label>
                <div class="controls">
                    <select class="form-control" name="news_author">
                        <option value="0" selected>Chọn tác giả</option>
                        @foreach($authors as $id=>$author)
                        <option value="{!! $id !!}" style="font-weight: bold" @if($news->news_author == $id) selected @endif>{!! $author !!}</option>
                        @endforeach
                    </select>
                    @if ($errors->first('news_author')) 
                    <span class="help-block">{!! $errors->first('news_author') !!}</span>
                    @endif
                </div>
            </div>
            <br>

            <!-- Select news relation -->
            <div class="control-group {!! $errors->has('news_relation') ? 'has-error' : '' !!}">
                <label class="control-label" for="news_relation">Bài viết liên quan</label>
                <div class="controls">
                    <input type="text" name="news_relation" id="news_relation" placeholder="Tìm kiếm bài viết">
                    @if ($errors->first('news_relation')) 
                    <span class="help-block">{!! $errors->first('news_relation') !!}</span>
                    @endif
                </div>
            </div>
            <br>

            <!--News highlight-->
            <div class="row">
                @if($newsHLExist == null)
                <div class="control-group col-md-4 {!! $errors->has('news_highlight') ? 'has-error' : '' !!}">
                    {!! Form::checkbox('news_highlight', '1', null) !!} <label class="control-label" for="news_highlight">Tiêu điểm</label>
                </div>
                @endif
                @if($newsHomeExist == null)
                <div class="control-group col-md-4 {!! $errors->has('news_home') ? 'has-error' : '' !!}">
                    {!! Form::checkbox('news_home', '1', null) !!} <label class="control-label" for="news_home">Hiển thị trang chủ</label>
                </div>
                @endif
                @if($newsCateExist == null)
                <div class="control-group col-md-4 {!! $errors->has('news_cate') ? 'has-error' : '' !!}">
                    {!! Form::checkbox('news_cate', '1', null) !!} <label class="control-label" for="news_cate">Nổi bật chuyên mục</label>
                </div>
                @endif
            </div>
            <br>
            <div class="row">
                @if($newsFollowExist == null)
                <div class="control-group col-md-4 {!! $errors->has('follow_news') ? 'has-error' : '' !!}">
                    {!! Form::checkbox('follow_news', '1', null) !!} <label class="control-label" for="follow_news">Theo dòng thời sự</label>
                </div>
                @endif
            </div>
        </div>

        <div class="col-md-6">
            <!-- Select Category -->
            <div class="control-group {!! $errors->has('cat_id') ? 'has-error' : '' !!}">
                <label class="control-label" for="cat_id">Danh mục (*)</label>
                <div class="controls">
                    <select class="form-control" name="cat_id">
                        <option value="" selected disabled="">Chọn danh mục</option>
                        @foreach($categories as $category)
                        <option value="{!! $category->id !!}" style="font-weight: bold" @if($news->cat_id == $category->id) selected @endif>{!! $category->name !!}</option>
                        @endforeach
                    </select>
                    @if ($errors->first('cat_id')) 
                    <span class="help-block">{!! $errors->first('cat_id') !!}</span>
                    @endif
                </div>
            </div>
            <br>

            <!-- Select type -->
            <div class="control-group {!! $errors->has('type') ? 'has-error' : '' !!}">
                <label class="control-label" for="type">Loại bài viết</label>
                <div class="controls">
                    {!! Form::select('type', ['1' => 'Bài viết bình thường','2' => 'Bài viết đặc biệt'], $news->type, ['class'=>'form-control', 'id'=>'type']) !!}
                    @if ($errors->first('type')) 
                    <span class="help-block">{!! $errors->first('type') !!}</span>
                    @endif
                </div>
            </div>
            <br>

            <!-- Status -->
            <div class="control-group {!! $errors->has('news_status') ? 'has-error' : '' !!}">
                <label class="control-label" for="news_status">Trạng thái</label>
                <div class="controls">
                    {!! Form::select('news_status', ['Bài đợi biên tập', 'Bài nhận biên tập', 'Bài đã biên tập xong', 'Bài đã xét duyệt', 'Bài đã xuất bản', 'Bài đã trả lại', 'Bài đã gỡ'], $news->news_status, ['class'=>'form-control', 'id'=>'news_status'] ) !!}
                    @if ($errors->first('news_status'))
                    <span class="help-block">{!! $errors->first('news_status') !!}</span>
                    @endif
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
            @if(isset($metaData))
            <!-- Meta title -->
            <div class="control-group {!! $errors->has('meta_title') ? 'has-error' : '' !!}">
                <label class="control-label" for="meta_title">Meta title</label>

                <div class="controls"> {!! Form::text('meta_title', $metaData->meta_title, array('class'=>'form-control', 'id' => 'meta_title', 'value'=>Input::old('meta_title'))) !!}
                    @if ($errors->first('meta_title'))
                    <span class="help-block">{!! $errors->first('meta_title') !!}</span>
                    @endif
                </div>
            </div>
            <br>

            <!-- Meta description -->
            <div class="control-group {!! $errors->has('meta_description') ? 'has-error' : '' !!}">
                <label class="control-label" for="meta_description">Meta description</label>

                <div class="controls"> {!! Form::text('meta_description', $metaData->meta_description, array('class'=>'form-control', 'id' => 'meta_description', 'value'=>Input::old('meta_description'))) !!}
                    @if ($errors->first('meta_description'))
                    <span class="help-block">{!! $errors->first('meta_description') !!}</span>
                    @endif
                </div>
            </div>
            <br>

            <!-- Meta keyword -->
            <div class="control-group {!! $errors->has('meta_keyword') ? 'has-error' : '' !!}">
                <label class="control-label" for="meta_keyword">Meta keyword</label>
                <div class="controls"> {!! Form::text('meta_keyword', $metaData->meta_keyword, array('class'=>'form-control', 'id' => 'meta_keyword', 'value'=>Input::old('meta_keyword'))) !!}
                    @if ($errors->first('meta_keyword'))
                    <span class="help-block">{!! $errors->first('meta_keyword') !!}</span>
                    @endif
                </div>
            </div>
            @else
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
        </div>
        @endif
    </div>
    <div class="col-md-12" style="margin-top: 15px;">
        <!-- Content -->
        <div class="control-group {!! $errors->has('news_content') ? 'has-error' : '' !!}">
            <label class="control-label" for="news_content">Nội dung (*)</label>
            <div class="controls"> {!! Form::textarea('news_content', $news->news_content, array('class'=>'form-control', 'id' => 'news_content',
                'placeholder'=>trans('fully.news_content'), 'value'=>Input::old('news_content'))) !!}
                @if ($errors->first('news_content'))
                <span class="help-block">{!! $errors->first('news_content') !!}</span>
                @endif
            </div>
        </div>
    </div>
    <!-- Image -->
    <div class="col-md-12" style="margin-top: 15px;">
        <div class="fileinput fileinput-new control-group {!! $errors->has('news_image') ? 'has-error' : '' !!}" data-provides="fileinput">
            <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
                <img data-src="" {!! (($news->news_image) ? "src='".url($news->news_image)."'" : null) !!} alt="...">
            </div>
            <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"></div>
            <div>
                <span class="btn btn-default btn-file"><span class="fileinput-new">{{trans('fully.choose_pic')}}</span><span class="fileinput-exists">{{trans('fully.change')}}</span>
                    {!! Form::file('news_image', null, array('class'=>'form-control', 'id' => 'news_image', 'placeholder'=>'Image', 'value'=>Input::old('news_image'))) !!}
                    @if ($errors->first('news_image'))
                    <span class="help-block">{!! $errors->first('news_image') !!}</span>
                    @endif
                </span> <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">{{trans('fully.delete')}}</a>
                <!--            <button type="button" id="reset" class='btn btn-default'>{{trans('fully.reset')}}</button>-->
                <!--<button type="button" id="reset_trigger" class='btn btn-default'>trigger reset.bs.fileinput</button>
                    <button type="button" id="reset_form" class='btn btn-default'>Reset Form</button>-->
            </div>
        </div>
        <br>
        <br>
        <div>
            {!! Form::submit(trans('fully.save_change'), array('class' => 'btn btn-success')) !!}
            <a href="{!! url(getLang() . '/admin/news') !!}" class="btn btn-default">&nbsp;Hủy bỏ</a>
            {!! Form::close() !!}
        </div>
    </div>
</div>
<script type="text/javascript">
    window.onload = function () {
        CKEDITOR.replace('news_content', {
            "filebrowserBrowseUrl": "{!! url('filemanager/show') !!}"
        });
    };
</script>
@include('backend.library.validate_special')
@stop