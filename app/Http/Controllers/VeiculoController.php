<?php

namespace App\Http\Controllers;

use App\Models\Veiculo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VeiculoController extends Controller
{
    // Listar veículos do usuário
    public function index()
    {
        $veiculos = Auth::user()->veiculos ?? Veiculo::where('user_id', Auth::id())->get();
        return view('veiculos.index', compact('veiculos'));
    }

    // Tela de cadastro
    public function create()
    {
        return view('veiculos.create');
    }

    // Salvar no banco
    public function store(Request $request)
    {
        $request->validate([
             'numero' => 'nullable|string|max:50', // Validação do número
            'placa' => 'required|string|unique:veiculos,placa',
            'modelo' => 'required|string|max:255',
            'marca' => 'required|string|max:255',
            'ano' => 'required|integer|min:1900|max:'.(date('Y') + 1),
            'quilometragem_atual' => 'required|integer|min:0',
        ]);

        Auth::user()->veiculos()->create($request->all());

        return redirect()->route('veiculos.index')->with('success', 'Veículo cadastrado com sucesso!');
    }

    // Tela de edição
    public function edit(Veiculo $veiculo)
    {
        // Garante que o usuário só edita os próprios veículos
        if ($veiculo->user_id !== Auth::id()) {
            abort(403);
        }
        return view('veiculos.edit', compact('veiculo'));
    }

    // Atualizar no banco
    public function update(Request $request, Veiculo $veiculo)
    {
        if ($veiculo->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
             'numero' => 'nullable|string|max:50', // Validação do número
            'placa' => 'required|string|unique:veiculos,placa,'.$veiculo->id,
            'modelo' => 'required|string|max:255',
            'marca' => 'required|string|max:255',
            'ano' => 'required|integer|min:1900|max:'.(date('Y') + 1),
            'quilometragem_atual' => 'required|integer|min:0',
        ]);

        $veiculo->update($request->all());

        return redirect()->route('veiculos.index')->with('success', 'Veículo atualizado com sucesso!');
    }

    // Deletar veículo
    public function destroy(Veiculo $veiculo)
    {
        if ($veiculo->user_id !== Auth::id()) {
            abort(403);
        }
        
        $veiculo->delete();
        return redirect()->route('veiculos.index')->with('success', 'Veículo excluído com sucesso!');
    }
}
