<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'

const darkMode = ref(false)
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

            axios.post('/logs', {
                type: 'update',
                message: `El usuario cambió al modo ${darkMode.value ? 'oscuro' : 'claro'}`,
                metadata: { darkMode: darkMode.value }
            }).then(() => {
                console.log('📝 Log registrado')
            }).catch(err => {
                console.warn('No se pudo guardar el log del modo oscuro', err)
            })

        })
        .catch((err) => {
            error.value = 'No se pudo guardar el modo oscuro (¿401?)'
            console.warn('Error:', err)
        })
}

onMounted(() => {
    const saved = localStorage.getItem('darkMode')
    darkMode.value = saved === 'true'
    updateTheme()
})
</script>
