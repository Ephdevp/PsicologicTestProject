<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserLevel extends Model
{
    public function users()
    {
        return $this->hasMany(User::class, 'user_level_id');
    }
}
