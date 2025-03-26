<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { ref, onMounted } from 'vue';
import axios from 'axios';
import { Line } from 'vue-chartjs';
import { Chart as ChartJS, Title, Tooltip, Legend, LineElement, CategoryScale, LinearScale } from 'chart.js';

// Register chart.js components
ChartJS.register(Title, Tooltip, Legend, LineElement, CategoryScale, LinearScale);

// Datos del gráfico
const chartData = ref({
    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'],
    datasets: [
        {
            label: 'Usuarios Registrados',
            data: [60, 70, 80, 90, 100, 110, 120],
            borderColor: '#4CAF50',
            backgroundColor: 'rgba(76, 175, 80, 0.2)',
            fill: true,
        },
    ],
});

// Obtener los datos de la base de datos
const fetchUserStats = async () => {
    try {
        const response = await axios.get('/api/user-registration-stats');
        const data = response.data;

        const labels = data.map(item => {
            const date = new Date();
            date.setMonth(item.month - 1);
            return date.toLocaleString('default', { month: 'short' });
        });

        const users = data.map(item => item.user_count);

        chartData.value.labels = labels;
        chartData.value.datasets[0].data = users;
    } catch (error) {
        console.error("Error fetching user stats:", error);
    }
};

onMounted(() => {
    fetchUserStats();
});
</script>

<template>
    <div class="flex h-screen bg-gray-800">
        <div class="w-64 bg-gray-900 text-white p-6">
            <div class="text-xl font-semibold mb-8">Dashboard</div>
            <ul>
                <li class="mb-4">
                    <a href="#" class="text-gray-400 hover:text-white">Inicio</a>
                </li>
                <li class="mb-4">
                    <a href="#" class="text-gray-400 hover:text-white">Usuarios</a>
                </li>
                <li class="mb-4">
                    <a href="#" class="text-gray-400 hover:text-white">Suscripciones</a>
                </li>
                <li class="mb-4">
                    <a href="#" class="text-gray-400 hover:text-white">Ajustes</a>
                </li>
            </ul>
        </div>
        <!-- Main Content -->
        <div class="flex h-screen bg-gray-800 p-6 w-full flex-col">
            <!-- Header -->
            <div class="bg-gray-900 text-white p-4 mb-6 flex justify-between items-center">
                <h1 class="text-2xl font-semibold">Dashboard</h1>
                <button class="bg-indigo-600 px-4 py-2 rounded-lg">Notificaciones</button>
            </div>
            <!-- Stats and Graphs -->
            <div class="grid grid-cols-3 gap-6">
                <!-- Card 1 -->
                <div class="bg-white p-6 rounded-lg shadow-lg">
                    <h2 class="text-xl font-semibold text-gray-900">Total Usuarios</h2>
                    <div class="mt-4 text-3xl font-bold text-green-600">120</div>
                </div>
                <!-- Card 2 -->
                <div class="bg-white p-6 rounded-lg shadow-lg">
                    <h2 class="text-xl font-semibold text-gray-900">Usuarios Activos</h2>
                    <div class="mt-4 text-3xl font-bold text-blue-600">95</div>
                </div>
                <!-- Card 3 -->
                <div class="bg-white p-6 rounded-lg shadow-lg">
                    <h2 class="text-xl font-semibold text-gray-900">Usuarios Inactivos</h2>
                    <div class="mt-4 text-3xl font-bold text-red-600">25</div>
                </div>
                <!-- Graph Section -->
                <div class="bg-white p-6 rounded-lg shadow-lg col-span-3">
                    <h2 class="text-xl font-semibold text-gray-900">Usuarios Registrados</h2>
                    <line-chart :data="chartData" />
                </div>
                <!-- Card 4 -->
                <div class="bg-white p-6 rounded-lg shadow-lg col-span-3">
                    <h2 class="text-xl font-semibold text-gray-900">Usuarios Registrados</h2>
                    <div class="mt-4">
                        <table class="w-full">
                            <thead>
                                <tr>
                                    <th class="text-left">Mes</th>
                                    <th class="text-right
                                    ">Usuarios</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Ene</td>
                                    <td class="text-right
                                    ">60</td>
                                </tr>
                                <tr>
                                    <td>Feb</td>
                                    <td class="text-right
                                    ">70</td>
                                </tr>
                                <tr>
                                    <td>Mar</td>
                                    <td class="text-right
                                    ">80</td>
                                </tr>
                                <tr>
                                    <td>Abr</td>
                                    <td class="text-right
                                    ">90</td>
                                </tr>
                                <tr>
                                    <td>May</td>
                                    <td class="text-right
                                    ">100</td>
                                </tr>
                                <tr>
                                    <td>Jun</td>
                                    <td class="text-right
                                    ">110</td>
                                </tr>
                                <tr>
                                    <td>Jul</td>
                                    <td class="text-right
                                    ">120</td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="mt-4 text-right">
                            <a href="#" class="text-indigo-600 hover:text-white">Ver más</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Footer -->
            <div class="bg-gray-900 text-white p-4 mt-auto flex justify-between items-center">
                <p>&copy; 2021 Todos los derechos reservados</p>
                <a href="#" class="text-indigo-600 hover:text-white">Acerca de</a>
                <a href="#" class="text-indigo-600 hover:text-white">Contacto</a>
                <a href="#" class="text-indigo-600 hover:text-white">Términos y Condiciones</a>
                <button class="ml-4 bg-indigo-600 px-4 py-2 rounded-lg">Cerrar Sesión</button>
            </div>
        </div>
    </div>
</template>
