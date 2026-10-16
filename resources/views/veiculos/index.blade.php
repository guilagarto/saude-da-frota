<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Meus Veículos') }}
            </h2>
            <!-- O botão azul que estava faltando -->
            <div>
                <a href="{{ route('veiculos.create') }}" class="bg-red-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-sm"> + Adicionar Veículo</a>
            </div>
        </div>      

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
               <!-- Barra de Filtro / Busca -->
<div class="mb-6">
    <form action="{{ route('veiculos.index') }}" method="GET" class="flex gap-2">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar por placa, prefixo ou modelo..." class="w-full sm:w-1/3 border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm text-sm">
        <button type="submit" class="bg-gray-800 hover:bg-gray-700 text-white font-semibold py-2 px-4 rounded-md text-sm">
            Filtrar
        </button>
        @if(request('search'))
            <a href="{{ route('veiculos.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 py-2 px-4 rounded-md text-sm flex items-center">
                Limpar
            </a>
        @endif
    </form>
</div>

@if($veiculos->isEmpty())
    <p class="text-gray-500 text-center">Nenhum veículo encontrado.</p>
@else
    <table class="min-w-full divide-y divide-gray-200">
        <thead>
            <tr>
                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nº Veículo</th>
                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Placa</th>
                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Modelo/Marca</th>
                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">KM Atual</th>
                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ações</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @foreach($veiculos as $veiculo)
                <tr class="hover:bg-gray-50 transition-colors duration-150">
                    <!-- O clique no número ou na placa agora leva para a página específica do veículo (show) -->
                    <td class="px-6 py-4 whitespace-nowrap">
                        <a href="{{ route('veiculos.show', $veiculo) }}" class="text-blue-600 hover:text-blue-900 font-semibold hover:underline">
                            {{ $veiculo->numero ?? 'N/A' }}
                        </a>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap font-bold text-gray-900">
                        <a href="{{ route('veiculos.show', $veiculo) }}" class="text-blue-600 hover:text-blue-900 hover:underline">
                            {{ $veiculo->placa }}
                        </a>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-gray-700">{{ $veiculo->modelo }} / {{ $veiculo->marca }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-gray-600">{{ number_format($veiculo->quilometragem_atual, 0, ',', '.') }} KM</td>
                    <td class="px-6 py-4 whitespace-nowrap flex space-x-3">
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
