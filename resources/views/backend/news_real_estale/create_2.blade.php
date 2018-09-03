@extends('backend/layout/layout')
@section('content')

{!! HTML::style('jasny-bootstrap/css/jasny-bootstrap.min.css') !!}
{!! HTML::style('dropzone/css/basic.css') !!}
{!! HTML::style('dropzone/css/dropzone.css') !!}
{!! HTML::script('dropzone/dropzone.js') !!}

<script type="text/javascript">
    $(document).ready(function () {
        // myDropzone is the configuration for the element that has an id attribute
        // with the value my-dropzone (or myDropzone)
        Dropzone.options.myDropzone = {
            init: function () {
                this.on("addedfile", function (file) {

                    var removeButton = Dropzone.createElement('<a class="dz-remove">Remove file</a>');
                    var _this = this;

                    removeButton.addEventListener("click", function (e) {
                        e.preventDefault();
                        e.stopPropagation();

                        var fileInfo = new Array();
                        fileInfo['name'] = file.name;

                        $.ajax({
                            type: "POST",
                            url: "{!! url(getLang() . '/admin/realestale-news-delete-image') !!}",
                            headers: {
                                'X-CSRF-Token': $('meta[name="_token"]').attr('content')
                            },
                            data: {file: file.name},
                            success: function (response) {

                                if (response == 'success') {

                                    //alert('deleted');
                                }
                            },
                            error: function () {
                                alert("error");
                            }
                        });

                        _this.removeFile(file);

                        // If you want to the delete the file on the server as well,
                        // you can do the AJAX request here.
                    });

                    // Add the button to the file preview element.
                    file.previewElement.appendChild(removeButton);
                });
            }
        };

        var myDropzone = new Dropzone("#dropzone .dropzone");
        Dropzone.options.myDropzone = false;

        @foreach($newsRealEstale->getPhotos as $photo)

        // Create the mock file:
        var mockFile = {name: "{!! $photo->file_name !!}", size: "{!! $photo->file_size !!}"};

        // Call the default addedfile event handler
        myDropzone.emit("addedfile", mockFile);

        // And optionally show the thumbnail of the file:
        myDropzone.emit("thumbnail", mockFile, "{!! url($photo->path) !!}");

        @endforeach
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
        <!-- Dropzone -->
        <label class="control-label" for="title">Đăng tải hình ảnh </label>
        
        <div style="width: 100%; min-height: 300px; height: auto; border:1px solid slategray;" id="dropzone">
            {!! Form::open(array('url' => getLang() . '/admin/realestale-news/upload/' . $newsRealEstale->id, 'class'=>'dropzone', 'id'=>'my-dropzone')) !!}
            <!-- Single file upload -->
            <!-- <div class="dz-default dz-message"><span>Drop files here to upload</span></div>
            Multiple file upload -->
            <div class="fallback">
                <input name="file" type="file" multiple/>
            </div>
            {!! Form::close() !!}
        </div>
        <br>
        
        <div class="col-md-12">
            <a href="{!! url(getLang() . '/admin/realestale-news') !!}" class="btn btn-success">&nbsp;Xác nhận</a>
            <a href="{!! url(getLang() . '/admin/realestale-news') !!}" class="btn btn-default">&nbsp;Hủy bỏ</a>
        </div>    
    </div>
</div>
@include('backend.library.validate_special')
@stop