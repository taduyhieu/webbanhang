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
        $("#title").slug();
//        if ($('#tag').length != 0) {
//            var elt = $('#tag');
//            elt.tagsinput();
//        }

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
            }
        });
    });

</script>

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1> {{trans('fully.news_header')}} <small> | {{trans('fully.news_new')}}</small> </h1>
    <ol class="breadcrumb">
        <li><a href="{!! url(getLang() . '/admin/news') !!}"><i class="fa fa-bookmark"></i> </a> {{trans('fully.news_header')}}</li>
        <li class="active">{{trans('fully.news_new')}}</li>
    </ol>
</section>
<br>
<br>
<div class="container">
    <div class="row">
        {!! Form::open(array('action' => '\Fully\Http\Controllers\Admin\NewsController@store', 'files'=>true)) !!}
        {!! csrf_field() !!}
        <div class="col-md-6">
            <!-- Title -->
            <div class="control-group {!! $errors->has('news_title') ? 'has-error' : '' !!}">
                <label class="control-label" for="news_title">{{trans('fully.news_title')}} (*)</label>

                <div class="controls"> {!! Form::text('news_title', null, array('class'=>'form-control', 'id' => 'news_title',
                    'placeholder'=>trans('fully.news_title'), 'value'=>Input::old('news_title'))) !!}
                    @if ($errors->first('news_title')) 
                    <span class="help-block">{!! $errors->first('news_title') !!}</span> 
                    @endif
                </div>
            </div>
            <br>
            <!-- SAPO -->
            <div class="control-group {!! $errors->has('news_sapo') ? 'has-error' : '' !!}">
                <label class="control-label" for="news_sapo">SAPO</label>

                <div class="controls"> {!! Form::text('news_sapo', null, array('class'=>'form-control', 'id' => 'news_sapo', 'value'=>Input::old('news_sapo'))) !!}
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
                        <option value="{!! $id !!}" style="font-weight: bold">{!! $author !!}</option>
                        @endforeach
                    </select>
                    @if ($errors->first('news_author')) 
                    <span class="help-block">{!! $errors->first('news_author') !!}</span>
                    @endif
                </div>
            </div>
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
        </div>
        <div class="col-md-6">
            <!-- Select Category -->
            <div class="control-group {!! $errors->has('cat_id') ? 'has-error' : '' !!}">
                <label class="control-label" for="cat_id">Danh mục (*)</label>
                <div class="controls">
                    <select class="form-control" name="cat_id">
                        <option value="" selected disabled="">Chọn danh mục</option>
                        @foreach($categories as $category)
                        <option value="{!! $category->id !!}" style="font-weight: bold">{!! $category->name !!}</option>
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
                    <select class="form-control" name="type">
                        <option value="1" selected>Bài viết bình thường</option>
                        <option value="2">Bài viết đặc biệt</option>
                    </select>
                    @if ($errors->first('type')) 
                    <span class="help-block">{!! $errors->first('type') !!}</span>
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
            <div class="row" style="margin-top: -6px;">
                <!-- Meta description -->
                <div class="control-group col-md-6 {!! $errors->has('meta_description') ? 'has-error' : '' !!}">
                    <label class="control-label" for="meta_description">Meta description</label>
                    <div class="controls"> {!! Form::text('meta_description', null, array('class'=>'form-control', 'id' => 'meta_description', 'value'=>Input::old('meta_description'))) !!}
                        @if ($errors->first('meta_description'))
                        <span class="help-block">{!! $errors->first('meta_description') !!}</span>
                        @endif
                    </div>
                </div>

                <!-- Meta keyword -->
                <div class="control-group col-md-6 {!! $errors->has('meta_keyword') ? 'has-error' : '' !!}">
                    <label class="control-label" for="meta_keyword">Meta keyword</label>
                    <div class="controls"> {!! Form::text('meta_keyword', null, array('class'=>'form-control', 'id' => 'meta_keyword', 'value'=>Input::old('meta_keyword'))) !!}
                        @if ($errors->first('meta_keyword'))
                        <span class="help-block">{!! $errors->first('meta_keyword') !!}</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12" style="margin-top: 15px;">
            <!-- Content -->
            <div class="control-group {!! $errors->has('news_content') ? 'has-error' : '' !!}">
                <label class="control-label" for="news_content">Nội dung (*)</label>

                <div class="controls"> {!! Form::textarea('news_content', null, array('class'=>'form-control', 'id' => 'news_content', 'placeholder'=>trans('fully.news_content'), 'value'=>Input::old('news_content'))) !!}
                    @if ($errors->first('news_content'))
                    <span class="help-block">{!! $errors->first('news_content') !!}</span>
                    @endif
                </div>
            </div>
        </div>
        <!-- Image -->
        <div class="col-md-12" style="margin-top: 15px;">
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
                {!! Form::submit(trans('fully.save'), array('class' => 'btn btn-success' )) !!}
                <a href="{!! url(getLang() . '/admin/news') !!}" class="btn btn-default">&nbsp;Hủy bỏ</a>
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
</script>
@include('backend.library.validate_special')
@stop