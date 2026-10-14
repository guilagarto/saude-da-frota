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
    Schema::create('manutencaos', function (Blueprint $table) {
        $table->id();
        // Vincula a manutenção ao veículo cadastrado
        $table->foreignId('veiculo_id')->constrained('veiculos')->onDelete('cascade');
        
        $table->string('tipo'); // Ex: Troca de Óleo, Pastilha de Freio
        $table->text('descricao')->nullable();
        $table->date('data_realizada');
        $table->integer('quilometragem_registro');
        $table->decimal('custo', 10, 2)->default(0.00);
        
        // Alertas opcionais
        $table->date('proxima_data')->nullable();
        $table->integer('proxima_quilometragem')->nullable();
        
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('manutencaos');
    }
};
