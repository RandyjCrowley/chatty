<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Character extends Model
{
    use HasFactory;

    protected $fillable = //phpcs:ignore
    ['name', 'persona'];

    public function chats(): HasMany
    {
        return $this->hasMany(Chat::class);
    }
}
