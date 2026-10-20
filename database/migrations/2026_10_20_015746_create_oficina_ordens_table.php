<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up(): void
{
    Schema::create('oficina_ordens', function (Blueprint $table) {
        $table->id();
        // Vincula à atividade da oficina do dia
        $table->foreignId('oficina_atividade_id')->constrained('oficina_atividades')->onDelete('cascade');
        
        // Identifica qual botão foi clicado
        $table->string('categoria'); // eletrica, mecanica, lanternagem, borracharia, pintura
        
        // Campos de histórico solicitados
        $table->string('motivo_manutencao'); // Ex: Curto circuito, Barulho na suspensão
        $table->text('pecas_trocadas')->nullable(); // Peças substituídas
        $table->string('status')->default('Pendente'); // Pendente, Em Execução, Concluído
        
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('oficina_ordens');
    }
};
