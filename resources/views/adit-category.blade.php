@extends('_layout')
@section('breadcrumb')
    دسته بندی ها
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
                            <label class="col-md-3 form-control-label" for="name">نام دسته بندی</label>
                            <div class="col-md-9">
                                <input type="text" id="name" name="name" class="form-control"
                                       placeholder="لطفا نام دسته بندی را وارد نمایید" maxlength="50" required
                                       value="{{ old('name',isset($category) ? $category->name : '') }}">
                                {{--                                <span class="small text-danger">لطفا نام دسته بندی را وارد نمایید</span>--}}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 form-control-label" for="description">توضیحات</label>
                            <div class="col-md-9">
                                <input type="text" id="description" name="description" class="form-control"
                                       placeholder="لطفا توضیحات را وارد نمایید" maxlength="50" required
                                       value="{{ old('description',isset($category) ? $category->description : '') }}">
                                {{--                                <span class="small text-danger">لطفا توضیحات را وارد نمایید</span>--}}
                            </div>
                        </div>

                        <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-dot-circle-o"></i>
                            {{ $panel_title }}
                        </button>
                        <button type="reset" class="btn btn-sm btn-danger"><i class="fa fa-ban"></i> ریست</button>
                    </form>
                </div>

            </div>

        </div>
    </div>
    <!--/row-->
@endsection
