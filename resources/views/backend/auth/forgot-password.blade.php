<!DOCTYPE html>
<html>
    <head>
        <title>Alberta CMS</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta charset="utf-8">
        <!-- CSS are placed here -->
        <!--        {!! HTML::style('assets/bootstrap/css/backend_bootstrap.css') !!}-->
        <!--{!! HTML::style('assets/bootstrap/css/signin.css') !!}-->
        <!--{!! HTML::style("assets/css/github-right.css") !!}-->
        <style>
            .forgot-form h1{
                color: #000;
                font-size: 40px;
            }
            .forgot-form h5{
                color: #000;
                font-size: 20px;
            }
            .forgot-form .input-email{
                height: 40px;
                width: 240px;
                padding: 12px;
                border: 1px solid #ccc;
                border-radius: 4px;
                box-sizing: border-box;
                resize: vertical;
                margin-bottom: 15px
            }
            .forgot-form .btn-forgot{
                background-color: #4CAF50;
                color: white;
                padding: 12px 20px;
                border: none;
                border-radius: 4px;
                cursor: pointer;
                margin-left: 140px; 
            }
        </style>
    </head>

    <body>
        <div class="container">
            <div class="row">
                <div class="forgot-form" style="text-align: center" class="col-md-4 col-md-offset-4">
                    <h1>Alberta CMS</h1>

                    <div class="panel panel-default">
                        <div class="panel-body">
                            <h5 class="text-center"><b>{{ trans('fully.auth_forgot') }}</b></h5>
                            {!! Form::open(array('class' => 'form-signup', 'id' => 'form-signin')) !!}

                            @if ($errors->has('forgot-password'))
                            <div class="alert alert-danger">
                                <a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>{!! $errors->first('forgot-password', ':message') !!}
                            </div>
                            @endif

                            @if ($errors->has('email'))
                            <div class="alert alert-danger">
                                <a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>{!! $errors->first('email', ':message') !!}
                            </div>
                            @endif

                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span>
                                    </span>
                                    {!! Form::text('email', null,array('class' => 'form-control input-email', 'placeholder'=> trans('fully.auth_email'), 'autofocus'=>'')) !!}
                                </div>
                            </div>

                            {!! Form::submit(trans('fully.save'), array('class' => 'btn btn-forgot', 'role'=>'button')) !!}
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
