<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    public function user() {
        $this->hasOne(User::class);
    }

    public function album() {
        $this->hasOne(Album::class);
    }
}
