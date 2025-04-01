<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Album extends Model
{

    protected $fillable = [
        
    ];

    public function votes() {
        return $this->hasMany(Vote::class);
    }

    public function scopeVotes($q) {
        
    }
}
