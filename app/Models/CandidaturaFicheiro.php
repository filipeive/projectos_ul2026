<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CandidaturaFicheiro extends Model
{
    protected $fillable = [
        'candidatura_id',
        'nome_ficheiro',
        'caminho',
        'tamanho_bytes',
        'uploaded_by',
    ];

    public function candidatura()
    {
        return $this->belongsTo(Candidatura::class);
    }
}
