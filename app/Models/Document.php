<?php

namespace App\Models;

use App\Libs\Traits\SluggableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 *
 * @method create(string[] $array)
 * @method latest()
 * @method whereSlug($slug)
 */
class Document extends Model
{
    use HasFactory, SluggableTrait;

    /**
     * @var string[]
     */
    protected $fillable = [
        'company_id', 'document_type', 'document_link', 'slug'
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
        'source' => 'document_type'
    ];

}
