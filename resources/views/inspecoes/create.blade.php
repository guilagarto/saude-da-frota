<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Nova Ficha > Manutenção Preventiva (40.000 KM)') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <!-- Formulário Principal de Cadastro -->
                <form action="{{ route('inspecoes.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    <!-- Dados Gerais Iniciais (KM, Veículo, Data) -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 border-b border-gray-100 pb-4">
                        <div>
                            <label for="veiculo_id" class="block text-sm font-medium text-gray-700 font-bold">Selecione o Veículo *</label>
                            <select name="veiculo_id" id="veiculo_id" required class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm font-semibold">
                                <option value="">Selecione um carro...</option>
                                @foreach($veiculos as $veiculo)
                                    <option value="{{ $veiculo->id }}">
                                        {{ $veiculo->placa }} - {{ $veiculo->modelo }} / {{ $veiculo->marca }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="data_inspecao" class="block text-sm font-medium text-gray-700 font-bold">Data da Inspeção *</label>
                            <input type="date" name="data_inspecao" id="data_inspecao" required value="{{ date('Y-m-d') }}" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm">
                        </div>
                        <div>
                            <label for="horario_inspecao" class="block text-sm font-medium text-gray-700 font-bold">Horário de Início</label>
                            <input type="time" name="horario_inspecao" id="horario_inspecao" value="{{ date('H:i') }}" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm">
                        </div>
                    </div>

                    <!-- Abas de Navegação Comercial Dinâmicas -->
                    <div class="flex flex-wrap border-b border-gray-200 gap-2" id="tabsHeaders">
                        <button type="button" onclick="switchTab('eletrica')" id="btn-eletrica" class="border-b-2 border-blue-500 py-2 px-4 text-blue-600 font-bold text-sm tab-nav transition-all">
                            ⚡ 1. Elétrica
                        </button>
                        <button type="button" onclick="switchTab('mecanica')" id="btn-mecanica" class="py-2 px-4 text-gray-500 hover:text-blue-600 font-bold text-sm tab-nav transition-all">
                            ⚙️ 2. Mecânica e Agregados
                        </button>
                        <button type="button" onclick="switchTab('lanternagem')" id="btn-lanternagem" class="py-2 px-4 text-gray-500 hover:text-blue-600 font-bold text-sm tab-nav transition-all">
                            🎨 3. Lanternagem & Carroceria
                        </button>
                    </div>

                    <!-- CONTAINER DOS CAMPOS DAS ABAS -->
                    <div class="mt-6">
                        
                        <!-- ================= ⚡ ABA 1: ELÉTRICA ================= -->
                        <div id="tab-eletrica" class="tab-content grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @php
                                $camposEletricos = [
                                    'farois_alto_baixo' => 'Faróis Alto e Baixo, Faroletes e Indicadores de Direção',
                                    'faroletes' => 'Vigias Dianteiros e Laterais',
                                    'indicadores_direcao' => 'Luz de Freio, Luz de Ré e Sinal Sonoro de Ré',
                                    'lanternas_vigias_traseiros' => 'Lanternas e Vigias Traseiros',
                                    'luz_cabine' => 'Luzes de Cabine',
                                    'luzes_painel_instrumentos' => 'Luzes de Painel e Instrumentos',
                                    'buzina' => 'Buzina, Itinerário e Retrovisores Internos/Externos',
                                    'limpador_para_brisas' => 'Limpador de Para-brisa, Água Esguicho',
                                    'quebra_sol' => 'Quebra-Sol',
                                    'alavanca_marcha' => 'Alavanca Marcha: Manopla e Coifa',
                                    'extintor_incendio' => 'Extintor de Incêndio, Documentos',
                                    'poltrona_motorista' => 'Poltrona Motorista e Situação do Volante',
                                    'baterias' => 'Baterias, Alternador e Motor de Arranque',
                                    'cabeamento' => 'Cabeamento Elétrico e Conexões Gerais'
                                ];
                            @endphp

                            @foreach($camposEletricos as $campo => $label)
                                <div class="bg-gray-50 p-3 rounded-lg border border-gray-200 flex flex-col justify-between shadow-sm">
                                    <label for="{{ $campo }}" class="block text-xs font-bold text-gray-700 uppercase tracking-wide mb-2">{{ $label }}</label>
                                    <select name="{{ $campo }}" id="{{ $campo }}" class="block w-full border-gray-300 focus:ring-blue-500 focus:border-blue-500 rounded-md text-sm font-semibold">
                                        <option value="Bom">💚 Bom ( OK )</option>
                                        <option value="Regular">💛 Regular</option>
                                        <option value="Ruim">❤️ Ruim (Defeito)</option>
                                        <option value="N/A">⚪ N/A</option>
                                    </select>
                                </div>
                            @endforeach
                        </div>
                        <!-- ================= ⚙️ ABA 2: MECÂNICA ================= -->
                        <div id="tab-mecanica" class="tab-content hidden space-y-6">
                            @php
                                $mecanicaMotor = [
                                    'mot_oleo_filtro' => 'Óleo motor e filtro lubrificante: trocar',
                                    'mot_filtro_combustivel' => 'Filtro combustível (principal e separador): trocar elementos filtrantes',
                                    'mot_correias' => 'Correias do motor: verificar estado e tensão',
                                    'mot_fixacao_coxins' => 'Fixação motor: verificar fixação dos coxins',
                                    'mot_turbocompressor' => 'Turbocompressor: verificar folga do eixo e estado da carcaça',
                                    'mot_tubulacao_admissao' => 'Tubulação de admissão entre o filtro de ar e o motor: verificar estado e fixação',
                                    'mot_compressor_ar' => 'Verificar compressor de ar e componentes do motor',
                                    'mot_mangueiras_canos' => 'Verificar situação das mangueiras e canos: óleo diesel e óleo lubrificante',
                                    'mot_sistema_arrefecimento' => 'Sistema de arrefecimento: verificar o nível e completar com mistura',
                                    'mot_mangueiras_abraca_radiador' => 'Verificar mangueiras e abraçadeiras do radiador e intercooler',
                                    'mot_sistema_escapamento' => 'Sistema escapamento: verificar estado e fixações',
                                    'mot_soprar_filtro_ar' => 'Soprar filtro de ar: verificar data e situação filtro',
                                    'mot_higienizador_ar' => 'Higienizador de ar condicionado',
                                    'mot_conexao_sensores' => 'Verificar conexão de sensores e atuadores',
                                    'mot_folga_bomba_agua' => 'Conferir folga bomba d\'água',
                                    'mot_rolamento_tensor_embreagem' => 'Retirar correias: analisar rolamento, tensor e embreagem viscosa'
                                ];

                                $mecanicaRodas = [
                                    'pne_vazamento_valvulas' => 'Cubos de Roda / Pneus: Verificar possíveis vazamentos nas válvulas e conexões',
                                    'pne_bracos_barras_direcao' => 'Braços e barras de ligação e de direção: verificar fixações e estado dos terminais',
                                    'pne_rolamentos_cubos' => 'Rolamentos dos cubos das rodas dianteiras e traseiras: verificar estado',
                                    'pne_porcas_travas_cubo' => 'Porcas e travas cubo, Retentores dianteiros e traseiros: conferir e verificar',
                                    'pne_frisos_desgaste_calibragem' => 'Pneus: verificar altura dos frisos e desgaste desigual, calibrar e aperto roda',
                                    'pne_suporte_radiador_arla' => 'Suporte radiador e arla: inspecionar',
                                    'pne_tanque_combustivel_respiro' => 'Tanque combustível: verificar respiro e analisar aperto da cinta'
                                ];
                            @endphp

                            <div class="space-y-6">
                                <!-- Motor -->
                                <div>
                                    <h4 class="font-extrabold text-blue-700 bg-blue-50 px-3 py-1.5 rounded text-xs uppercase tracking-wider mb-3">📦 2.1 Motor e Componentes Internos</h4>
                                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                        @foreach($mecanicaMotor as $campo => $label)
                                            <div class="bg-gray-50 p-3 rounded-lg border border-gray-200 flex flex-col justify-between shadow-sm">
                                                <label class="block text-xs font-bold text-gray-600 uppercase mb-2">{{ $label }}</label>
                                                <select name="{{ $campo }}" class="block w-full border-gray-300 rounded-md text-sm font-semibold">
                                                    <option value="Bom">💚 Bom</option>
                                                    <option value="Regular">💛 Regular</option>
                                                    <option value="Ruim">❤️ Ruim</option>
                                                </select>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                <!-- Rodas e Pneus -->
                                <div class="pt-2">
                                    <h4 class="font-extrabold text-amber-700 bg-amber-50 px-3 py-1.5 rounded text-xs uppercase tracking-wider mb-3">🛞 2.2 Cubos de Roda, Eixo Dianteiro e Pneus</h4>
                                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                        @foreach($mecanicaRodas as $campo => $label)
                                            <div class="bg-gray-50 p-3 rounded-lg border border-gray-200 flex flex-col justify-between shadow-sm">
                                                <label class="block text-xs font-bold text-gray-600 uppercase mb-2">{{ $label }}</label>
                                                <select name="{{ $campo }}" class="block w-full border-gray-300 rounded-md text-sm font-semibold">
                                                    <option value="Bom">💚 Bom</option>
                                                    <option value="Regular">💛 Regular</option>
                                                    <option value="Ruim">❤️ Ruim</option>
                                                </select>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                <!-- Freios, Suspensão e Caixa -->
                                @php
                                    $mecanicaFreios = [
                                        'fre_reservatorio_ar_drenar' => 'Reservatório de ar dos freios: drenar',
                                        'fre_erguer_pneus_regular_freio' => 'Erguer pneus dianteiros e regular freio',
                                        'fre_cuica_haste_vazamento' => 'Verificar cuíca; haste e possível vazamento',
                                        'fre_buchas_eixo_s' => 'Verificar buchas eixo "S"',
                                        'fre_lonas_desgaste' => 'Lonas de freio: verificar desgaste',
                                        'fre_pedais_embreagem_acelerador' => 'Conferir pedais freio, embreagem e acelerador',
                                        'fre_vazamentos_ar_oleo_embreagem' => 'Verificar possíveis vazamentos ar/óleo: embreagem',
                                        'fre_eixos_s_ajustadores_lubrificar' => 'Eixos "S" e ajustadores: lubrificar',
                                        'fre_flexiveis_conduites' => 'Verificar flexíveis freio e conduítes',
                                        'fre_catraca_pinos' => 'Verificar catraca e pinos da catraca',
                                        'fre_jumelos_lubrificar_aperto' => 'Jumelos: lubrificar e conferir aperto',
                                        'fre_jumelos_pinos_desgastes' => 'Jumelos: verificar pinos e desgastes',
                                        'fre_compressor_ar_conexoes' => 'Compressor de ar: verificar conexões e fixações',
                                        'fre_freio_motor' => 'Freio motor: verificar fixação e acionamento',
                                        'fre_grampos_u_feixes_molas' => 'Grampos "U" dos feixes de molas: reapertar',
                                        'fre_barra_estabilizadora_buchas_bieletas' => 'Barra stabilizadora, buchas fixas, buchas móveis e bieletas: verificar folga',
                                        'fre_amortecedores_buchas_vazamento' => 'Amortecedores e buchas: verificar vazamento',
                                        'fre_suporte_molas_jumelos_olhais' => 'Suporte de molas, jumelos, olhais: reapertar',
                                        'fre_suporte_motor_coxim_caixa' => 'Suporte motor e coxim caixa: inspecionar'
                                    ];

                                    $mecanicaDirecao = [
                                        'tra_direcao_hidraulica_cruzetas' => 'Direção hidráulica: lubrificar cruzetas, verificar vazamentos e estado de mangueiras',
                                        'tra_junta_universal_coluna' => 'Junta universal da coluna de direção: lubrificar e verificar folga',
                                        'tra_direcao_hidraulica_nivel' => 'Direção hidráulica: verificar nível de fluido',
                                        'tra_caixa_direcao_torque_vazamentos' => 'Caixa direção hidráulica: verificar torque de fixação e vazamentos',
                                        'tra_embreagem_nivel_fluido' => 'Embreagem: verificar nível de fluido',
                                        'tra_embreagem_buchas_eixo_garfo' => 'Embreagem: lubrificar buchas do eixo do garfo de acionamento',
                                        'tra_servo_embreagem_vazamento' => 'Servo de embreagem: acionar pedal para verificar vazamento óleo/ar',
                                        'tra_caixa_mudancas_oleo_respiro' => 'Caixa de mudanças: verificar nível de óleo e limpar respiro',
                                        'tra_arvore_transmissao_cruzetas_cardam' => 'Árvore de transmissão: verificar e lubrificar cruzetas e rolamento cardam',
                                        'tra_rolamento_cardam_diferencial_ruido' => 'Rolamento cardam e diferencial: identificar ruído',
                                        'tra_suporte_cardam_saida_caixa' => 'Suporte cardam e saída caixa: verificar fixação parafusos',
                                        'tra_diferencial_oleo_respiro' => 'Diferencial: verificar nível de óleo e limpar respiro'
                                    ];
                                @endphp

                                <div class="pt-2">
                                    <h4 class="font-extrabold text-red-700 bg-red-50 px-3 py-1.5 rounded text-xs uppercase tracking-wider mb-3">🛑 2.3 Freios, Amortecedores e Suspensão</h4>
                                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                        @foreach($mecanicaFreios as $campo => $label)
                                            <div class="bg-gray-50 p-3 rounded-lg border border-gray-200 flex flex-col justify-between shadow-sm">
                                                <label class="block text-xs font-bold text-gray-600 uppercase mb-2">{{ $label }}</label>
                                                <select name="{{ $campo }}" class="block w-full border-gray-300 rounded-md text-sm font-semibold">
                                                    <option value="Bom">💚 Bom</option>
                                                    <option value="Regular">💛 Regular</option>
                                                    <option value="Ruim">❤️ Ruim</option>
                                                </select>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                <div class="pt-2">
                                    <h4 class="font-extrabold text-teal-700 bg-teal-50 px-3 py-1.5 rounded text-xs uppercase tracking-wider mb-3">⚙️ 2.4 Direção, Embreagem, Caixa, Transmissão e Diferencial</h4>
                                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                        @foreach($mecanicaDirecao as $campo => $label)
                                            <div class="bg-gray-50 p-3 rounded-lg border border-gray-200 flex flex-col justify-between shadow-sm">
                                                <label class="block text-xs font-bold text-gray-600 uppercase mb-2">{{ $label }}</label>
                                                <select name="{{ $campo }}" class="block w-full border-gray-300 rounded-md text-sm font-semibold">
                                                    <option value="Bom">💚 Bom</option>
                                                    <option value="Regular">💛 Regular</option>
                                                    <option value="Ruim">❤️ Ruim</option>
                                                </select>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- ================= 🎨 ABA 3: LANTERNAGEM ================= -->
                        <div id="tab-lanternagem" class="tab-content hidden grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @php
                                $carroceriaCampos = [
                                    'car_saida_emergencia_puxador_cortinas' => 'Capas saída emergência e puxador de vidro, corda, passador e cortinas',
                                    'car_cinto_seguranca_apoio_bancos' => 'Cinto de segurança, apoio de braço e situação dos bancos',
                                    'car_canaletas_trava_janelas_assoalho' => 'Canaletas dos vidros, trava das janelas, forro lateral e assoalho',
                                    'car_porta_acesso_fechaduras_corrimaos' => 'Porta de acesso, fechaduras, trincos e corrimãos',
                                    'car_fixacao_bagageiros_alcapao' => 'Fixação dos bagageiros internos e alçapão teto',
                                    'car_faixas_refletivas_vidro_traseiro' => 'Faixas refletivas, vidro traseiro e para-brisas',
                                    'car_estepe_triangulo_lataria_frisos' => 'Estepe, triângulo, lataria, retrovisores externos e frisos'
                                ];
                            @endphp

                            @foreach($carroceriaCampos as $campo => $label)
                                <div class="bg-gray-50 p-3 rounded-lg border border-gray-200 flex flex-col justify-between shadow-sm">
                                    <label class="block text-xs font-bold text-gray-600 uppercase mb-2">{{ $label }}</label>
                                    <select name="{{ $campo }}" class="block w-full border-gray-300 rounded-md text-sm font-semibold">
                                        <option value="Bom">💚 Bom</option>
                                        <option value="Regular">💛 Regular</option>
                                        <option value="Ruim">❤️ Ruim</option>
                                    </select>
                                </div>
                            @endforeach
                        </div>

                    </div>

                    <!-- Rodapé de Controle: Arquivos e Observações -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 pt-6 border-t border-gray-200">
                        <div class="md:col-span-2">
                            <label for="observacoes" class="block text-sm font-bold text-gray-700">Observações / Anotações Gerais da Oficina</label>
                            <textarea name="observacoes" id="observacoes" rows="3" placeholder="Insira dados de relatórios, vazamentos ou observações adicionais..." class="mt-1 block w-full border-gray-300 rounded-md shadow-sm text-sm"></textarea>
                        </div>
                        <div>
                            <label for="foto" class="block text-sm font-bold text-gray-700">Anexar Evidência Visual (Foto Opcional)</label>
                            <input type="file" name="foto" id="foto" accept="image/*" class="mt-1 block w-full text-xs text-gray-500 file:mr-4 file:py-1.5 file:px-3 file:rounded file:border-0 file:text-xs file:font-bold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                        </div>
                    </div>

                    <!-- 📋 PARECER FINAL DE LIBERAÇÃO DA OFICINA -->
                    <div class="bg-slate-50 p-4 rounded-lg border border-slate-200 mt-4">
                        <span class="block text-sm font-bold text-slate-800 uppercase tracking-wide mb-3">📋 Resultado da Inspeção Técnica</span>
                        <div class="flex flex-wrap gap-6">
                            <label class="flex items-center gap-2 font-bold text-sm text-green-700 cursor-pointer">
                                <input type="radio" name="resultado_inspecao" value="Liberado" checked class="text-green-600 focus:ring-green-500"> Liberado ( OK )
                            </label>
                            <label class="flex items-center gap-2 font-bold text-sm text-amber-700 cursor-pointer">
                                <input type="radio" name="resultado_inspecao" value="Liberado c/ Retorno" class="text-amber-600 focus:ring-amber-500"> Liberado c/ Retorno
                            </label>
                            <label class="flex items-center gap-2 font-bold text-sm text-red-700 cursor-pointer">
                                <input type="radio" name="resultado_inspecao" value="Não Liberado" class="text-red-600 focus:ring-red-500"> Não Liberado ( Oficina )
                            </label>
                        </div>
                    </div>

                    <!-- Botões de Ação -->
                    <div class="flex justify-end gap-4 pt-4 border-t border-gray-100">
                        <a href="{{ route('inspecoes.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold py-2 px-5 rounded text-sm uppercase tracking-wider transition-colors">
                            Cancelar
                        </a>
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded text-sm uppercase tracking-wider shadow transition-colors">
                            Salvar Ficha
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>

    <!-- Script Inline VanillaJS para alternar abas -->
    <script>
        function switchTab(tabName) {
            document.querySelectorAll('.tab-content').forEach(el => el.classList.add('hidden'));
            document.querySelectorAll('.tab-nav').forEach(btn => {
                btn.classList.remove('border-b-2', 'border-blue-500', 'text-blue-600');
                btn.classList.add('text-gray-500');
            });
            document.getElementById('tab-' + tabName).classList.remove('hidden');
            const activeBtn = document.getElementById('btn-' + tabName);
            activeBtn.classList.add('border-b-2', 'border-blue-500', 'text-blue-600');
            activeBtn.classList.remove('text-gray-500');
        }
    </script>
</x-app-layout>
