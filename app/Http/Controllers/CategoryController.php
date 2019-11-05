<?php

namespace App\Http\Controllers;

use App\Category;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
//    public function __construct()
//    {
//        $this->middleware('auth');
//    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::check() && Auth::user()->role == User::SuperAdmin) {
            $category = Category::paginate(10);

        } elseif (Auth::check() && Auth::user()->role == User::Admin) {
            $category = Category::where('creator_name', Auth::user()->name)->paginate(10);

        } else {
            return redirect()->route('login');
        }
        return view('categories', compact('category'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('adit-category')->with('panel_title', 'افزودن دسته بندی');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'description' => 'required',
        ], [
            'name.required' => 'لطفا نام را وارد کنید',
            'description.required' => 'لطفا توضیحات را وارد کنید',
        ]);

        $new_category_data = [
            'name' => $request->input('name'),
            'creator_name' => Auth::user()->name,
            'description' => $request->input('description'),
        ];
        $new_category = Category::create($new_category_data);
        if ($new_category instanceof Category) {
            return redirect()->route('categories_index')->with('success', 'دسته بندی با موفقیت ایجاد شد');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Category $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Category $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category, $id)
    {
        $id = intval($id);
        $category = Category::findOrFail($id);
        return view('adit-category', compact('category'))->with('panel_title', 'ویرایش دسته بندی');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Category $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category, $id)
    {

        $this->validate($request, [
            'name' => 'required',
            'description' => 'required',
        ], [
            'name.required' => 'لطفا نام را وارد کنید',
            'description.required' => 'لطفا توضیحات را وارد کنید',
        ]);
        $category_data = [
            'name' => $request->input('name'),
            'creator_name' => Auth::user()->name,
            'description' => $request->input('description'),
        ];
        $category = Category::findOrFail($id);
        $category->update($category_data);
        return redirect()->route('categories_index')->with('success', 'دسته بندی با موفقیت ویرایش ایجاد شد');
    }

    public function search(Request $request)
    {
        $searchTerm = $request->input('search');
        $category = Category::search($searchTerm)->where('creator_name', Auth::user()->name)->paginate(10);
        return view('categories', compact('category', 'searchTerm'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Category $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category, $id)
    {
        $id = intval($id);
        $category = Category::findOrFail($id);
        if (Category::all()->count() > 1) {
            if ($category) {
                $category->delete();
                return redirect()->route('categories_index');
            }
        } else {
            return redirect()->back()->withErrors(['category' => 'تعداد دسته بندی ها نمی تواند کمتر از یک باشد']);
        }
    }
}
