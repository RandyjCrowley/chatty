<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Str;

class Conversation extends Model
{
    use HasFactory;

    protected $fillable = //phpcs:ignore
    ['chat_id', 'is_user_message', 'user_id', 'content'];

    protected $keyType = //phpcs:ignore
    'string';

    public $incrementing = //phpcs:ignore
    false;

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($model): void {
            if (empty($model->id)) {
                $model->id = (string) Str::uuid();
            }
        });
    }

    public function chat(): HasOne
    {
        return $this->hasOne(Chat::class);
    }

    // Relationship with User (assuming a User model exists)
    public function user(): BelongsTo
    {
        return $this->hasOne(Chat::class)->belongsTo(User::class);
    }
}
