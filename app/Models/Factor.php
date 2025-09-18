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
}
