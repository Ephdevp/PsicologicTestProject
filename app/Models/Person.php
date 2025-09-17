<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'last_name',
        'age',
        'gender'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
