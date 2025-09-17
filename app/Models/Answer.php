<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    protected $table = 'answers';

    protected $fillable = [
        'question_id',
        'answer_text',
        'score',
    ];

    public function question()
    {
        return $this->belongsTo(Question::class, 'question_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'answer_user', 'answer_id', 'user_id')->withTimestamps();
    }
}
