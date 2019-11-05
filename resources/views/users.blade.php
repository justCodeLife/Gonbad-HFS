@extends('_layout')
@section('breadcrumb')
    مدیران
@endsection
@section('search')
    <li class="breadcrumb-menu">
        <form action="/admin/users/search" method="get">
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
                    <i class="fa fa-align-justify"></i> جدول مدیران
                </div>
                <div class="card-block">
                    @include('errors')
                    <div style="height:400px;overflow: auto">
                        @if ($user && count($user)>0)
                            <table class="table table-bordered table-striped table-condensed">
                                <thead>
                                <tr>
                                    <th>نام</th>
                                    <th>ایمیل</th>
                                    <th>نام کاربری</th>
                                    <th>دسترسی ها</th>
                                    @canany(['ویرایش مدیر','حذف مدیر'])
                                        <th>عملیات</th>
                                    @endcanany
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($user as $usr)
                                    <tr>
                                        <td>{{ $usr->name }}</td>
                                        <td>{{ $usr->email }}</td>
                                        <td>{{ $usr->username }}</td>
                                        <td data-toggle="tooltip" data-placement="top" title="@foreach ($usr->getPermissionNames() as $perm) {{ $perm }} @endforeach">
                                            @foreach ($usr->getPermissionNames() as $perm)
                                                <span style="background:limegreen;color: white;padding: 5px;margin-right: 5px">&nbsp;{{ $perm }}&nbsp</span>
                                            @endforeach
                                        </td>
                                        <td>
                                            @can('ویرایش مدیر')
                                                <a class="btn btn-warning"
                                                   href="/admin/users/edit/{{ $usr->id }}">ویرایش</a>
                                            @endcan
                                            @can('حذف مدیر')
                                                <a data-id="{{ $usr->id }}" class="btn btn-danger delete"
                                                   href="#">حذف</a>
                                            @endcan
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        @elseif(count($user)==0)
                            <p class="text-right">هیچ کاربری وجود ندارد</p>
                        @endif
                    </div>

                    @if ($user->lastPage() > 1)
                        <nav>
                            <ul class="pagination">
                                <li class="page-item {{ ($user->currentPage() == 1) ? ' disabled' : '' }}"><a
                                        class="page-link" href="{{ $user->url(1) }}">قبلی</a>
                                </li>
                                @for ($i = 1; $i <= $user->lastPage(); $i++)
                                    <li class="page-item {{ ($user->currentPage() == $i) ? ' active' : '' }}">
                                        <a class="page-link" href="{{ $user->url($i) }}">{{ $i }}</a>
                                    </li>
                                @endfor
                                <li class="page-item {{ ($user->currentPage() == $user->lastPage()) ? ' disabled' : '' }}">
                                    <a class="page-link"
                                       href="{{ $user->url($user->currentPage()+1) }}">بعدی</a>
                                </li>
                            </ul>
                        </nav>
                    @endif
                </div>
            </div>
        </div>
        <!--/col-->

    </div>
    @can('حذف مدیر')
        <script>
            $('.btn.btn-danger.delete').click(function () {
                var userID = $(this).data('id');
                Swal.fire({
                    title: 'آیا از حذف این مدیر اطمینان دارید؟',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'بله ، حذف بشه',
                    cancelButtonText: 'خیر'
                }).then((result) => {
                    if (result.value) {
                        window.location.href = "/admin/users/delete/" + userID;
                    }
                })
            });
        </script>
    @endcan
@endsection
