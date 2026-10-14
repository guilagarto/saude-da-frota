<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Cadastrar Veículo') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('veiculos.store') }}" method="POST" class="space-y-4">
                    @csrf
                    
                    <div>
                        <x-input-label for="numero" value="Número do Veículo (Prefixo / C.C.)" />
                        <x-text-input id="numero" name="numero" type="text" class="mt-1 block w-full" value="{{ old('numero') }}" placeholder="Ex: 102" />
                        <x-input-error :messages="$errors->get('numero')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="placa" value="Placa" />
                        <x-text-input id="placa" name="placa" type="text" class="mt-1 block w-full" required value="{{ old('placa') }}" placeholder="Ex: ABC1D23" />
                        <x-input-error :messages="$errors->get('placa')" class="mt-2" />
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <x-input-label for="marca" value="Marca" />
                            <x-text-input id="marca" name="marca" type="text" class="mt-1 block w-full" required value="{{ old('marca') }}" placeholder="Ex: Volvo" />
                        </div>
                        <div>
                            <x-input-label for="modelo" value="Modelo" />
                            <x-text-input id="modelo" name="modelo" type="text" class="mt-1 block w-full" required value="{{ old('modelo') }}" placeholder="Ex: FH 540" />
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <x-input-label for="ano" value="Ano" />
                            <x-text-input id="ano" name="ano" type="number" class="mt-1 block w-full" required value="{{ old('ano') }}" />
                        </div>
                        <div>
                            <x-input-label for="quilometragem_atual" value="KM Atual" />
                            <x-text-input id="quilometragem_atual" name="quilometragem_atual" type="number" class="mt-1 block w-full" required value="{{ old('quilometragem_atual') }}" />
                        </div>
                    </div>

                    <div class="flex justify-end space-x-2 pt-4">
                        <a href="{{ route('veiculos.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-500 hover:bg-gray-700 text-white rounded-md font-semibold text-xs uppercase text-sm">Cancelar</a>
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md font-semibold text-xs uppercase text-sm">Salvar Veículo</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
