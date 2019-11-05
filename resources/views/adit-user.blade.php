@extends('_layout')
@section('breadcrumb')
    مدیران
@endsection
@section('content')
    <div class="row">

        <div class="col-md-9">
            <div class="card">
                <div class="card-header bg-primary">
                    {{ $panel_title }}
                </div>
                <div class="card-block">
                    <form action="" method="POST" class="form-horizontal ">
                        @csrf
                        @include('errors')
                        <div class="form-group row">
                            <label class="col-md-3 form-control-label" for="name">نام</label>
                            <div class="col-md-9">
                                <input type="text" id="name" name="name" class="form-control"
                                       placeholder="لطفا نام مدیر را وارد نمایید" maxlength="50" required
                                       value="{{ old('name',isset($user) ? $user->name : '') }}">
                                {{--                                <span class="small text-danger">لطفا نام خود را وارد نمایید</span>--}}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 form-control-label" for="email">ایمیل</label>
                            <div class="col-md-9">
                                <input type="email" id="email" name="email" class="form-control"
                                       placeholder="لطفا ایمیل مدیر را وارد نمایید" maxlength="50" required
                                       value="{{ old('email',isset($user) ? $user->email : '') }}">
                                {{--                                <span class="small text-danger">لطفا ایمیل خود را وارد نمایید</span>--}}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 form-control-label" for="username">نام کاربری</label>
                            <div class="col-md-9">
                                <input type="text" id="username" name="username" class="form-control"
                                       placeholder="لطفا نام کاربری مدیر را وارد نمایید" maxlength="50" required
                                       value="{{ old('username',isset($user) ? $user->username : '') }}">
                                {{--                                <span class="small text-danger">لطفا نام کاربری خود را وارد نمایید</span>--}}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 form-control-label" for="password">رمز عبور</label>
                            <div class="col-md-9">
                                <input type="password" id="password" name="password" class="form-control" maxlength="50"
                                       @if (!isset($edit)) placeholder="لطفا رمز عبور مدیر را وارد نمایید ( حداقل ۴ رقم )"
                                       required @endif>
                                @if (isset($edit))
                                    <small class="text-warning">در صورت عدم تمایل به تغییر این فیلد را خالی
                                        بگزارید</small>
                                @endif                            </div>
                        </div>
                        {{--                        <div class="form-group row">--}}
                        {{--                            <label class="col-md-3 form-control-label" for="role">نقش</label>--}}
                        {{--                            <div class="col-md-9">--}}
                        {{--                                <select autocomplete="off" id="role" name="role" class="form-control"--}}
                        {{--                                        size="1">--}}
                        {{--                                    <option--}}
                        {{--                                        value="1" {{ isset($user) ? old('role',$user->role == 1 ? 'selected' : '') : '' }}>--}}
                        {{--                                        مدیر--}}
                        {{--                                    </option>--}}
                        {{--                                    <option--}}
                        {{--                                        value="2" {{ isset($user) ? old('role',$user->role == 2 ? 'selected' : '') : '' }}>--}}
                        {{--                                        آپلود کننده--}}
                        {{--                                    </option>--}}
                        {{--                                </select>--}}
                        {{--                            </div>--}}
                        {{--                        </div>--}}

                        <div class="form-group row">

                            <label class="col-md-3 form-control-label">دسترسی ها</label>

                            <div class="col-md-9">

                                <div class="row col-md-12">
                                    <div class="col-md-3 px-5">
                                        <div class="form-check d-flex justify-content-between my-3">
                                            <label class="form-check-label">
                                                <input id="users" name="users" class="form-check-input" type="checkbox"
                                                       value="" {{ old('users' ? 'checked' : '') }}>
                                            </label>
                                            <strong>مدیران</strong>
                                        </div>
                                        <div class="form-check d-flex justify-content-between my-3">
                                            <label class="form-check-label">
                                                <input id="view_users" name="view_users" class="form-check-input users"
                                                       type="checkbox"
                                                       value="" {{ old('view_users',isset($user) && $user->hasPermissionTo('نمایش مدیران') ? 'checked' : '') }}>
                                            </label>
                                            <span class="small">نمایش</span>
                                        </div>
                                        <div class="form-check d-flex justify-content-between my-3">
                                            <label class="form-check-label">
                                                <input id="add_user" name="add_user" class="form-check-input users"
                                                       type="checkbox"
                                                       value="" {{ old('add_user',isset($user) && $user->hasPermissionTo('افزودن مدیر') ? 'checked' : '') }}>
                                            </label>
                                            <span class="small">افزودن</span>
                                        </div>
                                        <div class="form-check d-flex justify-content-between my-3">
                                            <label class="form-check-label">
                                                <input id="edit_user" name="edit_user" class="form-check-input users"
                                                       type="checkbox"
                                                       value="" {{ old('edit_user',isset($user) && $user->hasPermissionTo('ویرایش مدیر') ? 'checked' : '') }}>
                                            </label>
                                            <span class="small">ویرایش</span>
                                        </div>
                                        <div class="form-check d-flex justify-content-between my-3">
                                            <label class="form-check-label">
                                                <input id="delete_user" name="delete_user"
                                                       class="form-check-input users"
                                                       type="checkbox"
                                                       value="" {{ old('delete_user',isset($user) && $user->hasPermissionTo('حذف مدیر') ? 'checked' : '') }}>
                                            </label>
                                            <span class="small">حذف</span>
                                        </div>
                                    </div>
                                    <div class="col-md-3 px-5">
                                        <div class="form-check d-flex justify-content-between my-3">
                                            <label class="form-check-label">
                                                <input id="files" name="files" class="form-check-input"
                                                       type="checkbox" value="" {{ old('files' ? 'checked' : '') }}>
                                            </label>
                                            <strong>فایل ها</strong>
                                        </div>
                                        <div class="form-check d-flex justify-content-between my-3">
                                            <label class="form-check-label">
                                                <input id="view_files" name="view_files"
                                                       class="form-check-input files"
                                                       type="checkbox"
                                                       value="" {{ old('view_files',isset($user) && $user->hasPermissionTo('نمایش فایل ها') ? 'checked' : '') }}>
                                            </label>
                                            <span class="small">نمایش</span>
                                        </div>
                                        <div class="form-check d-flex justify-content-between my-3">
                                            <label class="form-check-label">
                                                <input id="add_file" name="add_file" class="form-check-input files"
                                                       type="checkbox"
                                                       value="" {{ old('add_file',isset($user) && $user->hasPermissionTo('افزودن فایل') ? 'checked' : '') }}>
                                            </label>
                                            <span class="small">افزودن</span>
                                        </div>
                                        <div class="form-check d-flex justify-content-between my-3">
                                            <label class="form-check-label">
                                                <input id="edit_file" name="edit_file"
                                                       class="form-check-input files"
                                                       type="checkbox"
                                                       value="" {{ old('edit_file',isset($user) && $user->hasPermissionTo('ویرایش فایل') ? 'checked' : '') }}>
                                            </label>
                                            <span class="small">ویرایش</span>
                                        </div>
                                        <div class="form-check d-flex justify-content-between my-3">
                                            <label class="form-check-label">
                                                <input id="delete_file" name="delete_file"
                                                       class="form-check-input files"
                                                       type="checkbox"
                                                       value="" {{ old('delete_file',isset($user) && $user->hasPermissionTo('حذف فایل') ? 'checked' : '') }}>
                                            </label>
                                            <span class="small">حذف</span>
                                        </div>
                                    </div>
                                    <div class="col-md-3 px-5">
                                        <div class="form-check d-flex justify-content-between my-3">
                                            <label class="form-check-label">
                                                <input id="categories" name="categories" class="form-check-input"
                                                       type="checkbox"
                                                       value="" {{ old('categories' ? 'checked' : '') }}>
                                            </label>
                                            <strong>دسته بندی ها</strong>
                                        </div>
                                        <div class="form-check d-flex justify-content-between my-3">
                                            <label class="form-check-label">
                                                <input id="view_categories" name="view_categories"
                                                       class="form-check-input categories"
                                                       type="checkbox"
                                                       value="" {{ old('view_categories',isset($user) && $user->hasPermissionTo('نمایش دسته بندی ها') ? 'checked' : '') }}>
                                            </label>
                                            <span class="small">نمایش</span>
                                        </div>
                                        <div class="form-check d-flex justify-content-between my-3">
                                            <label class="form-check-label">
                                                <input id="add_category" name="add_category"
                                                       class="form-check-input categories"
                                                       type="checkbox"
                                                       value="" {{ old('add_category',isset($user) && $user->hasPermissionTo('افزودن دسته بندی') ? 'checked' : '') }}>
                                            </label>
                                            <span class="small">افزودن</span>
                                        </div>
                                        <div class="form-check d-flex justify-content-between my-3">
                                            <label class="form-check-label">
                                                <input id="edit_category" name="edit_category"
                                                       class="form-check-input categories"
                                                       type="checkbox"
                                                       value="" {{ old('edit_category',isset($user) && $user->hasPermissionTo('ویرایش دسته بندی') ? 'checked' : '') }}>
                                            </label>
                                            <span class="small">ویرایش</span>
                                        </div>
                                        <div class="form-check d-flex justify-content-between my-3">
                                            <label class="form-check-label">
                                                <input id="delete_category" name="delete_category"
                                                       class="form-check-input categories" type="checkbox"
                                                       value="" {{ old('delete_category',isset($user) && $user->hasPermissionTo('حذف دسته بندی') ? 'checked' : '') }}>
                                            </label>
                                            <span class="small">حذف</span>
                                        </div>
                                    </div>
                                    <div class="col-md-3 px-5">
                                        <div class="form-check d-flex justify-content-between">
                                            <label class="form-check-label">
                                                <input id="view_dashboard" name="view_dashboard"
                                                       class="form-check-input dashboard"
                                                       type="checkbox"
                                                       value="" {{ old('view_dashboard',isset($user) && $user->hasPermissionTo('نمایش داشبورد') ? 'checked' : '') }}>
                                            </label>
                                            <strong>نمایش داشبورد</strong>
                                        </div>
                                        <div class="form-check d-flex justify-content-between">
                                            <label class="form-check-label">
                                                <input id="download_file" name="download_file"
                                                       class="form-check-input"
                                                       type="checkbox"
                                                       value="" {{ old('download_file',isset($user) && $user->hasPermissionTo('دانلود فایل') ? 'checked' : '') }}>
                                            </label>
                                            <strong>دانلود فایل</strong>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>

                        <div>
                            <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-dot-circle-o"></i>
                                {{ $panel_title }}
                            </button>
                            <button type="reset" class="btn btn-sm btn-danger"><i class="fa fa-ban"></i> ریست</button>
                        </div>
                    </form>
                </div>

            </div>

        </div>

    </div>
    <script>
        $('#users').change(function () {
            if ($(this).is(":checked")) {
                $('.form-check-input.users').prop("checked", true);
            } else {
                $('.form-check-input.users').prop("checked", false);
            }
        });

        $('#files').change(function () {
            if ($(this).is(":checked")) {
                $('.form-check-input.files').prop("checked", true);
            } else {
                $('.form-check-input.files').prop("checked", false);
            }
        });

        $('#categories').change(function () {
            if ($(this).is(":checked")) {
                $('.form-check-input.categories').prop("checked", true);
            } else {
                $('.form-check-input.categories').prop("checked", false);
            }
        });
    </script>
@endsection
