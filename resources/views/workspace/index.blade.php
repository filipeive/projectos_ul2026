<!DOCTYPE html>
<html lang="pt-PT" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Workspace | {{ $candidatura->project_name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ asset('style.css') }}">
    <script src="https://unpkg.com/lucide@latest"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        slate: { 950: '#070a13', 900: '#0b0f19', 800: '#121929', 750: '#182238', 700: '#1e293b' },
                        /* Azul oficial do logótipo Universidade Licungo */
                        sky: { 400: '#38bdf8', 500: '#0090d4', 600: '#0078ad' },
                        /* Castanho/bronze do anel e moldura do logótipo — substitui o amber genérico */
                        bronze: { 400: '#c08a4e', 500: '#9c6a30', 600: '#7d5424' },
                        /* Mantemos amber como alias para não partir nada que já dependa dele */
                        amber: { 500: '#9c6a30' }
                    },
                    fontFamily: {
                        display: ['Inter', 'ui-sans-serif', 'system-ui'],
                    }
                }
            }
        }
    </script>
    <style>
        .animate-fade-in {
            animation: fadeIn 0.3s ease-out forwards;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(5px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-pop {
            animation: pop 0.25s ease-out;
        }

        @keyframes pop {
            0% {
                transform: scale(0.9);
                opacity: 0;
            }

            100% {
                transform: scale(1);
                opacity: 1;
            }
        }

        /* Indicador "a escrever..." mudo — pronto para ligar a websockets/polling depois */
        .typing-dot {
            animation: typingBlink 1.2s infinite;
        }

        .typing-dot:nth-child(2) {
            animation-delay: 0.2s;
        }

        .typing-dot:nth-child(3) {
            animation-delay: 0.4s;
        }

        @keyframes typingBlink {

            0%,
            80%,
            100% {
                opacity: 0.25;
            }

            40% {
                opacity: 1;
            }
        }

        /* Badge de notificação numérico nas tabs */
        .notif-badge {
            position: absolute;
            top: 2px;
            right: 6px;
            min-width: 16px;
            height: 16px;
            font-size: 9px;
            font-weight: 800;
            line-height: 16px;
            text-align: center;
            border-radius: 999px;
            padding: 0 3px;
        }

        /* Mobile sub-tabs para sidebars colapsadas */
        .mobile-subtab.active {
            color: #38bdf8;
            border-color: #38bdf8;
        }

        /* Botões de IA "mudos" — desativados de propósito, prontos para ligação futura */
        .ai-stub-btn {
            position: relative;
        }

        .ai-stub-btn:disabled {
            cursor: not-allowed;
            opacity: 0.55;
        }

        .ai-stub-btn .ai-tooltip {
            position: absolute;
            bottom: calc(100% + 6px);
            left: 50%;
            transform: translateX(-50%);
            background: #0b0f19;
            border: 1px solid #182238;
            color: #94a3b8;
            font-size: 10px;
            padding: 4px 8px;
            border-radius: 6px;
            white-space: nowrap;
            opacity: 0;
            pointer-events: none;
            transition: opacity .15s ease;
            z-index: 20;
        }

        .ai-stub-btn:hover .ai-tooltip {
            opacity: 1;
        }
    </style>
</head>

<body
    class="min-h-screen bg-slate-950 text-slate-100 flex flex-col relative antialiased md:h-screen md:overflow-hidden">

    <div class="glow-blob-blue"></div>

    <!-- HEADER -->
    <header
        class="relative z-20 w-full px-4 md:px-6 py-3 md:py-4 border-b border-slate-900 bg-slate-950/80 backdrop-blur-md flex items-center justify-between gap-3">
        <div class="flex items-center gap-3 md:gap-4 min-w-0">
            <div
                class="w-10 h-10 bg-slate-900/60 p-1.5 rounded-xl border border-slate-800 flex items-center justify-center flex-shrink-0">
                <img src="{{ asset('projectos_ul/ul.png') }}" alt="Universidade Licungo"
                    class="w-full h-full object-contain"
                    onerror="this.style.display='none'; this.nextElementSibling.style.display='flex'">
                <i data-lucide="terminal" class="w-5 h-5 text-sky-400" style="display:none"></i>
            </div>
            <div class="min-w-0">
                <div class="flex items-center gap-2">
                    <h1 class="text-base md:text-lg font-bold text-white font-display truncate">
                        {{ $candidatura->project_name }}</h1>
                    <span
                        class="hidden sm:inline-flex text-[9px] uppercase font-bold tracking-wider text-bronze-400/90 bg-bronze-500/10 border border-bronze-500/30 px-1.5 py-0.5 rounded">Licungo
                        Hub</span>
                </div>
                <p class="text-[11px] text-slate-400 font-mono truncate">ID: #{{ $candidatura->id }} &middot; Status:
                    <span class="text-emerald-400">{{ $candidatura->status }}</span></p>
            </div>
        </div>

        <div class="flex items-center gap-2 md:gap-3 flex-shrink-0">
            @if($isStudent)
                <a href="{{ route('candidatura.pdf', $candidatura->id) }}" target="_blank"
                    class="px-2.5 md:px-3 py-1.5 bg-sky-500/10 border border-sky-500/30 hover:bg-sky-500/20 text-sky-400 rounded-lg text-xs font-bold flex items-center gap-1.5 transition-colors">
                    <i data-lucide="download" class="w-3.5 h-3.5"></i> <span class="hidden sm:inline">Baixar Comprovativo
                        PDF</span><span class="sm:hidden">PDF</span>
                </a>
            @endif
            @if($isAdmin)
                @if($isViewer)
                    <span
                        class="px-2.5 md:px-3 py-1.5 bg-rose-500/10 border border-rose-500/30 text-rose-400 rounded-lg text-xs font-bold flex items-center gap-1.5">
                        <i data-lucide="eye" class="w-3.5 h-3.5"></i> <span class="hidden sm:inline">Vista de Leitura</span>
                    </span>
                @else
                    <span
                        class="px-2.5 md:px-3 py-1.5 bg-bronze-500/10 border border-bronze-500/30 text-bronze-400 rounded-lg text-xs font-bold flex items-center gap-1.5">
                        <i data-lucide="shield-check" class="w-3.5 h-3.5"></i> <span class="hidden sm:inline">Vista de
                            Mentor</span>
                    </span>
                @endif
                <a href="{{ route('admin.dashboard') }}"
                    class="px-2.5 md:px-3 py-1.5 bg-slate-900 border border-slate-800 hover:border-slate-700 text-slate-300 rounded-lg text-xs font-semibold flex items-center transition-colors">Voltar</a>
            @else
                <a href="{{ route('portal.index') }}"
                    class="px-2.5 md:px-3 py-1.5 bg-slate-900 border border-slate-800 hover:border-slate-700 text-slate-300 rounded-lg text-xs font-semibold flex items-center transition-colors">Sair</a>
            @endif
        </div>
    </header>

    <!-- MOBILE SUBNAV: alterna entre os 3 blocos no telemóvel -->
    <nav class="md:hidden relative z-10 flex border-b border-slate-900 bg-slate-950/90 overflow-x-auto">
        <button onclick="switchMobilePanel('info')" id="mobile-tab-info"
            class="mobile-subtab active flex-1 min-w-[90px] py-2.5 text-[11px] font-bold uppercase tracking-wide text-slate-500 border-b-2 border-transparent transition-colors flex items-center justify-center gap-1">
            <i data-lucide="info" class="w-3.5 h-3.5"></i> Detalhes
        </button>
        <button onclick="switchMobilePanel('room')" id="mobile-tab-room"
            class="mobile-subtab flex-1 min-w-[90px] py-2.5 text-[11px] font-bold uppercase tracking-wide text-slate-500 border-b-2 border-transparent transition-colors flex items-center justify-center gap-1">
            <i data-lucide="message-square" class="w-3.5 h-3.5"></i> Sala
        </button>
        <button onclick="switchMobilePanel('files')" id="mobile-tab-files"
            class="mobile-subtab flex-1 min-w-[90px] py-2.5 text-[11px] font-bold uppercase tracking-wide text-slate-500 border-b-2 border-transparent transition-colors flex items-center justify-center gap-1">
            <i data-lucide="folder" class="w-3.5 h-3.5"></i> Ficheiros
        </button>
    </nav>

    <!-- MAIN -->
    <main
        class="relative z-10 flex-grow w-full mx-auto px-2 md:px-6 py-4 flex flex-col md:flex-row gap-4 md:gap-6 md:h-[calc(100vh-128px)] md:overflow-hidden">

        <!-- SIDEBAR LEFT: Info, IA & Timeline (25%) -->
        <aside id="panel-info"
            class="w-full md:w-[25%] lg:w-[20%] flex flex-col gap-4 md:gap-6 flex-shrink-0 md:overflow-y-auto md:pr-1 scrollbar-thin">

            <!-- Details -->
            <div class="glass-panel rounded-2xl border border-slate-800/80 p-5 flex-shrink-0">
                <h3 class="text-sm font-bold text-white mb-4 flex items-center gap-2 border-b border-slate-800 pb-2">
                    <i data-lucide="info" class="w-4 h-4 text-sky-400"></i> Detalhes do Projeto
                </h3>

                <div class="space-y-4">
                    <div>
                        <span class="text-[10px] uppercase font-bold text-slate-500 font-mono">Tecnologia</span>
                        <p class="text-sm text-sky-400 font-mono">{{ $candidatura->technology }}</p>
                    </div>
                    <div class="pt-4 border-t border-slate-800">
                        <span class="text-[10px] uppercase font-bold text-slate-500 font-mono mb-2 block">Membros do
                            Grupo</span>
                        <ul class="text-xs text-slate-300 space-y-1.5">
                            <li class="flex items-center justify-between gap-2"><span
                                    class="text-white truncate">{{ $candidatura->member1_name }}</span> <span
                                    class="text-slate-500 font-mono flex-shrink-0">{{ $candidatura->member1_code }}</span>
                            </li>
                            <li class="flex items-center justify-between gap-2"><span
                                    class="text-white truncate">{{ $candidatura->member2_name }}</span> <span
                                    class="text-slate-500 font-mono flex-shrink-0">{{ $candidatura->member2_code }}</span>
                            </li>
                            @if($candidatura->member3_name)
                                <li class="flex items-center justify-between gap-2"><span
                                        class="text-white truncate">{{ $candidatura->member3_name }}</span> <span
                                        class="text-slate-500 font-mono flex-shrink-0">{{ $candidatura->member3_code }}</span>
                                </li>
                            @endif
                            @if($candidatura->member4_name)
                                <li class="flex items-center justify-between gap-2"><span
                                        class="text-white truncate">{{ $candidatura->member4_name }}</span> <span
                                        class="text-slate-500 font-mono flex-shrink-0">{{ $candidatura->member4_code }}</span>
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Painel de IA (botões mudos / placeholders para integração futura) -->
            <div class="glass-panel rounded-2xl border border-bronze-500/30 p-5 flex-shrink-0 relative overflow-hidden">
                <div class="absolute -top-8 -right-8 w-24 h-24 bg-sky-500/10 rounded-full blur-2xl"></div>
                <h3 class="text-sm font-bold text-white mb-1 flex items-center gap-2 relative z-10">
                    <i data-lucide="sparkles" class="w-4 h-4 text-sky-400"></i> Assistente IA
                </h3>
                <p class="text-[10px] text-slate-500 mb-4 relative z-10">Funcionalidades em preparação para este
                    workspace.</p>

                <div class="space-y-2 relative z-10">
                    <button type="button" onclick="aiSummarize()"
                        class="w-full text-left px-3 py-2.5 bg-slate-900/70 hover:bg-slate-800 border border-slate-800 rounded-xl text-xs font-semibold text-slate-300 flex items-center gap-2.5 transition-colors">
                        <i data-lucide="file-text" class="w-4 h-4 text-sky-400 flex-shrink-0"></i>
                        <span class="flex-grow">Resumo IA do Progresso</span>
                    </button>
                    <button type="button" onclick="aiSuggestTasks()"
                        class="w-full text-left px-3 py-2.5 bg-slate-900/70 hover:bg-slate-800 border border-slate-800 rounded-xl text-xs font-semibold text-slate-300 flex items-center gap-2.5 transition-colors">
                        <i data-lucide="list-todo" class="w-4 h-4 text-sky-400 flex-shrink-0"></i>
                        <span class="flex-grow">Sugerir Tarefas (Kanban)</span>
                    </button>
                    <button type="button" onclick="aiAnalyzeChat()"
                        class="w-full text-left px-3 py-2.5 bg-slate-900/70 hover:bg-slate-800 border border-slate-800 rounded-xl text-xs font-semibold text-slate-300 flex items-center gap-2.5 transition-colors">
                        <i data-lucide="message-circle-question" class="w-4 h-4 text-sky-400 flex-shrink-0"></i>
                        <span class="flex-grow">Analisar Mensagens</span>
                    </button>
                </div>

                @if(session()->has('admin_logged_in'))
                <div class="mt-4 pt-4 border-t border-slate-800 relative z-10">
                    <label class="flex items-center justify-between cursor-pointer group">
                        <span class="text-xs font-bold text-indigo-400 group-hover:text-indigo-300 transition-colors">Modo Piloto Automático IA</span>
                        <div class="relative">
                            <input type="checkbox" id="ai-auto-reply" class="sr-only peer" 
                                {{ $candidatura->ai_assistant_active ? 'checked' : '' }} 
                                onchange="toggleAiAutoReply(this.checked)">
                            <div class="block bg-slate-800 w-10 h-6 rounded-full border border-slate-700 peer-checked:bg-indigo-600 peer-checked:border-indigo-500 transition-colors"></div>
                            <div class="absolute left-1 top-1 bg-slate-400 w-4 h-4 rounded-full transition-transform peer-checked:translate-x-full peer-checked:bg-white"></div>
                        </div>
                    </label>
                    <p class="text-[10px] text-slate-500 mt-2 leading-relaxed">Quando ativo, o Assistente IA responderá automaticamente às dúvidas do grupo no chat.</p>
                </div>
                @endif
            </div>

            <!-- Timeline -->
            <div class="glass-panel rounded-2xl border border-slate-800/80 p-5 flex-grow md:overflow-y-auto">
                <h3 class="text-sm font-bold text-white mb-4 flex items-center gap-2 border-b border-slate-800 pb-2">
                    <i data-lucide="git-commit" class="w-4 h-4 text-sky-400"></i> Progresso do Projeto
                </h3>
                @php
                    $fases = [
                        'sensibilizacao' => 'Sensibilização',
                        'campo' => 'Campo & Modelação',
                        'mvp' => 'MVP',
                        'exposicao' => 'Dia da Informática',
                        'artigo' => 'Artigo Científico'
                    ];
                    $estados = $candidatura->progressos->keyBy('fase');
                @endphp
                <div class="space-y-4 relative">
                    @foreach($fases as $key => $label)
                        @php
                            $estado = $estados[$key]->estado ?? 'pendente';
                            $icon = $estado == 'concluida' ? 'check-circle' : ($estado == 'em_progresso' ? 'circle-dot' : 'circle');
                            $color = $estado == 'concluida' ? 'text-emerald-400' : ($estado == 'em_progresso' ? 'text-sky-400' : 'text-slate-600');
                            $isLast = $loop->last;
                        @endphp
                        <div class="flex items-start gap-3 relative">
                            @if(!$isLast)
                                <span
                                    class="absolute left-[9px] top-6 w-px h-[calc(100%-4px)] {{ $estado == 'concluida' ? 'bg-emerald-400/30' : 'bg-slate-800' }}"></span>
                            @endif
                            <i data-lucide="{{ $icon }}"
                                class="w-5 h-5 {{ $color }} mt-0.5 flex-shrink-0 relative z-10 bg-slate-950"></i>
                            <div>
                                <p class="text-xs font-bold text-white">{{ $label }}</p>
                                <p class="text-[10px] text-slate-500 uppercase font-mono tracking-wider">
                                    {{ str_replace('_', ' ', $estado) }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>

                @if($isAdmin && !$isViewer)
                    <div class="mt-6 pt-4 border-t border-slate-800">
                        <form action="{{ route('workspace.fase', $candidatura->id) }}" method="POST" class="space-y-2">
                            @csrf
                            <select name="fase"
                                class="w-full bg-slate-900 border border-slate-700 rounded-lg text-xs p-2 text-slate-200 outline-none focus:border-sky-500 transition-colors">
                                @foreach($fases as $key => $label)
                                    <option value="{{ $key }}">{{ $label }}</option>
                                @endforeach
                            </select>
                            <select name="estado"
                                class="w-full bg-slate-900 border border-slate-700 rounded-lg text-xs p-2 text-slate-200 outline-none focus:border-sky-500 transition-colors">
                                <option value="pendente">Pendente</option>
                                <option value="em_progresso">Em Progresso</option>
                                <option value="concluida">Concluída</option>
                            </select>
                            <textarea name="mensagem" rows="2" placeholder="Observação / Feedback (Opcional)..."
                                class="w-full bg-slate-900 border border-slate-700 rounded-lg text-xs p-2 text-slate-200 outline-none focus:border-sky-500 transition-colors resize-none"></textarea>
                            <button type="submit"
                                class="w-full py-2 bg-sky-600 hover:bg-sky-500 text-white rounded-lg text-xs font-bold transition-colors">Actualizar
                                Fase</button>
                        </form>
                    </div>
                @endif
            </div>
        </aside>

        <!-- CENTER: CHAT & KANBAN AREA (55%) -->
        <section id="panel-room"
            class="hidden md:flex w-full md:w-[50%] lg:w-[60%] min-h-[600px] md:min-h-0 h-auto md:h-full glass-panel rounded-2xl border border-slate-800/80 flex-col overflow-hidden relative shadow-2xl">

            <!-- TABS HEADER -->
            <div class="flex border-b border-slate-800 bg-slate-900/50">
                <button onclick="switchTab('chat')" id="tab-chat"
                    class="relative flex-1 py-3 text-xs font-bold uppercase tracking-wider text-sky-400 border-b-2 border-sky-400 transition-colors">
                    <i data-lucide="message-square" class="w-4 h-4 inline-block mr-1"></i> Chat
                    <span id="badge-chat" class="notif-badge bg-rose-500 text-white hidden">0</span>
                </button>
                <button onclick="switchTab('kanban')" id="tab-kanban"
                    class="relative flex-1 py-3 text-xs font-bold uppercase tracking-wider text-slate-500 hover:text-slate-300 border-b-2 border-transparent transition-colors">
                    <i data-lucide="kanban" class="w-4 h-4 inline-block mr-1"></i> Quadro Kanban
                    <span id="badge-kanban" class="notif-badge bg-sky-500 text-white hidden">0</span>
                </button>
            </div>

            <!-- TAB CONTENT: CHAT -->
            <div id="content-chat" class="flex-grow flex flex-col overflow-hidden h-full">
                <!-- Chat Messages -->
                <div class="flex-grow p-4 md:p-6 overflow-y-auto space-y-4 max-h-[500px] md:max-h-none scrollbar-thin"
                    id="chat-box" data-last-id="{{ $messages->last()->id ?? 0 }}">

                    <!-- Welcome Message -->
                    <div class="flex justify-center mb-6">
                        <span
                            class="text-[10px] uppercase font-bold text-slate-500 font-mono bg-slate-900/50 px-3 py-1 rounded-full border border-slate-800">
                            Início da Mentoria
                        </span>
                    </div>

                    @if($messages->isEmpty())
                        <div class="text-center py-10 text-slate-500" id="empty-chat-state">
                            <i data-lucide="message-square-dashed" class="w-10 h-10 mx-auto mb-3 opacity-50"></i>
                            <p class="text-sm">Nenhuma mensagem ainda.</p>
                            <p class="text-xs mt-1">Faça a sua primeira pergunta ou partilhe um link para o mentor.</p>
                        </div>
                    @endif

                    @php
                    if (!function_exists('renderChatMessage')) {
                        function renderChatMessage($text) {
                            $text = e($text);
                            $text = preg_replace('/(\*\*|__)(.*?)\1/', '<strong>$2</strong>', $text);
                            $text = preg_replace('/\[(.*?)\]\((.*?)\)/', '<a href="$2" target="_blank" class="text-sky-300 underline hover:text-sky-100">$1</a>', $text);
                            return nl2br($text);
                        }
                    }
                    @endphp

                    <!-- Messages Container -->
                    <div id="messages-container" class="space-y-4">
                        @foreach($messages as $msg)
                            @if($msg->sender_type === 'ai')
                                <!-- AI Message (Left) -->
                                <div class="flex items-start gap-3 w-[92%] sm:w-4/5">
                                    <div
                                        class="w-8 h-8 rounded-full bg-indigo-500 flex items-center justify-center flex-shrink-0 shadow-lg shadow-indigo-500/20">
                                        <i data-lucide="sparkles" class="w-4 h-4 text-white"></i>
                                    </div>
                                    <div>
                                        <div class="flex items-baseline gap-2 mb-1">
                                            <span class="text-xs font-bold text-indigo-400">Assistente IA (Académico)</span>
                                            <span
                                                class="text-[10px] text-slate-500">{{ $msg->created_at->format('H:i') }}</span>
                                        </div>
                                        <div
                                            class="group relative p-3 bg-slate-800 border border-indigo-500/30 rounded-2xl rounded-tl-sm text-sm text-slate-200 whitespace-pre-wrap">
                                            {!! renderChatMessage($msg->message) !!}
                                            @if($isAdmin)
                                                <div class="absolute -right-6 top-1 opacity-0 group-hover:opacity-100 transition-opacity flex flex-col gap-2">
                                                    <button onclick="editMessage({{ $msg->id }}, '{{ addslashes($msg->message) }}')" class="text-slate-400 hover:text-sky-400 bg-slate-900 rounded p-1" title="Editar IA"><i data-lucide="edit-2" class="w-3 h-3"></i></button>
                                                    <button onclick="deleteMessage({{ $msg->id }})" class="text-slate-400 hover:text-red-400 bg-slate-900 rounded p-1" title="Eliminar IA"><i data-lucide="trash-2" class="w-3 h-3"></i></button>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @elseif($msg->sender_type === 'mentor')
                                <!-- Mentor Message (Left) -->
                                <div class="flex items-start gap-3 w-[92%] sm:w-4/5">
                                    <div
                                        class="w-8 h-8 rounded-full bg-bronze-500 flex items-center justify-center flex-shrink-0 shadow-lg shadow-bronze-500/20">
                                        <i data-lucide="graduation-cap" class="w-4 h-4 text-white"></i>
                                    </div>
                                    <div>
                                        <div class="flex items-baseline gap-2 mb-1">
                                            <span class="text-xs font-bold text-bronze-400">Docente Mentor</span>
                                            <span
                                                class="text-[10px] text-slate-500">{{ $msg->created_at->format('H:i') }}</span>
                                        </div>
                                        <div
                                            class="group relative p-3 bg-slate-800 border border-slate-700 rounded-2xl rounded-tl-sm text-sm text-slate-200 whitespace-pre-wrap">
                                            {!! renderChatMessage($msg->message) !!}
                                            @if($isAdmin)
                                                <div class="absolute -right-6 top-1 opacity-0 group-hover:opacity-100 transition-opacity flex flex-col gap-2">
                                                    <button onclick="editMessage({{ $msg->id }}, '{{ addslashes($msg->message) }}')" class="text-slate-400 hover:text-sky-400 bg-slate-900 rounded p-1"><i data-lucide="edit-2" class="w-3 h-3"></i></button>
                                                    <button onclick="deleteMessage({{ $msg->id }})" class="text-slate-400 hover:text-red-400 bg-slate-900 rounded p-1"><i data-lucide="trash-2" class="w-3 h-3"></i></button>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @else
                                <!-- Student Message (Right) -->
                                <div class="flex items-start gap-3 w-[92%] sm:w-4/5 ml-auto justify-end">
                                    <div class="text-right">
                                        <div class="flex items-baseline gap-2 mb-1 justify-end">
                                            <span
                                                class="text-[10px] text-slate-500">{{ $msg->created_at->format('H:i') }}</span>
                                            <span class="text-xs font-bold text-sky-400">Grupo:
                                                {{ $candidatura->project_name }}</span>
                                        </div>
                                        <div
                                            class="group relative p-3 bg-sky-600 border border-sky-500 rounded-2xl rounded-tr-sm text-sm text-white whitespace-pre-wrap text-left">
                                            {!! renderChatMessage($msg->message) !!}
                                            @if(!$isAdmin)
                                                <div class="absolute -left-6 top-1 opacity-0 group-hover:opacity-100 transition-opacity flex flex-col gap-2">
                                                    <button onclick="editMessage({{ $msg->id }}, '{{ addslashes($msg->message) }}')" class="text-slate-200 hover:text-white bg-slate-800 rounded p-1"><i data-lucide="edit-2" class="w-3 h-3"></i></button>
                                                    <button onclick="deleteMessage({{ $msg->id }})" class="text-slate-200 hover:text-red-400 bg-slate-800 rounded p-1"><i data-lucide="trash-2" class="w-3 h-3"></i></button>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div
                                        class="w-8 h-8 rounded-full bg-slate-800 border border-slate-700 flex items-center justify-center flex-shrink-0">
                                        <i data-lucide="users" class="w-4 h-4 text-sky-400"></i>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>

                    <!-- Indicador "a escrever..." -->
                    <div id="typing-indicator" class="hidden flex items-start gap-3 w-[92%] sm:w-4/5">
                        <div
                            class="w-8 h-8 rounded-full bg-indigo-500/60 flex items-center justify-center flex-shrink-0">
                            <i data-lucide="sparkles" class="w-4 h-4 text-white"></i>
                        </div>
                        <div
                            class="px-4 py-3 bg-slate-800 border border-slate-700 rounded-2xl rounded-tl-sm flex items-center gap-1">
                            <span class="typing-dot w-1.5 h-1.5 rounded-full bg-slate-400"></span>
                            <span class="typing-dot w-1.5 h-1.5 rounded-full bg-slate-400"></span>
                            <span class="typing-dot w-1.5 h-1.5 rounded-full bg-slate-400"></span>
                        </div>
                    </div>
                </div>

                <!-- Input Area -->
                @if(!$isViewer)
                    <div class="p-4 border-t border-slate-800 bg-slate-900/50 backdrop-blur-sm">
                        <form id="chat-form" action="{{ route('workspace.message', $candidatura->id) }}" method="POST"
                            class="flex gap-2 items-end">
                            @csrf
                            <div class="relative w-full flex items-center bg-slate-950 border border-slate-800 focus-within:border-sky-500 rounded-xl transition-colors">
                                <label for="chat-ficheiro-upload" class="cursor-pointer px-3 text-slate-400 hover:text-sky-400 transition-colors" title="Anexar ficheiro">
                                    <i data-lucide="paperclip" class="w-5 h-5"></i>
                                </label>
                                <textarea name="message" id="message-input" rows="1" placeholder="Escreva uma mensagem..."
                                    required
                                    class="w-full bg-transparent border-none focus:outline-none focus:ring-0 py-3 pr-4 text-sm text-slate-200 resize-none overflow-hidden"
                                    oninput="this.style.height = ''; this.style.height = this.scrollHeight + 'px'"></textarea>
                            </div>
                            <button type="button" onclick="aiAskAssistant()"
                                title="Pedir orientação académica à IA (sobre a mensagem escrita)"
                                class="w-12 h-12 bg-indigo-900/40 hover:bg-indigo-800/60 border border-indigo-800/50 text-indigo-400 rounded-xl flex items-center justify-center flex-shrink-0 transition-colors">
                                <i data-lucide="sparkles" class="w-5 h-5"></i>
                            </button>

                            <button type="submit"
                                class="w-12 h-12 bg-sky-600 hover:bg-sky-500 text-white rounded-xl flex items-center justify-center flex-shrink-0 transition-colors shadow-lg shadow-sky-500/20">
                                <i data-lucide="send" class="w-5 h-5 ml-1"></i>
                            </button>
                        </form>
                        
                        <form id="hidden-file-upload-form" action="{{ route('workspace.ficheiro', $candidatura->id) }}" method="POST" enctype="multipart/form-data" class="hidden">
                            @csrf
                            <input type="file" name="ficheiro" id="chat-ficheiro-upload" onchange="document.getElementById('hidden-file-upload-form').submit()">
                        </form>
                    </div>
                @else
                    <div
                        class="p-4 border-t border-slate-800 bg-slate-900/50 backdrop-blur-sm text-center text-xs text-slate-500">
                        Modo de visualização. Apenas estudantes e o mentor atribuído podem enviar mensagens.
                    </div>
                @endif
            </div>

            <!-- TAB CONTENT: KANBAN -->
            <div id="content-kanban" class="hidden flex-grow flex flex-col overflow-hidden bg-slate-950">
                <!-- Kanban Toolbar -->
                <div class="p-3 border-b border-slate-800 flex justify-between items-center bg-slate-900/30">
                    <h3 class="text-xs font-bold text-slate-300 font-mono uppercase">Gestão de Tarefas</h3>
                    <div class="flex items-center gap-2">
                        <button type="button" onclick="aiSuggestTasks()" title="Sugerir tarefas com IA"
                            class="px-2.5 py-1.5 bg-slate-900 hover:bg-slate-800 border border-slate-800 text-bronze-400 rounded-lg text-xs font-bold flex items-center gap-1 transition-colors">
                            <i data-lucide="sparkles" class="w-3.5 h-3.5"></i> <span
                                class="hidden sm:inline">Sugerir</span>
                        </button>
                        @if(!$isViewer)
                            <button onclick="openKanbanModal()"
                                class="px-3 py-1.5 bg-sky-500/10 border border-sky-500/30 hover:bg-sky-500/20 text-sky-400 rounded-lg text-xs font-bold flex items-center gap-1 transition-colors">
                                <i data-lucide="plus" class="w-3.5 h-3.5"></i> Nova Tarefa
                            </button>
                        @endif
                    </div>
                </div>

                <!-- Kanban Board (Scrollable Container) -->
                <div class="flex-grow p-4 overflow-y-auto md:overflow-y-hidden overflow-x-hidden md:overflow-x-auto flex flex-col md:flex-row gap-4 kanban-container scrollbar-thin">

                    <!-- Coluna: A Fazer -->
                    <div
                        class="w-full md:w-64 md:flex-shrink-0 flex flex-col bg-slate-900/50 border border-slate-800/80 rounded-xl overflow-hidden h-[350px] md:h-full">
                        <div class="p-3 border-b border-slate-800 flex items-center justify-between bg-slate-800/30">
                            <span
                                class="text-xs font-bold text-slate-300 uppercase tracking-wider flex items-center gap-1.5">
                                <span class="w-2 h-2 rounded-full bg-slate-500"></span> A Fazer
                            </span>
                            <span id="count-todo"
                                class="text-[10px] font-mono text-slate-500 bg-slate-800/60 px-1.5 py-0.5 rounded">0</span>
                        </div>
                        <div class="flex-grow p-2 overflow-y-auto space-y-2 kanban-column scrollbar-thin"
                             data-status="todo" id="col-todo" ondrop="drop(event)" ondragover="allowDrop(event)">
                        </div>
                    </div>

                    <!-- Coluna: Em Progresso -->
                    <div
                        class="w-full md:w-64 md:flex-shrink-0 flex flex-col bg-slate-900/50 border border-slate-800/80 rounded-xl overflow-hidden h-[350px] md:h-full">
                        <div class="p-3 border-b border-slate-800 flex items-center justify-between bg-slate-800/30">
                            <span
                                class="text-xs font-bold text-sky-400 uppercase tracking-wider flex items-center gap-1.5">
                                <span class="w-2 h-2 rounded-full bg-sky-500"></span> Em Progresso
                            </span>
                            <span id="count-in_progress"
                                class="text-[10px] font-mono text-slate-500 bg-slate-800/60 px-1.5 py-0.5 rounded">0</span>
                        </div>
                        <div class="flex-grow p-2 overflow-y-auto space-y-2 kanban-column scrollbar-thin"
                             data-status="in_progress" id="col-in_progress" ondrop="drop(event)"
                             ondragover="allowDrop(event)">
                        </div>
                    </div>

                    <!-- Coluna: Em Revisão -->
                    <div
                        class="w-full md:w-64 md:flex-shrink-0 flex flex-col bg-slate-900/50 border border-slate-800/80 rounded-xl overflow-hidden h-[350px] md:h-full">
                        <div class="p-3 border-b border-slate-800 flex items-center justify-between bg-slate-800/30">
                            <span
                                class="text-xs font-bold text-bronze-400 uppercase tracking-wider flex items-center gap-1.5">
                                <span class="w-2 h-2 rounded-full bg-bronze-500"></span> Em Revisão
                            </span>
                            <span id="count-review"
                                class="text-[10px] font-mono text-slate-500 bg-slate-800/60 px-1.5 py-0.5 rounded">0</span>
                        </div>
                        <div class="flex-grow p-2 overflow-y-auto space-y-2 kanban-column scrollbar-thin"
                             data-status="review" id="col-review" ondrop="drop(event)" ondragover="allowDrop(event)">
                        </div>
                    </div>

                    <!-- Coluna: Concluído -->
                    <div
                        class="w-full md:w-64 md:flex-shrink-0 flex flex-col bg-slate-900/50 border border-slate-800/80 rounded-xl overflow-hidden h-[350px] md:h-full">
                        <div class="p-3 border-b border-slate-800 flex items-center justify-between bg-slate-800/30">
                            <span
                                class="text-xs font-bold text-emerald-400 uppercase tracking-wider flex items-center gap-1.5">
                                <span class="w-2 h-2 rounded-full bg-emerald-500"></span> Concluído
                            </span>
                            <span id="count-done"
                                class="text-[10px] font-mono text-slate-500 bg-slate-800/60 px-1.5 py-0.5 rounded">0</span>
                        </div>
                        <div class="flex-grow p-2 overflow-y-auto space-y-2 kanban-column scrollbar-thin"
                             data-status="done" id="col-done" ondrop="drop(event)" ondragover="allowDrop(event)">
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <!-- SIDEBAR RIGHT: Files (25%) -->
        <aside id="panel-files"
            class="hidden w-full md:w-[25%] lg:w-[20%] glass-panel rounded-2xl border border-slate-800/80 p-5 flex-col md:flex md:overflow-y-auto scrollbar-thin">
            <h3 class="text-sm font-bold text-white mb-4 flex items-center gap-2 border-b border-slate-800 pb-2">
                <i data-lucide="folder" class="w-4 h-4 text-sky-400"></i> Ficheiros e Recursos
            </h3>

            <div class="flex-grow overflow-y-auto space-y-3 scrollbar-thin">
                @forelse($candidatura->ficheiros as $f)
                    @php
                        $ext = strtolower(pathinfo($f->nome_ficheiro, PATHINFO_EXTENSION));
                        $icon = 'file';
                        $iconColor = 'text-slate-400';
                        if (in_array($ext, ['pdf'])) {
                            $icon = 'file-text';
                            $iconColor = 'text-rose-400';
                        } elseif (in_array($ext, ['zip', 'rar', 'tar'])) {
                            $icon = 'file-archive';
                            $iconColor = 'text-bronze-400';
                        } elseif (in_array($ext, ['png', 'jpg', 'jpeg', 'gif'])) {
                            $icon = 'image';
                            $iconColor = 'text-sky-400';
                        } elseif (in_array($ext, ['doc', 'docx'])) {
                            $icon = 'file-text';
                            $iconColor = 'text-blue-400';
                        }
                    @endphp
                    <div
                        class="p-3 bg-slate-900/50 border border-slate-800 rounded-xl flex items-center justify-between group hover:border-sky-500/50 transition-colors">
                        <div class="flex items-center gap-3 overflow-hidden pr-2">
                            <i data-lucide="{{ $icon }}" class="w-6 h-6 {{ $iconColor }} flex-shrink-0"></i>
                            <div class="overflow-hidden">
                                <p class="text-xs text-white truncate" title="{{ $f->nome_ficheiro }}">
                                    {{ $f->nome_ficheiro }}</p>
                                <div class="flex gap-2 items-center">
                                    <p class="text-[9px] text-slate-500 font-mono">{{ $f->created_at->format('d/m/Y') }}</p>
                                    <span class="text-[9px] px-1 bg-slate-800 rounded">{{ $f->uploaded_by }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="flex gap-1">
                            <button onclick="previewFile('{{ route('workspace.ficheiro.preview', $f->id) }}', '{{ $f->nome_ficheiro }}', '{{ $ext }}')"
                                class="p-1.5 bg-slate-800 hover:bg-sky-600 text-sky-400 hover:text-white rounded-lg transition-colors flex-shrink-0 shadow-sm"
                                title="Visualizar Ficheiro">
                                <i data-lucide="eye" class="w-3.5 h-3.5"></i>
                            </button>
                            <a href="{{ route('workspace.ficheiro.download', $f->id) }}"
                                class="p-1.5 bg-slate-800 hover:bg-sky-600 text-sky-400 hover:text-white rounded-lg transition-colors flex-shrink-0 shadow-sm"
                                title="Descarregar Ficheiro">
                                <i data-lucide="download" class="w-3.5 h-3.5"></i>
                            </a>
                            @if(!$isViewer && (($isAdmin && $f->uploaded_by === 'Docente Mentor') || (!$isAdmin && $f->uploaded_by === 'Grupo Estudante')))
                                <form action="{{ route('workspace.ficheiro.delete', ['id' => $candidatura->id, 'ficheiroId' => $f->id]) }}" method="POST" onsubmit="return confirm('Tem a certeza que deseja eliminar este ficheiro? O link no chat também deixará de funcionar.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-1.5 bg-slate-800 hover:bg-red-600 text-slate-400 hover:text-white rounded-lg transition-colors flex-shrink-0 shadow-sm" title="Eliminar Ficheiro">
                                        <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8">
                        <i data-lucide="folder-open" class="w-8 h-8 text-slate-600 mx-auto mb-2 opacity-50"></i>
                        <p class="text-xs text-slate-500">Nenhum ficheiro partilhado ainda.</p>
                    </div>
                @endforelse
            </div>

            @if(!$isViewer)
                <div class="mt-4 pt-4 border-t border-slate-800">
                    <form action="{{ route('workspace.ficheiro', $candidatura->id) }}" method="POST"
                        enctype="multipart/form-data" class="space-y-3">
                        @csrf
                        <div>
                            <input type="file" name="ficheiro" id="ficheiro" class="hidden" required>
                            <label for="ficheiro"
                                class="w-full py-2 px-3 border border-dashed border-slate-600 hover:border-sky-500 rounded-lg flex items-center justify-center gap-2 cursor-pointer transition-colors text-xs text-slate-400 hover:text-sky-400">
                                <i data-lucide="upload-cloud" class="w-4 h-4"></i> Partilhar Ficheiro
                            </label>
                            <p id="file-name-display" class="text-[9px] text-slate-500 text-center mt-1 truncate"></p>
                        </div>
                        <button type="submit"
                            class="w-full py-2 bg-slate-800 hover:bg-sky-600 text-white rounded-lg text-xs font-bold transition-colors">Fazer
                            Upload</button>
                    </form>
                </div>
            @endif
            <script>
                document.getElementById('ficheiro').addEventListener('change', function () {
                    const name = this.files[0] ? this.files[0].name : '';
                    document.getElementById('file-name-display').innerText = name;
                });
            </script>
        </aside>
    </main>

    <!-- KANBAN MOVE MODAL (MOBILE) -->
    <div id="kanban-move-modal"
        class="fixed inset-0 bg-black/60 backdrop-blur-sm z-50 flex items-end sm:items-center justify-center hidden opacity-0 transition-opacity duration-300 p-4">
        <div class="bg-slate-900 border border-slate-700 rounded-2xl w-full max-w-sm p-6 max-h-[85vh] overflow-y-auto transform translate-y-full sm:translate-y-0 sm:scale-95 transition-transform duration-300 shadow-2xl"
            id="kanban-move-content">
            <div class="flex justify-between items-center mb-5 border-b border-slate-800 pb-3">
                <h2 class="text-sm font-bold text-white flex items-center gap-2">
                    <i data-lucide="move" class="w-4 h-4 text-sky-400"></i> Mover Tarefa
                </h2>
                <button onclick="closeKanbanMoveModal()" class="text-slate-400 hover:text-white transition-colors">
                    <i data-lucide="x" class="w-4 h-4"></i>
                </button>
            </div>

            <input type="hidden" id="move-task-id">

            <div class="space-y-2">
                <button onclick="moveTaskTo('todo')"
                    class="w-full p-3 bg-slate-800 hover:bg-slate-700 border border-slate-700 rounded-xl text-xs font-bold text-slate-300 text-left flex justify-between items-center transition-colors">
                    A Fazer <span class="w-2 h-2 rounded-full bg-slate-500"></span>
                </button>
                <button onclick="moveTaskTo('in_progress')"
                    class="w-full p-3 bg-slate-800 hover:bg-slate-700 border border-slate-700 rounded-xl text-xs font-bold text-slate-300 text-left flex justify-between items-center transition-colors">
                    Em Progresso <span class="w-2 h-2 rounded-full bg-sky-500"></span>
                </button>
                <button onclick="moveTaskTo('review')"
                    class="w-full p-3 bg-slate-800 hover:bg-slate-700 border border-slate-700 rounded-xl text-xs font-bold text-slate-300 text-left flex justify-between items-center transition-colors">
                    Em Revisão <span class="w-2 h-2 rounded-full bg-bronze-500"></span>
                </button>
                <button onclick="moveTaskTo('done')"
                    class="w-full p-3 bg-slate-800 hover:bg-slate-700 border border-slate-700 rounded-xl text-xs font-bold text-slate-300 text-left flex justify-between items-center transition-colors">
                    Concluído <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                </button>
            </div>
        </div>
    </div>

    <!-- KANBAN MODAL -->
    <div id="kanban-modal"
        class="fixed inset-0 bg-black/60 backdrop-blur-sm z-50 flex items-center justify-center hidden opacity-0 transition-opacity duration-300 p-4">
        <div class="bg-slate-900 border border-slate-700 rounded-2xl w-full max-w-md p-6 max-h-[85vh] overflow-y-auto transform scale-95 transition-transform duration-300 shadow-2xl"
            id="kanban-modal-content">
            <div class="flex justify-between items-center mb-5">
                <h2 class="text-lg font-bold text-white flex items-center gap-2">
                    <i data-lucide="layout-list" class="w-5 h-5 text-sky-400"></i> Nova Tarefa
                </h2>
                <button onclick="closeKanbanModal()" class="text-slate-400 hover:text-white transition-colors">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>

            <form id="kanban-form" onsubmit="submitKanbanTask(event)" class="space-y-4">
                <input type="hidden" id="kanban-task-id">
                <div>
                    <label class="block text-xs font-semibold text-slate-400 uppercase mb-1">Título da Tarefa</label>
                    <input type="text" id="kanban-title" required
                        class="w-full bg-slate-950 border border-slate-700 rounded-lg px-3 py-2 text-sm text-white focus:border-sky-500 focus:outline-none transition-colors">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-400 uppercase mb-1">Descrição
                        (Opcional)</label>
                    <textarea id="kanban-description" rows="3"
                        class="w-full bg-slate-950 border border-slate-700 rounded-lg px-3 py-2 text-sm text-white focus:border-sky-500 focus:outline-none transition-colors resize-none"></textarea>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-400 uppercase mb-1">Coluna Inicial</label>
                    <select id="kanban-status"
                        class="w-full bg-slate-950 border border-slate-700 rounded-lg px-3 py-2 text-sm text-white focus:border-sky-500 focus:outline-none transition-colors">
                        <option value="todo">A Fazer</option>
                        <option value="in_progress">Em Progresso</option>
                        <option value="review">Em Revisão</option>
                        <option value="done">Concluído</option>
                    </select>
                </div>

                <div class="flex justify-end gap-2 mt-6">
                    <button type="button" onclick="closeKanbanModal()"
                        class="px-4 py-2 bg-slate-800 hover:bg-slate-700 text-white rounded-lg text-sm transition-colors">Cancelar</button>
                    <button type="submit"
                        class="px-4 py-2 bg-sky-600 hover:bg-sky-500 text-white rounded-lg text-sm font-bold transition-colors shadow-lg shadow-sky-500/20">Criar
                        Tarefa</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        lucide.createIcons();

        const chatBox = document.getElementById('chat-box');
        const msgContainer = document.getElementById('messages-container');
        chatBox.scrollTop = chatBox.scrollHeight;

        // ================= MOBILE SUBNAV =================
        // No telemóvel, alterna entre Detalhes (sidebar esq.), Sala (chat/kanban) e Ficheiros (sidebar dir.)
        function switchMobilePanel(panel) {
            ['info', 'room', 'files'].forEach(p => {
                document.getElementById('panel-' + p).classList.add('hidden');
                document.getElementById('mobile-tab-' + p).classList.remove('active');
            });
            document.getElementById('panel-' + panel).classList.remove('hidden');
            document.getElementById('panel-' + panel).classList.add(window.innerWidth < 768 ? 'flex' : '');
            document.getElementById('mobile-tab-' + panel).classList.add('active');
        }
        // Garante que em desktop os 3 painéis ficam sempre visíveis, ignorando o estado mobile
        function syncPanelsForViewport() {
            if (window.innerWidth >= 768) {
                document.getElementById('panel-info').classList.remove('hidden');
                document.getElementById('panel-room').classList.remove('hidden');
                document.getElementById('panel-files').classList.remove('hidden');
            }
        }
        window.addEventListener('resize', syncPanelsForViewport);
        syncPanelsForViewport();

        // ================= NOTIFICAÇÕES (badges) =================
        // Contador simples de mensagens novas enquanto o utilizador está noutra tab.
        // Pronto para ser alimentado por dados reais via fetchMessages() / loadKanbanTasks().
        let unreadChat = 0;
        let unreadKanban = 0;
        let activeTab = 'chat';

        function updateBadge(id, count) {
            const el = document.getElementById(id);
            if (!el) return;
            if (count > 0) {
                el.textContent = count > 9 ? '9+' : count;
                el.classList.remove('hidden');
            } else {
                el.classList.add('hidden');
            }
        }

        // AJAX Polling
        let lastId = parseInt(chatBox.getAttribute('data-last-id')) || 0;
        const candidaturaId = {{ $candidatura->id }};
        const API_BASE = "{{ url('/api/workspace') }}/" + candidaturaId;
        const isAdmin = {{ $isAdmin ? 'true' : 'false' }};

        let isFetchingMessages = false;
        function fetchMessages() {
            if (isFetchingMessages) return;
            isFetchingMessages = true;
            fetch(`${API_BASE}/mensagens?last_id=${lastId}`)
                .then(res => res.json())
                .then(data => {
                    const typingIndicator = document.getElementById('typing-indicator');
                    if (data.is_typing) {
                        typingIndicator.classList.remove('hidden');
                    } else {
                        typingIndicator.classList.add('hidden');
                    }

                    if (data.messages && data.messages.length > 0) {
                        const emptyState = document.getElementById('empty-chat-state');
                        if (emptyState) emptyState.remove();

                        data.messages.forEach(msg => {
                            lastId = Math.max(lastId, msg.id);
                            chatBox.setAttribute('data-last-id', lastId);

                            const date = new Date(msg.created_at);
                            const timeStr = date.getHours().toString().padStart(2, '0') + ':' + date.getMinutes().toString().padStart(2, '0');

                            let textRendered = msg.message.replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;");
                            textRendered = textRendered.replace(/(\*\*|__)(.*?)\1/g, '<strong>$2</strong>');
                            textRendered = textRendered.replace(/\[(.*?)\]\((.*?)\)/g, '<a href="$2" target="_blank" class="text-sky-300 underline hover:text-sky-100">$1</a>');
                            
                            // Prevent JS error if replacing quotes inside edit button
                            const safeRawText = msg.message.replace(/'/g, "\\'");

                            let html = '';
                            if (msg.sender_type === 'ai') {
                                html = `
                                <div class="flex items-start gap-3 w-[92%] sm:w-4/5 animate-fade-in">
                                    <div class="w-8 h-8 rounded-full bg-indigo-500 flex items-center justify-center flex-shrink-0 shadow-lg shadow-indigo-500/20">
                                        <i data-lucide="sparkles" class="w-4 h-4 text-white"></i>
                                    </div>
                                    <div>
                                        <div class="flex items-baseline gap-2 mb-1">
                                            <span class="text-xs font-bold text-indigo-400">Assistente IA (Académico)</span>
                                            <span class="text-[10px] text-slate-500">${timeStr}</span>
                                        </div>
                                        <div class="group relative p-3 bg-slate-800 border border-indigo-500/30 rounded-2xl rounded-tl-sm text-sm text-slate-200 whitespace-pre-wrap">
                                            ${textRendered}
                                            ${isAdmin ? `
                                            <div class="absolute -right-6 top-1 opacity-0 group-hover:opacity-100 transition-opacity flex flex-col gap-2">
                                                <button onclick="editMessage(${msg.id}, '${safeRawText}')" class="text-slate-400 hover:text-sky-400 bg-slate-900 rounded p-1" title="Editar IA"><i data-lucide="edit-2" class="w-3 h-3"></i></button>
                                                <button onclick="deleteMessage(${msg.id})" class="text-slate-400 hover:text-red-400 bg-slate-900 rounded p-1" title="Eliminar IA"><i data-lucide="trash-2" class="w-3 h-3"></i></button>
                                            </div>
                                            ` : ''}
                                        </div>
                                    </div>
                                </div>`;
                            } else if (msg.sender_type === 'mentor') {
                                html = `
                                <div class="flex items-start gap-3 w-[92%] sm:w-4/5 animate-fade-in">
                                    <div class="w-8 h-8 rounded-full bg-bronze-500 flex items-center justify-center flex-shrink-0 shadow-lg shadow-bronze-500/20">
                                        <i data-lucide="graduation-cap" class="w-4 h-4 text-white"></i>
                                    </div>
                                    <div>
                                        <div class="flex items-baseline gap-2 mb-1">
                                            <span class="text-xs font-bold text-bronze-400">Docente Mentor</span>
                                            <span class="text-[10px] text-slate-500">${timeStr}</span>
                                        </div>
                                        <div class="group relative p-3 bg-slate-800 border border-slate-700 rounded-2xl rounded-tl-sm text-sm text-slate-200 whitespace-pre-wrap">
                                            ${textRendered}
                                            ${isAdmin ? `
                                            <div class="absolute -right-6 top-1 opacity-0 group-hover:opacity-100 transition-opacity flex flex-col gap-2">
                                                <button onclick="editMessage(${msg.id}, '${safeRawText}')" class="text-slate-400 hover:text-sky-400 bg-slate-900 rounded p-1"><i data-lucide="edit-2" class="w-3 h-3"></i></button>
                                                <button onclick="deleteMessage(${msg.id})" class="text-slate-400 hover:text-red-400 bg-slate-900 rounded p-1"><i data-lucide="trash-2" class="w-3 h-3"></i></button>
                                            </div>
                                            ` : ''}
                                        </div>
                                    </div>
                                </div>`;
                            } else {
                                html = `
                                <div class="flex items-start gap-3 w-[92%] sm:w-4/5 ml-auto justify-end animate-fade-in">
                                    <div class="text-right">
                                        <div class="flex items-baseline gap-2 mb-1 justify-end">
                                            <span class="text-[10px] text-slate-500">${timeStr}</span>
                                            <span class="text-xs font-bold text-sky-400">Grupo: {{ addslashes($candidatura->project_name) }}</span>
                                        </div>
                                        <div class="group relative p-3 bg-sky-600 border border-sky-500 rounded-2xl rounded-tr-sm text-sm text-white whitespace-pre-wrap text-left">
                                            ${textRendered}
                                            ${!isAdmin ? `
                                            <div class="absolute -left-6 top-1 opacity-0 group-hover:opacity-100 transition-opacity flex flex-col gap-2">
                                                <button onclick="editMessage(${msg.id}, '${safeRawText}')" class="text-slate-200 hover:text-white bg-slate-800 rounded p-1"><i data-lucide="edit-2" class="w-3 h-3"></i></button>
                                                <button onclick="deleteMessage(${msg.id})" class="text-slate-200 hover:text-red-400 bg-slate-800 rounded p-1"><i data-lucide="trash-2" class="w-3 h-3"></i></button>
                                            </div>
                                            ` : ''}
                                        </div>
                                    </div>
                                    <div class="w-8 h-8 rounded-full bg-slate-800 border border-slate-700 flex items-center justify-center flex-shrink-0">
                                        <i data-lucide="users" class="w-4 h-4 text-sky-400"></i>
                                    </div>
                                </div>`;
                            }
                            msgContainer.insertAdjacentHTML('beforeend', html);

                            // Se a mensagem não é a tab activa nem do próprio utilizador, soma ao badge
                            if (activeTab !== 'chat') {
                                unreadChat++;
                                updateBadge('badge-chat', unreadChat);
                            }
                        });
                        lucide.createIcons();
                        chatBox.scrollTop = chatBox.scrollHeight;
                    }
                })
                .finally(() => {
                    isFetchingMessages = false;
                });
        }

        setInterval(fetchMessages, 5000); // Poll every 5s

        // Envia beacon de "a escrever..."
        let isSendingTyping = false;
        document.getElementById('message-input')?.addEventListener('input', function () {
            if (isSendingTyping) return;
            isSendingTyping = true;
            fetch(`${API_BASE}/typing`, {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
            });
            setTimeout(() => { isSendingTyping = false; }, 2500);
        });

        // Form submission via AJAX to avoid reload
        document.getElementById('chat-form')?.addEventListener('submit', function (e) {
            e.preventDefault();
            const input = document.getElementById('message-input');
            const message = input.value;
            input.value = '';
            input.style.height = '';

            fetch(this.action, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ message: message })
            }).then(() => {
                fetchMessages(); // instantly fetch new message
            });
        });

        // ================= KANBAN SYSTEM =================
        let lastKanbanCount = null;

        function switchTab(tab) {
            document.getElementById('content-chat').classList.add('hidden');
            document.getElementById('content-kanban').classList.add('hidden');
            document.getElementById('tab-chat').className = 'relative flex-1 py-3 text-xs font-bold uppercase tracking-wider text-slate-500 hover:text-slate-300 border-b-2 border-transparent transition-colors';
            document.getElementById('tab-kanban').className = 'relative flex-1 py-3 text-xs font-bold uppercase tracking-wider text-slate-500 hover:text-slate-300 border-b-2 border-transparent transition-colors';

            document.getElementById('content-' + tab).classList.remove('hidden');
            document.getElementById('tab-' + tab).className = 'relative flex-1 py-3 text-xs font-bold uppercase tracking-wider text-sky-400 border-b-2 border-sky-400 transition-colors';

            activeTab = tab;
            if (tab === 'chat') { unreadChat = 0; updateBadge('badge-chat', 0); }
            if (tab === 'kanban') { unreadKanban = 0; updateBadge('badge-kanban', 0); loadKanbanTasks(); }
        }

        function loadKanbanTasks() {
            fetch(`${API_BASE}/kanban`)
                .then(res => res.json())
                .then(tasks => {
                    document.querySelectorAll('.kanban-column').forEach(col => col.innerHTML = '');
                    const counts = { todo: 0, in_progress: 0, review: 0, done: 0 };

                    tasks.forEach(task => {
                        const col = document.getElementById('col-' + task.status);
                        if (col) {
                            counts[task.status]++;
                            const badgeColor = task.created_by === 'mentor' ? 'bg-bronze-500 text-white' : 'bg-slate-700 text-slate-300';
                            const badgeText = task.created_by === 'mentor' ? 'Docente' : 'Grupo';

                            // Store task payload as data attribute for easy editing
                            const taskDataStr = JSON.stringify(task).replace(/"/g, '&quot;');

                            col.innerHTML += `
                            <div id="task-${task.id}" class="bg-slate-800 border border-slate-700 p-3 rounded-lg shadow-sm cursor-grab active:cursor-grabbing hover:border-sky-500 transition-colors animate-pop group" draggable="true" ondragstart="drag(event)">
                                <div class="flex justify-between items-start mb-2" onclick="openKanbanMoveModal(${task.id})">
                                    <h4 class="text-sm font-bold text-slate-200 leading-tight">${task.title}</h4>
                                </div>
                                ${task.description ? `<p class="text-xs text-slate-400 mb-3 line-clamp-2" onclick="openKanbanMoveModal(${task.id})">${task.description}</p>` : ''}
                                <div class="flex items-center justify-between mt-2">
                                    <span class="text-[9px] font-bold px-2 py-0.5 rounded ${badgeColor}">${badgeText}</span>
                                    <div class="flex items-center gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                                        <button onclick="editKanbanTask('${taskDataStr}')" class="p-1 hover:bg-slate-700 text-slate-400 hover:text-sky-400 rounded transition-colors" title="Editar">
                                            <i data-lucide="edit-2" class="w-3.5 h-3.5"></i>
                                        </button>
                                        <button onclick="deleteKanbanTask(${task.id})" class="p-1 hover:bg-slate-700 text-slate-400 hover:text-rose-400 rounded transition-colors" title="Apagar">
                                            <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>`;
                        }
                    });

                    for (let status in counts) {
                        const el = document.getElementById('count-' + status);
                        if (el) el.innerText = counts[status];
                    }

                    // Notifica se houve novas tarefas desde a última verificação (e não estamos na tab kanban)
                    const total = tasks.length;
                    if (lastKanbanCount !== null && total > lastKanbanCount && activeTab !== 'kanban') {
                        unreadKanban += (total - lastKanbanCount);
                        updateBadge('badge-kanban', unreadKanban);
                    }
                    lastKanbanCount = total;

                    // Re-renderizar os ícones do Lucide após injetar o HTML dinâmico
                    if (typeof lucide !== 'undefined') {
                        lucide.createIcons();
                    }
                });
        }

        // Verifica periodicamente novas tarefas mesmo fora da tab kanban, para o badge funcionar
        setInterval(loadKanbanTasks, 8000);
        loadKanbanTasks();

        // Drag and Drop
        function allowDrop(ev) {
            ev.preventDefault();
            ev.currentTarget.classList.add('bg-slate-800/50');
        }

        function drop(ev) {
            ev.preventDefault();
            document.querySelectorAll('.kanban-column').forEach(c => c.classList.remove('bg-slate-800/50'));

            let targetCol = ev.target.closest('.kanban-column');
            if (!targetCol) return;

            const taskIdFull = ev.dataTransfer.getData("text");
            const taskEl = document.getElementById(taskIdFull);
            if (taskEl) {
                const taskId = taskIdFull.replace('task-', '');
                const status = targetCol.getAttribute('data-status');

                // Optimização optimista (muda no DOM imediatamente)
                targetCol.appendChild(taskEl);

                fetch(`${API_BASE}/kanban/${taskId}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ status: status })
                }).then(() => loadKanbanTasks());
            }
        }

        // ================= KANBAN MOVE MODAL (MOBILE) =================
        function openKanbanMoveModal(taskId) {
            if (window.innerWidth >= 768) return; // Apenas mobile
            document.getElementById('move-task-id').value = taskId;
            document.getElementById('kanban-move-modal').classList.remove('hidden');
            setTimeout(() => {
                document.getElementById('kanban-move-modal').classList.remove('opacity-0');
                document.getElementById('kanban-move-content').classList.remove('translate-y-full', 'sm:translate-y-0');
            }, 10);
        }

        function closeKanbanMoveModal() {
            document.getElementById('kanban-move-modal').classList.add('opacity-0');
            document.getElementById('kanban-move-content').classList.add('translate-y-full', 'sm:translate-y-0');
            setTimeout(() => {
                document.getElementById('kanban-move-modal').classList.add('hidden');
            }, 300);
        }

        function moveTaskTo(status) {
            const taskId = document.getElementById('move-task-id').value;
            fetch(`${API_BASE}/kanban/${taskId}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ status: status })
            }).then(() => {
                closeKanbanMoveModal();
                loadKanbanTasks();
            });
        }

        function drag(ev) {
            ev.dataTransfer.setData("text", ev.target.id);
        }

        document.querySelectorAll('.kanban-column').forEach(col => {
            col.addEventListener('dragleave', (e) => {
                e.currentTarget.classList.remove('bg-slate-800/50');
            });
        });

        // Kanban Modal
        function openKanbanModal() {
            document.getElementById('kanban-modal').classList.remove('hidden');
            setTimeout(() => document.getElementById('kanban-modal').classList.remove('opacity-0'), 10);
            document.getElementById('kanban-title').focus();
        }

        function editKanbanTask(taskStr) {
            const task = JSON.parse(taskStr.replace(/&quot;/g, '"'));
            document.getElementById('kanban-task-id').value = task.id;
            document.getElementById('kanban-title').value = task.title;
            document.getElementById('kanban-description').value = task.description || '';
            document.getElementById('kanban-status').value = task.status;
            openKanbanModal();
        }

        function deleteKanbanTask(taskId) {
            Swal.fire({
                title: 'Tem a certeza?',
                text: "Esta tarefa será apagada permanentemente!",
                icon: 'warning',
                showCancelButton: true,
                background: '#0f172a', color: '#f8fafc',
                confirmButtonColor: '#e11d48', cancelButtonColor: '#475569',
                confirmButtonText: 'Sim, Apagar', cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`${API_BASE}/kanban/${taskId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    }).then(() => loadKanbanTasks());
                }
            });
        }

        function closeKanbanModal() {
            document.getElementById('kanban-modal').classList.add('opacity-0');
            setTimeout(() => {
                document.getElementById('kanban-modal').classList.add('hidden');
                document.getElementById('kanban-form').reset();
                document.getElementById('kanban-task-id').value = '';
            }, 300);
        }

        function submitKanbanTask(e) {
            e.preventDefault();
            const taskId = document.getElementById('kanban-task-id').value;
            const payload = {
                title: document.getElementById('kanban-title').value,
                description: document.getElementById('kanban-description').value,
                status: document.getElementById('kanban-status').value
            };

            const url = taskId
                ? `${API_BASE}/kanban/${taskId}`
                : `${API_BASE}/kanban`;
            const method = taskId ? 'PUT' : 'POST';

            fetch(url, {
                method: method,
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify(payload)
            }).then(() => {
                closeKanbanModal();
                loadKanbanTasks();
            });
        }
        // ================= INTELIGÊNCIA ARTIFICIAL =================
        function showAILoading() {
            Swal.fire({
                title: 'Assistente IA a Processar...',
                html: '<div class="text-slate-400 text-sm mt-2 mb-4">Por favor aguarde enquanto a Inteligência Artificial analisa o contexto do projeto.</div><div class="flex justify-center"><i data-lucide="loader-2" class="w-8 h-8 text-indigo-500 animate-spin"></i></div>',
                background: '#0b0f19',
                color: '#fff',
                showConfirmButton: false,
                allowOutsideClick: false,
                width: window.innerWidth < 640 ? '90%' : '500px',
                customClass: {
                    popup: 'border border-slate-800 rounded-2xl p-4 sm:p-6 text-center'
                },
                didOpen: () => { 
                    lucide.createIcons();
                }
            });
        }

        function aiSuggestTasks() {
            showAILoading();
            fetch(`${API_BASE}/ai/suggest-tasks`, {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
            })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            iconHtml: '<div class="w-20 h-20 rounded-full bg-indigo-500/20 flex items-center justify-center border border-indigo-500/30"><i data-lucide="sparkles" class="w-10 h-10 text-indigo-400"></i></div>',
                            customClass: { icon: 'border-none mx-auto mb-4' },
                            title: 'Tarefas Criadas!',
                            text: 'A IA sugeriu novas tarefas e colocou-as na coluna "A Fazer"!',
                            background: '#0b0f19', color: '#fff',
                            confirmButtonColor: '#4f46e5',
                            didOpen: () => lucide.createIcons()
                        });
                        loadKanbanTasks();
                    } else {
                        Swal.fire({ icon: 'error', title: 'Oops...', text: data.error || data.raw, background: '#0b0f19', color: '#fff' });
                    }
                })
                .catch(() => Swal.fire({ icon: 'error', title: 'Erro de rede', text: 'Não foi possível contactar a IA.', background: '#0b0f19', color: '#fff' }));
        }

        function aiSummarize() {
            showAILoading();
            fetch(`${API_BASE}/ai/summarize`)
                .then(res => res.json())
                .then(data => {
                    Swal.fire({
                        iconHtml: '<div class="w-16 h-16 rounded-full bg-indigo-500/20 flex items-center justify-center border border-indigo-500/30"><i data-lucide="brain" class="w-8 h-8 text-indigo-400"></i></div>',
                        customClass: { icon: 'border-none mx-auto mb-4', htmlContainer: 'mt-4' },
                        title: 'Análise de Progresso IA',
                        html: `<div class="text-sm text-left leading-relaxed text-slate-300 max-h-[60vh] overflow-y-auto scrollbar-thin pr-2 prose prose-invert prose-p:mb-2 prose-strong:text-indigo-400">${data.summary}</div>`,
                        background: '#0b0f19', color: '#fff',
                        confirmButtonColor: '#4f46e5',
                        width: window.innerWidth < 640 ? '95%' : '600px',
                        didOpen: () => lucide.createIcons()
                    });
                })
                .catch(() => Swal.fire({ icon: 'error', title: 'Erro', text: 'Não foi possível gerar o resumo.', background: '#0b0f19', color: '#fff' }));
        }

        function aiAnalyzeChat() {
            showAILoading();
            fetch(`${API_BASE}/ai/analyze-chat`)
                .then(res => res.json())
                .then(data => {
                    Swal.fire({
                        iconHtml: '<div class="w-16 h-16 rounded-full bg-indigo-500/20 flex items-center justify-center border border-indigo-500/30"><i data-lucide="lightbulb" class="w-8 h-8 text-indigo-400"></i></div>',
                        customClass: { icon: 'border-none mx-auto mb-4', htmlContainer: 'mt-4' },
                        title: 'Análise da Conversa IA',
                        html: `<div class="text-sm text-left leading-relaxed text-slate-300 max-h-[60vh] overflow-y-auto scrollbar-thin pr-2 prose prose-invert prose-p:mb-2 prose-strong:text-indigo-400">${data.analysis}</div>`,
                        background: '#0b0f19', color: '#fff',
                        confirmButtonColor: '#4f46e5',
                        width: window.innerWidth < 640 ? '95%' : '600px',
                        didOpen: () => lucide.createIcons()
                    });
                })
                .catch(() => Swal.fire({ icon: 'error', title: 'Erro', text: 'Falha ao analisar a conversa.', background: '#0b0f19', color: '#fff' }));
        }
        function aiAskAssistant() {
            const input = document.getElementById('message-input');
            const message = input.value.trim();
            if (!message) {
                Swal.fire({ icon: 'warning', title: 'Mensagem Vazia', text: 'Escreva uma pergunta ou pedido no chat antes de clicar no Assistente IA.', background: '#0b0f19', color: '#fff' });
                return;
            }

            input.value = ''; // Limpa o input
            document.getElementById('chat-box').style.height = ''; // Reseta altura textarea

            // Mostrar "a escrever..."
            const typingIndicator = document.getElementById('typing-indicator');
            typingIndicator.classList.remove('hidden');
            const chatBox = document.getElementById('messages-container');
            if (chatBox) chatBox.scrollTop = chatBox.scrollHeight;

            fetch(`${API_BASE}/ai/ask`, {
                method: 'POST',
                headers: { 
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ message: message })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    typingIndicator.classList.add('hidden');
                    
                    if (data.suggestion) {
                        // É o Docente! A IA devolveu um rascunho para ser editado.
                        input.value = data.suggestion;
                        input.style.height = ''; // Reset para recalcular
                        input.style.height = input.scrollHeight + 'px'; // Ajusta altura ao conteúdo
                        input.focus(); // Coloca o cursor para o docente editar
                    } else {
                        // É o Aluno! A IA publicou diretamente no chat.
                        fetchMessages(); // Buscar a resposta da IA e atualizar o chat sem reload
                    }
                } else {
                    typingIndicator.classList.add('hidden');
                    input.value = message; // Devolver a mensagem à caixa de input para tentar novamente
                    Swal.fire({ icon: 'error', title: 'Oops...', text: data.error, background: '#0b0f19', color: '#fff' });
                }
            })
            .catch(() => {
                typingIndicator.classList.add('hidden');
                input.value = message; // Devolver a mensagem à caixa de input para tentar novamente
                Swal.fire({ icon: 'error', title: 'Erro de rede', text: 'Não foi possível contactar a IA.', background: '#0b0f19', color: '#fff' });
            });
        }
        function deleteMessage(messageId) {
            Swal.fire({
                title: 'Eliminar mensagem?',
                text: "Esta ação não pode ser revertida!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#334155',
                confirmButtonText: 'Sim, eliminar',
                cancelButtonText: 'Cancelar',
                background: '#0b0f19',
                color: '#fff'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`${API_BASE}/messages/${messageId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            window.location.reload(); // Recarregar para mostrar que desapareceu
                        } else {
                            Swal.fire({ icon: 'error', title: 'Erro', text: data.error, background: '#0b0f19', color: '#fff' });
                        }
                    });
                }
            });
        }

        function editMessage(messageId, currentText) {
            Swal.fire({
                title: 'Editar mensagem',
                input: 'textarea',
                inputValue: currentText,
                showCancelButton: true,
                confirmButtonColor: '#0ea5e9',
                cancelButtonColor: '#334155',
                confirmButtonText: 'Guardar',
                cancelButtonText: 'Cancelar',
                background: '#0b0f19',
                color: '#fff',
                inputValidator: (value) => {
                    if (!value) {
                        return 'A mensagem não pode estar vazia!';
                    }
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`${API_BASE}/messages/${messageId}`, {
                        method: 'PUT',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({ message: result.value })
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            window.location.reload();
                        } else {
                            Swal.fire({ icon: 'error', title: 'Erro', text: data.error, background: '#0b0f19', color: '#fff' });
                        }
                    });
                }
            });
        }

        function toggleAiAutoReply(isActive) {
            fetch(`${API_BASE}/ai/toggle-auto-reply`, {
                method: 'POST',
                headers: { 
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ active: isActive })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        icon: isActive ? 'success' : 'info',
                        title: isActive ? 'Piloto Automático IA ativado' : 'Piloto Automático IA desativado',
                        background: '#0b0f19', color: '#fff'
                    });
                }
            });
        }
        function previewFile(url, fileName, ext) {
            let htmlContent = '';
            
            if (['png', 'jpg', 'jpeg', 'gif', 'webp'].includes(ext.toLowerCase())) {
                htmlContent = `<div class="flex justify-center bg-slate-900 rounded-lg p-2"><img src="${url}" alt="${fileName}" class="max-w-full max-h-[50vh] sm:max-h-[70vh] rounded shadow-lg object-contain"></div>`;
            } else if (ext.toLowerCase() === 'pdf') {
                htmlContent = `<iframe src="${url}" class="w-full h-[50vh] sm:h-[70vh] border-0 rounded-lg bg-white"></iframe>`;
            } else if (['mp4', 'webm', 'ogg'].includes(ext.toLowerCase())) {
                htmlContent = `<video controls class="w-full max-h-[50vh] sm:max-h-[70vh] rounded-lg bg-black"><source src="${url}" type="video/${ext}">O seu navegador não suporta vídeos.</video>`;
            } else if (['txt', 'csv', 'json', 'md'].includes(ext.toLowerCase())) {
                htmlContent = `<iframe src="${url}" class="w-full h-[50vh] sm:h-[70vh] border-0 rounded-lg bg-slate-900 text-slate-300"></iframe>`;
            } else {
                Swal.fire({
                    icon: 'info',
                    title: 'Pré-visualização Indisponível',
                    text: `Não é possível pré-visualizar ficheiros do tipo .${ext} no navegador. Por favor, descarregue o ficheiro para o visualizar.`,
                    background: '#0b0f19',
                    color: '#fff',
                    confirmButtonColor: '#0ea5e9'
                });
                return;
            }

            Swal.fire({
                title: fileName,
                html: htmlContent,
                width: window.innerWidth < 640 ? '95%' : '80%',
                background: '#0b0f19',
                color: '#fff',
                showCloseButton: true,
                showConfirmButton: false,
                customClass: {
                    title: 'text-sm sm:text-lg font-bold text-sky-400 mb-2 sm:mb-4 truncate px-4',
                    popup: 'border border-slate-800 rounded-2xl p-2 sm:p-4',
                    closeButton: 'text-slate-400 hover:text-white',
                    htmlContainer: 'm-0 p-0'
                }
            });
        }
    </script>
</body>

</html>