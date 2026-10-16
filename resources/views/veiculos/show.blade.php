<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Detalhes do Veículo: {{ $veiculo->modelo }} [{{ $veiculo->numero ?? 'S/N' }}]
            </h2>
            <a href="{{ route('veiculos.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded text-xs uppercase">
                Voltar
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Card de Informações Técnicas -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 grid grid-cols-2 md:grid-cols-4 gap-4">
                <div>
                    <span class="text-xs text-gray-500 uppercase font-bold">Placa</span>
                    <p class="text-lg font-bold text-gray-900">{{ $veiculo->placa }}</p>
                </div>
                <div>
                    <span class="text-xs text-gray-500 uppercase font-bold">Marca / Modelo</span>
                    <p class="text-lg text-gray-700">{{ $veiculo->marca }} / {{ $veiculo->modelo }}</p>
                </div>
                <div>
                    <span class="text-xs text-gray-500 uppercase font-bold">Ano</span>
                    <p class="text-lg text-gray-700">{{ $veiculo->ano }}</p>
                </div>
                <div>
                    <span class="text-xs text-gray-500 uppercase font-bold">KM Atual</span>
                    <p class="text-lg text-gray-700">{{ number_format($veiculo->quilometragem_atual, 0, ',', '.') }} KM</p>
                </div>
            </div>

            <!-- Histórico de Manutenções Vinculado -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4">Histórico de Serviços deste Veículo</h3>
                
                @if($veiculo->manutencoes->isEmpty())
                    <p class="text-gray-500 text-sm">Nenhuma manutenção lançada para este veículo ainda.</p>
                @else
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead>
                            <tr>
                                <th class="px-4 py-2 bg-gray-50 text-left font-medium text-gray-500">Serviço</th>
                                <th class="px-4 py-2 bg-gray-50 text-left font-medium text-gray-500">Data</th>
                                <th class="px-4 py-2 bg-gray-50 text-left font-medium text-gray-500">KM</th>
                                <th class="px-4 py-2 bg-gray-50 text-left font-medium text-gray-500">Custo</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($veiculo->manutencoes as $manutencao)
                                <tr>
                                    <td class="px-4 py-3 font-semibold text-gray-800">{{ $manutencao->tipo }}</td>
                                    <td class="px-4 py-3 text-gray-600">{{ date('d/m/Y', strtotime($manutencao->data_realizada)) }}</td>
                                    <td class="px-4 py-3 text-gray-600">{{ number_format($manutencao->quilometragem_registro, 0, ',', '.') }} KM</td>
                                    <td class="px-4 py-3 text-green-600 font-bold">R$ {{ number_format($manutencao->custo, 2, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
