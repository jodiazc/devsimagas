<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
class FileController extends Controller
{
    public function show($filename)
    {
        $path = storage_path('app/public/uploads/' . $filename);
        if (!file_exists($path)) {
            abort(404);
        }

        return response()->file($path);
    }
}
