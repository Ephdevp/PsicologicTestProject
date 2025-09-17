<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Question extends Model
{
    protected $fillable = [
        'test_id',
        'question_text',
        'question_order',
        'factor',
    ];

    /**
     * Get the test that owns this question
     */
    public function test(): BelongsTo
    {
        return $this->belongsTo(TestData::class, 'test_id');
    }

    /**
     * Get the answers for this question
     */
    public function answers(): HasMany
    {
        return $this->hasMany(Answer::class)->orderBy('answer_order');
    }

    /**
     * Get user answer records for this question
     */
    public function userAnswerRecords(): HasMany
    {
        return $this->hasMany(UserAnswerRecord::class);
    }
}
