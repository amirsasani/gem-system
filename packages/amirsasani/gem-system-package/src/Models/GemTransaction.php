<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GemTransaction extends Model
{
    use HasFactory;

    protected $fillable = ['gem_id', 'amount'];

    public function gem()
    {
        return $this->belongsTo(Gem::class);
    }
}
