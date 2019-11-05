<!DOCTYPE html>
<html lang="fa-IR" dir="rtl">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="author" content="justCodeLife">
    <title>مرکز دانلود دانشگاه گنبد کاووس</title>
    <!-- Icons -->
    <link href="{{ asset('css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/simple-line-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('dest/style.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/sweetalert2.min.css') }}">
    <script src="{{ asset('js/jquery-3.4.1.min.js') }}"></script>
    <script src="{{ asset('js/sweetalert2.all.min.js') }}"></script>
</head>

<body class="navbar-fixed sidebar-nav fixed-nav">
<header class="navbar">
    <div class="container-fluid bg-primary">
        <button class="navbar-toggler mobile-toggler hidden-lg-up" type="button">&#9776;</button>
        <a class="navbar-brand" style="font-size: 15px !important;" href="#">دانشگاه گنبد کاووس</a>
        <ul class="nav navbar-nav hidden-md-down">
            <li class="nav-item">
                <a class="nav-link navbar-toggler layout-toggler" href="#">&#9776;</a>
            </li>

        </ul>
        <ul class="nav navbar-nav pull-lg-right pull-md-right pull-xs-right">

            @if ( Auth::check() )
                <li class="nav-item">
                    <b> خوش آمدید {{ Auth::user()->name }}</b>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('logout') }}">خروج</a>
                </li>
                <li class="nav-item">
                </li>
            @else
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}">ورود</a>
                </li>
                <li class="nav-item">
                </li>
            @endif
        </ul>
    </div>
</header>
<div class="sidebar">
    <nav class="sidebar-nav">
        <ul class="nav">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('client_index') }}"><i class="icon-home"></i>صفحه اصلی</a>
            </li>
            @can('نمایش داشبورد')
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('home') }}"><i class="icon-speedometer"></i>داشبورد</a>
                </li>
            @endcan
            @can('نمایش مدیران')
                <li class="nav-title">
                    مدیران
                </li>
            @endcan
            <li class="nav-item">
                @can('نمایش مدیران')
                    <a class="nav-link" href="{{ route('users_index') }}"><i class="icon-people"></i> لیست مدیران</a>
                @endcan
                @can('افزودن مدیر')
                    <a class="nav-link" href="{{ route('users_add') }}"><i class="icon-user-follow"></i> افزودن مدیر</a>
                @endcan
            </li>
            @can('نمایش فایل ها')
                <li class="nav-title">
                    مدیریت فایل ها
                </li>
            @endcan
            <li class="nav-item">
                @can('نمایش فایل ها')
                    <a class="nav-link" href="{{ route('files_index') }}"><i class="icon-docs"></i> لیست فایل ها</a>
                @endcan
                @can('افزودن فایل')
                    <a class="nav-link" href="{{ route('files_add') }}"><i class="icon-doc"></i> افزودن فایل </a>
                @endcan
            </li>

            @can('نمایش دسته بندی ها')
                <li class="nav-title">
                    مدیریت دسته بندی ها
                </li>
            @endcan
            <li class="nav-item">
                @can('نمایش دسته بندی ها')
                    <a class="nav-link" href="{{ route('categories_index') }}"><i class="icon-docs"></i> لیست دسته بندی
                        ها</a>
                @endcan
                @can('افزودن دسته بندی')
                    <a class="nav-link" href="{{ route('categories_add') }}"><i class="icon-doc"></i> افزودن دسته بندی
                    </a>
                @endcan
            </li>
        </ul>
    </nav>
</div>
<main class="main">

    <ol class="breadcrumb">
        <li class="breadcrumb-item">خانه</li>
        <li class="breadcrumb-item"><a href="#">مدیریت</a>
        </li>
        <li class="breadcrumb-item active">@yield('breadcrumb')</li>

        @yield('search')

    </ol>

    <div class="container-fluid">
        <div class="animated fadeIn">
            @yield('content')
        </div>

    </div>
</main>

<footer class="footer">
        <span class="pull-right">
            <a href="http://www.gonbad.ac.ir"> Gonbad HFS </a>&copy; 2019 - Powered by <strong>@justCodeLife</strong>
        </span>
</footer>
<script src="{{ asset('js/bootstrap.js') }}"></script>
<script src="{{ asset('js/app.js') }}"></script>
@yield('scripts')
</body>

</html>
