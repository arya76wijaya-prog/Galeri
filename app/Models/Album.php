<?php

namespace App\Models;

use Database\Factories\AlbumFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

#[Fillable([
    'title',
    'slug',
    'description',
    'cover_photo',
    'category',
    'created_by',
    'status',
    'event_date',
    'published_at',
])]
class Album extends Model
{
    /** @use HasFactory<AlbumFactory> */
    use HasFactory;

    protected static function booted(): void
    {
        static::saving(function (Album $album): void {
            if ($album->isDirty('title') || empty($album->slug)) {
                $base = Str::slug($album->title ?: 'album') ?: 'album';
                $slug = $base;
                $counter = 1;

                while (static::query()
                    ->where('slug', $slug)
                    ->when($album->exists, fn (Builder $query) => $query->whereKeyNot($album->getKey()))
                    ->exists()) {
                    $slug = $base.'-'.$counter++;
                }

                $album->slug = $slug;
            }

            $album->status = 'published';

            if (empty($album->published_at)) {
                $album->published_at = now();
            }
        });
    }

    protected function casts(): array
    {
        return [
            'event_date' => 'date',
            'published_at' => 'datetime',
        ];
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    protected function coverUrl(): Attribute
    {
        return Attribute::get(function (): ?string {
            if ($this->cover_photo) {
                return Storage::disk('public')->url($this->cover_photo);
            }

            $firstPhoto = $this->photos()->first();

            return $firstPhoto?->image_url;
        });
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function photos(): HasMany
    {
        return $this->hasMany(Photo::class);
    }

    public function likes(): HasManyThrough
    {
        return $this->hasManyThrough(Like::class, Photo::class);
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', 'published');
    }

    public function scopeSearch(Builder $query, ?string $term): Builder
    {
        if (! $term) {
            return $query;
        }

        return $query->where(function (Builder $query) use ($term) {
            $query->where('title', 'like', "%{$term}%")
                ->orWhere('description', 'like', "%{$term}%")
                ->orWhere('category', 'like', "%{$term}%");
        });
    }

    public function scopeCategory(Builder $query, ?string $category): Builder
    {
        return $category ? $query->where('category', $category) : $query;
    }
}
