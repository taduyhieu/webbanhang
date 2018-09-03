@extends('backend/layout/layout')
@section('content')
<section class="content-header">
    <h1> Người dùng
        <small> | Xóa</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{!! langRoute('admin.user.index') !!}"><i class="fa fa-user"></i> Người dùng</a></li>
        <li class="active">Xóa</li>
    </ol>
</section>
<br>
<br>
<br>
<div class="col-lg-10">
    {!! Form::open( array(  'route' => array(getLang(). '.admin.user.destroy', $user->id ) ) ) !!}
    {!! Form::hidden( '_method', 'DELETE' ) !!}
    <div class="alert alert-warning">
        <div class="pull-left">Bạn có muốn xóa <b>{!! $user->first_name !!}  {!! $user->last_name !!} </b> ?
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