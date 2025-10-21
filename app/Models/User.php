<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'user_level_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Define the relationship with the Test model through the pivot table
    public function tests()
    {
        return $this->belongsToMany(Test::class, 'test_user', 'user_id', 'test_id')->withTimestamps()->withPivot('status');
    }

    public function people()
    {
        return $this->hasMany(Person::class, 'user_id');
    }

    public function userLevel()
    {
        return $this->belongsTo(UserLevel::class, 'user_level_id');
    }

    public function answers()
    {
        return $this->belongsToMany(Answer::class, 'answer_user', 'user_id', 'answer_id')->withTimestamps();
    }

    public function factors_test()
    {
        return $this->belongsToMany(Factor::class, 'factor_test_user', 'user_id', 'factor_id')->withTimestamps();
    }

    public function user_results()
    {
        return $this->hasMany(UserResults::class, 'user_id');
    }

    // Mutator: siempre guardar el nombre en minúsculas
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = is_string($value) ? mb_strtolower($value, 'UTF-8') : $value;
    }
}
