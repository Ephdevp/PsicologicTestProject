<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Carbon\Carbon;

class TestSession extends Model
{
    protected $fillable = [
        'user_id',
        'test_id',
        'session_token',
        'status',
        'started_at',
        'expires_at',
        'completed_at',
        'calculated_scores',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'expires_at' => 'datetime',
        'completed_at' => 'datetime',
        'calculated_scores' => 'array',
    ];

    /**
     * Get the user that owns this session
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the test for this session
     */
    public function test(): BelongsTo
    {
        return $this->belongsTo(TestData::class, 'test_id');
    }

    /**
     * Get the user answer records for this session
     */
    public function userAnswerRecords(): HasMany
    {
        return $this->hasMany(UserAnswerRecord::class);
    }

    /**
     * Check if the session is expired
     */
    public function isExpired(): bool
    {
        return $this->expires_at->isPast();
    }

    /**
     * Check if the session is active
     */
    public function isActive(): bool
    {
        return $this->status === 'in_progress' && !$this->isExpired();
    }

    /**
     * Mark session as expired
     */
    public function markAsExpired(): void
    {
        $this->update(['status' => 'expired']);
    }

    /**
     * Mark session as completed
     */
    public function markAsCompleted(array $scores = []): void
    {
        $this->update([
            'status' => 'completed',
            'completed_at' => now(),
            'calculated_scores' => $scores,
        ]);
    }

    /**
     * Get completion percentage
     */
    public function getCompletionPercentage(): float
    {
        $totalQuestions = $this->test->questions()->count();
        $answeredQuestions = $this->userAnswerRecords()->count();
        
        if ($totalQuestions === 0) {
            return 0;
        }

        return round(($answeredQuestions / $totalQuestions) * 100, 2);
    }

    /**
     * Check if all questions are answered
     */
    public function isComplete(): bool
    {
        return $this->getCompletionPercentage() >= 100;
    }
}
