<?php

namespace App\Models;

use App\Libs\Traits\SluggableTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @method create(array $array)
 */
class Admin extends Model
{
    use HasFactory, SoftDeletes, SluggableTrait;

    /**
     * @var string[]
     */
    protected $fillable = [
        'user_id', 'full_name', 'phone_number', 'address', 'profile_image', 'slug'
    ];

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public array $sluggable = [
        'source' => 'full_name'
    ];

}
