<?php

namespace App\Http\Controllers\Server;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NodesController extends Controller
{
    public function index()
    {
        return inertia('Server/Nodes');
    }
}
