<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CandidaturaProgresso extends Model
{
    protected $fillable = [
        'candidatura_id',
        'fase',
        'estado',
        'observacao',
        'updated_by',
    ];

    public function candidatura()
    {
        return $this->belongsTo(Candidatura::class);
    }
}
