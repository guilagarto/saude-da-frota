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
    Schema::create('inspecoes', function (Blueprint $table) {
        $table->id();
        $table->foreignId('veiculo_id')->constrained('veiculos')->onDelete('cascade');
        $table->date('data_inspecao');
        $table->string('horario_inspecao', 10)->nullable(); // ⏰ Campo adicionado aqui nativamente
        $table->text('observacoes')->nullable();
        $table->string('foto_path')->nullable();

        // ⚡ CAMPOS DA INSPEÇÃO ELÉTRICA
        $table->char('farois_alto_baixo', 10)->default('Bom');
        $table->char('faroletes', 10)->default('Bom');
        $table->char('indicadores_direcao', 10)->default('Bom');
        $table->char('lanternas_vigias_traseiros', 10)->default('Bom');
        $table->char('luz_cabine', 10)->default('Bom');
        $table->char('luzes_painel_instrumentos', 10)->default('Bom');
        $table->char('buzina', 10)->default('Bom');
        $table->char('limpador_para_brisas', 10)->default('Bom');
        $table->char('quebra_sol', 10)->default('Bom');
        $table->char('alavanca_marcha', 10)->default('Bom');
        $table->char('extintor_incendio', 10)->default('Bom');
        $table->char('poltrona_motorista', 10)->default('Bom');
        $table->char('baterias', 10)->default('Bom');
        $table->char('cabeamento', 10)->default('Bom');

        // ⚙️ MECÂNICA - MOTOR E AGREGADOS
        $table->char('mot_oleo_filtro', 10)->default('Bom');
        $table->char('mot_filtro_combustivel', 10)->default('Bom');
        $table->char('mot_correias', 10)->default('Bom');
        $table->char('mot_fixacao_coxins', 10)->default('Bom');
        $table->char('mot_turbocompressor', 10)->default('Bom');
        $table->char('mot_tubulacao_admissao', 10)->default('Bom');
        $table->char('mot_compressor_ar', 10)->default('Bom');
        $table->char('mot_mangueiras_canos', 10)->default('Bom');
        $table->char('mot_sistema_arrefecimento', 10)->default('Bom');
        $table->char('mot_mangueiras_abraca_radiador', 10)->default('Bom');
        $table->char('mot_sistema_escapamento', 10)->default('Bom');
        $table->char('mot_soprar_filtro_ar', 10)->default('Bom');
        $table->char('mot_higienizador_ar', 10)->default('Bom');
        $table->char('mot_conexao_sensores', 10)->default('Bom');
        $table->char('mot_folga_bomba_agua', 10)->default('Bom');
        $table->char('mot_rolamento_tensor_embreagem', 10)->default('Bom');

        // ⚙️ MECÂNICA - CUBOS, EIXO, RODAS E PNEUS
        $table->char('pne_vazamento_valvulas', 10)->default('Bom');
        $table->char('pne_bracos_barras_direcao', 10)->default('Bom');
        $table->char('pne_rolamentos_cubos', 10)->default('Bom');
        $table->char('pne_porcas_travas_cubo', 10)->default('Bom');
        $table->char('pne_frisos_desgaste_calibragem', 10)->default('Bom');
        $table->char('pne_suporte_radiador_arla', 10)->default('Bom');
        $table->char('pne_tanque_combustivel_respiro', 10)->default('Bom');

        // ⚙️ MECÂNICA - FREIOS E SUSPENSÃO
        $table->char('fre_reservatorio_ar_drenar', 10)->default('Bom');
        $table->char('fre_erguer_pneus_regular_freio', 10)->default('Bom');
        $table->char('fre_cuica_haste_vazamento', 10)->default('Bom');
        $table->char('fre_buchas_eixo_s', 10)->default('Bom');
        $table->char('fre_lonas_desgaste', 10)->default('Bom');
        $table->char('fre_pedais_embreagem_acelerador', 10)->default('Bom');
        $table->char('fre_vazamentos_ar_oleo_embreagem', 10)->default('Bom');
        $table->char('fre_eixos_s_ajustadores_lubrificar', 10)->default('Bom');
        $table->char('fre_flexiveis_conduites', 10)->default('Bom');
        $table->char('fre_catraca_pinos', 10)->default('Bom');
        $table->char('fre_jumelos_lubrificar_aperto', 10)->default('Bom');
        $table->char('fre_jumelos_pinos_desgastes', 10)->default('Bom');
        $table->char('fre_compressor_ar_conexoes', 10)->default('Bom');
        $table->char('fre_freio_motor', 10)->default('Bom');
        $table->char('fre_grampos_u_feixes_molas', 10)->default('Bom');
        $table->char('fre_barra_estabilizadora_buchas_bieletas', 10)->default('Bom');
        $table->char('fre_amortecedores_buchas_vazamento', 10)->default('Bom');
        $table->char('fre_suporte_molas_jumelos_olhais', 10)->default('Bom');
        $table->char('fre_suporte_motor_coxim_caixa', 10)->default('Bom');

        // ⚙️ MECÂNICA - DIREÇÃO, EMBREAGEM E TRANSMISSÃO
        $table->char('tra_direcao_hidraulica_cruzetas', 10)->default('Bom');
        $table->char('tra_junta_universal_coluna', 10)->default('Bom');
        $table->char('tra_direcao_hidraulica_nivel', 10)->default('Bom');
        $table->char('tra_caixa_direcao_torque_vazamentos', 10)->default('Bom');
        $table->char('tra_embreagem_nivel_fluido', 10)->default('Bom');
        $table->char('tra_embreagem_buchas_eixo_garfo', 10)->default('Bom');
        $table->char('tra_servo_embreagem_vazamento', 10)->default('Bom');
        $table->char('tra_caixa_mudancas_oleo_respiro', 10)->default('Bom');
        $table->char('tra_arvore_transmissao_cruzetas_cardam', 10)->default('Bom');
        $table->char('tra_rolamento_cardam_diferencial_ruido', 10)->default('Bom');
        $table->char('tra_suporte_cardam_saida_caixa', 10)->default('Bom');
        $table->char('tra_diferencial_oleo_respiro', 10)->default('Bom');

        // 🎨 LANTERNAGEM / CARROCERIA
        $table->char('car_saida_emergencia_puxador_cortinas', 10)->default('Bom');
        $table->char('car_cinto_seguranca_apoio_bancos', 10)->default('Bom');
        $table->char('car_canaletas_trava_janelas_assoalho', 10)->default('Bom');
        $table->char('car_porta_acesso_fechaduras_corrimaos', 10)->default('Bom');
        $table->char('car_fixacao_bagageiros_alcapao', 10)->default('Bom');
        $table->char('car_faixas_refletivas_vidro_traseiro', 10)->default('Bom');
        $table->char('car_estepe_triangulo_lataria_frisos', 10)->default('Bom');
        
        // 📋 RESULTADO FINAL
        $table->string('resultado_inspecao', 30)->default('Liberado');

        $table->timestamps();
    });
}



    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inspecoes');
    }
};
