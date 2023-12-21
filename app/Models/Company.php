<?php

namespace App\Models;

use App\Libs\Traits\SluggableTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 *
 * @method create(array $array)
 * @method whereSlug($slug)
 * @method latest()
 */
class Company extends Model
{
    use HasFactory, SluggableTrait, SoftDeletes;

    /**
     * @var string[]
     */
    protected $fillable = [
        'user_id', 'name', 'address', 'phone_number', 'cac_number', 'logo', 'category_id', 'board_members', 'slug'
    ];

    /**
     * @return BelongsTo
    */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * @return BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    /**
     * @var array|string[]
     */
    public array $sluggable = [
        'source' => 'name'
    ];

}
