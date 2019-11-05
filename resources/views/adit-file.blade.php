@extends('_layout')
@section('breadcrumb')
    فایل ها
@endsection
@section('content')
    <div class="row">

        <div class="col-md-9">
            <div class="card">
                <div class="card-header bg-primary">
                    {{ $panel_title }}
                </div>
                <div class="card-block">
                    @if ($categories && count($categories)>0)
                        <form id="form" action="" method="POST" enctype="multipart/form-data" class="form-horizontal ">
                            @csrf
                            <div id="error-list"></div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="file_name">نام فایل</label>
                                <div class="col-md-9">
                                    <input type="text" id="file_name" name="file_name" class="form-control"
                                           placeholder="لطفا نام فایل را وارد نمایید" maxlength="50"
                                           value="{{ old('file_name',isset($file) ? $file->file_name : '') }}">
                                    <span class="small text-warning">در صورت تمایل به ذخیره فایل با نام خودش فیلد را خالی بگزارید</span>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-3 form-control-label"
                                       for="file_description">توضیحات</label>
                                <div class="col-md-9">
                                            <textarea id="file_description" name="file_description" rows="9"
                                                      class="form-control"
                                                      placeholder="لطفا توضیحات را وارد نمایید">{{ old('file_description',isset($file) ? $file->file_description : '') }}</textarea>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="categories">دسته بندی</label>
                                <div class="col-md-9">
                                    <select autocomplete="off" id="categories" name="categories" class="form-control"
                                            size="1">
                                        @if ($categories && count($categories)>0)
                                            @foreach($categories as $cat )
                                                <option
                                                    value="{{ $cat->id  }}" {{ old('categories',isset($file) && $cat->id==$file->category_id ? "selected":"") }}>
                                                    {{ $cat->name }}
                                                </option>
                                            @endforeach
                                        @elseif(count($categories)==0)
                                            <option value="0" selected>نامشخص</option>
                                        @endif
                                    </select>

                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="image">نمایش داده شود</label>
                                <label class="switch switch-3d switch-primary">
                                    <input name="visibility" type="checkbox"
                                           {{ old('visibility',isset($file) && $file->visibility==1 ? 'checked' : '') }}
                                           class="switch-input">
                                    <span class="switch-label"></span>
                                    <span class="switch-handle"></span>
                                </label>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="image">تصویر فایل</label>
                                <div class="col-md-9">
                                    <input type="file" id="image" name="image">
                                </div>
                                <span id="upload_image" class="small text-success"></span>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-3"></div>
                                <div class="col-md-9">
                                    <small class="text-danger">حداکثر حجم مجاز برای آپلود هر فایل ۲ گیگابایت می
                                        باشد</small>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="file">آپلود فایل</label>
                                <div class="col-md-9">
                                    <input type="file" id="file" name="file">
                                </div>
                                <span id="upload_file" class="small text-success"></span>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-3"></div>
                                <div class="col-md-9">
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar" aria-valuenow=""
                                             aria-valuemin="0" aria-valuemax="100" style="width: 0%">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-dot-circle-o"></i>
                                {{ $panel_title }}
                            </button>
                            <button type="reset" class="btn btn-sm btn-danger"><i class="fa fa-ban"></i>ریست</button>
                        </form>
                    @else
                        <p class="text-right text-danger">برای افزودن فایل باید حداقل یک دسته بندی ایجاد شود</p>
                    @endif
                </div>

            </div>

        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{asset('js/jquery.form.js')}}"></script>
    <script src="{{asset('js/validation.js')}}"></script>
    <script>
        $(document).ready(function () {
            $('#form').ajaxForm({
                uploadProgress: function (event, position, total, percentComplete) {
                    $('.progress-bar').text('در حال آپلود : ' + percentComplete + '%');
                    $('.progress-bar').css('width', percentComplete + '%');
                },
                success: function (data) {
                    if (data.errors) {
                        $('.progress-bar').text('');
                        $('.progress-bar').css('width', '0%');

                        var str = "";
                        data.errors.forEach(function (error) {
                            str += '<li>' + error + '</li>'
                        });

                        $('#error-list').html('<div class="alert alert-danger"><ul>' + str + '</ul></div>');
                        $('.progress-bar').text('');
                        $('#upload_file').text('');
                        $('#upload_image').text('');
                    }
                    if (data.success) {
                        $('.progress-bar').text('آپلود شد');
                        $('.progress-bar').css('width', '100%');
                        $('#upload_image').text('');
                        $('#upload_file').text('');
                        Swal.fire(
                            'انجام شد',
                            'فایل مورد نظر با موفقیت {{ isset($edit) ? 'ویرایش' : 'اضافه' }} شد',
                            'success'
                        ).then(function () {
                            window.location.replace("/admin/files");
                        });
                    }
                },
                error: function (e) {
                    console.log(e);
                    Swal.fire({
                        type: 'error',
                        title: 'خطا',
                        text: 'افزودن فایل ناموفق بود'
                    });
                },
                resetForm: true
            });
        });

    </script>
@stop
