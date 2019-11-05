<?php

namespace App\Http\Controllers;

use Chumper\Zipper\Zipper;
use App\Category;
use App\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ClientController extends Controller
{
    public function index()
    {
        $files = File::latest()->where('visibility', 1)->paginate(10);
        $categories = Category::all();
        return view('client', compact('files', 'categories'));
    }

    public function search(Request $request)
    {
        $categories = Category::all();
        $searchTerm = $request->input('search');
        $files = File::search($searchTerm)->paginate(10);
        return view('client', compact('files', 'searchTerm', 'categories'));
    }

    public function download(Request $request)
    {
        if (isset($request->downloadFiles)) {

            $files = File::findOrFail($request->downloadFiles);
            $zipper = new Zipper;

            $zipName = 'download.zip';
            $zipper->make(public_path('/storage/' . $zipName));

            foreach ($files as $file) {
                $zipper->add(public_path('uploads/' . $file->file_url));
            }

            $zipper->close();
            $headers = array(
                'Content-Type: application/zip',
                'Content-Length: ' . filesize(public_path("/storage/" . $zipName)),
                'Content-Disposition: attachment; filename=' . $zipName,
                'Expires: 0',
                'Cache-Control: must-revalidate, post-check=0, pre-check=0',
            );

            return response()->download(public_path('/storage/' . $zipName), $zipName, $headers)->deleteFileAfterSend();
        }

    }

    public function getCatFiles(Request $request, $id)
    {
        $categories = Category::all();
        $files = Category::findOrFail($id)->files()->paginate(10);
        return view('client', compact('files', 'categories'));
    }


    public function down(Request $request)
    {
        $file = File::findOrFail($request->downloadFiles[0]);
        if (Storage::exists($file->file_url)) {
            return response()->download(public_path('files' . $file->file_url));
        } else {
            abort(404);
        }
    }

}
