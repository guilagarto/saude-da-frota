<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Veiculo extends Model
{
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
}
