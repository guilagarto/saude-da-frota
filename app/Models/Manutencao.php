<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Manutencao extends Model
{
    // Vincula explicitamente ao nome da tabela que criamos
    protected $table = 'manutencaos';

    protected $fillable = [
        'veiculo_id',
        'tipo',
        'descricao',
        'data_realizada',
        'quilometragem_registro',
        'custo',
        'proxima_data',
        'proxima_quilometragem',
    ];

    /**
     * Relacionamento: Uma manutenção pertence a um veículo específico.
     */
    public function veiculo(): BelongsTo
    {
        return $this->belongsTo(Veiculo::class);
    }
}
