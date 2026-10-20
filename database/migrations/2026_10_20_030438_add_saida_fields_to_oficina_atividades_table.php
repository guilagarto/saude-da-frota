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
    Schema::table('oficina_atividades', function (Blueprint $table) {
        $table->date('data_saida')->nullable()->after('status_geral');
        $table->time('horario_saida')->nullable()->after('data_saida');
        $table->text('obs_saida')->nullable()->after('horario_saida');
    });
}


    public function down(): void
    {
        Schema::table('oficina_atividades', function (Blueprint $table) {
            // Remove as três colunas caso a migration seja revertida
            $table->dropColumn(['data_saida', 'horario_saida', 'obs_saida']);
        });
    }
};