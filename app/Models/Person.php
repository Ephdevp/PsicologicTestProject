<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'last_name',
        'birthdate',
        'gender',
        'education_level',
        'phone',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Accessor: compute age from birthdate (people.birthdate)
    public function getAgeAttribute(): ?int
    {
        if (empty($this->birthdate)) {
            return null;
        }

        try {
            $age = Carbon::parse($this->birthdate)->age;
            return $age < 0 ? 0 : $age;
        } catch (\Throwable $e) {
            return null;
        }
    }
}
