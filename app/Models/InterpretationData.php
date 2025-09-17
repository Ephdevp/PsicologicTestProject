<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InterpretationData extends Model
{
    protected $fillable = [
        'test_id',
        'factor',
        'sten_min',
        'sten_max',
        'level_name',
        'interpretation',
    ];

    protected $casts = [
        'sten_min' => 'integer',
        'sten_max' => 'integer',
    ];

    /**
     * Get the test that owns this interpretation
     */
    public function test(): BelongsTo
    {
        return $this->belongsTo(TestData::class, 'test_id');
    }

    /**
     * Find interpretation for given STEN score
     */
    public static function findInterpretation(int $testId, string $factor, int $stenScore): ?self
    {
        return static::where('test_id', $testId)
            ->where('factor', $factor)
            ->where('sten_min', '<=', $stenScore)
            ->where('sten_max', '>=', $stenScore)
            ->first();
    }
}
