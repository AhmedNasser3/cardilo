<?php

namespace App\Models\api;

use App\Models\Frontend\Category;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * SubCategory Model
 *
 * @property string $id
 * @property string $slug
 * @property string $name
 * @property string|null $description
 * @property array|null $metadata
 * @property int $set_order
 * @property string|null $image
 * @property string|null $category_id
 * @property string|null $user_id
 * @property bool $is_active
 * @property \Illuminate\Support\Carbon|null $publish_at
 * @property \Illuminate\Support\Carbon|null $approved_at
 */
class SubCategory extends Model
{
    use HasFactory, SoftDeletes;

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'id', 'slug', 'name', 'description', 'metadata', 'set_order', 'image', 'category_id',
        'user_id', 'is_active', 'publish_at', 'approved_at',  'updated_by',
    ];

    protected $casts = [
        'metadata'     => 'array',
        'is_active'    => 'boolean',
        'publish_at'   => 'datetime',
        'approved_at'  => 'datetime',
    ];

    /**
     * Scope: only active subcategories.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope: only published subcategories.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePublished($query)
    {
        return $query
            ->whereNotNull('publish_at')
            ->where('publish_at', '<=', now());
    }

    /**
     * Mutator: slugify name automatically when setting slug.
     *
     * @param string $value
     */
    public function setSlugAttribute($value)
    {
        $this->attributes['slug'] = Str::slug($value);
    }

    /**
     * Relation: creator user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }

    /**
     * Relation: parent category.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}