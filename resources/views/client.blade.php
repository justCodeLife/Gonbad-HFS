<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <title>مرکز دانلود دانشگاه گنبد کاووس</title>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap-rtl.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sweetalert2.min.css') }}">
    <link disabled id="dark-reader" rel="stylesheet" href="{{ asset('css/dark.css') }}">
    <script src="{{ asset('js/jquery-3.4.1.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.bundle.js') }}"></script>
    <script src="{{ asset('js/sweetalert2.all.min.js') }}"></script>

    <style>
        .dropdown-content a {
            color: #fff;
            text-decoration: none;
            transition: 0.25s linear;
        }

        .dropdown-content a:hover {
            color: #656565;
            text-decoration: none;
        }

        .dropdown:hover {
            display: block;
        }

        .card-body a {
            color: #1b1e21;
            text-decoration: none;

        }

        .card-body a:hover {
            color: #2f3134;
            text-decoration: none;

        }

        .card-header button {
            text-decoration: none;
            color: #1b1e21;
        }

        .card-header button:hover {
            text-decoration: none;
        }

        .ul-list li a {
            color: #1b1e21;
            text-decoration: none;
            list-style: none;
        }

        .ul-list li {
            padding: 10px;
            list-style: none;

        }

    </style>
</head>
<body style="background-color: ghostwhite">

<section style="background:transparent" class="container">

    <section class="shadow rounded">
        <nav dir="rtl" class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="http://gonbad.ac.ir">سایت دانشگاه</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="http://erp.gonbad.ac.ir">پورتال دانشجویان</a>
                    </li>
                    <li class="nav-item">
                        <a id="btnTheme" class="nav-link" href="javascript:void(0)"
                           onclick="dark_toggle();return false;">تم تاریک</a>
                    </li>
                </ul>
                <form action="/search" method="get" class="form-inline my-2 my-lg-0">
                    @csrf
                    <input name="search" class="form-control mr-sm-2 rounded-pill" type="search" placeholder="جستجو..."
                           aria-label="Search" value="{{ old('search',isset($searchTerm) ? $searchTerm : '') }}"
                           maxlength="50">
                    <button class="btn btn-outline-primary my-2 my-sm-0 rounded-pill" type="submit">جستجو</button>
                </form>
            </div>
        </nav>
        <header>
            <section class="row">
                <img class="m-5 pl-5" src="{{ asset('img/back.png') }}">
                <img class="my-5 py-5" style="width: 50%" src="{{ asset('img/logo2.png') }}">
            </section>
        </header>
    </section>

    <div style="padding: 30px;"></div>
    <section>

        <div class="container-fluid">

            <div class="row">
                <div class="col-md-9">

                    <div id="filemanager" class="shadow rounded card mb-3">


                        <form action="/download" method="post" id="downloadForm">
                            @csrf
                            <div class="card-header text-right">
                                <div class="row">
                                    <button type="submit" id="downloadSelected" class="btn btn-link btn-sm">دانلود فایل
                                        های انتخاب شده
                                    </button>
                                    <div class="text-center col">
                                        آخرین فایل ها
                                    </div>
                                    <a id="selectNone" class="btn btn-link btn-sm">هیچکدام</a>
                                    /
                                    <a id="selectAll" class="btn btn-link btn-sm">انتخاب همه</a>
                                </div>
                            </div>
                            <div class="card-body text-secondary">
                                @if (isset($files))
                                    @if ($files && count($files)>0)
                                        @foreach ($files as $file)

                                            <div class="card mb-3">
                                                <div class="row">
                                                    <div class="col-md-5 p-5">
                                                        <img class="img-thumbnail"
                                                             src="{{ asset('/uploads/'.$file->file_image) }}" alt="">
                                                    </div>
                                                    <div class="col-md-7 rtl">
                                                        <div class="card-block px-3 pt-4">
                                                            <h4 class="card-title">{{ $file->file_name }}</h4>
                                                            <div
                                                                class="card-text my-3 d-flex align-items-center justify-content-between">
                                                                <small>دسته بندی
                                                                    : {{ isset($file->category->name)?$file->category->name:'نامشخص' }}</small>
                                                                <small> نوع فایل : {{ $file->file_type }}</small>
                                                                <small class="ml-4">آپلود کننده
                                                                    : {{ $file->uploader_name }}</small>
                                                            </div>
                                                            <p class="card-text my-3">{{ $file->file_description }}</p>
                                                            <div
                                                                class="card-text my-3 d-flex align-items-center justify-content-between">
                                                                <small>تاریخ
                                                                    : {{ \Carbon\Carbon::parse(jdate($file->created_at))->format('Y/m/d')}}</small>
                                                                <small>حجم : {{ $file->file_size }} مگابایت</small>
                                                                <a href="{{ asset('/uploads/'.$file->file_url) }}"
                                                                   class="text-white btn btn-primary mt-2">دانلود</a>
                                                            </div>
                                                            <label class="switch switch-3d switch-primary">
                                                                <input name="downloadFiles[]" type="checkbox"
                                                                       class="switch-input" value="{{ $file->id }}">
                                                                <span class="switch-label"></span>
                                                                <span class="switch-handle"></span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        @endforeach
                                    @elseif(count($files)==0)
                                        <p class="text-center">هیچ فایلی وجود ندارد</p>
                                    @endif
                                @endif

                            </div>
                        </form>
                    </div>
                </div>

                <div class="col-md-3 text-center">

                    <div style="width:100%" class="shadow rounded card mb-3 accordion">
                        <div class="card-header text-center">دسته بندی ها</div>

                        @if (isset($categories))
                            @if ($categories && count($categories)>0)
                                @foreach ($categories as $cat)
                                    <div class="card">
                                        <div class="text-secondary">
                                            <a class="btn btn-link" href="/get_cat_files/{{ $cat->id }}">
                                                {{ $cat->name }}
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            @elseif(count($categories)==0)
                                <div class="card">
                                    <div class="text-secondary">
                                        <p>هیچ دسته بندی وجود ندارد</p>
                                    </div>
                                </div>
                            @endif
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </section>

    @if (isset($files))
        @if ($files->lastPage() > 1)
            <nav>
                <ul class="pagination">
                    <li class="page-item {{ ($files->currentPage() == 1) ? ' disabled' : '' }}"><a
                            class="page-link" href="{{ $files->url(1) }}">قبلی</a>
                    </li>
                    @for ($i = 1; $i <= $files->lastPage(); $i++)
                        <li class="page-item {{ ($files->currentPage() == $i) ? ' active' : '' }}">
                            <a class="page-link" href="{{ $files->url($i) }}">{{ $i }}</a>
                        </li>
                    @endfor
                    <li class="page-item {{ ($files->currentPage() == $files->lastPage()) ? ' disabled' : '' }}">
                        <a class="page-link"
                           href="{{ $files->url($files->currentPage()+1) }}">بعدی</a>
                    </li>
                </ul>
            </nav>
        @endif
    @endif

