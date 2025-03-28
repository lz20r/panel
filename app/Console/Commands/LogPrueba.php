<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Helpers\Logger;

class LogPrueba extends Command
{
    protected $signature = 'log:prueba';
    protected $description = 'Prueba si el sistema de logs funciona correctamente';

    public function handle()
    {
        Logger::log('🔥 Este es un log de prueba desde la consola', 'prueba', [
            'fuente' => 'comando log:prueba',
            'custom_data' => 'funciona',
        ]);

        $this->info('✅ Log de prueba enviado. Revisa tu base de datos.');
    }
}
