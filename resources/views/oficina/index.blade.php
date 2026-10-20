<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Painel Diário > 🛠️ Oficina') }}
            </h2>
            <!-- Botão que aciona o Modal Flutuante -->
            <button onclick="toggleModal(true)" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-sm uppercase tracking-wider shadow transition-colors">
                + Entrar Veículo
            </button>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Barra de Controle de Filtro por Data -->
            <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-100 flex items-center justify-between flex-wrap gap-4">
                <form id="dataForm" action="{{ route('oficina.index') }}" method="GET" class="flex items-center gap-2">
                    <label for="data" class="text-xs font-bold text-gray-400 uppercase">Filtrar Dia:</label>
                    <input type="date" name="data" id="data" value="{{ $dataFiltro }}" onchange="document.getElementById('dataForm').submit()" class="border-gray-300 focus:ring-blue-500 rounded-md text-sm font-semibold text-gray-700">
                </form>
                
                <div class="text-right bg-blue-50 px-4 py-1.5 rounded-md border border-blue-100">
                    <span class="text-sm font-black text-blue-700 uppercase tracking-wide">{{ $dataTexto }}</span>
                </div>
            </div>

            <!-- Listagem Principal de Atividades da Oficina -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-gray-500">
                        <thead class="text-xs text-gray-400 uppercase bg-gray-50 border-b border-gray-100">
                            <tr>
                                <th scope="col" class="px-6 py-3">Nº Veículo</th>
<th scope="col" class="px-6 py-3">Modelo / Marca</th>
<th scope="col" class="px-6 py-3 text-center">Status / Origem</th>
<th scope="col" class="px-6 py-3 text-center">Ações / Abertura de Histórico</th>
                            </tr>
                        </thead>
                        <tbody>
                           @forelse($atividades as $atividade)
    <tr class="bg-white border-b hover:bg-gray-50">
        <td class="px-6 py-4 font-mono font-bold text-blue-600 text-base">
            {{ $atividade->veiculo->numero }}
        </td>
        <td class="px-6 py-4 font-medium text-gray-800">
            {{ $atividade->veiculo->modelo }}
        </td>
        
        <!-- Crachá de Status de Permanência -->
        <td class="px-6 py-4 text-center">
            @if($atividade->data_saida == $dataFiltro)
                <span class="bg-green-100 text-green-800 text-xs font-bold px-2.5 py-1 rounded border border-green-200 uppercase">✓ Saiu Hoje</span>
            @elseif($atividade->data_atividade < $dataFiltro)
                <span class="bg-red-100 text-red-800 text-xs font-bold px-2.5 py-1 rounded border border-red-200 uppercase animate-pulse">⏳ Virou o Dia</span>
            @else
                <span class="bg-blue-100 text-blue-800 text-xs font-bold px-2.5 py-1 rounded border border-blue-200 uppercase">📥 Entrou Hoje</span>
            @endif
        </td>

        <td class="px-6 py-4">
            <div class="flex flex-wrap justify-center items-center gap-2">
                <!-- Seus 5 botões anteriores mantidos aqui -->
                <a href="{{ route('oficina.ordem.create', ['atividade' => $atividade->id, 'categoria' => 'eletrica']) }}" class="bg-amber-500 hover:bg-amber-600 text-white text-[11px] font-bold py-1.5 px-3 rounded uppercase tracking-wider shadow-sm">⚡ Elétrica</a>
                <a href="{{ route('oficina.ordem.create', ['atividade' => $atividade->id, 'categoria' => 'mecanica']) }}" class="bg-slate-700 hover:bg-slate-800 text-white text-[11px] font-bold py-1.5 px-3 rounded uppercase tracking-wider shadow-sm">⚙️ Mecânica</a>
                <a href="{{ route('oficina.ordem.create', ['atividade' => $atividade->id, 'categoria' => 'lanternagem']) }}" class="bg-blue-500 hover:bg-blue-600 text-white text-[11px] font-bold py-1.5 px-3 rounded uppercase tracking-wider shadow-sm">🎨 Lanternagem</a>
                <a href="{{ route('oficina.ordem.create', ['atividade' => $atividade->id, 'categoria' => 'borracharia']) }}" class="bg-emerald-600 hover:bg-emerald-700 text-white text-[11px] font-bold py-1.5 px-3 rounded uppercase tracking-wider shadow-sm">🛞 Borracharia</a>
                <a href="{{ route('oficina.ordem.create', ['atividade' => $atividade->id, 'categoria' => 'pintura']) }}" class="bg-purple-600 hover:bg-purple-700 text-white text-[11px] font-bold py-1.5 px-3 rounded uppercase tracking-wider shadow-sm">🖌️ Pintura</a>
                
                <!-- 🚪 BOTÃO DE SAÍDA ADICIONADO -->
                @if(empty($atividade->data_saida))
                    <button onclick="abrirModalSaida({{ $atividade->id }}, '{{ $atividade->veiculo->numero }}')" class="bg-slate-500 hover:bg-slate-600 text-white text-[11px] font-bold py-1.5 px-3 rounded uppercase tracking-wider shadow-sm transition-all">
                        🚪 Saída
                    </button>
                @endif
            </div>
        </td>
    </tr>
