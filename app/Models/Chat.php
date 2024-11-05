<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Chat extends Model
{
    use HasFactory;

    protected $fillable = //phpcs:ignore
    ['character_id', 'user_id', 'message', 'is_user_message'];

    // Relationship with Character
    public function character(): BelongsTo
    {
        return $this->belongsTo(Character::class);
    }

    // Relationship with User (assuming a User model exists)
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
