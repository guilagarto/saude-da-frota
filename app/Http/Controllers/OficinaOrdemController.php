<?php

namespace App\Http\Controllers;

use App\Models\OficinaAtividade;
use App\Models\OficinaOrdem;
use Illuminate\Http\Request;

class OficinaOrdemController extends Controller
{
    public function create(OficinaAtividade $atividade, $categoria)
    {
        $atividade->load('veiculo');

        // Mapeamento dos itens de cada categoria
        $itens = [];
        if ($categoria == 'eletrica') {
            $itens = [
                'farois_alto_baixo' => 'Faróis Alto e Baixo, Faroletes e Setas',
                'faroletes' => 'Vigias Dianteiros e Laterais',
                'indicadores_direcao' => 'Luzes de Freio, Ré e Sinal Sonoro',
                'lanternas_vigias_traseiros' => 'Lanternas e Vigias Traseiros',
                'luz_cabine' => 'Luzes de Cabine',
                'luzes_painel_instrumentos' => 'Luzes de Painel e Instrumentos',
                'buzina' => 'Buzina, Itinerário e Retrovisores',
                'limpador_para_brisas' => 'Limpador de Para-brisa e Esguicho',
                'quebra_sol' => 'Quebra-Sol',
                'alavanca_marcha' => 'Alavanca Marcha (Manopla/Coifa)',
                'extintor_incendio' => 'Extintor de Incêndio e Documentos',
                'poltrona_motorista' => 'Poltrona Motorista e Volante',
                'baterias' => 'Baterias, Alternador e Arranque',
                'cabeamento' => 'Cabeamento Elétrico e Conexões'
            ];
        } elseif ($categoria == 'mecanica') {
            $itens = [
                'mot_oleo_filtro' => 'Óleo motor e filtro lubrificante',
                'mot_filtro_combustivel' => 'Filtro combustível (principal/separador)',
                'mot_correias' => 'Correias do motor: estado e tensão',
                'mot_fixacao_coxins' => 'Fixação motor: coxins',
                'pne_frisos_desgaste_calibragem' => 'Pneus: altura dos frisos, calibrar e aperto',
                'fre_lonas_desgaste' => 'Lonas de freio: verificar desgaste',
                'fre_cuica_haste_vazamento' => 'Cuíca: haste e possíveis vazamentos',
                'tra_direcao_hidraulica_nivel' => 'Direção hidráulica: nível de fluido'
            ];
        } elseif ($categoria == 'lanternagem') {
            $itens = [
                'car_saida_emergencia_puxador_cortinas' => 'Capas de emergência, puxadores, cordas e cortinas',
                'car_cinto_seguranca_apoio_bancos' => 'Cintos de segurança, apoios de braço e bancos',
                'car_canaletas_trava_janelas_assoalho' => 'Canaletas, travas de janelas, forro e assoalho',
                'car_porta_acesso_fechaduras_corrimaos' => 'Porta de acesso, fechaduras, trincos e corrimãos'
            ];
        } else {
            // Itens dinâmicos para Borracharia e Pintura compartilharem
            $itens = [
                'item_generico_1' => 'Componente Primário de Verificação',
                'item_generico_2' => 'Componente Secundário de Reparo'
            ];
        }

        // Puxa históricos já salvos caso o usuário queira editar
        $ordensSalvas = OficinaOrdem::where('oficina_atividade_id', $atividade->id)
            ->where('categoria', $categoria)
            ->get()
            ->keyBy('item_chave');

        return view('oficina.ordem_form', compact('atividade', 'categoria', 'itens', 'ordensSalvas'));
    }

    public function store(Request $request, OficinaAtividade $atividade, $categoria)
    {
        // Remove históricos antigos da mesma categoria para evitar duplicações
        OficinaOrdem::where('oficina_atividade_id', $atividade->id)
            ->where('categoria', $categoria)
            ->delete();

        $inspecao = \App\Models\Inspecao::find($atividade->inspecao_id);

        if ($request->has('itens')) {
            foreach ($request->itens as $chave => $dados) {
                
                // 1. Grava no Histórico da Oficina se houver ação tomada
                if (!empty($dados['acao'])) {
                    OficinaOrdem::create([
                        'oficina_atividade_id' => $atividade->id,
                        'categoria' => $categoria,
                        'item_chave' => $chave,
                        'item_label' => $dados['label'] ?? $chave,
                        'acao' => $dados['acao'],
                        'motivo' => $dados['motivo'] ?? '',
                        'pecas_trocadas' => $dados['pecas'] ?? ''
                    ]);
                }

                // 2. Sincroniza diretamente com o Painel de Saúde da Frota
                if ($inspecao && !empty($dados['status_saude'])) {
                    $inspecao->update([
                        $chave => $dados['status_saude']
                    ]);
                }
            }
        }

        return redirect()->route('oficina.index', ['data' => $atividade->data_atividade])
            ->with('success', 'Histórico e Índices de Saúde atualizados com sucesso!');
    }
}