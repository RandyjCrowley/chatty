<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Character extends Model
{
    use HasFactory;

    protected $fillable = //phpcs:ignore
    ['name', 'persona'];

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

    public function chats(): HasMany
    {
        return $this->hasMany(Chat::class);
    }
}
