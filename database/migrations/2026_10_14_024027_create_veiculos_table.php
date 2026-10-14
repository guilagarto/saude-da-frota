<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('veiculos', function (Blueprint $table) {
            $table->id();
            // Relaciona o veículo ao usuário que o cadastrou
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('placa')->unique();
            $table->string('modelo');
            $table->string('marca');
            $table->integer('ano');
            $table->integer('quilometragem_atual');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('veiculos');
    }
};
