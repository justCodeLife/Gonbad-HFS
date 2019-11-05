@extends('_layout')
@section('breadcrumb')
    فایل ها
@endsection
@section('search')
    <li class="breadcrumb-menu">
        <form action="/admin/files/search" method="get">
            @csrf
            <div class="input-group no-border p-t-1">
                <input name="search" type="text" value="{{ old('search',isset($searchTerm) ? $searchTerm : '') }}"
                       class="form-control" placeholder="جستجو..." maxlength="50">
            </div>
        </form>
    </li>
@endsection

@section('content')

    <div class="row">

        <div class="col-lg-12">
            <div class="card">
                <div class="card-header bg-primary">
                    <i class="fa fa-align-justify"></i> جدول فایل ها
                </div>
                <div class="card-block">
                    @include('errors')
                    <div style="height:400px;overflow: auto">
                        @if ($file && count($file)>0)
                            <table class="table table-bordered table-striped table-condensed">
                                <thead>
                                <tr>
                                    <th>عنوان فایل</th>
                                    <th>نوع فایل</th>
                                    <th>توضیحات</th>
                                    <th>حجم فایل</th>
                                    <th>دسته بندی</th>
                                    <th>آپلود کننده</th>
                                    <th>تاریخ اضافه شدن</th>
                                    <th>نمایش</th>
                                    @canany(['ویرایش فایل','حذف فایل','دانلود فایل'])
                                        <th>عملیات</th>
                                    @endcanany
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($file as $fi)
                                    <tr>
                                        <td>{{ $fi->file_name }}</td>
                                        <td>{{ $fi->file_type }}</td>
                                        <td data-toggle="tooltip" data-placement="top"
                                            title="{{ $fi->file_description }}">{{ $fi->file_description }}</td>
                                        <td>{{ $fi->file_size }} مگابایت</td>
                                        <td>{{ isset(App\File::find($fi->id)->category->name) ? App\File::find($fi->id)->category->name : 'نامشخص'  }}</td>
                                        <td>{{ $fi->uploader_name }}</td>
                                        <td>{{ jdate($fi->created_at) }}</td>
                                        <td>{{ $fi->visibility==1 ? 'بله' : 'خیر' }}</td>
                                        <td>
                                            @can('ویرایش فایل')
                                                <a class="btn btn-warning"
                                                   href="/admin/files/edit/{{ $fi->id }}">ویرایش</a>
                                            @endcan
                                            {{--                                            <a class="btn btn-danger" href="/admin/files/delete/{{ $fi->id }}">حذف</a>--}}
                                            @can('حذف فایل')
                                                <a data-id="{{ $fi->id }}" class="btn btn-danger delete"
                                                   href="#">حذف</a>
                                            @endcan
                                            @can('دانلود فایل')
                                                <a class="btn btn-primary"
                                                   href="{{ asset('/uploads/'.$fi->file_url) }}">دانلود</a>
                                            @endcan
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        @elseif(count($file)==0)
                            <p class="text-right">هیچ فایلی وجود ندارد</p>
                        @endif
                    </div>

                    @if ($file->lastPage() > 1)
                        <nav>
                            <ul class="pagination">
                                <li class="page-item {{ ($file->currentPage() == 1) ? ' disabled' : '' }}"><a
                                        class="page-link" href="{{ $file->url(1) }}">قبلی</a>
                                </li>
                                @for ($i = 1; $i <= $file->lastPage(); $i++)
                                    <li class="page-item {{ ($file->currentPage() == $i) ? ' active' : '' }}">
                                        <a class="page-link" href="{{ $file->url($i) }}">{{ $i }}</a>
                                    </li>
                                @endfor
                                <li class="page-item {{ ($file->currentPage() == $file->lastPage()) ? ' disabled' : '' }}">
                                    <a class="page-link"
                                       href="{{ $file->url($file->currentPage()+1) }}">بعدی</a>
                                </li>
                            </ul>
                        </nav>
                    @endif
                </div>
            </div>
        </div>
        <!--/col-->

    </div>
    @can('حذف فایل')
        <script>
            $('.btn.btn-danger.delete').click(function () {
                var fileID = $(this).data('id');
                Swal.fire({
                    title: 'آیا از حذف این فایل اطمینان دارید؟',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'بله ، حذف بشه',
                    cancelButtonText: 'خیر'
                }).then((result) => {
                    if (result.value) {
                        Swal.fire({
                            title: 'حذف شد !',
                            confirmButtonText: 'باشه'
                        }).then(function () {
                            window.location.href = "/admin/files/delete/" + fileID;
                        });
                    }
                })
            });
        </script>
    @endcan
@endsection
