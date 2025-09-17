<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StenAge extends Model
{
    use HasFactory;

    protected $table = 'sten_age_s';

    protected $fillable = [
        'group_sex_age',
        'sex',
        'age_from',
        'age_to',
        'sten_value',
        'A_from', 'A_to',
        'B_from', 'B_to',
        'C_from', 'C_to',
        'E_from', 'E_to',
        'F_from', 'F_to',
        'G_from', 'G_to',
        'H_from', 'H_to',
        'I_from', 'I_to',
        'L_from', 'L_to',
        'M_from', 'M_to',
        'N_from', 'N_to',
        'O_from', 'O_to',
        'Q1_from', 'Q1_to',
        'Q2_from', 'Q2_to',
        'Q3_from', 'Q3_to',
        'Q4_from', 'Q4_to',
        'created_at',
        'updated_at',
    ];
}
