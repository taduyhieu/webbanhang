@extends('backend/layout/layout')
@section('content')
    <section class="content-header">
        <h1> Bình luận
            <small> | Xóa</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{!! langRoute('admin.news-comment.index') !!}"><i class="fa fa-play"></i> Bình luận</a></li>
            <li class="active">Xóa</li>
        </ol>
    </section>
    <br>
    <br>
    <br>
    <div class="col-lg-10">
        {!! Form::open( array(  'route' => array(getLang(). '.admin.news-comment.destroy', $comment->id ) ) ) !!}
        {!! Form::hidden( '_method', 'DELETE' ) !!}
        <div class="alert alert-warning">
            <div class="pull-left"><b> Cẩn thận!</b> Có phải bạn muốn xóa bình luận <b>{!! $comment->content !!} </b> ?
            </div>
            <div class="pull-right">
                {!! Form::submit( 'Có', array( 'class' => 'btn btn-danger' ) ) !!}
                {!! link_to( URL::previous(), 'Không', array( 'class' => 'btn btn-primary' ) ) !!}
            </div>
            <div class="clearfix"></div>
        </div>
        {!! Form::close() !!}
    </div>
@stop