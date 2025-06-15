<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mcliadm;

class McliadmController extends Controller
{
    // Mostrar todos los registros
    public function index()
    {
        $mcliadms = Mcliadm::all();
        return view('admin.mcliadms.index', compact('mcliadms'));
    }

    // Mostrar formulario para crear un nuevo registro
    public function create()
    {
        return view('admin.mcliadms.create');
    }

    // Guardar un nuevo registro
    public function store(Request $request)
    {
        $validated = $request->validate([
            'NOMRESP' => 'nullable|string|max:50',
            'CONTACTO' => 'nullable|string|max:40',
            'DIRECCION1' => 'nullable|string|max:70',
            'CORREO_E' => 'nullable|email|max:100',
            'K_TANQUE' => 'required|numeric',
            // Agrega más validaciones si es necesario
        ]);

        Mcliadm::create($validated);

        return redirect()->route('mcliadms.index')->with('success', 'Cliente creado correctamente.');
    }

    // Mostrar un registro específico
    public function show($id)
    {
        $mcliadm = Mcliadm::findOrFail($id);
        return view('admin.mcliadms.show', compact('mcliadm'));
    }

    // Mostrar formulario para editar un registro
    public function edit($id)
    {
        $mcliadm = Mcliadm::findOrFail($id);
        return view('admin.mcliadms.edit', compact('mcliadm'));
    }

    // Actualizar un registro existente
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'NOMRESP' => 'nullable|string|max:50',
            'CONTACTO' => 'nullable|string|max:40',
            'DIRECCION1' => 'nullable|string|max:70',
            'CORREO_E' => 'nullable|email|max:100',
            'K_TANQUE' => 'required|numeric',
            // Agrega más validaciones si es necesario
        ]);

        $mcliadm = Mcliadm::findOrFail($id);
        $mcliadm->update($validated);

        return redirect()->route('mcliadms.index')->with('success', 'Cliente actualizado correctamente.');
    }

    // Eliminar un registro
    public function destroy($id)
    {
        $mcliadm = Mcliadm::findOrFail($id);
        $mcliadm->delete();

        return redirect()->route('mcliadms.index')->with('success', 'Cliente eliminado correctamente.');
    }
}
