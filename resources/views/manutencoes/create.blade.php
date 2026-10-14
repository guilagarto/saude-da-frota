<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Registrar Nova Manutenção') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('manutencoes.store') }}" method="POST" class="space-y-4">
                    @csrf
                    
                    <!-- Seleção do Veículo -->
                    <div>
                        <x-input-label for="veiculo_id" value="Selecione o Veículo" />
                        <select id="veiculo_id" name="veiculo_id" required class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                            <option value="">-- Escolha um veículo da sua frota --</option>
                            @foreach($veiculos as $veiculo)
                                <option value="{{ $veiculo->id }}" {{ old('veiculo_id') == $veiculo->id ? 'selected' : '' }}>
                                    {{ $veiculo->numero ? '['.$veiculo->numero.'] ' : '' }}{{ $marca ?? $veiculo->marca }} {{ $veiculo->modelo }} - {{ $veiculo->placa }}
                                </option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('veiculo_id')" class="mt-2" />
                    </div>

                    <!-- Tipo de Manutenção -->
                    <div>
                        <x-input-label for="tipo" value="Tipo de Serviço" />
                        <x-text-input id="tipo" name="tipo" type="text" class="mt-1 block w-full" required placeholder="Ex: Troca de Óleo, Revisão dos Freios" value="{{ old('tipo') }}" />
                    </div>

                    <!-- Descrição detalhada -->
                    <div>
                        <x-input-label for="descricao" value="Descrição / Detalhes (Opcional)" />
                        <textarea id="descricao" name="descricao" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" rows="3">{{ old('descricao') }}</textarea>
                    </div>

                    <div class="grid grid-cols-3 gap-4">
                        <div>
                            <x-input-label for="data_realizada" value="Data do Serviço" />
                            <x-text-input id="data_realizada" name="data_realizada" type="date" class="mt-1 block w-full" required value="{{ old('data_realizada', date('Y-m-d')) }}" />
                        </div>
                        <div>
                            <x-input-label for="quilometragem_registro" value="KM no Dia" />
                            <x-text-input id="quilometragem_registro" name="quilometragem_registro" type="number" class="mt-1 block w-full" required value="{{ old('quilometragem_registro') }}" />
                        </div>
                        <div>
                            <x-input-label for="custo" value="Custo Total (R$)" />
                            <x-text-input id="custo" name="custo" type="number" step="0.01" class="mt-1 block w-full" required placeholder="0.00" value="{{ old('custo') }}" />
                        </div>
                    </div>

                    <!-- Bloco de Alertas para Próxima Revisão -->
                    <div class="border-t pt-4 mt-4">
                        <h3 class="text-sm font-semibold text-gray-700 mb-2">Configurar Alerta para Próxima Manutenção (Opcional)</h3>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <x-input-label for="proxima_quilometragem" value="Próxima Troca com (KM)" />
                                <x-text-input id="proxima_quilometragem" name="proxima_quilometragem" type="number" class="mt-1 block w-full" placeholder="Ex: 50000" value="{{ old('proxima_quilometragem') }}" />
                            </div>
                            <div>
                                <x-input-label for="proxima_data" value="Próxima Data Limite" />
                                <x-text-input id="proxima_data" name="proxima_data" type="date" class="mt-1 block w-full" value="{{ old('proxima_data') }}" />
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end space-x-2 pt-4">
                        <a href="{{ route('manutencoes.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-500 hover:bg-gray-700 text-white rounded-md font-semibold text-xs uppercase">Cancelar</a>
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md font-semibold text-xs uppercase">Salvar Registro</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
