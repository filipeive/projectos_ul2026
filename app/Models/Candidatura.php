<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Candidatura extends Model
{
    use HasFactory;

    protected $table = 'candidaturas';

    protected $fillable = [
        'project_number',
        'project_name',
        'technology',
        'mentor',
        'member1_name',
        'member1_code',
        'member2_name',
        'member2_code',
        'member3_name',
        'member3_code',
        'member4_name',
        'member4_code',
        'rationale',
        'status',
    ];
}
