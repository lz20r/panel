<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Error | Algo salió mal')</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #121212;
            color: #ffffff;
            font-family: 'Arial', sans-serif;
            text-align: center;
        }

        .error-container {
            max-width: 600px;
            padding: 20px;
        }

        h1 {
            font-size: 100px;
            font-weight: bold;
            animation: glitch 1s infinite alternate;
            color: #e74c3c;
        }

        @keyframes glitch {
            0% {
                text-shadow: 2px 2px #ff4757;
            }

            100% {
                text-shadow: -2px -2px #ff6b81;
            }
        }

        /* Nuevo estilo llamativo para los párrafos <p> */
        p {
            font-size: 24px;
            /* Aumentamos el tamaño de fuente */
            color: #ff4500;
            /* Un color rojo anaranjado más intenso */
            font-weight: bold;
            /* Negrita para mayor énfasis */
            text-shadow: 2px 2px 10px rgba(255, 69, 0, 0.8), -2px -2px 10px rgba(255, 69, 0, 0.8);
            /* Sombra de texto */
            margin: 20px 0 30px;
            /* Márgenes más grandes para espacio */
            font-style: italic;
            /* Estilo de fuente en cursiva */
            animation: pulse 2s infinite alternate;
            /* Animación pulsante */
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
                opacity: 0.9;
            }

            50% {
                transform: scale(1.1);
                opacity: 1;
            }

            100% {
                transform: scale(1);
                opacity: 0.9;
            }
        }

        .error-code {
            font-size: 22px;
            font-weight: bold;
            color: #f1c40f;
        }

        a {
            text-decoration: none;
            padding: 10px 20px;
            background-color: #3498db;
            color: #fff;
            border-radius: 5px;
            transition: 0.3s;
            display: inline-block;
            margin-top: 15px;
        }

        a:hover {
            background-color: #2980b9;
        }
    </style>
</head>

<body>
    <div class="error-container">
        <h1>'¡Oops!'</h1> <br>
        <h3> Algo salió mal. No podemos encontrar la página que buscas.</h3>
        <p id="error-message">@yield('message')</p>
        <p class="error-code" id="error-code">Error: @yield('code', 'XXX')</p>
        <p id="dynamic-link"></p>
        <a href="/">Volver al inicio</a>
    </div>

    <script>
        const urlParams = new URLSearchParams(window.location.search);
        const errorCode = urlParams.get('code');

        const errorUrl = window.location.href;

        document.getElementById("error-message").innerText = `The link ${errorUrl} @yield('message')`;
    </script>
</body>

</html>