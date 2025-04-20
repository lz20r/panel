<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogEntry extends Model
{
    public $timestamps = false; 
    protected $fillable = [
        'user_id',
        'type',
        'message',
        'url',
        'user_agent',
        'method',
        'route',
        'input',
        'exception',
        'ip',
        'context',
    ];

    protected $casts = [
        'input' => 'array',
        'context' => 'array',
    ];
}
