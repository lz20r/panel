<script setup>
import { ref, onMounted } from 'vue';

const accepted = ref(false);
const activeSection = ref('section1');
const showModal = ref(true);

const OFFSET = 100;

onMounted(() => {
    const scrollToHash = (hash) => {
        const target = document.querySelector(hash);
        if (target) {
            const y = target.getBoundingClientRect().top + window.scrollY - OFFSET;
            window.scrollTo({ top: y, behavior: 'smooth' });
        }
    };

    document.querySelectorAll('a[href^="#"]').forEach((link) => {
        link.addEventListener('click', (e) => {
            e.preventDefault();
            const hash = link.getAttribute('href');
            scrollToHash(hash);
            history.pushState(null, '', hash);
        });
    });

    const observer = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    activeSection.value = entry.target.id;
                }
            });
        },
        {
            rootMargin: `-${OFFSET + 10}px 0px -80% 0px`,
            threshold: 0,
        }
    );

    const sections = document.querySelectorAll('section[id]');
    sections.forEach((section) => observer.observe(section));

    if (window.location.hash) {
        scrollToHash(window.location.hash);
    }
});

function acceptTerms() {
    accepted.value = true;
    showModal.value = false;
    if (accepted.value) {
        window.location.href = '/terms/' + accepted.value;
    }
}
</script>

<template>
    <div class="bg-gray-50 text-black/50 dark:bg-black dark:text-white/50 min-h-screen">
        <nav class="bg-white dark:bg-gray-900 shadow sticky top-0 z-50">
            <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
                <h1 class="text-xl font-bold text-black dark:text-white">Cinashop</h1>
                <ul class="hidden md:flex gap-6 text-sm font-medium">
                    <li><a href="#section1" class="hover:text-blue-600">Generalidades</a></li>
                    <li><a href="#section2" class="hover:text-blue-600">Acceso</a></li>
                    <li><a href="#section3" class="hover:text-blue-600">Pagos</a></li>
                    <li><a href="#section4" class="hover:text-blue-600">Propiedad</a></li>
                    <li><a href="#section5" class="hover:text-blue-600">Cambios</a></li>
                </ul>
            </div>
        </nav>

        <div class="relative w-full max-w-7xl mx-auto px-6 py-12">
            <header class="mb-10">
                <h1 class="text-4xl font-bold text-center mb-4">Términos del Servicio</h1>
                <p class="text-center text-lg">Por favor, lee cuidadosamente nuestros términos antes de continuar.</p>
            </header>

            <div class="flex flex-col lg:flex-row gap-8">
                <aside class="w-full lg:w-1/4 sticky top-28">
                    <nav class="space-y-2 text-sm font-medium">
                        <a href="#section1"
                            :class="activeSection === 'section1' ? 'text-blue-500 font-semibold' : 'hover:text-blue-600'"
                            class="block transition-all">1. Generalidades</a>
                        <a href="#section2"
                            :class="activeSection === 'section2' ? 'text-blue-500 font-semibold' : 'hover:text-blue-600'"
                            class="block transition-all">2. Acceso y uso</a>
                        <a href="#section3"
                            :class="activeSection === 'section3' ? 'text-blue-500 font-semibold' : 'hover:text-blue-600'"
                            class="block transition-all">3. Pagos y facturación</a>
                        <a href="#section4"
                            :class="activeSection === 'section4' ? 'text-blue-500 font-semibold' : 'hover:text-blue-600'"
                            class="block transition-all">4. Propiedad intelectual</a>
                        <a href="#section5"
                            :class="activeSection === 'section5' ? 'text-blue-500 font-semibold' : 'hover:text-blue-600'"
                            class="block transition-all">5. Cambios</a>
                    </nav>
                </aside>

                <main class="w-full lg:w-3/4 space-y-24">
                    <section id="section1" class="scroll-mt-28">
                        <h2 class="text-2xl font-semibold mb-4">1. Generalidades</h2>
                        <p class="mb-4" v-for="i in 10" :key="'section1-' + i">Lorem ipsum dolor sit amet, consectetur
                            adipiscing elit...</p>
                    </section>

                    <section id="section2" class="scroll-mt-28">
                        <h2 class="text-2xl font-semibold mb-4">2. Acceso y uso</h2>
                        <p class="mb-4" v-for="i in 10" :key="'section2-' + i">Vestibulum ante ipsum primis in faucibus
                            orci luctus...</p>
                    </section>

                    <section id="section3" class="scroll-mt-28">
                        <h2 class="text-2xl font-semibold mb-4">3. Pagos y facturación</h2>
                        <p class="mb-4" v-for="i in 10" :key="'section3-' + i">Aliquam erat volutpat. Curabitur id metus
                            vitae arcu porttitor...</p>
                    </section>

                    <section id="section4" class="scroll-mt-28">
                        <h2 class="text-2xl font-semibold mb-4">4. Propiedad intelectual</h2>
                        <p class="mb-4" v-for="i in 10" :key="'section4-' + i">Curabitur sollicitudin, lorem eget luctus
                            finibus...</p>
                    </section>

                    <section id="section5" class="scroll-mt-28">
                        <h2 class="text-2xl font-semibold mb-4">5. Cambios en los términos</h2>
                        <p class="mb-4" v-for="i in 10" :key="'section5-' + i">Phasellus dapibus diam vitae ligula
                            facilisis...</p>
                    </section>
                </main>
            </div>
        </div>

        <!-- Modal -->
        <div v-if="showModal" class="fixed inset-0 bg-black/70 backdrop-blur-sm flex items-center justify-center z-50">
            <div class="bg-white dark:bg-gray-900 p-8 rounded-lg max-w-md w-full text-center shadow-xl">
                <h2 class="text-2xl font-bold mb-4">Aceptar Términos</h2>
                <p class="mb-4 text-sm">Debes aceptar los términos del servicio para continuar usando Cinashop.</p>
                <div class="flex items-center justify-center gap-2 mb-4">
                    <input type="checkbox" id="accept" v-model="accepted" class="mr-2" />
                    <label for="accept">He leído y acepto los Términos del Servicio</label>
                </div>
                <button :disabled="!accepted" @click="acceptTerms"
                    class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 disabled:opacity-50">Continuar</button>
            </div>
        </div>
    </div>
</template>
