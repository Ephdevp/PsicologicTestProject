<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Factor extends Model
{
    protected $table = 'factors';

    protected $fillable = [
        'name',
    ];

    public function questions()
    {
        return $this->hasMany(Question::class, 'factor_id');
    }

    public function tests_user()
    {
        return $this->belongsToMany(Test::class, 'factor_test_user', 'factor_id', 'test_id')->withTimestamps();
    }
}
