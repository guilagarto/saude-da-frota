<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Histórico Geral > 📋 Ordens de Serviço Realizadas') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Barra de Busca Inteligente -->
            <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-100">
                <form action="{{ route('oficina.ordens.lista') }}" method="GET" class="flex items-center gap-3 max-w-xl">
                    <div class="w-full relative">
                        <input type="text" name="busca" value="{{ $busca }}" placeholder="Buscar por Nº do veículo, placa, peça ou motivo..." class="w-full border-gray-300 focus:ring-blue-500 rounded-md text-sm text-gray-700">
                    </div>
                    <button type="submit" class="bg-slate-800 hover:bg-slate-900 text-white text-xs font-bold px-5 py-3 rounded uppercase tracking-wider transition-colors shadow-sm">
                        Buscar
                    </button>
                    @if(!empty($busca))
                        <a href="{{ route('oficina.ordens.lista') }}" class="text-xs text-gray-500 hover:text-gray-700 underline font-medium">Limpar</a>
                    @endif
                </form>
            </div>

            <!-- Tabela Concretizada de Ordens -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-gray-500">
                        <thead class="text-xs text-gray-400 uppercase bg-gray-50 border-b border-gray-100">
                            <tr>
                                <th scope="col" class="px-4 py-3">Data Manutenção</th>
                                <th scope="col" class="px-4 py-3">Nº Veículo</th>
                                <th scope="col" class="px-4 py-3">Módulo</th>
                                <th scope="col" class="px-4 py-3">Item Consertado</th>
                                <th scope="col" class="px-4 py-3 text-center">Operação</th>
                                <th scope="col" class="px-4 py-3">Motivo / Defeito</th>
                                <th scope="col" class="px-4 py-3">Peças Substituídas</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($ordens as $ordem)
                                <tr class="bg-white border-b hover:bg-slate-50 transition-colors">
                                    <td class="px-4 py-4 text-gray-600 font-medium">
                                        {{ \Carbon\Carbon::parse($ordem->atividade->data_atividade)->format('d/m/Y') }}
                                    </td>
                                    <td class="px-4 py-4 font-mono font-bold text-blue-600">
                                        Nº {{ $ordem->atividade->veiculo->numero ?? 'N/A' }}
                                    </td>
                                    <td class="px-4 py-4 font-bold text-xs uppercase">
                                        @if($ordem->categoria == 'eletrica')
                                            <span class="text-amber-600 bg-amber-50 px-2 py-0.5 rounded border border-amber-100">⚡ Elétrica</span>
                                        @elseif($ordem->categoria == 'mecanica')
                                            <span class="text-slate-600 bg-slate-50 px-2 py-0.5 rounded border border-slate-100">⚙️ Mecânica</span>
                                        @elseif($ordem->categoria == 'lanternagem')
                                            <span class="text-blue-600 bg-blue-50 px-2 py-0.5 rounded border border-blue-100">🎨 Lant.</span>
                                        @elseif($ordem->categoria == 'borracharia')
                                            <span class="text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded border border-emerald-100">🛞 Borr.</span>
                                        @else
                                            <span class="text-purple-600 bg-purple-50 px-2 py-0.5 rounded border border-purple-100">🖌️ Pintura</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-4 font-semibold text-gray-700 max-w-[200px] truncate" title="{{ $ordem->item_label }}">
                                        {{ $ordem->item_label }}
                                    </td>
                                    <td class="px-4 py-4 text-center">
                                        @if($ordem->acao == 'Trocar')
                                            <span class="text-red-700 bg-red-50 text-[10px] font-black uppercase px-2 py-0.5 rounded border border-red-200">🔄 Troca</span>
                                        @else
                                            <span class="text-blue-700 bg-blue-50 text-[10px] font-black uppercase px-2 py-0.5 rounded border border-blue-200">🛠️ Reparo</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-4 text-gray-600 italic">
                                        {{ $ordem->motivo ?? '-' }}
                                    </td>
                                    <td class="px-4 py-4 font-medium text-gray-800 bg-slate-50 border-l border-r border-gray-100">
                                        {{ $ordem->pecas_trocadas ?? 'Nenhuma peça cadastrada' }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-4 py-12 text-center text-gray-400">
                                        <span class="text-3xl block mb-2">📋</span>
                                        Nenhuma Ordem de Serviço encontrada com os termos informados.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <!-- Links de Paginação do Tailwind -->
                <div class="mt-4">
                    {{ $ordens->appends(['busca' => $busca])->links() }}
                </div>
            </div>

        </div>
    </div>
</x-app-layout>