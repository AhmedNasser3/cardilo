<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
     protected $fillable = [
        'title',
        'body',
        'extra',
        'read_at',
    ];

    protected $casts = [
        'extra' => 'array',
        'read_at' => 'datetime',
    ];
}