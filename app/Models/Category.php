<?php

namespace App\Models;

use App\Libs\Traits\SluggableTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @method create(array $array)
 * @method latest()
 * @method whereSlug($slug)
 */
class Category extends Model
{
    use HasFactory, SoftDeletes, SluggableTrait;

     /**
     * @var string[]
     */
    protected $fillable = [
        'name', 'description', 'annual_payment', 'slug'
    ];

    /**
     * @var array|string[]
     */
    public array $sluggable = [
        'source' => 'name'
    ];

}
