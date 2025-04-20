<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RegistroLecturas;


class RegistroLecturasController extends Controller
{
    public function index()
    {
        $registros = RegistroLecturas::latest()->get();
        return view('admin.registro.index', compact('registros'));
    }

    public function create(Request $request)
    {
        $almacen = $request->query('almacen'); // o $request->get('almacen');
        $cliente = $request->query('cliente');        
        return view('admin.registro.create', compact('almacen', 'cliente'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'cliente' => 'string|max:255',
            'lectura_inicial' => 'required|string|max:255',
            'lectura_final' => 'required|string',
            'imagen_lectura' => 'required|file|mimes:jpeg,png,jpg,pdf|max:2048',
            'almacen' => 'string|max:255',
        ]);
    
        // Sanitizar los datos para el nombre del archivo
        $cliente = str_replace(' ', '_', strtolower($request->cliente));
        $almacen = str_replace(' ', '_', strtolower($request->almacen));
        $timestamp = now()->format('Ymd_His');
    
        // Obtener la extensión
        $extension = $request->file('imagen_lectura')->getClientOriginalExtension();
    
        // Construir el nombre del archivo
        $filename = "{$almacen}_{$cliente}_{$timestamp}.{$extension}";
    
        // Guardar el archivo en la carpeta "archivos"
        $path = $request->file('imagen_lectura')->storeAs('archivos', $filename, 'public');
    
        // Guardar en la base de datos
        RegistroLecturas::create([
            'cliente' => $request->cliente,
            'lectura_inicial' => $request->lectura_inicial,
            'lectura_final' => $request->lectura_final,
            'imagen_lectura' => $path,
        ]);
    
        return redirect()->back()->with('success', 'Registro guardado correctamente.');
    }    

    /*public function store(Request $request)
    {
        $request->validate([
            'cliente' => 'required|string|max:255',
            'lectura_inicial' => 'required|string|max:255',
            'lectura_final' => 'required|string',
            'imagen_lectura' => 'required|file|mimes:jpeg,png,jpg,pdf|max:2048',
        ]);

        $path = $request->file('imagen_lectura')->store('archivos', 'public');

        RegistroLecturas::create([
            'cliente' => $request->cliente,
            'lectura_inicial' => $request->lectura_inicial,
            'lectura_final' => $request->lectura_final,
            'imagen_lectura' => $path,
        ]);

        return redirect()->back()->with('success', 'Registro guardado correctamente.');
    }*/
}
