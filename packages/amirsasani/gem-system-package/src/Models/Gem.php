<?php

namespace AmirSasani\GemSystem\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gem extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'gem'];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function transactions()
    {
        return $this->hasMany(GemTransaction::class);
    }
}
