<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StenAge extends Model
{
    protected $table = 'sten_age_s';

    protected $fillable = [
        'test_id',
        'factor',
        'age_min',
        'age_max',
        'gender',
        'raw_score_min',
        'raw_score_max',
        'sten_score',
    ];

    protected $casts = [
        'age_min' => 'integer',
        'age_max' => 'integer',
        'raw_score_min' => 'integer',
        'raw_score_max' => 'integer',
        'sten_score' => 'integer',
    ];

    /**
     * Get the test that owns this STEN range
     */
    public function test(): BelongsTo
    {
        return $this->belongsTo(TestData::class, 'test_id');
    }

    /**
     * Find STEN score for given raw score and criteria
     */
    public static function findStenScore(int $testId, string $factor, int $rawScore, ?int $age = null, ?string $gender = null): ?int
    {
        $query = static::where('test_id', $testId)
            ->where('factor', $factor)
            ->where('raw_score_min', '<=', $rawScore)
            ->where('raw_score_max', '>=', $rawScore);

        // Add age filter if provided
        if ($age) {
            $query->where(function ($q) use ($age) {
                $q->where(function ($sq) use ($age) {
                    $sq->where('age_min', '<=', $age)
                       ->where('age_max', '>=', $age);
                })->orWhere(function ($sq) {
                    $sq->whereNull('age_min')
                       ->whereNull('age_max');
                });
            });
        }

        // Add gender filter if provided
        if ($gender) {
            $query->where(function ($q) use ($gender) {
                $q->where('gender', $gender)
                  ->orWhereNull('gender');
            });
        }

        return $query->first()?->sten_score;
    }
}
