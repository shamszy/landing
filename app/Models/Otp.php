<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @method create(array $array)
 * @method static where(string $string, string $string1, $userId)
 */
class Otp extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $fillable = [
        'otp', 'user_id', 'expires_at'
    ];

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
