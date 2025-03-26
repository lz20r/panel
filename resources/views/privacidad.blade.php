@extends('layouts.app') {{-- o 'layouts.base', 'layouts.main' según uses --}}

@section('content')
<div class="min-h-screen bg-gray-100 flex flex-col items-center justify-center px-4">
    <div class="bg-white shadow-xl rounded-2xl max-w-xl w-full p-8 mt-10">
        <h1 class="text-3xl font-bold text-indigo-700 mb-4 text-center">Política de Privacidad</h1>
        <p class="text-gray-700 text-sm mb-4 text-center leading-relaxed">
            Para continuar usando la plataforma, es necesario aceptar nuestra política de privacidad.<br>
            Nos comprometemos a proteger tus datos personales.
        </p>

        @if(session('error'))
        <div class="bg-red-100 text-red-700 p-3 rounded mb-4 text-center">
            {{ session('error') }}
        </div>
        @endif

        <form method="POST" action="{{ route('privacidad.aceptar') }}" class="text-center mt-6">
            @csrf
            <button type="submit"
                class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-6 py-2 rounded-full transition duration-300">
                Aceptar y continuar
            </button>
        </form>

        <div class="mt-6 text-center">
            <a href="/" class="text-sm text-indigo-600 hover:underline">
                Volver al inicio
            </a>
        </div>
    </div>
</div>
@endsection