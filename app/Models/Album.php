<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Album extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = ['title', 'artwork_url'];

    public function artists(): BelongsToMany
    {
        return $this->belongsToMany(Artist::class,'artist_albums')->withTimestamps();
    }

    public function songs(): HasMany
    {
        return $this->hasMany(Song::class,'album_id');
    }
}
