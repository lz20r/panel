<script setup>
import { ref } from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue'
import { router } from '@inertiajs/vue3'

// Props del backend
const props = defineProps({
    logs: Object,
    filters: Object,
    selectedFilter: String,
})

// Filtro seleccionado
const filterType = ref(props.selectedFilter || '')

// Al cambiar el filtro
function applyFilter() {
    router.get(route('logs'), {
        type: filterType.value
    }, {
        preserveScroll: true,
        preserveState: false,
    })
}

// Navegación entre páginas
function goToPage(url) {
    router.visit(url, {
        preserveScroll: true,
        preserveState: true,
    })
}

// Borrar logs antiguos
function clearLogs() {
    router.visit(route('logs.clear'), {
        method: 'delete',
        preserveScroll: true,
        preserveState: false,
    })
}
</script>

<template>
    <AppLayout layout="Logs">
        <div class="p-6">
            <h1 class="text-2xl font-bold mb-4">📜 Logs del sistema</h1>
            <h2 class="text-gray-500 mb-4">Total de logs: {{ props.logs.total }}</h2>

            <!-- 🔘 Filtro -->
            <div class="mb-4">
                <label class="text-gray-500">
                    Filtrar por tipo:
                    <select name="type" v-model="filterType" @change="applyFilter"
                        class="border rounded px-2 py-1 ml-2 text-gray-700">
                        <option value="">Todos</option>
                        <option v-for="(label, key) in props.filters" :key="key" :value="key">
                            {{ label }}
                        </option>
                    </select>
                </label>
            </div>

            <!-- 🚫 Sin resultados -->
            <div v-if="!props.logs?.data?.length">
                <p class="text-gray-400">No hay logs para mostrar.</p>
            </div>

            <!-- 📋 Lista de logs -->
            <div v-else>
                <div v-for="log in props.logs.data" :key="log.id"
                    class="shadow-md rounded-lg p-4 mb-4 border border-gray-200 hover:border-gray-300">
                    <p class="text-sm text-gray-500"><strong>🕒 Fecha:</strong>
                        {{ new Date(log.created_at).toLocaleString() }}
                    </p>
                    <p class="text-sm text-gray-500"><strong>📝 Ruta:</strong> {{ log.message }}</p>
                    <p class="text-sm text-gray-500"><strong>🔍 Tipo:</strong> <span
                            class="font-bold">{{ log.type }}</span></p>
                    <p class="text-sm text-gray-500"><strong>🌐 IP:</strong> {{ log.ip }}</p>
                    <p class="text-sm text-gray-500"><strong>🔧 Método:</strong> {{ log.method }}</p>
                    <p class="text-sm text-gray-500"><strong>📍 Ruta:</strong> {{ log.route || 'N/A' }}</p>
                    <p class="text-sm text-gray-500"><strong>🧭 Navegador:</strong> {{ log.user_agent }}</p>
                    <p class="text-sm text-gray-500"><strong>📦 Contexto:</strong> {{ log.context }}</p>
                </div>
            </div>

            <!-- ⏭ Paginación -->
            <div class="mt-4 flex gap-2 items-center">
                <button @click="goToPage(route('logs', { page: props.logs.current_page - 1, type: filterType.value }))"
                    :disabled="props.logs.current_page === 1"
                    class="bg-gray-700 hover:bg-gray-600 text-white px-3 py-1 rounded">
                    Anterior
                </button>

                <span class="text-sm">
                    Página {{ props.logs.current_page }} de {{ props.logs.last_page }}
                </span>

                <button @click="goToPage(route('logs', { page: props.logs.current_page + 1, type: filterType.value }))"
                    :disabled="props.logs.current_page === props.logs.last_page"
                    class="bg-gray-700 hover:bg-gray-600 text-white px-3 py-1 rounded">
                    Siguiente
                </button>

                <!-- 🧹 Botón de limpieza -->
                <button @click="clearLogs"
                    class="ml-auto bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded font-bold text-sm">
                    🧹 Limpiar logs antiguos
                </button>
            </div>
        </div>
    </AppLayout>
</template>
