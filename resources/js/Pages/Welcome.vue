<script setup>
import { Pagination, Navigation, Autoplay } from 'swiper/modules';
import { Swiper, SwiperSlide } from 'swiper/vue';
import { Head, Link } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';
import axios from 'axios';

import '@fortawesome/fontawesome-free/css/all.min.css';
import 'swiper/css';
import 'swiper/css/pagination';
import 'swiper/css/navigation';

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    laravelVersion: {
        type: String,
        required: true,
    },
    phpVersion: {
        type: String,
        required: true,
    },
});

function handleImageError() {
    document.getElementById('screenshot-container')?.classList.add('!hidden');
    document.getElementById('docs-card')?.classList.add('!row-span-1');
    document.getElementById('docs-card-content')?.classList.add('!flex-row');
    document.getElementById('background')?.classList.add('!hidden');
}
const modules = [Pagination, Navigation, Autoplay];
const features = [
    { title: "Rendimiento", description: "Servidores de alta velocidad para cargas rápidas.", icon: "fas fa-microchip" },
    { title: "Seguridad", description: "Protegemos tu proyecto con tecnologías avanzadas.", icon: "fas fa-shield-alt" },
    { title: "Soporte 24/7", description: "Soporte técnico disponible en todo momento.", icon: "fas fa-headset" },
    { title: "Escalabilidad", description: "Infraestructura adaptable para crecimiento ilimitado.", icon: "fas fa-expand-arrows-alt" },
    { title: "Hosting Seguro", description: "Infraestructura optimizada con alta seguridad.", icon: "fas fa-server" },
    { title: "Alta Disponibilidad", description: "Servidores confiables 24/7 con uptime garantizado.", icon: "fas fa-cloud" },
    { title: "Optimización Gaming", description: "Soluciones para servidores de juegos con baja latencia.", icon: "fas fa-gamepad" },
    { title: "Copias de Seguridad", description: "Backups automáticos para proteger tus datos.", icon: "fas fa-database" }
];

const contributors = [
    { name: "Alice", role: "Desarrolladora", avatar: "https://avatars.steamstatic.com/9b38510b533396323f555650a039bfd964099fde_full.jpg" },
    { name: "Bob", role: "Diseñador", avatar: "https://avatars.steamstatic.com/9b05c1f921552afc849854eafb55b652b31719a6_full.jpg" },
    { name: "Charlie", role: "Tester", avatar: "https://avatars.steamstatic.com/9b116090e35b2703aab9b10ab5fa663822de32f7_full.jpg" },
    { name: "Diana", role: "Gestora de Proyecto", avatar: "https://avatars.steamstatic.com/9b48aa1a91ffa32d6fc960068cebf2eec0e4ee18_full.jpg" }
];

const sidebarOpen = ref(false);
function toggleSidebar() {
    sidebarOpen.value = !sidebarOpen.value;
    document.body.style.overflow = sidebarOpen.value ? 'hidden' : 'auto';

    if (darkMode.value !== false) {
        document.body.style.background = `linear-gradient(to right, ${darkMode.value ? '#6576B4' : '#9AA3C6'}, ${darkMode.value ? '#9AA3C6' : '#6576B4'})`;
    } else {
        document.body.style.background = '#fff';
        document.body.style.color = '#000';
    }
}

const darkMode = ref(false);

onMounted(() => {
    const saved = localStorage.getItem('darkMode');

    if (saved === null) {
        // Si no está en localStorage, tomar desde el backend
        darkMode.value = $page.props.auth.user?.dark_mode ?? false;
    } else {
        darkMode.value = saved === 'true';
    }

    updateTheme();
});

function updateTheme() {
    document.documentElement.classList.toggle('dark', darkMode.value);
    localStorage.setItem('darkMode', darkMode.value);
    document.body.style.background = darkMode.value
        ? 'linear-gradient(to right, #6576B4, #9AA3C6)'
        : '#fff';
    document.body.style.color = darkMode.value ? '#fff' : '#000';
}

function toggleDarkMode() {
    darkMode.value = !darkMode.value;
    updateTheme();

    // Guardar en backend
    axios.post('/darkMode', { dark: darkMode.value })
        .then(() => console.log('Dark mode guardado 🖤'))
        .catch(() => console.warn('Error al guardar el dark mode'));
}
</script>

