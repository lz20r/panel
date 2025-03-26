<button
    wire:click="toggle"
    class="fixed top-4 right-4 bg-indigo-600 text-white px-4 py-2 rounded shadow hover:bg-indigo-700 transition z-50">
    @if ($dark)
    🌙 Modo Oscuro activado
    @else
    ☀️ Modo Claro activado
    @endif
</button>

<script>
    const darkModeToggle = document.querySelector('[wire:click="toggle"]');
    const body = document.querySelector('body');
    const darkModeClass = 'dark-mode';
    const darkModeStorageKey = 'dark-mode';
    const savedDarkMode = localStorage.getItem(darkModeStorageKey);
    const isDarkMode = savedDarkMode === 'true';
    body.classList.toggle(darkModeClass, isDarkMode);
    darkModeToggle.textContent = isDarkMode? '🌞 Modo Oscuro activado' : '🌚 Modo Claro activado';

</script>