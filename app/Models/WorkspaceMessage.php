<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkspaceMessage extends Model
{
    protected $fillable = [
        'candidatura_id',
        'sender_type',
        'message',
    ];

    public function candidatura()
    {
        return $this->belongsTo(Candidatura::class);
    }
}
