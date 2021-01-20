<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tactic extends Model
{
    protected $table = 'tactic';

    protected $fillable = [
        'tactic_id',
        'shortname',
        'name',
        'description',
    ];

    protected $casts = [
        'tactic_id' => 'string',
        'shortname' => 'string',
        'name' => 'string',
        'description' => 'string'
    ];

}