<template>
    <Head title="Welcome" />
    <div class="bg-gray-50 text-black/50 dark:bg-black dark:text-white/50">
        <img id="background" class="absolute -left-20 top-0 max-w-[877px]"
            src="https://laravel.com/assets/img/welcome/background.svg" />
        <div
            class="relative min-h-screen flex flex-col items-center justify-center selection:bg-[#FF2D20] selection:text-white">
            <div class="relative w-full max-w-2xl px-6 lg:max-w-7xl">
                <!-- Header -->
                <header>
                    <!-- NAVBAR -->
                    <nav class="p-4 flex justify-between items-center shadow-lg text-center ">
                        <!-- Botón Menú (Móvil) -->
                        <div class="flex items-justify gap-4">

                            <svg class="h-12 w-auto lg:h-16 lg:text-[#FF2D20] mx-auto" viewBox="0 0 62 65" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M61.8548 14.6253C61.8778 14.7102 61.8895 14.7978 61.8897 14.8858V28.5615C61.8898 28.737 61.8434 28.9095 61.7554 29.0614C61.6675 29.2132 61.5409 29.3392 61.3887 29.4265L49.9104 36.0351V49.1337C49.9104 49.4902 49.7209 49.8192 49.4118 49.9987L25.4519 63.7916C25.3971 63.8227 25.3372 63.8427 25.2774 63.8639C25.255 63.8714 25.2338 63.8851 25.2101 63.8913C25.0426 63.9354 24.8666 63.9354 24.6991 63.8913C24.6716 63.8838 24.6467 63.8689 24.6205 63.8589C24.5657 63.8389 24.5084 63.8215 24.456 63.7916L0.501061 49.9987C0.348882 49.9113 0.222437 49.7853 0.134469 49.6334C0.0465019 49.4816 0.000120578 49.3092 0 49.1337L0 8.10652C0 8.01678 0.0124642 7.92953 0.0348998 7.84477C0.0423783 7.8161 0.0598282 7.78993 0.0697995 7.76126C0.0884958 7.70891 0.105946 7.65531 0.133367 7.6067C0.152063 7.5743 0.179485 7.54812 0.20192 7.51821C0.230588 7.47832 0.256763 7.43719 0.290416 7.40229C0.319084 7.37362 0.356476 7.35243 0.388883 7.32751C0.425029 7.29759 0.457436 7.26518 0.498568 7.2415L12.4779 0.345059C12.6296 0.257786 12.8015 0.211853 12.9765 0.211853C13.1515 0.211853 13.3234 0.257786 13.475 0.345059L25.4531 7.2415H25.4556C25.4955 7.26643 25.5292 7.29759 25.5653 7.32626C25.5977 7.35119 25.6339 7.37362 25.6625 7.40104C25.6974 7.43719 25.7224 7.47832 25.7523 7.51821C25.7735 7.54812 25.8021 7.5743 25.8196 7.6067C25.8483 7.65656 25.8645 7.70891 25.8844 7.76126C25.8944 7.78993 25.9118 7.8161 25.9193 7.84602C25.9423 7.93096 25.954 8.01853 25.9542 8.10652V33.7317L35.9355 27.9844V14.8846C35.9355 14.7973 35.948 14.7088 35.9704 14.6253C35.9792 14.5954 35.9954 14.5692 36.0053 14.5405C36.0253 14.4882 36.0427 14.4346 36.0702 14.386C36.0888 14.3536 36.1163 14.3274 36.1375 14.2975C36.1674 14.2576 36.1923 14.2165 36.2272 14.1816C36.2559 14.1529 36.292 14.1317 36.3244 14.1068C36.3618 14.0769 36.3942 14.0445 36.4341 14.0208L48.4147 7.12434C48.5663 7.03694 48.7383 6.99094 48.9133 6.99094C49.0883 6.99094 49.2602 7.03694 49.4118 7.12434L61.3899 14.0208C61.4323 14.0457 61.4647 14.0769 61.5021 14.1055C61.5333 14.1305 61.5694 14.1529 61.5981 14.1803C61.633 14.2165 61.6579 14.2576 61.6878 14.2975C61.7103 14.3274 61.7377 14.3536 61.7551 14.386C61.7838 14.4346 61.8 14.4882 61.8199 14.5405C61.8312 14.5692 61.8474 14.5954 61.8548 14.6253ZM59.893 27.9844V16.6121L55.7013 19.0252L49.9104 22.3593V33.7317L59.8942 27.9844H59.893ZM47.9149 48.5566V37.1768L42.2187 40.4299L25.953 49.7133V61.2003L47.9149 48.5566ZM1.99677 9.83281V48.5566L23.9562 61.199V49.7145L12.4841 43.2219L12.4804 43.2194L12.4754 43.2169C12.4368 43.1945 12.4044 43.1621 12.3682 43.1347C12.3371 43.1097 12.3009 43.0898 12.2735 43.0624L12.271 43.0586C12.2386 43.0275 12.2162 42.9888 12.1887 42.9539C12.1638 42.9203 12.1339 42.8916 12.114 42.8567L12.1127 42.853C12.0903 42.8156 12.0766 42.7707 12.0604 42.7283C12.0442 42.6909 12.023 42.656 12.013 42.6161C12.0005 42.5688 11.998 42.5177 11.9931 42.4691C11.9881 42.4317 11.9781 42.3943 11.9781 42.3569V15.5801L6.18848 12.2446L1.99677 9.83281ZM12.9777 2.36177L2.99764 8.10652L12.9752 13.8513L22.9541 8.10527L12.9752 2.36177H12.9777ZM18.1678 38.2138L23.9574 34.8809V9.83281L19.7657 12.2459L13.9749 15.5801V40.6281L18.1678 38.2138ZM48.9133 9.14105L38.9344 14.8858L48.9133 20.6305L58.8909 14.8846L48.9133 9.14105ZM47.9149 22.3593L42.124 19.0252L37.9323 16.6121V27.9844L43.7219 31.3174L47.9149 33.7317V22.3593ZM24.9533 47.987L39.59 39.631L46.9065 35.4555L36.9352 29.7145L25.4544 36.3242L14.9907 42.3482L24.9533 47.987Z"
                                    fill="currentColor" />
                            </svg>
                            <button @click="toggleSidebar" class="text-3xl lg:hidden mr-3">
                                <i class="fas fa-bars"></i>
                            </button>
                        </div>

                        <!-- Menú Principal (Escritorio) -->
                        <div class="hidden lg:flex gap-5">
                            <Link v-if="$page.props.auth.user" href="docs" class="hover:text-[#c6cde7] transition">Docs
                            </Link>
                            <Link v-if="$page.props.auth.user" href="blog" class="hover:text-[#c6cde7] transition">Blog
                            </Link>
                            <Link v-if="$page.props.auth.user" href="donate" class="hover:text-[#c6cde7] transition">
                            Donate
                            </Link>
                            <Link v-if="$page.props.auth.user" href="faq" class="hover:text-[#c6cde7] transition">FAQ
                            </Link>
                            <Link v-if="$page.props.auth.user" href="hub" class="hover:text-[#c6cde7] transition">Hub
                            </Link>
                            <Link v-if="$page.props.auth.user" href="eggs" class="hover:text-[#c6cde7] transition">Eggs
                            </Link>
                            <Link v-if="$page.props.auth.user" :href="route('dashboard')"
                                class="hover:text-[#c6cde7] transition">Dashboard</Link>
                            <template v-else>
                                <Link href="docs" class="hover:text-[#c6cde7] transition">Docs</Link>
                                <Link href="blog" class="hover:text-[#c6cde7] transition">Blog</Link>
                                <Link href="donate" class="hover:text-[#c6cde7] transition">Donate</Link>
                                <Link href="faq" class="hover:text-[#c6cde7] transition">FAQ</Link>
                                <Link href="hub" class="hover:text-[#c6cde7] transition">Hub</Link>
                                <Link href="eggs" class="hover:text-[#c6cde7] transition">Eggs</Link>
                                <Link v-if="canLogin" :href="route('login')" class="hover:text-[#c6cde7] transition">
                                Iniciar
                                Sesión</Link>
                                <Link v-if="canRegister" :href="route('register')"
                                    class="hover:text-[#c6cde7] transition">
                                Registrarse</Link>
                            </template>
                        </div>

                        <!-- ICONOS A LA DERECHA -->
                        <div class="flex items-center gap-4">
                            <a href="https://github.com/cinammon-es/" target="_blank"><i
                                    class="fab fa-github text-xl cursor-pointer hover:text-gray-400"></i></a>
                            <a href="https://discord.com" target="_blank"><i
                                    class="fab fa-discord text-xl cursor-pointer hover:text-gray-400"></i></a>
                            <button @click="toggleDarkMode">
                                <i :class="darkMode ? 'fas fa-moon' : 'fas fa-sun'"
                                    class="text-xl cursor-pointer hover:text-gray-400"></i>
                            </button>
                            <!-- Barra de búsqueda -->
                            <div class="hidden md:flex px-5 py-1 items-center gap-3">
                                <i class="fas fa-search"></i>
                                <input type="text" placeholder="Buscar..."
                                    class="border-0 bg-[#8b96bf] rounded-full px-3 py-1 w-full focus:outline-none focus:ring-0" />
                            </div>
                        </div>
                    </nav>

                    <!-- MENÚ LATERAL (Móvil) -->
                    <div :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
                        class="fixed top-0 left-0 h-full w-64 bg-white text-black transition-transform duration-300 ease-in-out z-50">
                        <div class="flex justify-end p-4">
                            <button @click="toggleSidebar" class="text-3xl">&times;</button>
                        </div>
                        <nav class="flex flex-col gap-4 px-6">
                            <Link v-if="$page.props.auth.user" href="docs" class="hover:text-[#c6cde7] transition">Docs
                            </Link>
                            <Link v-if="$page.props.auth.user" href="blog" class="hover:text-[#c6cde7] transition">Blog
                            </Link>
                            <Link v-if="$page.props.auth.user" href="donate" class="hover:text-[#c6cde7] transition">
                            Donate
                            </Link>
                            <Link v-if="$page.props.auth.user" href="faq" class="hover:text-[#c6cde7] transition">FAQ
                            </Link>
                            <Link v-if="$page.props.auth.user" href="hub" class="hover:text-[#c6cde7] transition">Hub
                            </Link>
                            <Link v-if="$page.props.auth.user" href="eggs" class="hover:text-[#c6cde7] transition">Eggs
                            </Link>
                            <Link v-if="$page.props.auth.user" :href="route('dashboard')"
                                class="hover:text-[#c6cde7] transition">Dashboard
                            </Link>
                            <template v-else>
                                <Link href="docs" class="hover:text-[#c6cde7] transition">Docs</Link>
                                <Link href="blog" class="hover:text-[#c6cde7] transition">Blog</Link>
                                <Link href="donate" class="hover:text-[#c6cde7] transition">Donate</Link>
                                <Link href="faq" class="hover:text-[#c6cde7] transition">FAQ</Link>
                                <Link href="hub" class="hover:text-[#c6cde7] transition">Hub</Link>
                                <Link href="eggs" class="hover:text-[#c6cde7] transition">Eggs</Link>
                            </template>
                        </nav>
                    </div>
                </header>

                <!-- Hero Section -->
                <section class="py-40 px-6 text-center">
                    <h1 class="text-5xl font-bold">Cinammon</h1>
                    <p class="mt-4 text-lg">From foundation to forefront: Cinammon leads the way!</p>
                    <div class="mt text-lg text-center space-x-4">
                        <a href="install"
                            class="mt-6 inline-block py-2 px-6 rounded-lg text-lg hover:bg-gray-800">Instalar</a>
                        <a href="Demo" class="mt-6 inline-block py-2 px-6 rounded-lg text-lg hover:bg-gray-800">
                            Demo</a>
                    </div>

                </section>

                <!-- Features Swiper -->
                <section class=" py-20 px-6">
                    <h2 class="text-4xl font-bold text-center">Características Destacadas</h2>
                    <Swiper :modules="modules" :spaceBetween="20" :slidesPerView="3" :loop="true"
                        :autoplay="{ delay: 1000, disableOnInteraction: false }">
                        <SwiperSlide v-for="(feature, index) in features" :key="index">
                            <div class="bg-black p-4 rounded-lg shadow-lg text-center text-[#9aa3c6] ">
                                <i :class="feature.icon" class="text-5xl text-[#9aa3c6] mb-4"></i>
                                <h2 class="text-x font-bold">{{ feature.title }}</h2>
                                <p class="text-[#9aa3c6] dark:text-">{{ feature.description }}</p>
                            </div>
                        </SwiperSlide>
                    </Swiper>
                </section>

                <!-- Testimonials Section -->
                <section class="py-20 px-6 ">
                    <div class="max-w-6xl mx-auto">
                        <h2 class="text-3xl font-bold text-center">Testimonios</h2>
                        <div class="mt-10 grid mx-auto">
                            <div class="bg-black p-6 rounded-lg shadow-lg text-center text-[#9aa3c6] ">
                                <p class="text-lg">"Cinammon ha sido la mejor elección para mi proyecto, la velocidad y
                                    seguridad que ofrece es increíble."</p>
                                <p class="mt-4 font-bold">- John Doe</p>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Contribuidores Section -->
                <section class="py-20 px-6 max-w-6xl mx-auto text-center">
                    <h2 class="text-3xl font-bold">Contribuidores</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8 mt-10">
                        <div v-for="(contributor, index) in contributors" :key="index"
                            class="bg-black p-6 rounded-lg shadow-lg text-center text-[#9aa3c6] ">
                            <img :src="contributor.avatar" alt="Avatar" class="w-20 h-20 rounded-full mx-auto mb-4">
                            <h3 class="text-xl font-bold">{{ contributor.name }}</h3>
                            <p class="text-gray-600 dark:text-gray-300">{{ contributor.role }}</p>
                        </div>
                    </div>
                </section>

                <footer class="py-10 text-center text-sm text-white">
                    <div class="grid grid-cols-1 gap-8 max-w-6xl mx-auto lg:grid-cols-2">

                        <div>
                            <h3 class="text-lg font-bold">Documentation</h3>
                            <ul class="mt-2 space-y-2">
                                <li><a href="#" class="hover:underline">Panel</a></li>
                                <li><a href="#" class="hover:underline">Wings</a></li>
                                <li><a href="#" class="hover:underline">SSL Setup</a></li>
                            </ul>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold">Community</h3>
                            <ul class="mt-2 space-y-2">
                                <li><a href="#" class="hover:underline">Discord</a></li>
                                <li><a href="#" class="hover:underline">Blog</a></li>
                                <li><a href="#" class="hover:underline">GitHub</a></li>
                            </ul>
                        </div>
                        <div class="lg:col-span-2">
                            <svg class="h-12 w-auto lg:h-16 lg:text-[#FF2D20] mx-auto" viewBox="0 0 62 65" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M61.8548 14.6253C61.8778 14.7102 61.8895 14.7978 61.8897 14.8858V28.5615C61.8898 28.737 61.8434 28.9095 61.7554 29.0614C61.6675 29.2132 61.5409 29.3392 61.3887 29.4265L49.9104 36.0351V49.1337C49.9104 49.4902 49.7209 49.8192 49.4118 49.9987L25.4519 63.7916C25.3971 63.8227 25.3372 63.8427 25.2774 63.8639C25.255 63.8714 25.2338 63.8851 25.2101 63.8913C25.0426 63.9354 24.8666 63.9354 24.6991 63.8913C24.6716 63.8838 24.6467 63.8689 24.6205 63.8589C24.5657 63.8389 24.5084 63.8215 24.456 63.7916L0.501061 49.9987C0.348882 49.9113 0.222437 49.7853 0.134469 49.6334C0.0465019 49.4816 0.000120578 49.3092 0 49.1337L0 8.10652C0 8.01678 0.0124642 7.92953 0.0348998 7.84477C0.0423783 7.8161 0.0598282 7.78993 0.0697995 7.76126C0.0884958 7.70891 0.105946 7.65531 0.133367 7.6067C0.152063 7.5743 0.179485 7.54812 0.20192 7.51821C0.230588 7.47832 0.256763 7.43719 0.290416 7.40229C0.319084 7.37362 0.356476 7.35243 0.388883 7.32751C0.425029 7.29759 0.457436 7.26518 0.498568 7.2415L12.4779 0.345059C12.6296 0.257786 12.8015 0.211853 12.9765 0.211853C13.1515 0.211853 13.3234 0.257786 13.475 0.345059L25.4531 7.2415H25.4556C25.4955 7.26643 25.5292 7.29759 25.5653 7.32626C25.5977 7.35119 25.6339 7.37362 25.6625 7.40104C25.6974 7.43719 25.7224 7.47832 25.7523 7.51821C25.7735 7.54812 25.8021 7.5743 25.8196 7.6067C25.8483 7.65656 25.8645 7.70891 25.8844 7.76126C25.8944 7.78993 25.9118 7.8161 25.9193 7.84602C25.9423 7.93096 25.954 8.01853 25.9542 8.10652V33.7317L35.9355 27.9844V14.8846C35.9355 14.7973 35.948 14.7088 35.9704 14.6253C35.9792 14.5954 35.9954 14.5692 36.0053 14.5405C36.0253 14.4882 36.0427 14.4346 36.0702 14.386C36.0888 14.3536 36.1163 14.3274 36.1375 14.2975C36.1674 14.2576 36.1923 14.2165 36.2272 14.1816C36.2559 14.1529 36.292 14.1317 36.3244 14.1068C36.3618 14.0769 36.3942 14.0445 36.4341 14.0208L48.4147 7.12434C48.5663 7.03694 48.7383 6.99094 48.9133 6.99094C49.0883 6.99094 49.2602 7.03694 49.4118 7.12434L61.3899 14.0208C61.4323 14.0457 61.4647 14.0769 61.5021 14.1055C61.5333 14.1305 61.5694 14.1529 61.5981 14.1803C61.633 14.2165 61.6579 14.2576 61.6878 14.2975C61.7103 14.3274 61.7377 14.3536 61.7551 14.386C61.7838 14.4346 61.8 14.4882 61.8199 14.5405C61.8312 14.5692 61.8474 14.5954 61.8548 14.6253ZM59.893 27.9844V16.6121L55.7013 19.0252L49.9104 22.3593V33.7317L59.8942 27.9844H59.893ZM47.9149 48.5566V37.1768L42.2187 40.4299L25.953 49.7133V61.2003L47.9149 48.5566ZM1.99677 9.83281V48.5566L23.9562 61.199V49.7145L12.4841 43.2219L12.4804 43.2194L12.4754 43.2169C12.4368 43.1945 12.4044 43.1621 12.3682 43.1347C12.3371 43.1097 12.3009 43.0898 12.2735 43.0624L12.271 43.0586C12.2386 43.0275 12.2162 42.9888 12.1887 42.9539C12.1638 42.9203 12.1339 42.8916 12.114 42.8567L12.1127 42.853C12.0903 42.8156 12.0766 42.7707 12.0604 42.7283C12.0442 42.6909 12.023 42.656 12.013 42.6161C12.0005 42.5688 11.998 42.5177 11.9931 42.4691C11.9881 42.4317 11.9781 42.3943 11.9781 42.3569V15.5801L6.18848 12.2446L1.99677 9.83281ZM12.9777 2.36177L2.99764 8.10652L12.9752 13.8513L22.9541 8.10527L12.9752 2.36177H12.9777ZM18.1678 38.2138L23.9574 34.8809V9.83281L19.7657 12.2459L13.9749 15.5801V40.6281L18.1678 38.2138ZM48.9133 9.14105L38.9344 14.8858L48.9133 20.6305L58.8909 14.8846L48.9133 9.14105ZM47.9149 22.3593L42.124 19.0252L37.9323 16.6121V27.9844L43.7219 31.3174L47.9149 33.7317V22.3593ZM24.9533 47.987L39.59 39.631L46.9065 35.4555L36.9352 29.7145L25.4544 36.3242L14.9907 42.3482L24.9533 47.987Z"
                                    fill="currentColor" />
                            </svg>
                        </div>
                    </div>
                    <!-- Copyright -->
                    <p class="mt-8">Copyright © 2022 Cinammon v{{ laravelVersion }} (PHP v{{ phpVersion }}). All rights
                        reserved.
                    </p>
                </footer>
            </div>
        </div>
    </div>
</template>
