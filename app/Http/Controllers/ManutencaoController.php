<?php

namespace App\Http\Controllers;

use App\Models\Manutencao;
use App\Models\Veiculo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ManutencaoController extends Controller
{
    // Listar todas as manutenções dos veículos do usuário logado
    public function index()
    {
        // Obtém os IDs dos veículos pertencentes ao usuário logado
        $veiculoIds = Veiculo::where('user_id', Auth::id())->pluck('id');
        
        // Carrega as manutenções desses veículos trazendo junto os dados do veículo relacionado
        $manutencoes = Manutencao::with('veiculo')->whereIn('veiculo_id', $veiculoIds)->get();

        return view('manutencoes.index', compact('manutencoes'));
    }

    // Tela de registro de nova manutenção
    public function create()
    {
        // Lista apenas os veículos do próprio usuário para preencher o campo de seleção (Select)
        $veiculos = Veiculo::where('user_id', Auth::id())->get();
        return view('manutencoes.create', compact('veiculos'));
    }

    // Gravar a manutenção no banco de dados
    public function store(Request $request)
    {
        $request->validate([
            'veiculo_id' => 'required|exists:veiculos,id',
            'tipo' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'data_realizada' => 'required|date',
            'quilometragem_registro' => 'required|integer|min:0',
            'custo' => 'required|numeric|min:0',
            'proxima_data' => 'nullable|date|after:data_realizada',
            'proxima_quilometragem' => 'nullable|integer|gt:quilometragem_registro',
        ]);

        // Validação de segurança: Garante que o veículo selecionado pertence ao usuário logado
        Veiculo::where('id', $request->veiculo_id)->where('user_id', Auth::id())->firstOrFail();

        Manutencao::create($request->all());

        return redirect()->route('manutencoes.index')->with('success', 'Manutenção registrada com sucesso!');
    }
}
