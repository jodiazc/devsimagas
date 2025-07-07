<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RegistroLecturas;
use App\Models\DcliadmDatosPeriodo;
use Intervention\Image\Facades\Image;

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
            'lectura_final' => 'required|string',
            'imagen_lectura' => 'required|file|mimes:jpeg,png,jpg|max:4096', // Aumenté el límite por si acaso
            'almacen' => 'string|max:255',
            'observaciones' => 'string|max:255',
        ]);
    
        // Sanitizar nombres
        $cliente = str_replace(' ', '_', strtolower($request->cliente));
        $almacen = str_replace(' ', '_', strtolower($request->almacen));
        $observaciones = $request->observaciones;
        $timestamp = now()->format('Ymd_His');
    
        // Archivo original
        $file = $request->file('imagen_lectura');
        $extension = $file->getClientOriginalExtension();
        $filename = "{$almacen}_{$cliente}_{$timestamp}.{$extension}";
        $path = "archivos/{$filename}";
    
        // Redimensionar y comprimir imagen
        $image = Image::make($file)
            ->resize(1200, null, function ($constraint) {
                $constraint->aspectRatio(); // Mantiene proporciones
                $constraint->upsize();      // No agranda si es pequeña
            })
            ->encode($extension, 70); // Comprime (calidad 70%)
    
        // Guardar en disco 'public'
        \Storage::disk('public')->put($path, (string) $image);
    
        // Guardar en base de datos
        RegistroLecturas::create([
            'almacen' => $request->almacen,
            'cliente' => $request->cliente,
            'lectura_final' => $request->lectura_final,
            'imagen_lectura' => $path,
            'observaciones' => $observaciones,
            
        ]);

        // Actualizar campo ESTATUS en DcliadmDatosPeriodo
        $datosPeriodo = DcliadmDatosPeriodo::where('REFERENCIA', $request->cliente)->first();

        if ($datosPeriodo) {
            $datosPeriodo->ESTATUS = 'P'; // O el valor que necesites
            $datosPeriodo->save();
        }        
    
        //return redirect()->back()->with('success', 'Registro guardado correctamente.');
        //return redirect()->route('admin.mcliadms.index',['cliente' => $request->cliente,'almacen' => $request->almacen])->with('success', 'Registro guardado correctamente.');
        //return redirect()->route('admin.mcliadms.index')
        //->with('success', 'Registro guardado correctamente.')
        //->with('cliente', $request->cliente)
        //->with('almacen', $request->almacen);
        return redirect()->route('admin.mcliadms.index', [
            'cliente' => $request->cliente,
            'almacen' => $request->almacen,
        ])->with('success', 'Registro guardado correctamente.');        

    } 
}
