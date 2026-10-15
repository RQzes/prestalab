<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Panel del Estudiante</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-flash />

            <div class="bg-white shadow-sm sm:rounded-lg p-6 mb-6">
                <p class="text-lg text-gray-800">Hola, <strong>{{ auth()->user()->name }}</strong></p>
                <p class="text-gray-600">Rol: <span class="font-semibold">{{ auth()->user()->etiquetaRol() }}</span></p>
            </div>

            <div class="bg-white shadow-sm sm:rounded-lg overflow-x-auto">
                <h3 class="px-6 pt-6 text-lg font-semibold text-gray-800">Equipos disponibles</h3>
                <table class="min-w-full text-left mt-4">
                    <thead class="bg-gray-50 text-gray-600 text-sm uppercase">
                        <tr>
                            <th class="px-6 py-3">Código</th>
                            <th class="px-6 py-3">Nombre</th>
                            <th class="px-6 py-3">Categoría</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @forelse ($equipos as $equipo)
                            <tr>
                                <td class="px-6 py-3 font-mono">{{ $equipo->codigo }}</td>
                                <td class="px-6 py-3">{{ $equipo->nombre }}</td>
                                <td class="px-6 py-3">{{ $equipo->categoria }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="3" class="px-6 py-6 text-center text-gray-500">No hay equipos disponibles por ahora.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <p class="mt-3 text-sm text-gray-500">Para pedir un equipo, acércate al Encargado del laboratorio.</p>
        </div>
    </div>
</x-app-layout>
