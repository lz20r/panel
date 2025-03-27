<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import DarkModeDebug from '@/Components/DarkModeDebug.vue'
</script>

<template>
    <div class="flex items-center justify-center min-h-screen bg-gray-100">
        <div>
            <ApplicationLogo class="block h-12 w-auto fill-current text-gray-600" />
            <DarkModeDebug />
        </div>
    </div>
</template>
