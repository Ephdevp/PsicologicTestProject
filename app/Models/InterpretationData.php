<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InterpretationData extends Model
{
    use HasFactory;

    protected $table = 'interpretation_data';

    protected $fillable = [
        'factor',
        'group',
        'plan',
        'sten_from',
        'sten_to',
        'title',
        'psychology_text',
        'health_text',
    ];
}
