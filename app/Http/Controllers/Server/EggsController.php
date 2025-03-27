<?php

namespace App\Http\Controllers\Server;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EggsController extends Controller
{
    public function index()
    {
        return inertia('Server/Eggs');
    }
}
