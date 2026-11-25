<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'user_id',
    'photo_id',
    'reason',
    'description',
    'status',
    'reviewed_by',
    'reviewed_at',
])]
class Report extends Model
{
    use HasFactory;

    protected function casts(): array
    {
        return [
            'reviewed_at' => 'datetime',
        ];
    }

    protected function reasonLabel(): Attribute
    {
        return Attribute::get(fn (): string => match ($this->reason) {
            'inappropriate' => 'Konten tidak pantas',
            'blurry' => 'Foto buram / tidak jelas',
            'wrong_album' => 'Foto salah album',
            'copyright' => 'Masalah hak cipta',
            default => 'Lainnya',
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function photo(): BelongsTo
    {
        return $this->belongsTo(Photo::class);
    }

    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    public function scopePending(Builder $query): Builder
    {
        return $query->where('status', 'pending');
    }
}
