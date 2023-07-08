<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    /**
     * Display the specified resource.
     */
    public function show(File $file)
    {
      //  dd(Storage::path($file->path));
        return response()->file(Storage::path($file->path));
        dd($file->path);
    }
}
