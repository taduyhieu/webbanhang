@extends('backend/layout/layout')
@section('content')
{!! HTML::style('assets/bootstrap/css/bootstrap-tagsinput.css') !!}
{!! HTML::style('jasny-bootstrap/css/jasny-bootstrap.min.css') !!}
{!! HTML::script('assets/bootstrap/js/bootstrap-tagsinput.js') !!}
{!! HTML::script('assets/js/jquery.slug.js') !!}
{!! HTML::script('jasny-bootstrap/js/jasny-bootstrap.min.js') !!}

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1> Người dùng
        <small> | Thêm mới</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{!! url(getLang(). '/admin/user') !!}"><i class="fa fa-user"></i> Người dùng</a></li>
        <li class="active">Thêm mới</li>
    </ol>
</section>
<br>
<br>
<div class="container">
    {!! Form::open(array('action' => '\Fully\Http\Controllers\Admin\UserController@store')) !!}

    <!-- User -->
    <div class="control-group {!! $errors->has('user_name') ? 'has-error' : '' !!}">
        <label class="control-label" for="user_name">Tên tài khoản</label>

        <div class="controls">
            {!! Form::text('user_name', null, array('class'=>'form-control', 'id' => 'user_name', 'placeholder'=>'Tên tài khoản', 'value'=>Input::old('user_name'))) !!}
            @if ($errors->first('user_name'))
            <span class="help-block">{!! $errors->first('user_name') !!}</span>
            @endif
        </div>
    </div>
    <br>
    <!-- Full Name -->
    <div class="control-group {!! $errors->has('full_name') ? 'has-error' : '' !!}">
        <label class="control-label" for="full_name">Tền đầy đủ</label>

        <div class="controls">
            {!! Form::text('full_name', null, array('class'=>'form-control', 'id' => 'full_name', 'placeholder'=>'Tên đầy đủ', 'value'=>Input::old('full_name'))) !!}
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
            {!! Form::text('email', null, array('class'=>'form-control', 'id' => 'email', 'placeholder'=>'Email', 'value'=>Input::old('email'))) !!}
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
            {!! Form::text('mobile', null, array('class'=>'form-control', 'id' => 'mobile', 'placeholder'=>'Số điện thoại', 'value'=>Input::old('mobile'))) !!}
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
            <label><input type="radio" value="{!! $id !!}" name="account-role" checked="checked">  {!! $role !!} </label>
            @endforeach
            @if ($errors->first('account-role'))
            <span class="help-block">{!! $errors->first('account-role') !!}</span>
            @endif
        </div>
    </div>
    <br>
    <!-- Password -->
    <div class="control-group {!! $errors->has('password') ? 'has-error' : '' !!}">
        <label class="control-label" for="password">Mật khẩu</label>

        <div class="controls">
            {!! Form::password('password', array('class'=>'form-control', 'id' => 'password', 'placeholder'=>'Mật khẩu', 'value'=>Input::old('password'))) !!}
            @if ($errors->first('password'))
            <span class="help-block">{!! $errors->first('password') !!}</span>
            @endif
        </div>
    </div>
    <br>
    <!-- Confirm Password -->
    <div class="control-group {!! $errors->has('confirm-password') ? 'has-error' : '' !!}">
        <label class="control-label" for="confirm-password">Xác nhận mật khẩu</label>

        <div class="controls">
            {!! Form::password('confirm_password', array('class'=>'form-control', 'id' => 'confirm_password', 'placeholder'=>'Xác nhận mật khẩu', 'value'=>Input::old('confirm_password'))) !!}
            @if ($errors->first('confirm-password'))
            <span class="help-block">{!! $errors->first('confirm-password') !!}</span>
            @endif
        </div>
    </div>
    <br>

    <!-- Image -->
<!--    <div class="">
        <label class="control-label" for="user_image">Ảnh đại diện</label>
    </div>
     Image 
    <div class="fileinput fileinput-new control-group {!! $errors->has('user_image') ? 'has-error' : '' !!}" data-provides="fileinput">
        <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 200px; height: 150px;"></div>
        <div> 
            <span class="btn btn-default btn-file"><span class="fileinput-new">{{trans('fully.choose_pic')}}</span><span class="fileinput-exists">{{trans('fully.change')}}</span> {!! Form::file('user_image', null, array('class'=>'form-control', 'id' => 'user_image', 'placeholder'=>'Ảnh', 'value'=>Input::old('user_image'))) !!}
                @if ($errors->first('user_image')) 
                <span class="help-block">{!! $errors->first('user_image') !!}</span>
                @endif
            </span>
            <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">{{trans('fully.delete')}}</a>
        </div>
    </div>
    <br>
    <br>-->
    <!-- Form actions -->
    {!! Form::submit('Xác nhận', array('class' => 'btn btn-success')) !!}
    <a href="{!! url('/'.getLang().'/admin/user') !!}"
       class="btn btn-default">
        &nbsp;Hủy
    </a>
    {!! Form::close() !!}
</div>
@stop