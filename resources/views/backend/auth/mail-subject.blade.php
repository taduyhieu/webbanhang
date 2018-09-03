<div class="container">
    {!! Form::open() !!}
    <div class="row">
        <div class="col-md-12">
            {!! Form::label( trans('fully.auth_e') ) !!}:
            {!! $email !!}
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            {!! Form::label( trans('fully.auth_reset') ) !!}:
            {!! $resetCode !!}
        </div>
    </div>
    {!! Form::close() !!}
</div>