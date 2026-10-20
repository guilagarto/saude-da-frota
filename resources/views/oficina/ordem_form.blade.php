<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight uppercase tracking-wider">
                🛠️ Oficina > Veículo {{ $atividade->veiculo->numero }} > Módulo {{ ucfirst($categoria) }}
            </h2>
            <a href="{{ route('oficina.index', ['data' => $atividade->data_atividade]) }}" class="text-sm font-bold text-gray-500 hover:text-gray-700 underline">
                ← Voltar ao Painel
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <div class="bg-slate-50 p-4 rounded-lg border border-gray-200 mb-6 flex justify-between text-sm font-semibold">
                    <div>🚗 <span class="text-gray-400">Modelo:</span> {{ $atividade->veiculo->modelo }} ({{ $atividade->veiculo->placa }})</div>
                    <div>📅 <span class="text-gray-400">Data Atividade:</span> {{ \Carbon\Carbon::parse($atividade->data_atividade)->format('d/m/Y') }}</div>
                </div>

                <form action="{{ route('oficina.ordem.store', ['atividade' => $atividade->id, 'categoria' => $categoria]) }}" method="POST" class="space-y-6">
                    @csrf

                    <div class="overflow-x-auto border border-gray-100 rounded-lg shadow-sm">
                        <table class="w-full text-left text-sm text-gray-500">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-100 border-b border-gray-200">
                                <tr>
                                    <th scope="col" class="px-4 py-3 w-1/4">Item Avaliado</th>
                                    <th scope="col" class="px-4 py-3 text-center">Ação Oficinal</th>
                                    <th scope="col" class="px-4 py-3 text-center w-1/5">Status de Saúde (Gráfico)</th>
                                    <th scope="col" class="px-4 py-3">Motivo da Avaria</th>
                                    <th scope="col" class="px-4 py-3">Peças Substituídas</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($itens as $chave => $label)
                                    @php
                                        $salvo = $ordensSalvas[$chave] ?? null;
                                        $inspecaoVinculada = $atividade->inspecao_id ? \App\Models\Inspecao::find($atividade->inspecao_id) : null;
                                        $statusAtual = $inspecaoVinculada ? $inspecaoVinculada->$chave : 'Bom';
                                    @endphp
                                    <tr class="border-b bg-white hover:bg-slate-50">
                                        <td class="px-4 py-3 font-semibold text-gray-700">
                                            {{ $label }}
                                            <input type="hidden" name="itens[{{ $chave }}][label]" value="{{ $label }}">
                                        </td>
                                        <td class="px-4 py-3 text-center">
                                            <div class="flex justify-center gap-4 text-xs font-bold uppercase">
                                                <label class="flex items-center gap-1 text-blue-600 cursor-pointer">
                                                    <input type="radio" name="itens[{{ $chave }}][acao]" value="Reparar" {{ $salvo && $salvo->acao == 'Reparar' ? 'checked' : '' }} class="rounded border-gray-300 text-blue-600 focus:ring-blue-500"> Reparar
                                                </label>
                                                <label class="flex items-center gap-1 text-red-600 cursor-pointer">
                                                    <input type="radio" name="itens[{{ $chave }}][acao]" value="Trocar" {{ $salvo && $salvo->acao == 'Trocar' ? 'checked' : '' }} class="rounded border-gray-300 text-red-600 focus:ring-red-500"> Trocar
                                                </label>
                                            </div>
                                        </td>
                                        <td class="px-4 py-3 text-center">
                                            <select name="itens[{{ $chave }}][status_saude]" class="border-gray-300 focus:ring-blue-500 rounded-md text-xs py-1 font-semibold text-gray-700">
                                                <option value="Bom" {{ $statusAtual == 'Bom' ? 'selected' : '' }}>💚 Bom</option>
                                                <option value="Regular" {{ $statusAtual == 'Regular' ? 'selected' : '' }}>💛 Regular</option>
                                                <option value="Ruim" {{ $statusAtual == 'Ruim' ? 'selected' : '' }}>❤️ Ruim</option>
                                            </select>
                                        </td>
                                        <td class="px-4 py-2">
                                            <input type="text" name="itens[{{ $chave }}][motivo]" value="{{ $salvo ? $salvo->motivo : '' }}" placeholder="Ex: Queimado, Quebrado" class="w-full border-gray-300 rounded-md text-xs py-1.5 focus:ring-blue-500">
                                        </td>
                                        <td class="px-4 py-2">
                                            <input type="text" name="itens[{{ $chave }}][pecas]" value="{{ $salvo ? $salvo->pecas_trocadas : '' }}" placeholder="Ex: Lâmpada H7" class="w-full border-gray-300 rounded-md text-xs py-1.5 focus:ring-blue-500">
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="flex justify-end gap-4 border-t border-gray-100 pt-4">
                        <a href="{{ route('oficina.index', ['data' => $atividade->data_atividade]) }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold py-2 px-4 rounded text-xs uppercase tracking-wider">
                            Cancelar
                        </a>
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded text-xs uppercase tracking-wider shadow">
                            Salvar Ordem de Serviço
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>