<?php

namespace App\Models;

use Database\Factories\PhotoFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

#[Fillable(['album_id', 'image_path', 'caption', 'uploaded_by'])]
class Photo extends Model
{
    /** @use HasFactory<PhotoFactory> */
    use HasFactory;

    protected function imageUrl(): Attribute
    {
        return Attribute::get(fn (): string => Storage::disk('public')->url($this->image_path));
    }

    protected function likedByAuth(): Attribute
    {
        return Attribute::get(function (): bool {
            $user = auth()->user();

            if ($user) {
                return $this->likes()->where('user_id', $user->id)->exists();
            }

            return false;
        });
    }

    public function album(): BelongsTo
    {
        return $this->belongsTo(Album::class);
    }

    public function uploader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    public function likes(): HasMany
    {
        return $this->hasMany(Like::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function approvedComments(): HasMany
    {
        return $this->comments()->approved()->latest();
    }

    public function reports(): HasMany
    {
        return $this->hasMany(Report::class);
    }
}
