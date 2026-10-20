<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OficinaOrdem extends Model
{
    protected $table = 'oficina_ordens';
    protected $guarded = [];

    public function atividade()
    {
        return $this->belongsTo(OficinaAtividade::class, 'oficina_atividade_id');
    }
}