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
        // Vincula cada entrada da oficina com a ficha de inspeção do veículo
        $table->foreignId('inspecao_id')->nullable()->after('veiculo_id')->constrained('inspecoes')->onDelete('set null');
    });
}

public function down(): void
{
    Schema::table('oficina_atividades', function (Blueprint $table) {
        $table->dropForeign(['inspecao_id']);
        $table->dropColumn('inspecao_id');
    });
}
};
