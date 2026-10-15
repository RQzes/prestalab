<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Panel del Encargado</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-flash />

            <div class="bg-white shadow-sm sm:rounded-lg p-6 mb-6">
                <p class="text-lg text-gray-800">Hola, <strong>{{ auth()->user()->name }}</strong></p>
                <p class="text-gray-600">Rol: <span class="font-semibold">{{ auth()->user()->etiquetaRol() }}</span></p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
                <div class="bg-white shadow-sm sm:rounded-lg p-6 text-center">
                    <div class="text-3xl font-bold text-gray-800">{{ $resumen['total'] }}</div>
                    <div class="text-gray-500">Equipos registrados</div>
                </div>
                <div class="bg-white shadow-sm sm:rounded-lg p-6 text-center">
                    <div class="text-3xl font-bold text-green-600">{{ $resumen['disponibles'] }}</div>
                    <div class="text-gray-500">Disponibles</div>
                </div>
                <div class="bg-white shadow-sm sm:rounded-lg p-6 text-center">
                    <div class="text-3xl font-bold text-amber-600">{{ $resumen['prestados'] }}</div>
                    <div class="text-gray-500">Prestados</div>
                </div>
            </div>

            <a href="{{ route('equipos.index') }}"
               class="inline-block rounded-md bg-gray-800 px-5 py-3 text-white font-semibold hover:bg-gray-700">
                Administrar equipos
            </a>
        </div>
    </div>
</x-app-layout>
