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
        return $this->belongsToMany(User::class, 'test_user', 'test_id', 'user_id')->withPivot('id', 'status', 'completed_at')->withTimestamps();
    }

    public function factors_user()
    {
        return $this->belongsToMany(Factor::class, 'factor_test_user', 'test_id', 'factor_id')->withTimestamps();
    }

    public function user_results()
    {
        return $this->hasMany(UserResults::class, 'test_id');
    }
}
