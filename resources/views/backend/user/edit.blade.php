@extends('backend/layout/layout')
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1> Người dùng
        <small> | Sửa</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{!! url(getLang(). '/admin/user') !!}"><i class="fa fa-user"></i> Người dùng</a></li>
        <li class="active">Sửa</li>
    </ol>
</section>
<br>
<br>
<div class="container">

    {!! Form::open( array( 'route' => array(getLang(). '.admin.user.update', $user->id), 'method' => 'PATCH')) !!}
    <!-- Full Name -->
    <div class="control-group {!! $errors->has('full_name') ? 'has-error' : '' !!}">
        <label class="control-label" for="full_name">Tên đầy đủ</label>

        <div class="controls">
            {!! Form::text('full_name', $user->full_name, array('class'=>'form-control', 'id' => 'full_name', 'placeholder'=>'Tên đầy đủ', 'value'=>Input::old('full_name'))) !!}
            @if ($errors->first('full_name'))
            <span class="help-block">{!! $errors->first('full_name') !!}</span>
            @endif
        </div>
    </div>
    <br>
    <!-- Email -->
    <div class="control-group {!! $errors->has('email') ? 'has-error' : '' !!}">
        <label class="control-label" for="email">Email</label>

        <div class="controls">
            {!! Form::text('email', $user->email, array('class'=>'form-control', 'id' => 'email', 'placeholder'=>'Email', 'value'=>Input::old('email'))) !!}
            @if ($errors->first('email'))
            <span class="help-block">{!! $errors->first('email') !!}</span>
            @endif
        </div>
    </div>
    <br>

     <!-- Mobile -->
    <div class="control-group {!! $errors->has('mobile') ? 'has-error' : '' !!}">
        <label class="control-label" for="mobile">Số điện thoại</label>

        <div class="controls">
            {!! Form::text('mobile', $user->mobile, array('class'=>'form-control', 'id' => 'mobile', 'placeholder'=>'Số điện thoại', 'value'=>Input::old('mobile'))) !!}
            @if ($errors->first('mobile'))
            <span class="help-block">{!! $errors->first('mobile') !!}</span>
            @endif
        </div>
    </div>
    <br>

    <!-- Role -->
    <div class="control-group {!! $errors->has('is_published') ? 'has-error' : '' !!}">
        <label class="control-label" for="groups">Roles</label>
        <div class="controls">

            @foreach($roles as $id=>$role)
            <label><input {!! ((in_array($role, $userRoles)) ? 'checked' : '') !!} id="{!! $role !!} " type="radio" value="{!! $id !!}" name="account-role">  {!! $role !!}</label>
            @endforeach

        </div>
    </div>
    <br>

    <!-- Form actions -->
    {!! Form::submit('Xác nhận', array('class' => 'btn btn-success')) !!}
    <a href="{!! url(getLang() . '/admin/user') !!}"
       class="btn btn-default">
        &nbsp;Hủy bỏ
    </a>
    {!! Form::close() !!}
</div>

@stop