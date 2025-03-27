<?php

namespace App\Http\Controllers\Advanced;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WebhooksController extends Controller
{
    public function index()
    {
        return inertia('Advanced/Webhooks');
    }
}
