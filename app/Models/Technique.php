<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Technique extends Model
{
    protected $table = 'technique';

    protected $fillable = [
        'attack_pattern_id',
        'parent_shortname',
        'name',
        'description',
        'parent_shortnames',
    ];

    protected $casts = [
        'attack_pattern_id' => 'string',
        'parent_shortname' => 'string',
        'name' => 'string',
        'description' => 'string',
        'parent_shortnames' => 'string',
    ];

    public function relation()
    {
        return $this->hasMany(Relation::class, 'technique_id', 'id');
    }
}
