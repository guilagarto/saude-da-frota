<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Meus Veículos') }}
            </h2>
            <a href="{{ route('veiculos.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-sm">
                + Adicionar Veículo
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
                @if($veiculos->isEmpty())
                    <p class="text-gray-500 text-center">Nenhum veículo cadastrado ainda.</p>
                @else
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Número</th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Placa</th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Modelo/Marca</th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ano</th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">KM Atual</th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ações</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($veiculos as $veiculo)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap font-bold text-gray-900">{{ $veiculo->numero }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap font-bold text-gray-900">{{ $veiculo->placa }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-700">{{ $veiculo->modelo }} / {{ $veiculo->marca }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-600">{{ $veiculo->ano }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-600">{{ number_format($veiculo->quilometragem_atual, 0, ',', '.') }} KM</td>
                                    <td class="px-6 py-4 whitespace-nowrap flex space-x-2">
                                        <a href="{{ route('veiculos.edit', $veiculo) }}" class="text-indigo-600 hover:text-indigo-900 font-medium">Editar</a>
                                        <form action="{{ route('veiculos.destroy', $veiculo) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900 font-medium">Excluir</button>
                                        </form>
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
