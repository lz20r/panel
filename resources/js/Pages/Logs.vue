<script setup>
import { ref, watch } from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue'
import { router } from '@inertiajs/vue3'

// Define las props que recibes del backend
const props = defineProps({
    logs: Object,
    filters: Array,
})

// Crea una variable reactiva para almacenar el filtro seleccionado
const filterType = ref('')

// Función para aplicar el filtro
function applyFilter() {
    router.get(route('logs'), { type: filterType.value }, {
        preserveState: true,
        preserveScroll: true, // Mantiene el scroll al aplicar el filtro
    })
}

// Función para navegar a la siguiente o anterior página de logs
function goToPage(url) {
    router.visit(url)
}

// Verifica si hay un cambio en el filtro y vuelve a aplicar el filtro automáticamente
watch(filterType, () => {
    applyFilter()
})
</script>

<template>
    <AppLayout layout="Logs">
        <div class="p-6">
            <h1 class="text-2xl font-bold mb-4">📜 Logs del sistema</h1>

            <!-- Filtro -->
            <div class="mb-4">
                <label class="text-gray-500">Filtrar por tipo:
                    <select v-model="filterType" @change="applyFilter"
                        class="border rounded px-2 py-1 ml-2 text-gray-700">
                        name="select">
                        <option value="">Todos</option>
                        <!-- Filtros disponibles -->
                        <option v-for="filter in props.filters" :key="filter" :value="filter">{{ filter }}</option>
                        <!-- Filtros adicionales -->
                        <option value="error">Error</option>
                        <option value="info">Info</option>
                        <option value="debug">Debug</option>
                        <option value="warning">Warning</option>
                        <option value="notice">Notice</option>
                        <option value="critical">Critical</option>
                        <option value="alert">Alert</option>
                        <option value="emergency">Emergency</option>
                        <option value="routes">Routes</option>
                        <option value="database">Database</option>
                        <option value="queue">Queue</option>
                        <option value="cache">Cache</option>
                        <option value="session">Session</option>
                    </select>
                </label>
            </div>

            <!-- Sin resultados -->
            <div v-if="!props.logs?.data?.length">
                <p class="text-gray-400">No hay logs para mostrar.</p>
            </div>

            <!-- Lista de logs -->
            <div v-else>
                <div v-for="log in props.logs.data" :key="log.id"
                    class="border p-4 mb-2 rounded shadow bg-white dark:bg-gray-900">
                    <p class="text-sm text-gray-500">🕒 {{ new Date(log.created_at).toLocaleString() }}</p>
                    <p><strong>📝 Rutas:</strong> {{ log.message }}</p>
                    <p><strong>🔍 Tipo:</strong> {{ log.type }}</p>
                    <p><strong>🌐 IP:</strong> {{ log.ip }}</p>
                    <p><strong>📦 Metadata:</strong> {{ log.context }}</p>
                    <p class="text-xs text-gray-400 mt-2">🆔 ID: {{ log.id }}</p>

                </div>
            </div>

            <!-- Paginación -->
            <div class="mt-4 flex gap-2">
                <!-- Botón anterior -->
                <button
                    class="border rounded px-2 py-1 text-gray-700 text-sm font-bold text-white bg-gray-800 hover:bg-gray-700"
                    :disabled="props.logs.current_page === 1"
                    @click="goToPage(route('logs', { page: props.logs.current_page - 1 }))">
                    Anterior
                </button>

                <!-- Página actual -->
                <span
                    class="border rounded px-2 py-1 text-gray-700 text-sm font-bold text-white bg-gray-800 hover:bg-gray-700">
                    Página {{ props.logs.current_page }} de {{ props.logs.last_page }}
                </span>

                <!-- Botón siguiente -->
                <button
                    class="border rounded px-2 py-1 text-gray-700 text-sm font-bold text-white bg-gray-800 hover:bg-gray-700"
                    :disabled="props.logs.current_page === props.logs.last_page"
                    @click="goToPage(route('logs', { page: props.logs.current_page + 1 }))">
                    Siguiente
                </button>

            </div>
        </div>
    </AppLayout>
</template>
