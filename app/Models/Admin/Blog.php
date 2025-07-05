<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Blog extends Model
{

    use HasFactory, SoftDeletes;
    protected $fillable = [
        'title',
        'content',
        'image',
        'publisher',
    ];
}