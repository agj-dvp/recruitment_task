<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Relation extends Model
{
    public $timestamps = false;
    protected $table = 'relation';

    protected $fillable = [
        'tactic_id',
        'technique_id'
    ];

    protected $casts = [
        'attack_pattern_id' => 'integer',
        'parent_shortname' => 'integer',
    ];
}
