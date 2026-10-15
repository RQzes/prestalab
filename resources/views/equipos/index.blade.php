<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Equipos del laboratorio</h2>
            <a href="{{ route('equipos.create') }}"
               class="rounded-md bg-gray-800 px-4 py-2 text-white text-sm font-semibold hover:bg-gray-700">+ Registrar equipo</a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-flash />

            <div class="bg-white shadow-sm sm:rounded-lg overflow-x-auto">
                <table class="min-w-full text-left">
                    <thead class="bg-gray-50 text-gray-600 text-sm uppercase">
                        <tr>
                            <th class="px-4 py-3">Código</th>
                            <th class="px-4 py-3">Nombre</th>
                            <th class="px-4 py-3">Categoría</th>
                            <th class="px-4 py-3">Estado</th>
                            <th class="px-4 py-3">Prestado a</th>
                            <th class="px-4 py-3">Préstamo / devolución</th>
                            <th class="px-4 py-3">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @forelse ($equipos as $equipo)
                            <tr>
                                <td class="px-4 py-3 font-mono">{{ $equipo->codigo }}</td>
                                <td class="px-4 py-3">{{ $equipo->nombre }}</td>
                                <td class="px-4 py-3">{{ $equipo->categoria }}</td>
                                <td class="px-4 py-3">
                                    @if ($equipo->estaPrestado())
                                        <span class="rounded-full bg-amber-100 px-2 py-1 text-xs font-semibold text-amber-800">Prestado</span>
                                    @else
                                        <span class="rounded-full bg-green-100 px-2 py-1 text-xs font-semibold text-green-800">Disponible</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3">{{ $equipo->prestatario?->name ?? '—' }}</td>
                                <td class="px-4 py-3">
                                    @if ($equipo->estaPrestado())
                                        <form method="POST" action="{{ route('equipos.devolver', $equipo) }}">
                                            @csrf
                                            <button class="rounded-md bg-blue-600 px-3 py-1 text-sm text-white hover:bg-blue-500">Registrar devolución</button>
                                        </form>
                                    @else
                                        <form method="POST" action="{{ route('equipos.prestar', $equipo) }}" class="flex gap-2">
                                            @csrf
                                            <select name="estudiante_id" required class="rounded-md border-gray-300 text-sm">
                                                <option value="">Estudiante…</option>
                                                @foreach ($estudiantes as $estudiante)
                                                    <option value="{{ $estudiante->id }}">{{ $estudiante->name }}</option>
                                                @endforeach
                                            </select>
                                            <button class="rounded-md bg-green-600 px-3 py-1 text-sm text-white hover:bg-green-500">Prestar</button>
                                        </form>
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center gap-3">
                                        <a href="{{ route('equipos.edit', $equipo) }}" class="text-indigo-600 hover:underline">Editar</a>
                                        <form method="POST" action="{{ route('equipos.destroy', $equipo) }}"
                                              onsubmit="return confirm('¿Eliminar el equipo {{ $equipo->codigo }}?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="text-red-600 hover:underline">Eliminar</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="7" class="px-4 py-6 text-center text-gray-500">Aún no hay equipos registrados.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
