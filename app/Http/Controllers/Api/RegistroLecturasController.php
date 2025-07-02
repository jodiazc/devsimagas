<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RegistroLecturas;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Log;

class RegistroLecturasController extends Controller
{
    public function index()
    {
        return response()->json(RegistroLecturas::all());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'almacen' => 'required|string|max:255',
            'cliente' => 'required|string|max:255',
            'lectura_inicial' => 'required|numeric',
            'lectura_final' => 'required|numeric|gte:lectura_inicial',
            'imagen_lectura' => 'nullable|string',
        ]);

        $registro = RegistroLecturas::create($data);

        return response()->json($registro, 201);
    }

    public function show($id)
    {
        $registro = RegistroLecturas::find($id);

        if (!$registro) {
            return response()->json(['message' => 'Registro no encontrado'], 404);
        }

        return response()->json($registro);
    }

    public function update(Request $request, $id)
    {
        $registro = RegistroLecturas::find($id);

        if (!$registro) {
            return response()->json(['message' => 'Registro no encontrado'], 404);
        }

        $data = $request->validate([
            'almacen' => 'sometimes|required|string|max:255',
            'cliente' => 'sometimes|required|string|max:255',
            'lectura_inicial' => 'sometimes|required|numeric',
            'lectura_final' => 'sometimes|required|numeric|gte:lectura_inicial',
            'imagen_lectura' => 'nullable|string',
        ]);

        $registro->update($data);

        return response()->json($registro);
    }

    public function destroy($id)
    {
        $registro = RegistroLecturas::find($id);

        if (!$registro) {
            return response()->json(['message' => 'Registro no encontrado'], 404);
        }

        $registro->delete();

        return response()->json(['message' => 'Registro eliminado']);
    }

    public function buscar(Request $request)
    {
        $campo = $request->input('campo');
        $valor = $request->input('valor');

        Log::debug('Valores recibidos para búsqueda', [
            'campo' => $campo,
            'valor' => $valor,
        ]);        

        if (!$campo || !$valor) {
            return response()->json(['message' => 'Parámetros "campo" y "valor" son requeridos.'], 422);
        }

        if (!Schema::hasColumn('registro_lecturas', $campo)) {
            Log::warning("Intento de búsqueda con campo inválido: {$campo}");
            return response()->json(['message' => 'Campo inválido.'], 400);
        }

        $resultados = RegistroLecturas::where($campo, 'like', '%' . $valor . '%')->get();

        Log::info('Resultados de búsqueda obtenidos', ['count' => $resultados->count()]);

        return response()->json($resultados);
    }

    public function actualizarEstatus(Request $request, $id)
    {
        $registro = RegistroLecturas::find($id);

        if (!$registro) {
            return response()->json(['message' => 'Registro no encontrado'], 404);
        }

        $data = $request->validate([
            'estatus_registro' => 'required|string|max:100',
        ]);

        $registro->estatus_registro = $data['estatus_registro'];
        $registro->save();

        return response()->json(['message' => 'Estatus actualizado', 'registro' => $registro]);
    }    
}
