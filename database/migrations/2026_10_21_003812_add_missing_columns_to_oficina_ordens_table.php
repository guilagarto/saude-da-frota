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
    Schema::table('oficina_ordens', function (Blueprint $table) {
        if (!Schema::hasColumn('oficina_ordens', 'item_chave')) {
            $table->string('item_chave')->after('categoria');
            $table->string('item_label')->after('item_chave');
            $table->string('acao')->after('item_label');
        }
    });
}

public function down(): void
{
    Schema::table('oficina_ordens', function (Blueprint $table) {
        $table->dropColumn(['item_chave', 'item_label', 'acao']);
    });
}
};
