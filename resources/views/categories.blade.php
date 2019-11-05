@extends('_layout')
@section('breadcrumb')
    دسته بندی ها
@endsection
@section('search')
    <li class="breadcrumb-menu">
        <form action="/admin/categories/search" method="get">
            @csrf
            <div class="input-group no-border p-t-1">
                <input name="search" type="text" value="{{ old('search',isset($searchTerm) ? $searchTerm : '') }}"
                       class="form-control" placeholder="جستجو..." maxlength="50"></div>
        </form>
    </li>
@endsection

@section('content')
    <div class="row">

        <div class="col-lg-12">
            <div class="card">
                <div class="card-header bg-primary">
                    <i class="fa fa-align-justify"></i> جدول دسته بندی ها
                </div>
                <div class="card-block">
                    @include('errors')
                    <div style="height:400px;overflow: auto">
                        @if ($category && count($category)>0)
                            <table class="table table-bordered table-striped table-condensed">
                                <thead>
                                <tr>
                                    <th>نام دسته بندی</th>
                                    <th>توضیحات</th>
                                    @canany(['ویرایش دسته بندی','حذف دسته بندی'])
                                        <th>عملیات</th>
                                    @endcanany
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($category as $cat)
                                    <tr>
                                        <td>{{ $cat->name }}</td>
                                        <td data-toggle="tooltip" data-placement="top"
                                            title="{{ $cat->description }}">{{ $cat->description }}</td>
                                        <td>
                                            @can('ویرایش دسته بندی')
                                                <a class="btn btn-warning"
                                                   href="/admin/categories/edit/{{ $cat->id }}">ویرایش</a>
                                            @endcan
                                            @can('حذف دسته بندی')
                                                <a data-id="{{ $cat->id }}" class="btn btn-danger delete"
                                                   href="#">حذف</a>
                                            @endcan
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        @elseif(count($category)==0)
                            <p class="text-right">هیچ دسته بندی وجود ندارد</p>
                        @endif
                    </div>

                    @if ($category->lastPage() > 1)
                        <nav>
                            <ul class="pagination">
                                <li class="page-item {{ ($category->currentPage() == 1) ? ' disabled' : '' }}"><a
                                        class="page-link" href="{{ $category->url(1) }}">قبلی</a>
                                </li>
                                @for ($i = 1; $i <= $category->lastPage(); $i++)
                                    <li class="page-item {{ ($category->currentPage() == $i) ? ' active' : '' }}">
                                        <a class="page-link" href="{{ $category->url($i) }}">{{ $i }}</a>
                                    </li>
                                @endfor
                                <li class="page-item {{ ($category->currentPage() == $category->lastPage()) ? ' disabled' : '' }}">
                                    <a class="page-link"
                                       href="{{ $category->url($category->currentPage()+1) }}">بعدی</a>
                                </li>
                            </ul>
                        </nav>
                    @endif
                </div>
            </div>
        </div>
        <!--/col-->

    </div>
    @can('حذف دسته بندی')
        <script>
            $('.btn.btn-danger.delete').click(function () {
                var catID = $(this).data('id');
                Swal.fire({
                    title: 'آیا از حذف این دسته بندی اطمینان دارید؟',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'بله ، حذف بشه',
                    cancelButtonText: 'خیر'
                }).then((result) => {
                    if (result.value) {
                        window.location.href = "/admin/categories/delete/" + catID;
                    }
                })
            });
        </script>
    @endcan
@endsection
