<script setup>
import { ref, onMounted } from 'vue';
import AppLayout from '@/Layouts/AppLayout.vue';
const notifications = ref([]);

// Simula una llamada a la API para obtener las notificaciones
onMounted(() => {
    // Aquí puedes hacer la llamada real a la API para obtener las notificaciones
    notifications.value = [
        { id: 1, message: 'Nuevo mensaje recibido', created_at: '2021-12-10' },
        { id: 2, message: 'Tu perfil ha sido actualizado', created_at: '2021-12-09' }
    ];
});


</script>

<template>
    <AppLayout title="Notifications">
        <template #header>
            <h2 class="font-semibold text-xl text-white leading-tight">
                Notifications
            </h2>
        </template>

        <div>
            <h1>Tus Notificaciones</h1>
            <ul>
                <li v-for="notification in notifications" :key="notification.id">
                    {{ notification.message }}
                    <small>{{ notification.created_at }}</small>
                </li>
            </ul>
        </div>
    </AppLayout>
</template>
