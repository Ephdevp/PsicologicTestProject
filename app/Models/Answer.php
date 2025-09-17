<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Answer extends Model
{
    protected $fillable = [
        'question_id',
        'answer_text',
        'score_value',
        'answer_order',
    ];

    protected $casts = [
        'score_value' => 'integer',
        'answer_order' => 'integer',
    ];

    /**
     * Get the question that owns this answer
     */
    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }

    /**
     * Get user answer records for this answer
     */
    public function userAnswerRecords(): HasMany
    {
        return $this->hasMany(UserAnswerRecord::class);
    }
}
