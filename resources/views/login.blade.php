<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Login</title>
    <link href="{{ asset('css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/simple-line-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('dest/style.css') }}" rel="stylesheet">
</head>

<body class="">
<div class="container">
    <div class="row">
        <div class="col-md-8 m-x-auto pull-xs-none vamiddle"
             style="box-shadow: 0 12px 24px 0 rgba(0, 0, 0, 0.4), 0 18px 60px 0 rgba(0, 0, 0, 0.3);">
            <div class="card-group">
                <div class="card p-a-2">
                    <div class="card-block">
                        <form action="/login" method="post">
                            @csrf
                            <h1>ورود</h1>
                            <p class="text-muted">وارد حساب کاربری خود شوید</p>
                            <div class="input-group m-b-1">
                                <span class="input-group-addon"><i class="icon-user"></i>
                                </span>
                                <input name="username" id="username" type="text" class="form-control en"
                                       placeholder="نام کاربری" required autofocus maxlength="50">
                            </div>
                            <div class="input-group m-b-2">
                                <span class="input-group-addon"><i class="icon-lock"></i>
                                </span>
                                <input type="password" name="password" id="password" class="form-control en"
                                       placeholder="رمز ورود" required maxlength="50">
                            </div>
                            <div class="row pull-left">
                                <div class="col-xs-6">
                                    <button type="submit" class="btn btn-primary p-x-2">
                                        <i class="icon-login"></i>
                                        ورود
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    @if(session('loginError'))
                        <div class="alert alert-danger">
                            <p>
                                {{ session('loginError')  }}
                            </p>
                        </div>
                    @endif
                </div>
                <div id="uni" class="card card-inverse card-primary" style="width:44%">
                    <div class="card-block text-xs-center">
                        <div>
                            <img src="img/logo.png" alt="logo" style="width: 45%;height: 80%">
                        </div>
                        <b style="color: black">Gonbad HFS</b>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('js/jquery-3.4.1.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.js') }}"></script>
<script>
    function verticalAlignMiddle() {
        var bodyHeight = $(window).height();
        var formHeight = $('.vamiddle').height();
        var marginTop = (bodyHeight / 2) - (formHeight / 2);
        if (marginTop > 0) {
            $('.vamiddle').css('margin-top', marginTop);
        }
    }

    $(document).ready(function () {
        verticalAlignMiddle();
    });
    $(window).bind('resize', verticalAlignMiddle);
</script>
</body>

</html>
