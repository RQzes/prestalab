@csrf
<div class="space-y-4">
    <div>
        <x-input-label for="codigo" value="Código" />
        <x-text-input id="codigo" name="codigo" type="text" class="mt-1 block w-full" :value="old('codigo', $equipo->codigo ?? '')" required maxlength="50" />
        <x-input-error :messages="$errors->get('codigo')" class="mt-2" />
    </div>
    <div>
        <x-input-label for="nombre" value="Nombre" />
        <x-text-input id="nombre" name="nombre" type="text" class="mt-1 block w-full" :value="old('nombre', $equipo->nombre ?? '')" required maxlength="100" />
        <x-input-error :messages="$errors->get('nombre')" class="mt-2" />
    </div>
    <div>
        <x-input-label for="categoria" value="Categoría" />
        <x-text-input id="categoria" name="categoria" type="text" list="categorias" class="mt-1 block w-full" :value="old('categoria', $equipo->categoria ?? '')" required maxlength="50" />
        <datalist id="categorias">
            <option value="Laptops"><option value="Proyectores"><option value="Arduino"><option value="Medición">
        </datalist>
        <x-input-error :messages="$errors->get('categoria')" class="mt-2" />
    </div>
</div>
<div class="mt-6 flex items-center gap-4">
    <x-primary-button>Guardar</x-primary-button>
    <a href="{{ route('equipos.index') }}" class="text-gray-600 hover:underline">Cancelar</a>
</div>
