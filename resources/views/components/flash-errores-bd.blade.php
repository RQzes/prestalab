@if (session('error'))
    <div class="mb-4 rounded-md border border-red-300 bg-red-100 px-4 py-3 text-red-800">{{ session('error') }}</div>
@endif
