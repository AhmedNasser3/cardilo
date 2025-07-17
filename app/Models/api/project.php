<?php

namespace App\Models\Api;
use App\Models\User;
use Illuminate\Support\Str;
use App\Models\api\SubCategory;
use App\Enums\Api\ProjectStatus;
use App\Models\Scopes\HasStatusScopes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Project extends Model
{
    use HasFactory, SoftDeletes, HasStatusScopes;
    public $incrementing = false;
    public $keyType = 'string';
    protected $fillable = [
        'slug', 'name', 'description', 'metadata', 'skills', 'attachments',
        'price', 'deadline', 'set_order', 'status', 'publish_at', 'approved_at',
        'user_id', 'subcategory_id',
    ];
    protected $casts = [
        'metadata'     => 'array',
        'skills'       => 'array',
        'attachments'  => 'array',
        'publish_at'   => 'datetime',
        'approved_at'  => 'datetime',
        'status'       => ProjectStatus::class,
    ];
    protected function slug(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => Str::slug($value)
        );
    }
    public function subcatgory(){
        return $this->belongsTo(SubCategory::class, 'subcategory_id');
    }
    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
}