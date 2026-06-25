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
        'docente_id',
        'member1_name',
        'member1_code',
        'contact_email',
        'contact_phone',
        'member2_name',
        'member2_code',
        'member3_name',
        'member3_code',
        'member4_name',
        'member4_code',
        'rationale',
        'status',
        'group_password',
    ];

    public function workspaceMessages()
    {
        return $this->hasMany(WorkspaceMessage::class);
    }

    public function progressos()
    {
        return $this->hasMany(CandidaturaProgresso::class);
    }

    public function ficheiros()
    {
        return $this->hasMany(CandidaturaFicheiro::class);
    }

    public function docente()
    {
        return $this->belongsTo(User::class, 'docente_id');
    }
}
