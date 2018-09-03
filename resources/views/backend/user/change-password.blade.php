@extends('backend/layout/layout')
@section('content')

<div class="container">
    {!! Form::open(array('action' => '\Fully\Http\Controllers\Admin\UserController@updatePassword)) !!}

    <legend>Cập nhật mật khẩu</legend>
    
    <!--Current Password-->
    <div class="control-group {!! $errors->has('currentPassword') ? 'has-error' : '' !!}">
        <label class="control-label" for="currentPassword">Mật khẩu hiện tại</label>

        <div class="controls">
            {!! Form::password(currentPassword, array('class'=>'form-control', 'placeholder'=>'Mật khẩu hiện tại')) !!}
            @if ($errors->first('currentPassword'))
            <span class="help-block">{!! $errors->first('currentPassword') !!}</span>
            @endif
        </div>
    </div>
    <br>
    <!-- Password -->
    <div class="control-group {!! $errors->has('newPassword') ? 'has-error' : '' !!}">
        <label class="control-label" for="newPassword">Mật khẩu mới</label>

        <div class="controls">
            {!! Form::password('newPassword', array('class'=>'form-control', 'id' => 'newPassword', 'placeholder'=>'Mật khẩu', 'value'=>Input::old('newPassword'))) !!}
            @if ($errors->first('newPassword'))
            <span class="help-block">{!! $errors->first('newPassword') !!}</span>
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
    <!-- Form actions -->
    {!! Form::submit('Xác nhận', array('class' => 'btn btn-success')) !!}
    <a href="{!! url('/'.getLang().'/admin/user') !!}"
       class="btn btn-default">
        &nbsp;Hủy
    </a>
    {!! Form::close() !!}
</div>
@stop