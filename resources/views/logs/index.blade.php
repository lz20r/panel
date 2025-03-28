@extends('layouts.app')

@section('content')
<div class="p-6">
    <h1 class="text-2xl font-bold mb-4">📜 Logs del sistema</h1>

    <!-- Filtro -->
    <div class="mb-4">
        <label>Filtrar por tipo:</label>
        <select id="filterType" class="border rounded px-2 py-1 ml-2 text-black">
            <option value="">Todos</option>
            <!-- Filtros disponibles -->
            @foreach ($filters as $filter)
            <option value="{{ $filter }}">{{ ucfirst($filter) }}</option>
            @endforeach
        </select>
    </div>

    <!-- Sin resultados -->
    @if(count($logs) == 0)
    <p class="text-gray-400">No hay logs para mostrar.</p>
    @else
    <!-- Lista de logs -->
    @foreach ($logs as $log)
    <div class="border p-4 mb-2 rounded shadow bg-white dark:bg-gray-900">
        <p class="text-sm text-gray-500">🕒 {{ \Carbon\Carbon::parse($log->created_at)->toLocaleString() }}</p>
        <p><strong>👤 Usuario:</strong> {{ $log->user->name ?? 'Sistema' }}</p>
        <p><strong>🔍 Tipo:</strong> {{ $log->type }}</p>
        <p><strong>📝 Mensaje:</strong> {{ $log->message }}</p>

        <!-- Muestra la ip extraida metadata -->
        <p><strong>🌐 IP:</strong> {{ $log->metadata['ip_address'] ?? 'No disponible' }}</p>

        @if(!empty($log->metadata))
        <div class="mt-2">
            <p><strong>📦 Metadata:</strong></p>
            <pre class="bg-gray-100 text-xs p-2 rounded text-black dark:bg-gray-700 dark:text-white">
            {{ json_encode($log->metadata, JSON_PRETTY_PRINT) }}
            </pre>
        </div>
        @endif

        <p class="text-xs text-gray-400 mt-2">🆔 ID: {{ $log->id }}</p>
    </div>
    @endforeach
    @endif

    <!-- Paginación -->
    <div class="mt-4 flex gap-2">
        @if($logs->previousPageUrl())
        <a href="{{ $logs->previousPageUrl() }}" class="px-3 py-1 bg-gray-200 rounded">← Anterior</a>
        @endif
        @if($logs->nextPageUrl())
        <a href="{{ $logs->nextPageUrl() }}" class="px-3 py-1 bg-gray-200 rounded">Siguiente →</a>
        @endif
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.getElementById('filterType').addEventListener('change', function() {
        let filter = this.value;
        let url = `{{ route('logs') }}?type=${filter}`;
        window.location.href = url;
    });
</script>
@endsection