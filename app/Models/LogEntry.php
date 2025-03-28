<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LogEntry extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'message',
        'metadata',
    ];

    protected $casts = [
        'metadata' => 'array',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function getMetadataAttribute($value) {
        return json_decode($value);
    }

    public function setMetadataAttribute($value) {
        $this->attributes['metadata'] = json_encode($value);
    }

    public function scopeByType($query, $type) {
        return $query->where('type', $type);
    }
}
