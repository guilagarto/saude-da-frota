<?php

namespace App\Http\Controllers;

use App\Models\OficinaAtividade;
use App\Models\Veiculo;
use Illuminate\Http\Request;
use Carbon\Carbon;

class OficinaAtividadeController extends Controller
{
    public function index(Request $request)
    {
        $dataFiltro = $request->input('data', Carbon::today()->format('Y-m-d'));
        
        Carbon::setLocale('pt_BR');
        $dataTexto = Carbon::parse($dataFiltro)->translatedFormat('d/m l');

        $veiculosDisponiveis = Veiculo::all();

        // 🧠 LÓGICA INTELIGENTE: Busca veículos que entraram até hoje e ainda NÃO deram saída,
        // OU que deram saída exatamente na data que está sendo visualizada.
        $atividades = OficinaAtividade::with(['veiculo', 'ordens'])
            ->where('data_atividade', '<=', $dataFiltro)
            ->where(function ($q) use ($dataFiltro) {
                $q->whereNull('data_saida')
                  ->orWhere('data_saida', $dataFiltro);
            })
            ->get();

        return view('oficina.index', compact('atividades', 'veiculosDisponiveis', 'dataFiltro', 'dataTexto'));
    }

    public function store(Request $request)
    {
        $dataEnvio = $request->input('data_atividade') ?? Carbon::today()->format('Y-m-d');

        $request->validate([
            'veiculo_id' => 'required|exists:veiculos,id',
        ]);

        // Evita duplicar o mesmo veículo se ele já estiver retido em aberto na oficina
        $jaNaOficina = OficinaAtividade::where('veiculo_id', $request->veiculo_id)
            ->whereNull('data_saida')
            ->exists();

        if ($jaNaOficina) {
            return redirect()->back()->with('error', 'Este veículo já se encontra em manutenção na oficina!');
        }

        $inspecao = \App\Models\Inspecao::where('veiculo_id', $request->veiculo_id)
            ->where('data_inspecao', $dataEnvio)
            ->first();

        if (!$inspecao) {
            $inspecao = \App\Models\Inspecao::create([
                'veiculo_id' => $request->veiculo_id,
                'data_inspecao' => $dataEnvio,
                'resultado_inspecao' => 'Liberado'
            ]);
        }

        OficinaAtividade::create([
            'veiculo_id' => $request->veiculo_id,
            'inspecao_id' => $inspecao->id,
            'data_atividade' => $dataEnvio,
            'status_geral' => 'Em Manutenção'
        ]);

        return redirect()->route('oficina.index', ['data' => $dataEnvio])
            ->with('success', 'Veículo inserido com sucesso!');
    }

    // 🚀 NOVA FUNÇÃO: Executa a Baixa/Saída Manual do Veículo
    public function darSaida(Request $request, $id)
    {
        $request->validate([
            'data_saida' => 'required|date',
            'horario_saida' => 'required',
            'obs_saida' => 'nullable|string'
        ]);

        $atividade = OficinaAtividade::findOrFail($id);
        
        $atividade->update([
            'data_saida' => $request->data_saida,
            'horario_saida' => $request->horario_saida,
            'obs_saida' => $request->obs_saida,
            'status_geral' => 'Concluído'
        ]);

        return redirect()->route('oficina.index', ['data' => $request->data_saida])
            ->with('success', 'Saída do veículo registrada com sucesso!');
    }
}