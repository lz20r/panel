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
                    <select v-model="filterType" @change="applyFilter" class="border rounded px-2 py-1 ml-2 text-black"
                        name="select">
                        <option value="">Todos</option>
                        <!-- Filtros disponibles -->
                        <option v-for="filter in props.filters" :key="filter" :value="filter">{{ filter }}</option>
                        <!-- Filtros adicionales -->
                        <option value="alert">Alerta</option>
                        <option value="advertencia">Advertencia</option>
                        <option value="critical">Crítica</option>
                        <option value="login">Inicio de sesión</option>
                        <option value="logout">Cierre de sesión</option>
                        <option value="delete">Eliminación</option>
                        <option value="update">Actualización</option>
                        <option value="create">Creación</option>
                        <option value="warning">Emergencia</option>
                        <option value="error">Error</option>
                        <option value="success">Éxito</option>
                        <option value="info">Información</option>
                        <option value="notice">Notificación</option>
                        <option value="debug">Depuración</option>
                        <option value="trace">Rastreo</option>
                        <option value="emergency">Sobrecarga</option>
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
                    <p><strong>👤 Usuario:</strong> {{ log.user?.name ?? 'Sistema' }}</p>
                    <p><strong>🔍 Tipo:</strong> {{ log.type }}</p>
                    <p><strong>📝 Mensaje:</strong> {{ log.message }}</p>
                    <!-- Muestra la ip extraida metadata -->
                    <p><strong>🌐 IP:</strong> {{ log.metadata?.ip_address }}</p>
                    <div v-if="log.metadata && Object.keys(log.metadata).length" class="mt-2">
                        <p><strong>📦 Metadata:</strong></p>
                        <pre class="bg-gray-100 text-xs p-2 rounded text-black dark:bg-gray-700 dark:text-white">
                        {{ JSON.stringify(log.metadata, null, 2) }}
                        </pre>
                    </div>
                    <p class="text-xs text-gray-400 mt-2">🆔 ID: {{ log.id }}</p>

                </div>
            </div>

            <!-- Paginación -->
            <div class="mt-4 flex gap-2">
                <button v-if="props.logs?.prev_page_url" @click="goToPage(props.logs.prev_page_url)"
                    class="px-3 py-1 bg-gray-200 rounded">
                    ← Anterior
                </button>
                <button v-if="props.logs?.next_page_url" @click="goToPage(props.logs.next_page_url)"
                    class="px-3 py-1 bg-gray-200 rounded">
                    Siguiente →
                </button>
            </div>
        </div>
    </AppLayout>
</template>
