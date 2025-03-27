<script setup>
import { ref, onMounted } from 'vue'
import { usePage } from '@inertiajs/vue3'
import axios from 'axios'

// Obtenemos los props de Inertia (incluye el user si está logueado)
const page = usePage()
const user = page.props.auth?.user

const darkMode = ref(false)
const isLoggedIn = ref(false)
const error = ref(null)

function updateTheme() {
    document.documentElement.classList.toggle('dark', darkMode.value)
    localStorage.setItem('darkMode', darkMode.value)
    document.body.style.background = darkMode.value
        ? 'linear-gradient(to right, #6576B4, #9AA3C6)'
        : '#fff'
    document.body.style.color = darkMode.value ? '#fff' : '#000'
}

function toggleDarkMode() {
    darkMode.value = !darkMode.value
    updateTheme()

    axios.post('/darkMode', { dark: darkMode.value })
        .then(() => {
            console.log('✅ Modo oscuro guardado')
            error.value = null
        })
        .catch((err) => {
            error.value = 'No se pudo guardar el modo oscuro (¿401?)'
            console.warn('Error:', err)
        })
}

function checkLogin() {
    isLoggedIn.value = !!user
    error.value = isLoggedIn.value ? null : 'No estás logueada o la sesión no se reconoció'
    if (isLoggedIn.value) {
        console.log('✅ Logueada/o: como ', user.name)
    } else {
        console.warn('❌ No logueada/o')
    } 
}

onMounted(() => {
    const saved = localStorage.getItem('darkMode')
    darkMode.value = saved === 'true'
    updateTheme()
    checkLogin()
})
</script>

<template>
    <div class="p-6 text-black dark:text-black">
        <h2 class="text-2xl font-bold mb-4">🛠 Debug de sesión y modo oscuro</h2>

        <div class="mb-4">
            <p><strong>Logeada/o</strong> {{ isLoggedIn ? `con el usuario de ${ isLoggedIn ? user.name : 'nadie' }` : 'no' }}</p>
            <p><strong>Estás en modo:</strong> {{ darkMode ? 'claro 🌞' : 'oscuro 🌚' }}</p>
        </div>

        <div class="flex gap-4">
            <button @click="toggleDarkMode" class="px-4 py-2 bg-blue-500 text-black rounded shadow hover:bg-blue-600 transition">
                Alternar Dark Mode
            </button>
            <button @click="checkLogin" class="px-4 py-2 bg-green-500 text-black rounded shadow hover:bg-green-600 transition">
                Verificar sesión
            </button>
        </div>

        <p v-if="error" class="mt-4 text-red-500">⚠️ {{ error }}</p>
    </div>
</template>

<style>
body.dark {
    background: linear-gradient(to right, #6576B4, #9AA3C6);
    color: #fff;
}
</style>
