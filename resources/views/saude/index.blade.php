<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard > 📊 Saúde Geral da Frota') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Painel de Filtro -->
            <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100 flex items-center justify-between flex-wrap gap-4">
                <form id="dashboardForm" action="{{ route('saude.frota') }}" method="GET" class="w-full max-w-md">
                    <label class="block text-xs font-bold text-gray-400 uppercase mb-1">Selecione o Escopo de Análise</label>
                    <select name="veiculo_id" onchange="document.getElementById('dashboardForm').submit()" class="w-full border-gray-300 focus:ring-blue-500 rounded-md text-sm font-semibold text-gray-700">
                        <option value="">📊 Exibir Frota Completa (Todos os Carros)</option>
                        @foreach($veiculos as $veiculo)
                            <option value="{{ $veiculo->id }}" {{ $veiculoSelecionado == $veiculo->id ? 'selected' : '' }}>
                                🚗 {{ $veiculo->placa }} - {{ $veiculo->modelo }}
                            </option>
                        @endforeach
                    </select>
                </form>
                
                <div class="text-right">
                    <span class="text-xs font-bold text-gray-400 uppercase block">Fichas Processadas</span>
                    <span class="text-2xl font-black text-blue-600">{{ $inspecoes->count() }} vistorias</span>
                </div>
            </div>

            @if($inspecoes->count() > 0)
                @php
                    // Cálculo percentual seguro e preciso
                    $total = $bom + $regular + $ruim;
                    $totalValido = $total > 0 ? $total : 1;
                    
                    $pBom = ($bom / $totalValido) * 100;
                    $pRegular = ($regular / $totalValido) * 100;
                    $pRuim = ($ruim / $totalValido) * 100;
                @endphp

                <!-- Blocos de Gráficos e Indicadores -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    
                    <!-- Gráfico de Rosca Nativo em SVG -->
                    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100 md:col-span-2 flex flex-col justify-between items-center">
                        <h3 class="w-full text-sm font-bold text-gray-700 uppercase tracking-wide border-b pb-2 mb-6">Índice Geral de Conformidade (Peças e Sistemas)</h3>
                        
                        <div class="flex flex-col sm:flex-row items-center justify-center gap-12 w-full py-4">
                            
                            <!-- Gráfico Circular Nativo Avançado -->
                            <div class="relative w-44 h-44">
                                <svg viewBox="0 0 36 36" class="w-full h-full transform -rotate-90">
                                    <!-- Fundo Cinza Neutro -->
                                    <circle cx="18" cy="18" r="15.915" fill="transparent" stroke="#f3f4f6" stroke-width="4.2"></circle>
                                    
                                    <!-- Camada 1: Tudo que for BOM (Verde) -->
                                    @if($bom > 0)
                                        <circle cx="18" cy="18" r="15.915" fill="transparent" stroke="#10b981" stroke-width="4.3" 
                                                stroke-dasharray="{{ $pBom }} 100" 
                                                stroke-dashoffset="0"></circle>
                                    @endif
                                    
                                    <!-- Camada 2: Tudo que for REGULAR (Amarelo) -->
                                    @if($regular > 0)
                                        <circle cx="18" cy="18" r="15.915" fill="transparent" stroke="#f59e0b" stroke-width="4.3" 
                                                stroke-dasharray="{{ $pRegular }} 100" 
                                                stroke-dashoffset="-{{ $pBom }}"></circle>
                                    @endif
                                    
                                    <!-- Camada 3: Tudo que for RUIM (Vermelho) -->
                                    @if($ruim > 0)
                                        <circle cx="18" cy="18" r="15.915" fill="transparent" stroke="#ef4444" stroke-width="4.3" 
                                                stroke-dasharray="{{ $pRuim }} 100" 
                                                stroke-dashoffset="-{{ $pBom + $pRegular }}"></circle>
                                    @endif
                                </svg>

                                <!-- Texto central informativo -->
                                <div class="absolute inset-0 flex flex-col items-center justify-center text-center">
                                    <span class="text-2xl font-black text-slate-700">{{ round($pBom, 1) }}%</span>
                                    <span class="text-[9px] font-bold text-gray-400 uppercase tracking-wider">Eficiência</span>
                                </div>
                            </div>

                            <!-- Legendas Gerenciais Nativas -->
                            <div class="space-y-3 text-xs font-bold text-gray-600">
                                <div class="flex items-center gap-2.5">
                                    <span class="w-3 h-3 rounded-full bg-[#10b981]"></span>
                                    <span class="text-gray-700">Bom: {{ round($pBom, 1) }}% ({{ $bom }})</span>
                                </div>
                                <div class="flex items-center gap-2.5">
                                    <span class="w-3 h-3 rounded-full bg-[#f59e0b]"></span>
                                    <span class="text-gray-700">Regular: {{ round($pRegular, 1) }}% ({{ $regular }})</span>
                                </div>
                                <div class="flex items-center gap-2.5">
                                    <span class="w-3 h-3 rounded-full bg-[#ef4444]"></span>
                                    <span class="text-gray-700">Ruim: {{ round($pRuim, 1) }}% ({{ $ruim }})</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Métricas Individuais -->
                    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100 flex flex-col justify-between space-y-4">
                        <h3 class="text-sm font-bold text-gray-700 uppercase tracking-wide border-b pb-2">Status dos Componentes</h3>
                        
                        <div class="bg-green-50 p-4 rounded-lg border border-green-100 flex justify-between items-center">
                            <div>
                                <span class="block text-xs font-bold text-green-700 uppercase">Itens em Conformidade</span>
                                <span class="text-[11px] text-green-600 font-medium">Operando Normalmente</span>
                            </div>
                            <span class="text-2xl font-black text-green-600">{{ $bom }}</span>
                        </div>

                        <div class="bg-amber-50 p-4 rounded-lg border border-amber-100 flex justify-between items-center">
                            <div>
                                <span class="block text-xs font-bold text-amber-700 uppercase">Atenção / Manutenção</span>
                                <span class="text-[11px] text-amber-600 font-medium">Observar no Retorno</span>
                            </div>
                            <span class="text-2xl font-black text-amber-600">{{ $regular }}</span>
                        </div>

                        <div class="bg-red-50 p-4 rounded-lg border border-red-100 flex justify-between items-center">
                            <div>
                                <span class="block text-xs font-bold text-red-700 uppercase">Avarias Críticas</span>
                                <span class="text-[11px] text-red-600 font-medium">Risco Operacional / Oficina</span>
                            </div>
                            <span class="text-2xl font-black text-red-600">{{ $ruim }}</span>
                        </div>
                    </div>

                </div>
            @else
                <!-- Estado Vazio -->
                <div class="bg-white p-12 rounded-lg shadow-sm border border-gray-100 text-center">
                    <span class="text-4xl block mb-2">📊</span>
                    <p class="text-gray-600 font-bold">Nenhum dado estatístico coletado para o escopo selecionado.</p>
                    <p class="text-gray-400 text-sm">Realize as vistorias semanais para alimentar a central de dados gráficos.</p>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
