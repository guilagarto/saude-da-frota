<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Meus Veículos > Inspeções') }}
            </h2>
            <a href="{{ route('inspecoes.create') }}" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded text-sm uppercase tracking-wider shadow">
                + Nova Inspeção
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <!-- Formulário de Filtro por Carro Automático -->
                <form id="filtroForm" action="{{ route('inspecoes.index') }}" method="GET" class="mb-6 flex items-center gap-4">
                    <div class="w-full max-w-md">
                        <select name="veiculo_id" onchange="document.getElementById('filtroForm').submit()" class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm text-gray-600">
                            <option value="">Selecione um veículo para buscar...</option>
                            @foreach($veiculos as $veiculo)
                                <option value="{{ $veiculo->id }}" {{ request('veiculo_id') == $veiculo->id ? 'selected' : '' }}>
                                    {{ $veiculo->placa }} - {{ $veiculo->modelo }} / {{ $veiculo->marca }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    @if(request()->filled('veiculo_id'))
                        <a href="{{ route('inspecoes.index') }}" class="text-sm text-red-600 hover:text-red-800 font-medium underline">
                            Limpar Filtro
                        </a>
                    @endif
                </form>

                <!-- Tabela de Inspeções -->
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-gray-500">
                        <thead class="text-xs text-gray-400 uppercase bg-gray-50 border-b border-gray-100">
                            <tr>
                                <th scope="col" class="px-6 py-3">Placa</th>
                                <th scope="col" class="px-6 py-3">Modelo / Marca</th>
                                <th scope="col" class="px-6 py-3">Data da Inspeção</th>
                                <th scope="col" class="px-6 py-3 text-center">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($inspecoes as $inspecao)
                                <tr class="bg-white border-b hover:bg-gray-50">
                                    <td class="px-6 py-4 font-mono font-bold text-blue-600 uppercase">
                                        {{ $inspecao->veiculo->placa }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $inspecao->veiculo->modelo }} / {{ $inspecao->veiculo->marca }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ \Carbon\Carbon::parse($inspecao->data_inspecao)->format('d/m/Y') }}
                                    </td>
                                    <td class="px-6 py-4 text-center flex justify-center gap-6">
                                        <a href="{{ route('inspecoes.imprimir', $inspecao->id) }}" target="_blank" class="text-indigo-600 hover:text-indigo-900 font-semibold flex items-center gap-1">
                                            🖨️ Imprimir Ficha
                                        </a>
                                        <a href="{{ route('inspecoes.edit', $inspecao->id) }}" class="text-blue-600 hover:text-blue-900 font-semibold">
                                            ✏️ Editar
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center justify-center space-y-2">
                                            <span class="text-3xl">⚠️</span>
                                            @if(request()->filled('veiculo_id'))
                                                <p class="text-gray-600 font-medium text-base">Não foi realizada nenhuma inspeção para este veículo ainda.</p>
                                            </td>
                                            @else
                                                <p class="text-gray-500 font-medium text-base">Nenhuma inspeção registrada no sistema.</p>
                                            </td>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
