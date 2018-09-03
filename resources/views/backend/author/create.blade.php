@extends('backend/layout/layout')
@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1> Tác giả
        <small> | Thêm mới</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{!! url(getLang(). '/admin/province') !!}"><i class="fa fa-global"></i> Tác giả</a></li>
        <li class="active">Thêm mới</li>
    </ol>
</section>
<br>
<br>
<div class="container">

    {!! Form::open(array('action' => '\Fully\Http\Controllers\Admin\AuthorController@store')) !!}
    <!-- Name -->
    <div class="control-group {!! $errors->has('name') ? 'has-error' : '' !!}">
        <label class="control-label" for="name">Tên tác giả</label>

        <div class="controls">
            {!! Form::text('name', null, array('class'=>'form-control', 'id' => 'name', 'placeholder'=>'Tên tác giả', 'value'=>Input::old('name'))) !!}
            @if ($errors->first('name'))
            <span class="help-block">{!! $errors->first('name') !!}</span>
            @endif
        </div>
    </div>
    <br>

    <!--User id-->
    <div class="control-group {!! $errors->has('user_id') ? 'has-error' : '' !!}">
        <label class="control-label" for="user_id">User</label>
        <div class="controls">
            <select class="form-control" name="user_id">
                <option value="0" style="font-weight: bold" selected>Chọn user</option>
                @foreach($users as $id=>$user)
                <option value="{!! $id !!}" style="font-weight: bold">{!! $user !!}</option>
                @endforeach
            </select>
            @if ($errors->first('user_id')) 
            <span class="help-block">{!! $errors->first('user_id') !!}</span>
            @endif
        </div>
    </div>
    <br>
    
    <!-- Form actions -->
    {!! Form::submit('Xác nhận', array('class' => 'btn btn-success')) !!}
    <a href="{!! url(getLang(). '/admin/author') !!}" class="btn btn-default">&nbsp;Hủy</a>
    {!! Form::close() !!}
</div>
@stop