<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Artist extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = ['user_id', 'bio', 'name'];

    public function User(): BelongsTo
    {
        return $this->belongsTo(User::class,'user_id');
    }
}
