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
        
        // Identificadores do item e ação (Campos Cruciais)
        $table->string('categoria'); // eletrica, mecanica, lanternagem, etc.
        $table->string('item_chave'); 
        $table->string('item_label');
        $table->string('acao'); // Reparar ou Trocar
        
        // Histórico de motivos e trocas
        $table->string('motivo')->nullable(); 
        $table->text('pecas_trocadas')->nullable(); 
        $table->string('status')->default('Pendente'); 
        
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
