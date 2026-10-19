<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ficha de Inspeção - {{ $inspecao->veiculo->placa }}</title>
    
    <!-- Importando o Tailwind CSS para estilização rápida -->
    <script src="https://tailwindcss.com"></script>
    
    <style>
        @media print {
            body { background-color: #fff; color: #000; padding: 0; }
            .no-print { display: none !important; }
            .page-break { page-break-before: always; }
            .print-border { border: 1px solid #cbd5e1 !important; }
        }
    </style>
</head>
<body class="bg-gray-100 font-sans antialiased p-4 sm:p-6">

    <!-- Barra de Controle Superior (Ocultada dinamicamente ao imprimir) -->
    <div class="no-print max-w-5xl mx-auto mb-6 bg-white p-4 rounded-lg shadow flex justify-between items-center">
        <a href="{{ route('inspecoes.index') }}" class="text-blue-600 hover:text-blue-800 font-semibold flex items-center gap-1">
            ← Voltar para Listagem
        </a>
        <button onclick="window.print()" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-5 rounded shadow transition-colors">
            🖨️ Imprimir Ficha / Salvar PDF
        </button>
    </div>

    <!-- Corpo da Ficha de Inspeção (Simula tamanho de folha A4) -->
    <div class="max-w-5xl mx-auto bg-white p-6 sm:p-8 rounded-lg shadow-sm border border-gray-200 print-border">
        
        <!-- Cabeçalho Principal -->
        <div class="flex justify-between items-center border-b-2 border-gray-300 pb-4 mb-6">
            <div>
                <h1 class="text-2xl font-bold uppercase tracking-wide text-gray-800">Ficha de Inspeção Veicular</h1>
                <p class="text-xs text-gray-500 uppercase font-semibold tracking-wider">Manutenção Preventiva (40.000 KM)</p>
            </div>
            <div class="text-right">
                <p class="text-xs font-bold uppercase text-gray-400">Data e Horário</p>
                <p class="text-base font-black text-blue-600">
                    {{ \Carbon\Carbon::parse($inspecao->data_inspecao)->format('d/m/Y') }} 
                    @if(!empty($inspecao->horario_inspecao)) às {{ $inspecao->horario_inspecao }} @endif
                </p>
            </div>
        </div>

        <!-- Bloco de Dados do Veículo -->
        <div class="mb-6">
            <h2 class="text-xs font-bold uppercase tracking-wider text-gray-400 mb-2">Dados do Veículo Inspecionado</h2>
            <div class="grid grid-cols-3 gap-4 bg-gray-50 p-3 rounded-lg border border-gray-100">
                <div>
                    <span class="block text-[10px] uppercase text-gray-400 font-bold">Placa</span>
                    <span class="font-mono font-bold text-gray-800 text-base uppercase">{{ $inspecao->veiculo->placa }}</span>
                </div>
                <div>
                    <span class="block text-[10px] uppercase text-gray-400 font-bold">Modelo / Marca</span>
                    <span class="font-semibold text-gray-700 text-sm">{{ $inspecao->veiculo->modelo }} / {{ $inspecao->veiculo->marca }}</span>
                </div>
                <div>
                    <span class="block text-[10px] uppercase text-gray-400 font-bold">Ano</span>
                    <span class="font-semibold text-gray-700 text-sm">{{ $inspecao->veiculo->ano }}</span>
                </div>
            </div>
        </div>

        <!-- MACRO MACROS E HELPER PARA RENDERIZAR OS STATUS -->
        @php
            function renderStatus($valor) {
                if ($valor == 'Bom') return '<span class="text-green-600 font-bold">✓ Bom</span>';
                if ($valor == 'Regular') return '<span class="text-amber-600 font-bold">⚠ Reg</span>';
                if ($valor == 'Ruim') return '<span class="text-red-600 font-bold">🗙 Ruim</span>';
                return '<span class="text-gray-400">- N/A</span>';
            }
        @endphp

        <!-- ================= ⚡ SEÇÃO 1: ELÉTRICA ================= -->
        <div class="mb-6">
            <h3 class="font-extrabold text-blue-800 bg-blue-50 px-3 py-1 rounded text-xs uppercase tracking-wider mb-2">⚡ 1. Componentes Elétricos</h3>
            @php
                $camposEletricos = [
                    'farois_alto_baixo' => 'Faróis Alto e Baixo, Faroletes e Setas',
                    'faroletes' => 'Vigias Dianteiros e Laterais',
                    'indicadores_direcao' => 'Luzes de Freio, Ré e Sinal Sonoro',
                    'lanternas_vigias_traseiros' => 'Lanternas e Vigias Traseiros',
                    'luz_cabine' => 'Luzes de Cabine',
                    'luzes_painel_instrumentos' => 'Luzes de Painel e Instrumentos',
                    'buzina' => 'Buzina, Itinerário e Retrovisores',
                    'limpador_para_brisas' => 'Limpador de Para-brisa e Esguicho',
                    'quebra_sol' => 'Quebra-Sol',
                    'alavanca_marcha' => 'Alavanca Marcha (Manopla/Coifa)',
                    'extintor_incendio' => 'Extintor de Incêndio e Documentos',
                    'poltrona_motorista' => 'Poltrona Motorista e Volante',
                    'baterias' => 'Baterias, Alternador e Arranque',
                    'cabeamento' => 'Cabeamento Elétrico e Conexões'
                ];
            @endphp
            <div class="grid grid-cols-2 gap-x-6 text-[11px] border border-gray-200 rounded-lg p-3 bg-white">
                @foreach($camposEletricos as $campo => $label)
                    <div class="flex justify-between items-center py-1 border-b border-gray-100 last:border-0">
                        <span class="text-gray-700">{{ $label }}</span>
                        <span>{!! renderStatus($inspecao->$campo ?? 'Bom') !!}</span>
                    </div>
                @endforeach
            </div>
        </div>
        <!-- ================= ⚙️ SEÇÃO 2: MECÂNICA ================= -->
        <div class="mb-6">
            <h3 class="font-extrabold text-slate-800 bg-slate-100 px-3 py-1 rounded text-xs uppercase tracking-wider mb-2">⚙️ 2. Mecânica e Agregados</h3>
            
            <!-- 2.1 Motor -->
            <div class="mb-4">
                <h4 class="font-bold text-blue-700 text-[11px] uppercase tracking-wide mb-1">📦 2.1 Motor e Componentes Internos</h4>
                @php
                    $mecanicaMotor = [
                        'mot_oleo_filtro' => 'Óleo motor e filtro lubrificante',
                        'mot_filtro_combustivel' => 'Filtro combustível (principal/separador)',
                        'mot_correias' => 'Correias do motor: estado e tensão',
                        'mot_fixacao_coxins' => 'Fixação motor: coxins',
                        'mot_turbocompressor' => 'Turbocompressor: folga do eixo e carcaça',
                        'mot_tubulacao_admissao' => 'Tubulação de admissão entre filtro e motor',
                        'mot_compressor_ar' => 'Compressor de ar e agregados do motor',
                        'mot_mangueiras_canos' => 'Situação de mangueiras/canos (diesel/óleo)',
                        'mot_sistema_arrefecimento' => 'Sistema de arrefecimento e mistura de água',
                        'mot_mangueiras_abraca_radiador' => 'Mangueiras/braçadeiras do radiador/intercooler',
                        'mot_sistema_escapamento' => 'Sistema escapamento: estado e fixações',
                        'mot_soprar_filtro_ar' => 'Soprar filtro de ar: data e situação',
                        'mot_higienizador_ar' => 'Higienizador de ar condicionado',
                        'mot_conexao_sensores' => 'Conexão de sensores e atuadores',
                        'mot_folga_bomba_agua' => 'Folga da bomba d\'água',
                        'mot_rolamento_tensor_embreagem' => 'Análise de rolamento, tensor e viscosa'
                    ];
                @endphp
                <div class="grid grid-cols-2 gap-x-6 text-[11px] border border-gray-200 rounded-lg p-3 bg-white">
                    @foreach($mecanicaMotor as $campo => $label)
                        <div class="flex justify-between items-center py-0.5 border-b border-gray-100 last:border-0">
                            <span class="text-gray-700">{{ $label }}</span>
                            <span>{!! renderStatus($inspecao->$campo ?? 'Bom') !!}</span>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- 2.2 Cubos e Rodas -->
            <div class="mb-4">
                <h4 class="font-bold text-amber-700 text-[11px] uppercase tracking-wide mb-1">🛞 2.2 Cubos de Roda, Eixo Dianteiro e Pneus</h4>
                @php
                    $mecanicaRodas = [
                        'pne_vazamento_valvulas' => 'Vazamentos nas válvulas e conexões',
                        'pne_bracos_barras_direcao' => 'Braços/barras de direção e terminais',
                        'pne_rolamentos_cubos' => 'Rolamentos dos cubos dianteiros/traseiros',
                        'pne_porcas_travas_cubo' => 'Porcas, travas cubo e retentores',
                        'pne_frisos_desgaste_calibragem' => 'Pneus: altura dos frisos, calibrar e aperto',
                        'pne_suporte_radiador_arla' => 'Suporte radiador e arla',
                        'pne_tanque_combustivel_respiro' => 'Tanque combustível: respiro e cinta'
                    ];
                @endphp
                <div class="grid grid-cols-2 gap-x-6 text-[11px] border border-gray-200 rounded-lg p-3 bg-white">
                    @foreach($mecanicaRodas as $campo => $label)
                        <div class="flex justify-between items-center py-0.5 border-b border-gray-100 last:border-0">
                            <span class="text-gray-700">{{ $label }}</span>
                            <span>{!! renderStatus($inspecao->$campo ?? 'Bom') !!}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
            <!-- 2.3 Freios e Suspensão (Gera quebra de página automática se necessário) -->
            <div class="mb-4 page-break">
                <h4 class="font-bold text-red-700 text-[11px] uppercase tracking-wide mb-1">🛑 2.3 Freios, Amortecedores e Suspensão</h4>
                @php
                    $mecanicaFreios = [
                        'fre_reservatorio_ar_drenar' => 'Reservatório de ar dos freios: drenar',
                        'fre_erguer_pneus_regular_freio' => 'Erguer pneus dianteiros e regular freio',
                        'fre_cuica_haste_vazamento' => 'Cuíca: haste e possíveis vazamentos',
                        'fre_buchas_eixo_s' => 'Buchas do eixo "S"',
                        'fre_lonas_desgaste' => 'Lonas de freio: verificar desgaste',
                        'fre_pedais_embreagem_acelerador' => 'Pedais de freio, embreagem e acelerador',
                        'fre_vazamentos_ar_oleo_embreagem' => 'Vazamentos de ar/óleo na embreagem',
                        'fre_eixos_s_ajustadores_lubrificar' => 'Eixos "S" e ajustadores: lubrificar',
                        'fre_flexiveis_conduites' => 'Flexíveis de freio e conduítes',
                        'fre_catraca_pinos' => 'Catraca e pinos da catraca',
                        'fre_jumelos_lubrificar_aperto' => 'Jumelos: lubrificar e conferir aperto',
                        'fre_jumelos_pinos_desgastes' => 'Jumelos: pinos e desgastes',
                        'fre_compressor_ar_conexoes' => 'Compressor de ar: conexões e fixações',
                        'fre_freio_motor' => 'Freio motor: fixação e acionamento',
                        'fre_grampos_u_feixes_molas' => 'Grampos "U" dos feixes de molas: reapertar',
                        'fre_barra_estabilizadora_buchas_bieletas' => 'Barra estabilizadora, buchas e bieletas',
                        'fre_amortecedores_buchas_vazamento' => 'Amortecedores e buchas: vazamentos',
                        'fre_suporte_molas_jumelos_olhais' => 'Suporte de molas, jumelos e olhais',
                        'fre_suporte_motor_coxim_caixa' => 'Suporte motor e coxim da caixa'
                    ];
                @endphp
                <div class="grid grid-cols-2 gap-x-6 text-[11px] border border-gray-200 rounded-lg p-3 bg-white">
                    @foreach($mecanicaFreios as $campo => $label)
                        <div class="flex justify-between items-center py-0.5 border-b border-gray-100 last:border-0">
                            <span class="text-gray-700">{{ $label }}</span>
                            <span>{!! renderStatus($inspecao->$campo ?? 'Bom') !!}</span>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- 2.4 Direção e Transmissão -->
            <div class="mb-4">
                <h4 class="font-bold text-teal-700 text-[11px] uppercase tracking-wide mb-1">⚙️ 2.4 Direção, Embreagem, Caixa e Transmissão</h4>
                @php
                    $mecanicaDirecao = [
                        'tra_direcao_hidraulica_cruzetas' => 'Direção hidráulica: cruzetas e mangueiras',
                        'tra_junta_universal_coluna' => 'Junta universal da coluna de direção: folga',
                        'tra_direcao_hidraulica_nivel' => 'Direção hidráulica: nível de fluido',
                        'tra_caixa_direcao_torque_vazamentos' => 'Caixa de direção: torque e vazamentos',
                        'tra_embreagem_nivel_fluido' => 'Embreagem: nível de fluido',
                        'tra_embreagem_buchas_eixo_garfo' => 'Embreagem: lubrificar buchas do eixo do garfo',
                        'tra_servo_embreagem_vazamento' => 'Servo de embreagem: vazamento de óleo/ar',
                        'tra_caixa_mudancas_oleo_respiro' => 'Caixa de mudanças: nível de óleo e respiro',
                        'tra_arvore_transmissao_cruzetas_cardam' => 'Árvore de transmissão: cruzetas e cardam',
                        'tra_rolamento_cardam_diferencial_ruido' => 'Rolamento do cardam e diferencial: ruídos',
                        'tra_suporte_cardam_saida_caixa' => 'Suporte do cardam e saída da caixa',
                        'tra_diferencial_oleo_respiro' => 'Diferencial: nível de óleo e respiro'
                    ];
                @endphp
                <div class="grid grid-cols-2 gap-x-6 text-[11px] border border-gray-200 rounded-lg p-3 bg-white">
                    @foreach($mecanicaDirecao as $campo => $label)
                        <div class="flex justify-between items-center py-0.5 border-b border-gray-100 last:border-0">
                            <span class="text-gray-700">{{ $label }}</span>
                            <span>{!! renderStatus($inspecao->$campo ?? 'Bom') !!}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        <!-- ================= 🎨 SEÇÃO 3: LANTERNAGEM ================= -->
        <div class="mb-6">
            <h3 class="font-extrabold text-amber-800 bg-amber-50 px-3 py-1 rounded text-xs uppercase tracking-wider mb-2">🎨 3. Lanternagem & Carroceria</h3>
            @php
                $carroceriaCampos = [
                    'car_saida_emergencia_puxador_cortinas' => 'Capas de emergência, puxadores, cordas e cortinas',
                    'car_cinto_seguranca_apoio_bancos' => 'Cintos de segurança, apoios de braço e bancos',
                    'car_canaletas_trava_janelas_assoalho' => 'Canaletas, travas de janelas, forro e assoalho',
                    'car_porta_acesso_fechaduras_corrimaos' => 'Porta de acesso, fechaduras, trincos e corrimãos',
                    'car_fixacao_bagageiros_alcapao' => 'Fixação de bagageiros internos e alçapão do teto',
                    'car_faixas_refletivas_vidro_traseiro' => 'Faixas refletivas, vidro traseiro e para-brisas',
                    'car_estepe_triangulo_lataria_frisos' => 'Estepe, triângulo, lataria, retrovisores e frisos'
                ];
            @endphp
            <div class="grid grid-cols-2 gap-x-6 text-[11px] border border-gray-200 rounded-lg p-3 bg-white">
                @foreach($carroceriaCampos as $campo => $label)
                    <div class="flex justify-between items-center py-1 border-b border-gray-100 last:border-0">
                        <span class="text-gray-700">{{ $label }}</span>
                        <span>{!! renderStatus($inspecao->$campo ?? 'Bom') !!}</span>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Parecer Final -->
        <div class="mb-6 bg-slate-50 p-3 rounded-lg border border-slate-200 flex justify-between items-center text-xs">
            <div>
                <span class="font-bold uppercase text-slate-500 block text-[10px]">Resultado da Inspeção</span>
                <span class="font-black text-sm uppercase tracking-wider text-slate-800">
                    @if(($inspecao->resultado_inspecao ?? 'Liberado') == 'Liberado')
                        🟢 Liberado ( OK )
                    @elseif($inspecao->resultado_inspecao == 'Liberado c/ Retorno')
                        🟡 Liberado c/ Retorno
                    @else
                        🔴 Não Liberado ( Oficina )
                    @endif
                </span>
            </div>
        </div>

        <!-- Observações -->
        <div class="mb-6">
            <h2 class="text-[10px] font-bold uppercase tracking-wider text-gray-400 mb-1">Observações / Anotações Gerais</h2>
            <div class="border border-gray-200 p-3 rounded-lg min-h-[50px] text-xs text-gray-700 bg-gray-50">
                {{ $inspecao->observacoes ?? 'Nenhuma observação ou avaria registrada para esta ficha.' }}
            </div>
        </div>

        <!-- Foto se Houver -->
        @if(!empty($inspecao->foto_path))
            <div class="mb-6 page-break text-center">
                <h2 class="text-left text-[10px] font-bold uppercase tracking-wider text-gray-400 mb-2">Anexo Visual da Inspeção</h2>
                <img src="{{ asset('storage/' . $inspecao->foto_path) }}" class="max-h-[220px] mx-auto rounded border shadow-sm">
            </div>
        @endif

        <!-- Assinaturas Físicas -->
        <div class="mt-8 pt-4 border-t border-gray-200 grid grid-cols-2 gap-8 text-center text-[11px]">
            <div>
                <div class="border-b border-gray-400 mx-auto w-4/5 h-6"></div>
                <p class="text-[9px] uppercase text-gray-400 font-bold mt-1">Mecânico / Inspetor Responsável</p>
            </div>
            <div>
                <div class="border-b border-gray-400 mx-auto w-4/5 h-6"></div>
                <p class="text-[9px] uppercase text-gray-400 font-bold mt-1">Condutor / Recebedor do Veículo</p>
            </div>
        </div>

    </div>

</body>
</html>
