<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Controle de Manutenções') }}
            </h2>
            <a href="{{ route('manutencoes.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 text-sm">
                + Registrar Manutenção
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                @if($manutencoes->isEmpty())
                    <p class="text-gray-500 text-center">Nenhuma manutenção registrada para a sua frota.</p>
                @else
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase">Veículo</th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase">Tipo</th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase">Data</th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase">KM Registro</th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase">Custo</th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase">Próxima Revisão</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($manutencoes as $manutencao)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap font-bold text-gray-900">
                                        {{ $manutencao->veiculo->modelo }} ({{ $manutencao->veiculo->placa }})
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-700">{{ $manutencao->tipo }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-600">{{ date('d/m/Y', strtotime($manutencao->data_realizada)) }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-600">{{ number_format($manutencao->quilometragem_registro, 0, ',', '.') }} KM</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-green-600 font-medium">R$ {{ number_format($manutencao->custo, 2, ',', '.') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        @if($manutencao->proxima_quilometragem)
                                            <div>Com: {{ number_format($manutencao->proxima_quilometragem, 0, ',', '.') }} KM</div>
                                        @endif
                                        @if($manutencao->proxima_data)
                                            <div class="text-xs text-red-500">Data: {{ date('d/m/Y', strtotime($manutencao->proxima_data)) }}</div>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
