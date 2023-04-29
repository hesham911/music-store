<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Song extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = ['title', 'duration', 'album_id'];

    public function album(): BelongsTo
    {
        return $this->belongsTo(Album::class,'album_id');
    }

    public function artists(): BelongsToMany
    {
        return $this->belongsToMany(Artist::class,'artist_songs')->withTimestamps();
    }
}
