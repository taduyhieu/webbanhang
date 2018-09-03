@extends('backend/layout/layout')
@section('content')
    <section class="content-header">
        <h1> Tag Bất động sản
            <small> | Xóa </small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{!! langRoute('admin.realestale-tag.index') !!}"><i class="fa fa-play"></i> Tag Bất động sản</a></li>
            <li class="active">Xóa</li>
        </ol>
    </section>
    <br>
    <br>
    <br>
    <div class="col-lg-10">
        {!! Form::open( array(  'route' => array(getLang(). '.admin.realestale-tag.destroy', $tagRealEstale->id ) ) ) !!}
        {!! Form::hidden( '_method', 'DELETE' ) !!}
        <div class="alert alert-warning">
            <div class="pull-left"><b> Cẩn thận!</b> Có phải bạn muốn xóa <b>{!! $tagRealEstale->name !!} </b> ?
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