<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OficinaAtividade extends Model
{
    protected $table = 'oficina_atividades';
    protected $guarded = [];

    public function veiculo()
    {
        return $this->belongsTo(Veiculo::class);
    }
    public function ordens()
{
    return $this->hasMany(OficinaOrdem::class, 'oficina_atividade_id');
}
}