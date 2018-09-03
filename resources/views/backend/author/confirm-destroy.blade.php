@extends('backend/layout/layout')
@section('content')
<section class="content-header">
    <h1> Tác giả <small> | Xóa</small> </h1>
    <ol class="breadcrumb">
        <li><a href="{!! url(getLang(). '/admin/province') !!}"><i class="fa fa-globe"></i> Tác giả</a></li>
        <li class="active">Xóa </li>
    </ol>
</section>
<br>
<br>
<br>
<div class="col-lg-10">
    {!! Form::open( array( 'route' => array(getLang(). '.admin.author.destroy', $author->id ) ) ) !!}
    {!! Form::hidden( '_method', 'DELETE' ) !!}
    <div class="alert alert-warning">
        <div class="pull-left"><b> Bạn có chắc chắn muốn xóa <b>{!! $author->name !!} </b> ?
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