<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\UploadFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UploadFilesController extends Controller
{
    public function index()
    {
        $files = UploadFile::all();
        return view('admin.upload_files.index', compact('files'));
    }

    public function create()
    {
        return view('admin.upload_files.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:jpg,png,pdf,csv,xlsx|max:2048',
        ]);

        $originalName = $request->file('file')->getClientOriginalName();
        $path = $request->file('file')->storeAs('public/uploads', $originalName);

        $uploadFile = new UploadFile();
        $uploadFile->filename = $originalName; // Guarda el nombre original
        $uploadFile->path = $path; // Guarda la ruta en storage
        $uploadFile->save();

        return redirect()->route('admin.upload_files.index')->with('success', 'Archivo subido correctamente.');
    }

    public function showFile($filename)
    {
        $path = storage_path('app/public/uploads/' . $filename);

        \Log::info('Trying to access file at: ' . $path);

        if (!file_exists($path)) {
            \Log::error('File not found: ' . $path);
            abort(404);
        }

        return response()->file($path);
    }

    public function edit($id)
    {
        $file = UploadFile::findOrFail($id);
        return view('admin.upload_files.edit', compact('file'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'file' => 'file|mimes:jpg,png,pdf|max:2048',
        ]);

        $uploadFile = UploadFile::findOrFail($id);

        if ($request->hasFile('file')) {
            Storage::delete($uploadFile->path);
            $originalName = $request->file('file')->getClientOriginalName();
            $path = $request->file('file')->storeAs('public/uploads', $originalName);

            $uploadFile->filename = $originalName;
            $uploadFile->path = $path;
        }

        $uploadFile->save();
        return redirect()->route('admin.upload_files.index')->with('success', 'Archivo actualizado correctamente.');
    }

    public function destroy($id)
    {
        $uploadFile = UploadFile::findOrFail($id);
        Storage::delete($uploadFile->path);
        $uploadFile->delete();

        return redirect()->route('admin.upload_files.index')->with('success', 'Archivo eliminado correctamente.');
    }
}