@empty
                                <tr>
                                    <td colspan="3" class="px-6 py-12 text-center text-gray-500">
                                        <span class="text-3xl block mb-2">🛠️</span>
                                        <p class="font-bold text-gray-600">Nenhum veículo deu entrada na oficina nesta data.</p>
                                        <p class="text-gray-400 text-xs mt-1">Clique em "Entrar Veículo" acima para abrir o fluxo do dia.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    <!-- 📥 MODAL FLUTUANTE 100% NATIVO (ADICIONAR CARRO NO DIA) -->
    <div id="modalVeiculo" class="fixed inset-0 z-50 hidden bg-slate-900 bg-opacity-50 flex items-center justify-center p-4 transition-all">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-md transform transition-all overflow-hidden border border-gray-100">
            
            <!-- Cabeçalho do Modal -->
            <div class="bg-slate-50 px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                <h3 class="text-base font-bold text-gray-800 uppercase tracking-wide">Dar Entrada na Oficina</h3>
                <button onclick="toggleModal(false)" class="text-gray-400 hover:text-gray-600 font-bold text-lg">&times;</button>
            </div>

            <!-- Formulário Interno -->
            <form action="{{ route('oficina.store') }}" method="POST" class="p-6 space-y-4">
    @csrf
    <!-- Injeta o nome correto da variável esperada pelo Controller -->
    <input type="hidden" name="data_atividade" value="{{ $dataFiltro }}">

    <div>
        <label for="veiculo_id" class="block text-xs font-bold text-gray-500 uppercase mb-1">Selecione o Veículo Frota</label>
        <select name="veiculo_id" id="veiculo_id" required class="w-full border-gray-300 focus:ring-blue-500 rounded-md text-sm font-semibold text-gray-700">
            <option value="">Escolha um veículo disponível...</option>
            @foreach($veiculosDisponiveis as $v)
                <option value="{{ $v->id }}">Nº {{ $v->numero }} - {{ $v->modelo }} ({{ $v->placa }})</option>
            @endforeach
        </select>
    </div>

    <div class="pt-4 border-t border-gray-100 flex justify-end gap-3">
                <button type="button" onclick="toggleModal(false)" class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold py-2 px-4 rounded text-xs uppercase">
                    Cancelar
                </button>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-5 rounded text-xs uppercase tracking-wider shadow">
                    Confirmar Entrada
                </button>
            </div>
        </form>

        </div>
    </div>

    <!-- Script Inline para Controle do Modal Flutuante -->
    <script>
        function toggleModal(show) {
            const modal = document.getElementById('modalVeiculo');
            if (show) {
                modal.classList.remove('hidden');
            } else {
                modal.classList.add('hidden');
            }
        }
    </script>
     <!-- 🚪 MODAL FLUTUANTE DE SAÍDA DO VEÍCULO -->
    <div id="modalSaida" class="fixed inset-0 z-50 hidden bg-slate-900 bg-opacity-50 flex items-center justify-center p-4 transition-all">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-md overflow-hidden border border-gray-100">
            
            <div class="bg-slate-100 px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                <h3 class="text-base font-bold text-gray-800 uppercase tracking-wide">Dar Saída do Veículo <span id="txtNumeroCarro"></span></h3>
                <button onclick="fecharModalSaida()" class="text-gray-400 hover:text-gray-600 font-bold text-lg">&times;</button>
            </div>

            <form id="formSaida" action="" method="POST" class="p-6 space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Data da Saída</label>
                    <input type="date" name="data_saida" required value="{{ $dataFiltro }}" class="w-full border-gray-300 rounded-md text-sm">
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Horário de Saída</label>
                    <input type="time" name="horario_saida" required value="{{ date('H:i') }}" class="w-full border-gray-300 rounded-md text-sm">
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Observações de Liberação</label>
                    <textarea name="obs_saida" rows="3" placeholder="Insira o parecer final, reparos efetuados ou pendências de peças..." class="w-full border-gray-300 rounded-md text-xs"></textarea>
                </div>

                <div class="pt-4 border-t border-gray-100 flex justify-end gap-3">
                    <button type="button" onclick="fecharModalSaida()" class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold py-2 px-4 rounded text-xs uppercase">
                        Cancelar
                    </button>
                    <button type="submit" class="bg-slate-700 hover:bg-slate-800 text-white font-bold py-2 px-5 rounded text-xs uppercase tracking-wider shadow">
                        Finalizar Manutenção
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Scripts de Controle do Modal Secundário -->
    <script>
        function abrirModalSaida(id, numero) {
            document.getElementById('txtNumeroCarro').innerText = 'Nº ' + numero;
            // Define o endereço da rota dinamicamente injetando o ID da atividade
            document.getElementById('formSaida').action = '/oficina/atividade/' + id + '/saida';
            document.getElementById('modalSaida').classList.remove('hidden');
        }

        function fecharModalSaida() {
            document.getElementById('modalSaida').classList.add('hidden');
        }
    </script>
</x-app-layout>