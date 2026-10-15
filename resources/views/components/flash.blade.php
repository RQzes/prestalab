@if (session('ok'))
    <div class="mb-4 rounded-md border border-green-300 bg-green-100 px-4 py-3 text-green-800">{{ session('ok') }}</div>
@endif
@if (session('error'))
    <div class="mb-4 rounded-md border border-red-300 bg-red-100 px-4 py-3 text-red-800">{{ session('error') }}</div>
@endif
@if ($errors->any())
    <div class="mb-4 rounded-md border border-red-300 bg-red-100 px-4 py-3 text-red-800">
        <ul class="list-disc pl-5">
            @foreach ($errors->all() as $mensaje)
                <li>{{ $mensaje }}</li>
            @endforeach
        </ul>
    </div>
@endif
