<?php

namespace App\Http\Controllers;

use App\Category;
use App\File;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use JBZoo\Image\Exception;
use JBZoo\Image\Image;

class FileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        if (Auth::check() && Auth::user()->role == User::SuperAdmin) {
            $file = File::paginate(10);

        } elseif (Auth::check() && Auth::user()->role == User::Admin) {
            $file = File::where('uploader_name', Auth::user()->name)->paginate(10);

        } else {
            return redirect()->route('login');
        }
        return view('files', compact('file'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        return view('adit-file', compact('categories'))->with('panel_title', 'افزودن فایل');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file_name' => 'unique:files',
            'file_description' => 'required',
            'file' => 'required'
        ], [
            'file_name.unique' => 'فایلی به این نام از قبل وجود دارد',
            'file_description.required' => 'لطفا توضیحات فایل را وارد کنید',
            'file.required' => 'لطفا فایل را انتخاب کنید',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        $file = $request->file('file');
        $fileExt = $file->getClientOriginalExtension();

        if ($request->hasFile('image')) {

            $image = $request->file('image');
            $imageName = $image->getClientOriginalName();

            $imagePath = $image->storeAs('images', $imageName);
//            $imagePath = $image->move(public_path('/uploads/images/'), $imageName);

            try {
                $img = (new Image(public_path('/uploads/images/' . $imageName)))
                    ->thumbnail(290, 180)
                    ->saveAs(public_path('/uploads/images/' . $imageName));
            } catch (Exception $e) {
            } catch (\JBZoo\Utils\Exception $e) {
            }

        } else {
            $file_types = [
                'ai', 'avi', 'bmp', 'cad', 'css', 'dmg', 'doc', 'docx', 'eps', 'flv', 'gif', 'html', 'iso', 'jpeg', 'jpg', 'js', 'mp3', 'mpg',
                'pdf', 'php', 'png', 'ppt', 'pptx', 'psd', 'sql', 'txt', 'wmv', 'xls', 'xlsx', 'xml', 'zip', 'rar'
            ];
            if (in_array(strtolower($fileExt), $file_types)) {
                $imagePath = 'images/' . strtolower($fileExt) . '.png';
            } else {
                $imagePath = 'images/NoImage.png';
            }
        }

        if ($request->input('file_name') != null) {
            $fileName = $request->input('file_name');
        } elseif ($request->input('file_name') == null) {
            $fileName = $file->getClientOriginalName();
        }

        $filePath = $file->storeAs('files', $fileName . '.' . $fileExt);

        if ($request->input('visibility') == null) {
            $visibility = 0;
        } elseif ($request->input('visibility') == 'on') {
            $visibility = 1;
        }

        $new_file_data = [
            'file_name' => $fileName,
            'file_type' => $fileExt,
            'file_description' => $request->input('file_description'),
            'file_size' => round((filesize($file) / 1000000), 3),
            'file_image' => $imagePath,
            'file_url' => $filePath,
            'uploader_name' => Auth::user()->name ? Auth::user()->name : 'نامشخص',
            'category_id' => $request->input('categories'),
            'visibility' => $visibility
        ];

        $new_file = File::create($new_file_data);
        return response()->json(['success' => 'فایل با موفقیت اضافه شد']);

//        if ($new_file instanceof File) {
//            return redirect()->route('files_index')->with('success', 'فایل با موفقیت افزوده شد');
//        }

    }

    /**
     * Display the specified resource.
     *
     * @param \App\File $file
     * @return \Illuminate\Http\Response
     */
    public function show(File $file)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\File $file
     * @return \Illuminate\Http\Response
     */
    public function edit(File $file, $id)
    {
        $id = intval($id);
        $file = File::findOrFail($id);
        $categories = Category::all();
        return view('adit-file', compact('file', 'categories'))->with(['panel_title' => 'ویرایش فایل', 'edit' => 'edit']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\File $file
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, File $file, $id)
    {
        $validator = Validator::make($request->all(), [
            'file_description' => 'required',
        ], [
            'file_description.required' => 'لطفا توضیحات فایل را وارد کنید',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        $fileName = '';
        $fileExt = '';
        $fileSize = '';
        $filePath = '';
        $imagePath = '';

        if ($request->input('file_name') != null) {
            $fileName = $request->input('file_name');
        }

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = $image->getClientOriginalName();
            $imagePath = $image->storeAs('images', $imageName);

            try {
                $img = (new Image(public_path('/uploads/images/' . $imageName)))
                    ->thumbnail(290, 180)
                    ->saveAs(public_path('/uploads/images/' . $imageName));
            } catch (Exception $e) {
            } catch (\JBZoo\Utils\Exception $e) {
            }

        }

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileExt = $file->getClientOriginalExtension();
            $filePath = $file->storeAs('files', $fileName . '.' . $fileExt);
            $fileSize = round((filesize($file) / 1000000), 3);
        }

        if (!$request->has('visibility')) {
            $visibility = 0;
        } elseif ($request->input('visibility') == 'on') {
            $visibility = 1;
        }

        $file_data = [
            'file_name' => $fileName,
            'file_type' => $fileExt,
            'file_description' => $request->input('file_description'),
            'file_size' => $fileSize,
            'file_image' => $imagePath,
            'file_url' => $filePath,
            'uploader_name' => Auth::user()->name ? Auth::user()->name : 'نامشخص',
            'category_id' => $request->input('categories'),
            'visibility' => $visibility
        ];

        if ($request->input('file_name') == null || !$request->has('file_name')) {
            unset($file_data['file_name']);
        }

        if (!$request->hasFile('image')) {
            unset($file_data['file_image']);
        }

        if (!$request->hasFile('file')) {
            unset($file_data['file_url']);
            unset($file_data['file_type']);
            unset($file_data['file_size']);
        }

        $file = File::findOrFail($id);
        $file->update($file_data);
        return response()->json(['success' => 'فایل با موفقیت ویرایش شد']);

//        return redirect()->route('files_index')->with('success', 'فایل با موفقیت ویرایش شد');
    }

    public function search(Request $request)
    {
        $searchTerm = $request->input('search');
        $file = File::search($searchTerm)->where('uploader_name', Auth::user()->name)->paginate(10);
        return view('files', compact('file', 'searchTerm'));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\File $file
     * @return \Illuminate\Http\Response
     */
    public function destroy(File $file, $id)
    {
        $id = intval($id);
        $file = File::findOrFail($id);

        if (Storage::exists($file->file_image) && $file->file_image != 'images/NoImage.png') {
            Storage::delete($file->file_image);
        }

        if (Storage::exists($file->file_url)) {
            Storage::delete($file->file_url);
        }

        if ($file) {
            $file->delete();
            return redirect()->route('files_index');
        }

    }
}
