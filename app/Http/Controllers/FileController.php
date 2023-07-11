<?php

namespace App\Http\Controllers;

use App\Http\Requests\FileRequest;
use App\Models\File;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
  public function show(FileRequest $requset, File $file)
  {
    return response()->file(Storage::path($file->path));
  }
}
