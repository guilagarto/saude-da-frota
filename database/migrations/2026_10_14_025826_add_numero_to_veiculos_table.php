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
    Schema::table('veiculos', function (Blueprint $table) {
        // Adiciona o número do veículo (pode conter letras e números, ex: "FROTA-01" ou "102")
        $table->string('numero')->nullable()->after('user_id');
    });
}

public function down(): void
{
    Schema::table('veiculos', function (Blueprint $table) {
        $table->dropColumn('numero');
    });
}

};
