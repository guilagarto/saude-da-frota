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
    Schema::create('oficina_atividades', function (Blueprint $table) {
        $table->id();
        $table->foreignId('veiculo_id')->constrained('veiculos')->onDelete('cascade');
        $table->date('data_atividade');
        $table->string('status_geral')->default('Em Manutenção'); // Em Manutenção, Concluído
        $table->text('notas')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('oficina_atividades');
    }
};
