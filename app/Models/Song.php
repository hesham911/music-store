<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Song extends Model implements HasMedia
{
    use HasFactory, SoftDeletes, InteractsWithMedia;

    protected $fillable = ['title', 'duration', 'album_id'];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('songs')->singleFile();

        $this->addMediaCollection('image-song')->singleFile();
    }

    public function album(): BelongsTo
    {
        return $this->belongsTo(Album::class,'album_id');
    }

    public function artists(): BelongsToMany
    {
        return $this->belongsToMany(Artist::class,'artist_songs')->withTimestamps();
    }
}
