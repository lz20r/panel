<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cinammon Hosting</title>
    <meta name="description" content="Explora nuestros servicios de hosting, VPS, Minecraft host, y más en cinammon.es.">
    <meta name="keywords" content="hosting, VPS, Minecraft host, servicios, Discord, cinammon">
    <meta name="author" content="cinammon.es">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@2.1.4/css/boxicons.min.css">
    <link rel="icon" href="/images/main/favicon.ico">
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        /* Sidebar */

        .sidebar {
            z-index: 1000;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        /* Hero */
        .hero {
            background: url('/images/main/hero.jpg') center/cover no-repeat;
        }
        /* Features */
        .features {
            display: flex;
            justify-content: center;
            text-align: center;
            gap: 20px;
            padding: 50px 0;
        }

        .feature {
            background: #181818;
            padding: 30px;
            border-radius: 10px;
            width: 250px;
            transition: all 0.3s;
        }

        .feature:hover {
            background: #222;
        }

        .feature i {
            font-size: 50px;
            color: #00d4ff;
            margin-bottom: 10px;
        }
    </style>
</head>

<body class="bg-gray-950 text-white font-sans">

    <nav class="bg-gray-900 flex justify-between items-center px-6 py-3">
        <div class="flex items-center">
            <button onclick="toggleSidebar()" class="text-3xl lg:hidden mr-3">
                <i class='bx bx-menu'></i>
            </button>
            <a href="#" class="flex items-center">
                <svg class="h-10 w-auto text-white lg:h-16 lg:text-[#FF2D20]" viewBox="0 0 62 65" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M61.8548 14.6253C61.8778 14.7102 61.8895 14.7978 61.8897 14.8858V28.5615C61.8898 28.737 61.8434 28.9095 61.7554 29.0614C61.6675 29.2132 61.5409 29.3392 61.3887 29.4265L49.9104 36.0351V49.1337C49.9104 49.4902 49.7209 49.8192 49.4118 49.9987L25.4519 63.7916L0.501061 49.9987V8.10652L12.4779 0.345059L25.4531 7.2415H25.4556Z" fill="currentColor" />
                </svg>
            </a>
        </div>

        <div class="hidden lg:flex gap-5">
            <a href="#docs" class="hover:text-blue-400">Docs</a>
            <a href="#blog" class="hover:text-blue-400">Blog</a>
            <a href="#donate" class="hover:text-blue-400">Donate</a>
            <a href="#faq" class="hover:text-blue-400">FAQ</a>
            <a href="#hub" class="hover:text-blue-400">Hub</a>
            <a href="#eggs" class="hover:text-blue-400">Eggs</a>
            <a href="{{ route('login') }}" class="hover:text-blue-400">Iniciar Sesión</a>
            @if (Route::has('register'))
            <a href="{{ route('register') }}" class="hover:text-blue-400">Registrarse</a>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <i class='bx bxl-github text-xl cursor-pointer'></i>
            <i class='bx bxl-discord text-xl cursor-pointer'></i>
            <i class='bx bx-sun text-xl cursor-pointer'></i>
            <div class="bg-gray-700 rounded-full px-3 py-1 flex items-center">
                <i class='bx bx-search'></i>
                <input type="text" placeholder="Search Ctrl+K" class="bg-transparent outline-none ml-2">
            </div>
        </div>
    </nav>

    <div class="sidebar fixed top-0 left-[-250px] h-screen w-[250px] bg-gray-900 transition-all" id="sidebar">
        <div class="flex justify-end p-4">
            <button onclick="toggleSidebar()" class="text-3xl">&times;</button>
        </div>
        <nav class="flex flex-col gap-4 px-6">
            <a href="#docs">Docs</a>
            <a href="#blog">Blog</a>
            <a href="#donate">Donate</a>
            <a href="#faq">FAQ</a>
            <a href="#hub">Hub</a>
            <a href="#eggs">Eggs</a>
            <a href="{{ route('login') }}">Iniciar Sesión</a>
            @if (Route::has('register'))
            <a href="{{ route('register') }}">Registrarse</a>
            @endif
        </nav>
    </div>

    <!-- Hero Section -->
    <header class="hero bg-gradient-to-br from-gray-800 to-gray-900 min-h-screen flex items-center justify-center text-center p-4">
        <div class="container">
            <h1 class="text-4xl font-bold">Potencia tu Hosting con Cinammon</h1>
            <p class="mt-4">Rendimiento, velocidad y seguridad para tu proyecto digital 🚀</p>
            <a href="#precios" class="mt-4 inline-block bg-blue-500 hover:bg-blue-600 transition py-2 px-6 rounded">Explorar Planes</a>
        </div>
    </header>

    <!-- Features -->
    <section class="features">
        <div class="feature">
            <i class='bx bx-server'></i>
            <h4>Hosting Seguro</h4>
            <p>Infraestructura optimizada con la máxima seguridad.</p>
        </div>
        <div class="feature">
            <i class='bx bx-cloud'></i>
            <h4>Alta Disponibilidad</h4>
            <p>Servidores escalables y confiables 24/7.</p>
        </div>
        <div class="feature">
            <i class='bx bx-game'></i>
            <h4>Optimización Gaming</h4>
            <p>Soluciones para servidores de juegos con baja latencia.</p>
        </div>
        <div class="feature">
            <i class='bx bx-support'></i>
            <h4>Soporte 24/7</h4>
            <p>Asistencia técnica rápida y eficiente en todo momento.</p>
        </div>
    </section>



    <!-- Footer -->
    <footer class="bg-gray-900 text-center py-4">
        &copy; {{ date('Y') }} Cinammon Hosting - Todos los derechos reservados.
    </footer>

    <script>
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('left-0');
        }
    </script>

</body>

</html>