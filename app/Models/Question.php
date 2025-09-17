<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $table = 'questions';

    protected $fillable = [
        'question_id',
        'test_id',
        'group',
        'factor',
        'question_text',
    ];

    // Define the relationship with the Test model
    public function test()
    {
        return $this->belongsTo(Test::class, 'test_id');
    }

    public function answers()
    {
        return $this->hasMany(Answer::class, 'question_id');
    }
}
