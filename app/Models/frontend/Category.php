<?php

namespace App\Models\Frontend;

use Illuminate\Support\Str;
use App\Events\CategoryCreated;
use Illuminate\Support\Facades\Cache;
use App\Models\Traits\SelfReferencing;
use Database\Factories\CategoryFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory, SelfReferencing,SoftDeletes;

    /**
     * Disable auto-increment ID & use UUID.
     */
    public $incrementing = false;

    /**
     * Use string as the key type.
     */
    protected $keyType = 'string';

    /**
     * Fillable attributes.
     */
    protected $fillable = [
        'id', 'slug', 'name', 'description', 'metadata', 'set_order',
        'image', 'parent_id', 'user_id', 'is_active', 'publish_at', 'approved_at',
    ];

    /**
     * Casts.
     */
    protected $casts = [
        'metadata'    => 'array',
        'is_active'   => 'bool',
        'publish_at'  => 'datetime',
        'approved_at' => 'datetime',
    ];

    /**
     * Boot method: auto-uuid & fire event after create.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = (string) Str::uuid();
            }
        });

        static::created(function ($model) {
            event(new CategoryCreated($model));
        });
    }

    /**
     * Scope: active categories only.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope: published categories.
     */
    public function scopePublished($query)
    {
        return $query
            ->whereNotNull('publish_at')
            ->where('publish_at', '<=', now());
    }

    /**
     * Mutator: slugify automatically.
     */
    public function setSlugAttribute($value)
    {
        $this->attributes['slug'] = Str::slug($value);
    }

    /**
     * Get cached children.
     */
    public function cachedChildren()
    {
        return Cache::remember(
            "categories:{$this->id}:children",
            now()->addMinutes(10),
            fn () => $this->children()->get()
        );
    }

    /**
     * Relation: user (creator).
     */
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
    protected static function newFactory() {
            return CategoryFactory::new();
    }

}