<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inspecao extends Model
{
    use HasFactory;

    // Define explicitamente o nome correto da tabela em português
    protected $table = 'inspecoes';

    // Desativa a trava de segurança para aceitar a gravação de todos os 50+ campos novos
    protected $guarded = [];

    // Relacionamento nativo com o Veículo
    public function veiculo()
    {
        return $this->belongsTo(Veiculo::class);
    }
}
