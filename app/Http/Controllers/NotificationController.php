<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use App\Notifications\NewMessageNotification;
use App\Http\Controllers\Controller;

class NotificationController extends Controller
{
    // Método para enviar la notificación
    public function sendNotification()
    {
        // Encuentra al usuario al que quieres notificar
        $user = User::find(1);  // Cambia el 1 por el ID del usuario que deseas notificar

        // Enviar la notificación
        $user->notify(new NewMessageNotification('¡Tienes un nuevo mensaje!'));

        // Retorna una respuesta o una vista
        return "Notificación enviada.";
    }

    // Otros métodos del controlador...
}
