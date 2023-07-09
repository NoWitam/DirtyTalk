<?php

namespace App\Http\Controllers;

use App\Http\Requests\FileRequest;
use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    /**
     * Display the specified resource.
     */
    public function show(FileRequest $requset, File $file)
    {
      //  dd(Storage::path($file->path));
        return response()->file(Storage::path($file->path));
    }
}
