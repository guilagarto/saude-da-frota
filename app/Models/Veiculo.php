<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Veiculo extends Model
{
    // Usando o caminho completo diretamente dentro da função evita qualquer erro de importação no topo!

    protected $fillable = [
        'user_id',
        'numero',
        'placa',
        'modelo',
        'marca',
        'ano',
        'quilometragem_atual',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Garanta que o nome desta função seja exatamente 'manutencoes'
    public function manutencoes(): HasMany
    {
      return $this->hasMany(\App\Models\Manutencao::class, 'veiculo_id');

    }
}
