<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>login</title>
    <!-- Bootstrap core CSS-->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom fonts for this template-->
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <!-- Custom styles for this template-->
    <link href="css/sb-admin.css" rel="stylesheet">
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

    <style>
        body {
            background-color: white;
            color: #636b6f;
            /*  font-family: 'Raleway', sans-serif;*/
            font-weight: 100;
            height: 100vh;
        }

        .help-block {
            color: red;
            font-weight: bold;
        }

        label {
            font-weight: bold;
        }

        .card-header {
            font-size: 28px;
        }
    </style>
</head>

<body class="bg-dark">
    <div class="container">
        <div class="card card-login mx-auto mt-5">
            <div class="card-header">Connexion</div>
            <div class="card-body">
                <div id="div2">
                    <button type="submit" class="btn btn-primary btn-block"><a style="color:white; text-decoration:none;" href="http://localhost:3000/login?token=IM00002&platformName=XCSM&redirectUrl=http://localhost:8000/traitement-login">Se connecter avec IntraneAuth</a></button>
                    <button type="submit" class="btn btn-primary btn-block"><a style="color:white; text-decoration:none;" href="http://localhost:3000/register?token=IM00002&platformName=XCSM&redirectUrl=http://localhost:8000/traitement-register">Commencer l'inscription sur IntraneAuth</a></button>
                </div>
            </div>
        </div>
    </div>
    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
</body>

</html>


@section('body')
<div class="connectbody">

    <div class="login-box afterbody">
        <div id="inter">
            <div class="login-logo">
                <!--            {{--<a href="{{ url(config('adminlte.dashboard_url', 'home')) }}">{!! config('adminlte.logo', '<b>XCSM</b>MODULE') !!}</a>--}}-->
                <a href="#">
                    <!-- logo for regular state and mobile devices -->
                    <span class="mylogo">Connection au module XCSM </span>
                </a>
            </div>
            <!-- /.login-logo -->
            <div class="login-box-body box-login">
                <p class="login-box-msg"> {{ trans('adminlte::adminlte.login_message') }}</p>
                <form action="{{ url(config('adminlte.login_url', 'login')) }}" method="post">
                    {!! csrf_field() !!}

                    <div class="form-group has-feedback {{ $errors->has('email') ? 'has-error' : '' }}">
                        <input type="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="{{ trans('adminlte::adminlte.email') }}">
                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                        @if ($errors->has('email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                        @endif
                    </div>
                    <div class="form-group has-feedback {{ $errors->has('password') ? 'has-error' : '' }}">
                        <input type="password" name="password" class="form-control" placeholder="{{ trans('adminlte::adminlte.password') }}">
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                        @if ($errors->has('password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                        @endif
                    </div>
                    <div class="row">
                        <div class="col-xs-8">
                            <div class="checkbox icheck">
                                <label>
                                    <input class="input" type="checkbox" name="remember">

                                    {{ trans('adminlte::adminlte.remember_me') }}
                                </label>
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-xs-4">
                            <button type="submit" class="conbutton btn  bg-navy  margin ">

                                {{ trans('adminlte::adminlte.sign_in') }}
                            </button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>
                <div class="auth-links">
                    <!--                <a href="{{ url(config('adminlte.password_reset_url', 'password/reset')) }}"-->
                    <!--                   class="text-center"-->
                    <!--                >{{ trans('adminlte::adminlte.i_forgot_my_password') }}</a>-->
                    <br>
                    @if (config('adminlte.register_url', 'register'))
                    <a href="{{ url(config('adminlte.register_url', 'register')) }}" class="register text-center">
                        <!--                        Nouvel utilisateur-->
                        {{ trans('adminlte::adminlte.register_a_new_membership') }}
                    </a>
                    @endif
                </div>
            </div>
            <!-- /.login-box-body -->
        </div><!-- /.login-box -->
    </div>
</div>
@stop
<!--@section('css')-->
<!---->