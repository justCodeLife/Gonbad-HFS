<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;

class UserController extends Controller
{
    public function index()
    {
        try {
            $user = User::paginate(10);
            return view('users', compact('user'));
        } catch (\Exception $ex) {
            abort(500);
        }

    }

    public function create()
    {
        try {
            return view('adit-user')->with('panel_title', 'افزودن کاربر');
        } catch (\Exception $ex) {
            abort(500);
        }
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'username' => 'required|unique:users|min:4|max:20',
            'password' => 'required|min:4|max:20',
            'name' => 'required',
            'email' => 'required|unique:users',
        ], [
            'username.required' => 'لطفا نام کاربری را وارد نمایید',
            'password.required' => 'لطفا رمز عبور را وارد کنید',
            'name.required' => 'لطفا نام را وارد کنید',
            'email.required' => 'لطفا ایمیل را وارد کنید',
            'password.min' => 'تعداد رقم های رمز کمتر از حد مجاز می باشد',
            'password.max' => 'تعداد رقم های رمز بیشتر از حد مجاز می باشد',
            'username.min' => 'تعداد حروف نام کاربری کمتر از حد مجاز می باشد',
            'username.max' => 'تعداد حروف نام کاربری بیشتر از حد مجاز می باشد',
            'username.unique' => 'نام کاربری از قبل وجود دارد',
            'email.unique' => 'ایمیل از قبل وجود دارد',
        ]);

        $new_user_data = [
            'username' => $request->input('username'),
            'password' => Hash::make($request->input('password')),
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'role' => User::Admin
        ];
        $new_user = User::create($new_user_data);

        if ($request->has('view_users')) {
            $new_user->givePermissionTo('نمایش مدیران');
        }
        if ($request->has('add_user')) {
            $new_user->givePermissionTo('افزودن مدیر');
        }
        if ($request->has('edit_user')) {
            $new_user->givePermissionTo('ویرایش مدیر');
        }
        if ($request->has('delete_user')) {
            $new_user->givePermissionTo('حذف مدیر');
        }
        if ($request->has('view_files')) {
            $new_user->givePermissionTo('نمایش فایل ها');
        }
        if ($request->has('add_file')) {
            $new_user->givePermissionTo('افزودن فایل');
        }
        if ($request->has('edit_file')) {
            $new_user->givePermissionTo('ویرایش فایل');
        }
        if ($request->has('delete_file')) {
            $new_user->givePermissionTo('حذف فایل');
        }
        if ($request->has('download_file')) {
            $new_user->givePermissionTo('دانلود فایل');
        }
        if ($request->has('view_categories')) {
            $new_user->givePermissionTo('نمایش دسته بندی ها');
        }
        if ($request->has('add_category')) {
            $new_user->givePermissionTo('افزودن دسته بندی');
        }
        if ($request->has('edit_category')) {
            $new_user->givePermissionTo('ویرایش دسته بندی');
        }
        if ($request->has('delete_category')) {
            $new_user->givePermissionTo('حذف دسته بندی');
        }
        if ($request->has('view_dashboard')) {
            $new_user->givePermissionTo('نمایش داشبورد');
        }

        if ($new_user instanceof User) {
            return redirect()->route('users_index')->with('success', 'مدیر با موفقیت ایجاد شد');
        }
    }

    public
    function edit($id)
    {
        $id = intval($id);
        $user = User::findOrFail($id);
        return view('adit-user', compact('user'))->with(['panel_title' => 'ویرایش کاربر', 'edit' => 'edit']);
    }

    public
    function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $this->validate($request, [
            'username' => 'required|min:4|max:20',
            'name' => 'required',
            'email' => 'required',
        ], [
            'username.required' => 'لطفا نام کاربری را وارد نمایید',
            'name.required' => 'لطفا نام را وارد کنید',
            'email.required' => 'لطفا ایمیل را وارد کنید',
            'username.min' => 'تعداد حروف نام کاربری کمتر از حد مجاز می باشد',
            'username.max' => 'تعداد حروف نام کاربری بیشتر از حد مجاز می باشد',
        ]);

        if ($request->has('password') && $request->input('password') != null) {
            $this->validate($request, [
                'password' => 'min:4|max:20',
            ], [
                'password.min' => 'تعداد رقم های رمز کمتر از حد مجاز می باشد',
                'password.max' => 'تعداد رقم های رمز بیشتر از حد مجاز می باشد',
            ]);
        }

        if ($user->username != trim($request->input('username'))) {
            $this->validate($request, [
                'username' => 'unique:users',
            ], [
                'username.unique' => 'نام کاربری از قبل وجود دارد',
            ]);
        }

        if ($user->email != trim($request->input('email'))) {
            $this->validate($request, [
                'email' => 'unique:users',
            ], [
                'email.unique' => 'ایمیل از قبل وجود دارد',
            ]);
        }

        $user_data = [
            'username' => $request->input('username'),
            'password' => $request->input('password'),
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'role' => User::Admin
        ];

        if (!$request->has('password') || $request->input('password') == null) {
            unset($user_data['password']);
        }

        if ($user->username == trim($request->input('username'))) {
            unset($user_data['username']);
        }

        if ($user->email == trim($request->input('email'))) {
            unset($user_data['email']);
        }

        $user->update($user_data);

        if ($request->has('view_users') && !$user->hasPermissionTo('نمایش مدیران')) {
            $user->givePermissionTo('نمایش مدیران');
        }
        if (!$request->has('view_users') && $user->hasPermissionTo('نمایش مدیران')) {
            $user->revokePermissionTo('نمایش مدیران');
        }
        if ($request->has('add_user') && !$user->hasPermissionTo('افزودن مدیر')) {
            $user->givePermissionTo('افزودن مدیر');
        }
        if (!$request->has('add_user') && $user->hasPermissionTo('افزودن مدیر')) {
            $user->revokePermissionTo('افزودن مدیر');
        }
        if ($request->has('edit_user') && !$user->hasPermissionTo('ویرایش مدیر')) {
            $user->givePermissionTo('ویرایش مدیر');
        }
        if (!$request->has('edit_user') && $user->hasPermissionTo('ویرایش مدیر')) {
            $user->revokePermissionTo('ویرایش مدیر');
        }
        if ($request->has('delete_user') && !$user->hasPermissionTo('حذف مدیر')) {
            $user->givePermissionTo('حذف مدیر');
        }
        if (!$request->has('delete_user') && $user->hasPermissionTo('حذف مدیر')) {
            $user->revokePermissionTo('حذف مدیر');
        }
        if ($request->has('view_files') && !$user->hasPermissionTo('نمایش فایل ها')) {
            $user->givePermissionTo('نمایش فایل ها');
        }
        if (!$request->has('view_files') && $user->hasPermissionTo('نمایش فایل ها')) {
            $user->revokePermissionTo('نمایش فایل ها');
        }
        if ($request->has('add_file') && !$user->hasPermissionTo('افزودن فایل')) {
            $user->givePermissionTo('افزودن فایل');
        }
        if (!$request->has('add_file') && $user->hasPermissionTo('افزودن فایل')) {
            $user->revokePermissionTo('افزودن فایل');
        }
        if ($request->has('edit_file') && !$user->hasPermissionTo('ویرایش فایل')) {
            $user->givePermissionTo('ویرایش فایل');
        }
        if (!$request->has('edit_file') && $user->hasPermissionTo('ویرایش فایل')) {
            $user->revokePermissionTo('ویرایش فایل');
        }
        if ($request->has('delete_file') && !$user->hasPermissionTo('حذف فایل')) {
            $user->givePermissionTo('حذف فایل');
        }
        if (!$request->has('delete_file') && $user->hasPermissionTo('حذف فایل')) {
            $user->revokePermissionTo('حذف فایل');
        }
        if ($request->has('download_file') && !$user->hasPermissionTo('دانلود فایل')) {
            $user->givePermissionTo('دانلود فایل');
        }
        if (!$request->has('download_file') && $user->hasPermissionTo('دانلود فایل')) {
            $user->revokePermissionTo('دانلود فایل');
        }
        if ($request->has('view_categories') && !$user->hasPermissionTo('نمایش دسته بندی ها')) {
            $user->givePermissionTo('نمایش دسته بندی ها');
        }
        if (!$request->has('view_categories') && $user->hasPermissionTo('نمایش دسته بندی ها')) {
            $user->revokePermissionTo('نمایش دسته بندی ها');
        }
        if ($request->has('add_category') && !$user->hasPermissionTo('افزودن دسته بندی')) {
            $user->givePermissionTo('افزودن دسته بندی');
        }
        if (!$request->has('add_category') && $user->hasPermissionTo('افزودن دسته بندی')) {
            $user->revokePermissionTo('افزودن دسته بندی');
        }
        if ($request->has('edit_category') && !$user->hasPermissionTo('ویرایش دسته بندی')) {
            $user->givePermissionTo('ویرایش دسته بندی');
        }
        if (!$request->has('edit_category') && $user->hasPermissionTo('ویرایش دسته بندی')) {
            $user->revokePermissionTo('ویرایش دسته بندی');
        }
        if ($request->has('delete_category') && !$user->hasPermissionTo('حذف دسته بندی')) {
            $user->givePermissionTo('حذف دسته بندی');
        }
        if (!$request->has('delete_category') && $user->hasPermissionTo('حذف دسته بندی')) {
            $user->revokePermissionTo('حذف دسته بندی');
        }
        if ($request->has('view_dashboard') && !$user->hasPermissionTo('نمایش داشبورد')) {
            $user->givePermissionTo('نمایش داشبورد');
        }
        if (!$request->has('view_dashboard') && $user->hasPermissionTo('نمایش داشبورد')) {
            $user->revokePermissionTo('نمایش داشبورد');
        }

        return redirect()->route('users_index')->with('success', 'مدیر با موفقیت ویرایش شد');
    }

    public
    function search(Request $request)
    {
        $searchTerm = $request->input('search');
        try {
            $user = User::search($searchTerm)->paginate(10);
            return view('users', compact('user', 'searchTerm'));
        } catch (\Exception $ex) {
            abort(500);
        }
    }

    public
    function destroy(User $user, $id)
    {
        $id = intval($id);
        $user = User::findOrFail($id);
        if (User::all()->count() > 1 or $user->role == User::Admin) {
            if ($user) {
                $user->delete();
                return redirect()->route('users_index');
            }
        } else {
            return redirect()->back()->withErrors(['super_admin' => 'مدیر اصلی قابل حذف نمی باشد']);
        }
    }
}
