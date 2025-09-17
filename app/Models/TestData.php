<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TestData extends Model
{
    protected $table = 'tests_data';

    protected $fillable = [
        'name',
        'description',
        'time_limit',
        'is_active',
        'required_test_id',
        'factors',
    ];

    protected $casts = [
        'factors' => 'array',
        'is_active' => 'boolean',
    ];

    /**
     * Get the questions for this test
     */
    public function questions(): HasMany
    {
        return $this->hasMany(Question::class, 'test_id');
    }

    /**
     * Get the test sessions for this test
     */
    public function testSessions(): HasMany
    {
        return $this->hasMany(TestSession::class, 'test_id');
    }

    /**
     * Get the required test
     */
    public function requiredTest(): BelongsTo
    {
        return $this->belongsTo(TestData::class, 'required_test_id');
    }

    /**
     * Get tests that require this test
     */
    public function dependentTests(): HasMany
    {
        return $this->hasMany(TestData::class, 'required_test_id');
    }

    /**
     * Get STEN age ranges for this test
     */
    public function stenAges(): HasMany
    {
        return $this->hasMany(StenAge::class, 'test_id');
    }

    /**
     * Get interpretation data for this test
     */
    public function interpretations(): HasMany
    {
        return $this->hasMany(InterpretationData::class, 'test_id');
    }

    /**
     * Check if user can access this test
     */
    public function canBeAccessedByUser(User $user): bool
    {
        if (!$this->is_active) {
            return false;
        }

        // If no required test, user can access
        if (!$this->required_test_id) {
            return true;
        }

        // Check if user has completed the required test
        return $user->testSessions()
            ->where('test_id', $this->required_test_id)
            ->where('status', 'completed')
            ->exists();
    }

    /**
     * Check if user has already completed this test
     */
    public function isCompletedByUser(User $user): bool
    {
        return $user->testSessions()
            ->where('test_id', $this->id)
            ->where('status', 'completed')
            ->exists();
    }
}
