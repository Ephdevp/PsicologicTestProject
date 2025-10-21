<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserResults extends Model
{
    protected $table = 'user_results';

    protected $fillable = [
        'user_id',
        'test_id',
        'factorA_sten',
        'factorB_sten',
        'factorC_sten',
        'factorE_sten',
        'factorF_sten',
        'factorG_sten',
        'factorH_sten',
        'factorI_sten',
        'factorL_sten',
        'factorM_sten',
        'factorN_sten',
        'factorO_sten',
        'factorQ1_sten',
        'factorQ2_sten',
        'factorQ3_sten',
        'factorQ4_sten',
    ];
// Define the relationship with the Test model through the pivot table
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function test()
    {
        return $this->belongsTo(Test::class, 'test_id');
    }
}
