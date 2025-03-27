<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

class LogsController extends Controller
{
    public function index()
    {
        return Inertia::render('Logs');
    }
}