</section>
<script>
    $('#selectAll').click(function (event) {
        $(':checkbox').each(function () {
            this.checked = true;
        });
    });

    $('#selectNone').click(function (event) {
        $(':checkbox').each(function () {
            this.checked = false;
        });
    });
</script>
<script>
    function dark_toggle() {
        var el1 = document.getElementById("dark-reader");
        var el2 = document.getElementById("btnTheme");
        if (el1.disabled) {
            el1.disabled = false;
            el2.text = "تم روشن";
            localStorage.setItem("darkreader", "enabled");
        } else {
            el1.disabled = true;
            el2.text = "تم تاریک";
            localStorage.setItem("darkreader", "disabled");
        }
    }

    if (localStorage.getItem("darkreader") == "enabled") {
        document.getElementById("dark-reader").disabled = false;
        document.getElementById("btnTheme").text = "تم روشن";
    } else {
        document.getElementById("dark-reader").disabled = true;
        document.getElementById("btnTheme").text = "تم تاریک";
    }
</script>
<script>
    $('#downloadForm').submit(function () {
        let count = 0;
        var checkboxes = document.getElementsByName('downloadFiles[]');
        for (var i = 0, n = checkboxes.length; i < n; i++) {
            if (checkboxes[i].checked) {
                count++;
            }
        }
        if (count < 1) {
            Swal.fire({
                type: 'error',
                title: 'خطا',
                text: 'لطفا برای دانلود حداقل یک فایل را انتخاب کنید',
                confirmButtonText: 'باشه'
            });
            return false;
        }
    });

    $('#select-all').click(function (event) {
        $(':checkbox').each(function () {
            this.checked = true;
        });
    });

    $('#select-none').click(function (event) {
        $(':checkbox').each(function () {
            this.checked = false;
        });
    });
</script>
<small style="color: darkgray" class="fixed-bottom ml-2"> Gonbad-HFS &copy; 2019 - by @justCodeLife</small>
</body>
</html>
