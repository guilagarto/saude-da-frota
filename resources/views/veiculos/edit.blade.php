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
                        <x-input-label for="placa" value="Placa" />
                        <x-text-input id="placa" name="placa" type="text" class="mt-1 block w-full" required value="{{ old('placa') }}" />
                        <x-input-error :messages="$errors->get('placa')" class="mt-2" />
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <x-input-label for="marca" value="Marca" />
                            <x-text-input id="marca" name="marca" type="text" class="mt-1 block w-full" required value="{{ old('marca') }}" />
                        </div>
                        <div>
                            <x-input-label for="modelo" value="Modelo" />
                            <x-text-input id="modelo" name="modelo" type="text" class="mt-1 block w-full" required value="{{ old('modelo') }}" />
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
                        <button href="{{ route('veiculos.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded text-sm">Cancelar</button>
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-sm">Salvar Veículo</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
