<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Notifications\NewMessageNotification;
use App\Models\User;

class SendNotificationCommand extends Command
{
    // El nombre y la firma del comando
    protected $signature = 'send:notification';

    // Descripción del comando
    protected $description = 'Enviar una notificación a un usuario específico';

    // Ejecutar el comando
    public function handle()
    {
        // Encuentra al usuario al que quieres notificar
        $user = User::find(1);  // Cambia el 1 por el ID del usuario que deseas notificar

        // Enviar la notificación
        $user->notify(new NewMessageNotification('¡Tienes un nuevo mensaje!'));

        // Mensaje en la consola
        $this->info('Notificación enviada al usuario con ID 1');
    }
}
