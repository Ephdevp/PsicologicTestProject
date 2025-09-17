<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserAnswerRecord extends Model
{
    protected $fillable = [
        'test_session_id',
        'question_id',
        'answer_id',
        'answered_at',
    ];

    protected $casts = [
        'answered_at' => 'datetime',
    ];

    /**
     * Get the test session that owns this record
     */
    public function testSession(): BelongsTo
    {
        return $this->belongsTo(TestSession::class);
    }

    /**
     * Get the question for this record
     */
    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }

    /**
     * Get the answer for this record
     */
    public function answer(): BelongsTo
    {
        return $this->belongsTo(Answer::class);
    }
}
