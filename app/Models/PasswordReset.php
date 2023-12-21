<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PasswordReset extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'password_reset_tokens';

    /**
     * @var string[]
     */
    protected  $fillable = [
        'email', 'token'
    ];
    
}
