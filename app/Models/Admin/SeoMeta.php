<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SeoMeta extends Model
{
     use HasFactory;

    protected $table = 'seo_meta';

    protected $fillable = [
        'page',
        'title',
        'description',
        'keywords',
        'canonical',
        'og_title',
        'og_description',
        'og_image',
        'twitter_title',
        'twitter_description',
        'twitter_image',
    ];
}
