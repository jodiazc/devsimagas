<div class="p-4">
    <div class="flex flex-wrap gap-4 mb-4 items-end">
        <div class="flex-1 min-w-[200px]">
            <label class="block text-sm font-medium text-gray-700">Buscar por Almacén</label>
            <input
                type="text"
                wire:model.defer="searchAlmacenInput"
                wire:keydown.enter="buscar"
                class="border p-2 rounded w-full"
                placeholder="Ej. Almacén Central"
            >
        </div>

        <div class="flex-1 min-w-[200px]">
            <label class="block text-sm font-medium text-gray-700">Buscar por Cliente</label>
            <input
                type="text"
                wire:model.defer="searchClienteInput"
                wire:keydown.enter="buscar"
                class="border p-2 rounded w-full"
                placeholder="Ej. Cliente XYZ"
            >
        </div>

        <div class="flex gap-2">
            <button
                wire:click="buscar"
                class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                Buscar
            </button>

            <button
                wire:click="limpiar"
                class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 transition">
                Limpiar
            </button>
        </div>
    </div>

    <table class="min-w-full bg-white border border-gray-200">
        <thead>
            <tr class="bg-gray-100 text-left text-sm font-semibold">
                <th class="py-2 px-4 border-b">Inmueble</th>
                <th class="py-2 px-4 border-b">Almacén</th>
                <th class="py-2 px-4 border-b">Cliente</th>
                <th class="py-2 px-4 border-b">Depa</th>
                <th class="py-2 px-4 border-b">Estatus</th>
                <th class="py-2 px-4 border-b">Procesar</th> {{-- NUEVA COLUMNA --}}
            </tr>
        </thead>
        <tbody>
            @forelse($almacenes as $almacen)
                <tr>
                    <td class="py-2 px-4 border-b">{{ $almacen->inmueble }}</td>
                    <td class="py-2 px-4 border-b">{{ $almacen->almacen }}</td>
                    <td class="py-2 px-4 border-b">{{ $almacen->cliente }}</td>
                    <td class="py-2 px-4 border-b">{{ $almacen->depa }}</td>
                    <td class="py-2 px-4 border-b">{{ $almacen->estatus }}</td>
                    <td class="py-2 px-4 border-b">
                        <a href="{{ route('admin.registro.create', ['almacen' => $almacen->almacen, 'cliente' => $almacen->cliente]) }}"
                           class="text-blue-600 hover:underline font-semibold">
                            Procesar
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="py-2 px-4 text-center text-gray-500">No se encontraron resultados.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>