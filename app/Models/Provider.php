<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Provider extends Model
{
    use HasFactory;

    protected $fillable =  //phpcs:ignore
    ['provider', 'provider_id', 'user_id', 'avatar'];

    protected $hidden =  //phpcs:ignore
    ['created_at', 'updated_at'];
}
