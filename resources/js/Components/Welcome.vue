<script setup>
import { Chart as ChartJS, Title, Tooltip, Legend, LineElement, CategoryScale, LinearScale } from 'chart.js';
import '@fortawesome/fontawesome-free/css/all.min.css';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { ref, onMounted } from 'vue';
import { Line } from 'vue-chartjs';
import axios from 'axios';


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
        </div>
    </div>
    <!-- Footer Cinammon -->
    <!-- Footer con imagen y columnas tipo editorial -->
    <footer class="relative text-white text-center py-5 px-1">
        <div class="max-w-7xl mx-auto px-5 py-10 grid grid-cols-1 md:grid-cols-3 gap-8 z-10 relative">

            <!-- Columna 1 -->
            <div>
                <h2 class="text-xl font-bold mb-4">Cinammon</h2>
                <ul class="space-y-3 text-sm">
                    <li><a href="#">Inicio</a></li>
                    <li><a href="#">Sobre nosotros</a></li>
                    <li><a href="#">Contacto</a></li>
                </ul>
            </div>

            <!-- Columna 2 -->
            <div>
                <h2 class="text-xl font-bold mb-4">Servicios</h2>
                <ul class="space-y-2 text-sm">
                    <li><a href="#">APIs</a></li>
                    <li><a href="#">Documentación</a></li>
                    <li><a href="#">Hosting</a></li>
                </ul>
            </div>

            <!-- Columna 3 -->
            <div>
                <h2 class="text-xl font-bold mb-4">Soporte</h2>
                <ul class="space-y-2 text-sm">
                    <li><a href="#">Discord</a></li>
                    <li><a href="#">Tickets</a></li>
                    <li><a href="#">Blog</a></li>
                </ul>
            </div>

        </div>

        <!-- Imagen de fondo inferior -->
        <div class="absolute inset-0 text-white">
            <img src="https://images.unsplash.com/photo-1500530855697-b586d89ba3ee?auto=format&fit=crop&w=2100&q=80"
                alt="Footer Background" class="w-full h-64 object-cover">
            <div class="absolute inset-0 bg-black bg-opacity-40"></div>
            <div class="absolute bottom-4 left-5 flex gap-4 text-white">
                <p class="mt-6">Copyright © 2022 Cinammon. All rights reserved. </p> 
                <p class="mt-6"><a href="#" class="underline">Términos y Condiciones</a></p>
            </div>
            <div class="absolute bottom-4 right-6 flex gap-6 text-white">
                <a href="#"><i class="fab fa-facebook-f"></i></a>
                <a href="#"><i class="fab fa-twitter"></i></a>
                <a href="#"><i class="fab fa-github"></i></a>
                <a href="#"><i class="fab fa-discord"></i></a>
                <a href="#"><i class="fab fa-instagram"></i></a>
                <a href="#"><i class="fab fa-linkedin-in"></i></a>
                <a href="#"><i class="fab fa-youtube"></i></a>
            </div>
        </div>
    </footer>

</template>
