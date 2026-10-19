<?php

namespace App\Http\Controllers;

use App\Models\Inspecao;
use App\Models\Veiculo; // Certifique-se de importar seu model de Veículo
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InspecaoController extends Controller
{
    // Listar inspeções com filtro por veículo
    public function index(Request $request)
    {
        $veiculos = Veiculo::all();
        
        // Se o usuário filtrou por um carro específico
        $query = Inspecao::with('veiculo');
        if ($request->filled('veiculo_id')) {
            $query->where('veiculo_id', $request->veiculo_id);
        }
        $inspecoes = $query->latest()->get();

        return view('inspecoes.index', compact('inspecoes', 'veiculos'));
    }

    // Tela de preenchimento da ficha
    public function create()
    {
        $veiculos = Veiculo::all();
        return view('inspecoes.create', compact('veiculos'));
    }

    // Salvar os dados do formulário e fazer upload da foto
    public function store(Request $request)
    {
        $request->validate([
            'veiculo_id' => 'required|exists:veiculos,id',
            'data_inspecao' => 'required|date',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $dados = $request->all();

        // Lógica de Upload da Foto
        if ($request->hasFile('foto')) {
            $dados['foto_path'] = $request->file('foto')->store('inspecoes', 'public');
        }

        Inspecao::create($dados);

        return redirect()->route('inspecoes.index')->with('success', 'Inspeção salva com sucesso!');
    }

    // Tela de Edição
    // Tela de Edição
   public function edit(Inspecao $inspecom)
{
    // Renomeamos para $inspecao interna para não quebrar sua view
    $inspecao = $inspecom; 
    $veiculos = Veiculo::all();
    
    return view('inspecoes.edit', compact('inspecao', 'veiculos'));
}


    // Função de Imprimir (Apenas abre uma view limpa otimizada para impressão do navegador)
    public function imprimir(Inspecao $inspecao)
    {
        return view('inspecoes.imprimir', compact('inspecao'));
    }
    // Função de Atualização
public function update(Request $request, $id)
{
    // Localiza a inspeção pelo ID enviado na URL de forma manual e segura
    $inspecao = \App\Models\Inspecao::findOrFail($id);

    $request->validate([
        'veiculo_id' => 'required|exists:veiculos,id',
        'data_inspecao' => 'required|date',
        'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
    ]);

    $dados = $request->all();

    // Lógica para substituir a foto caso uma nova seja enviada
    if ($request->hasFile('foto')) {
        if ($inspecao->foto_path) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($inspecao->foto_path);
        }
        $dados['foto_path'] = $request->file('foto')->store('inspecoes', 'public');
    }

    // Executa a atualização dos 24 campos elétricos no banco de dados
    $inspecao->update($dados);

    return redirect()->route('inspecoes.index')->with('success', 'Inspeção elétrica atualizada com sucesso!');
}


    // Deletar uma inspeção
    public function destroy(Inspecao $inspecao)
    {
        // Se houver uma foto associada, deleta do storage
        if ($inspecao->foto_path) {
            Storage::disk('public')->delete($inspecao->foto_path);
        }

        $inspecao->delete();

        return redirect()->route('inspecoes.index')->with('success', 'Inspeção deletada com sucesso!');
    }
}
