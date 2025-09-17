<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    // Define the relationship with the Question model
    public function questions()
    {
        return $this->hasMany(Question::class, 'test_id');
    }

    // Define the relationship with the User model through the pivot table
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_test', 'test_id', 'user_id')->withTimestamps();
    }
}
