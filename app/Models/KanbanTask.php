<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KanbanTask extends Model
{
    protected $fillable = ['candidatura_id', 'title', 'description', 'status', 'created_by'];

    public function candidatura()
    {
        return $this->belongsTo(Candidatura::class);
    }
}
