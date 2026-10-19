<?php

namespace App\Http\Controllers;

use App\Models\Inspecao;
use App\Models\Veiculo;
use Illuminate\Http\Request;

class SaudeFrotaController extends Controller
{
    public function index(Request $request)
    {
        $veiculos = Veiculo::all();
        $veiculoSelecionado = $request->veiculo_id;

        // Puxa as inspeções filtrando por veículo se houver escolha
        $query = Inspecao::query();
        if ($request->filled('veiculo_id')) {
            $query->where('veiculo_id', $veiculoSelecionado);
        }
        $inspecoes = $query->get();

        // Inicializa os contadores estáticos do painel
        $bom = 0; 
        $regular = 0; 
        $ruim = 0;

        // Lista oficial e sem erros das colunas salvas na tabela do banco de dados
        $colunasChecklist = [
            'farois_alto_baixo', 'faroletes', 'indicadores_direcao', 'lanternas_vigias_traseiros',
            'luz_cabine', 'luzes_painel_instrumentos', 'buzina', 'limpador_para_brisas', 'quebra_sol',
            'alavanca_marcha', 'extintor_incendio', 'poltrona_motorista', 'baterias', 'cabeamento',
            'mot_oleo_filtro', 'mot_filtro_combustivel', 'mot_correias', 'mot_fixacao_coxins',
            'mot_turbocompressor', 'mot_tubulacao_admissao', 'mot_compressor_ar', 'mot_mangueiras_canos',
            'mot_sistema_arrefecimento', 'mot_mangueiras_abraca_radiador', 'mot_sistema_escapamento',
            'mot_soprar_filtro_ar', 'mot_higienizador_ar', 'mot_conexao_sensores', 'mot_folga_bomba_agua',
            'mot_rolamento_tensor_embreagem', 'pne_vazamento_valvulas', 'pne_bracos_barras_direcao',
            'pne_rolamentos_cubos', 'pne_porcas_travas_cubo', 'pne_frisos_desgaste_calibragem',
            'pne_suporte_radiador_arla', 'pne_tanque_combustivel_respiro', 'fre_reservatorio_ar_drenar',
            'fre_erguer_pneus_regular_freio', 'fre_cuica_haste_vazamento', 'fre_buchas_eixo_s',
            'fre_lonas_desgaste', 'fre_pedais_embreagem_acelerador', 'fre_vazamentos_ar_oleo_embreagem',
            'fre_eixos_s_ajustadores_lubrificar', 'fre_flexiveis_conduites', 'fre_catraca_pinos',
            'fre_jumelos_lubrificar_aperto', 'fre_jumelos_pinos_desgastes', 'fre_compressor_ar_conexoes',
            'fre_freio_motor', 'fre_grampos_u_feixes_molas', 'fre_barra_estabilizadora_buchas_bieletas',
            'fre_amortecedores_buchas_vazamento', 'fre_suporte_molas_jumelos_olhais', 'fre_suporte_motor_coxim_caixa',
            'tra_direcao_hidraulica_cruzetas', 'tra_junta_universal_coluna', 'tra_direcao_hidraulica_nivel',
            'tra_caixa_direcao_torque_vazamentos', 'tra_embreagem_nivel_fluido', 'tra_embreagem_buchas_eixo_garfo',
            'tra_servo_embreagem_vazamento', 'tra_caixa_mudancas_oleo_respiro', 'tra_arvore_transmissao_cruzetas_cardam',
            'tra_rolamento_cardam_diferencial_ruido', 'tra_suporte_cardam_saida_caixa', 'tra_diferencial_oleo_respiro',
            'car_saida_emergencia_puxador_cortinas', 'car_cinto_seguranca_apoio_bancos', 'car_canaletas_trava_janelas_assoalho',
            'car_porta_acesso_fechaduras_corrimaos', 'car_fixacao_bagageiros_alcapao', 'car_faixas_refletivas_vidro_traseiro',
            'car_estepe_triangulo_lataria_frisos'
        ];

        // Processa os dados de forma limpa e direta
        foreach ($inspecoes as $inspecao) {
            foreach ($colunasChecklist as $coluna) {
                $status = $inspecao->$coluna;
                
                if ($status === 'Bom') {
                    $bom++;
                } elseif ($status === 'Regular') {
                    $regular++;
                } elseif ($status === 'Ruim') {
                    $ruim++;
                }
            }
        }

        return view('saude.index', compact('veiculos', 'veiculoSelecionado', 'bom', 'regular', 'ruim', 'inspecoes'));
    }
}
