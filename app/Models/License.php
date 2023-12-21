<?php

namespace App\Models;

use App\Libs\Traits\SluggableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 *
 * @method create(string[] $array)
 * @method latest()
 * @method whereSlug($slug)
 */
class License extends Model
{
    use HasFactory, SluggableTrait, SoftDeletes;

    /**
     * @var string[]
     */
    protected $fillable = [
        'company_id', 'title', 'license_link', 'issued_date', 'expiry_date', 'is_active', 'previous_payment_prove', 'slug'
    ];

    /**
     * @return BelongsTo
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    /**
     * @var array|string[]
     */
    public array $sluggable = [
        'source' => 'title'
    ];

}
