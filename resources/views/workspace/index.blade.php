<!DOCTYPE html>
<html lang="pt-PT" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Workspace | {{ $candidatura->project_name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ asset('style.css') }}">
    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        slate: { 950: '#070a13', 900: '#0b0f19', 800: '#121929', 750: '#182238', 700: '#1e293b' },
                        sky: { 400: '#38bdf8', 500: '#008ad2' },
                        amber: { 500: '#c27a1e' }
                    }
                }
            }
        }
    </script>
</head>
<body class="min-h-screen bg-slate-950 text-slate-100 flex flex-col relative antialiased h-screen overflow-hidden">
    
    <div class="glow-blob-blue"></div>
    
    <!-- HEADER -->
    <header class="relative z-10 w-full px-6 py-4 border-b border-slate-900 bg-slate-950/80 backdrop-blur-md flex items-center justify-between">
        <div class="flex items-center gap-4">
            <div class="w-10 h-10 bg-slate-900/60 p-1.5 rounded-xl border border-slate-800 flex items-center justify-center">
                <i data-lucide="terminal" class="w-5 h-5 text-sky-400"></i>
            </div>
            <div>
                <h1 class="text-lg font-bold text-white font-display">Workspace: {{ $candidatura->project_name }}</h1>
                <p class="text-[11px] text-slate-400 font-mono">ID: #{{ $candidatura->id }} | Status: <span class="text-emerald-400">{{ $candidatura->status }}</span></p>
            </div>
        </div>
        
        <div class="flex gap-3">
            @if($isStudent)
                <a href="{{ route('candidatura.pdf', $candidatura->id) }}" target="_blank" class="px-3 py-1.5 bg-sky-500/10 border border-sky-500/30 hover:bg-sky-500/20 text-sky-400 rounded-lg text-xs font-bold flex items-center gap-1.5 transition-colors">
                    <i data-lucide="download" class="w-3.5 h-3.5"></i> Baixar Comprovativo PDF
                </a>
            @endif
            @if($isAdmin)
                @if($isViewer)
                    <span class="px-3 py-1.5 bg-rose-500/10 border border-rose-500/30 text-rose-500 rounded-lg text-xs font-bold flex items-center gap-1.5">
                        <i data-lucide="eye" class="w-3.5 h-3.5"></i> Vista de Leitura
                    </span>
                @else
                    <span class="px-3 py-1.5 bg-amber-500/10 border border-amber-500/30 text-amber-500 rounded-lg text-xs font-bold flex items-center gap-1.5">
                        <i data-lucide="shield-check" class="w-3.5 h-3.5"></i> Vista de Mentor
                    </span>
                @endif
                <a href="{{ route('admin.dashboard') }}" class="px-3 py-1.5 bg-slate-900 border border-slate-800 hover:border-slate-700 text-slate-300 rounded-lg text-xs font-semibold flex items-center transition-colors">Voltar</a>
            @else
                <a href="{{ route('portal.index') }}" class="px-3 py-1.5 bg-slate-900 border border-slate-800 hover:border-slate-700 text-slate-300 rounded-lg text-xs font-semibold flex items-center transition-colors">Sair da Sala</a>
            @endif
        </div>
    </header>

    <!-- MAIN -->
    <main class="relative z-10 flex-grow w-full mx-auto px-2 md:px-6 py-4 flex flex-col md:flex-row gap-6 h-[calc(100vh-80px)] overflow-y-auto md:overflow-hidden">
        
        <!-- SIDEBAR LEFT: Info & Timeline (25%) -->
        <aside class="w-full md:w-[25%] lg:w-[20%] flex flex-col gap-6 flex-shrink-0">
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
                        <span class="text-[10px] uppercase font-bold text-slate-500 font-mono mb-2 block">Membros do Grupo</span>
                        <ul class="text-xs text-slate-300 space-y-1.5">
                            <li><span class="text-white">{{ $candidatura->member1_name }}</span> <span class="text-slate-500 ml-1">{{ $candidatura->member1_code }}</span></li>
                            <li><span class="text-white">{{ $candidatura->member2_name }}</span> <span class="text-slate-500 ml-1">{{ $candidatura->member2_code }}</span></li>
                            @if($candidatura->member3_name)
                                <li><span class="text-white">{{ $candidatura->member3_name }}</span> <span class="text-slate-500 ml-1">{{ $candidatura->member3_code }}</span></li>
                            @endif
                            @if($candidatura->member4_name)
                                <li><span class="text-white">{{ $candidatura->member4_name }}</span> <span class="text-slate-500 ml-1">{{ $candidatura->member4_code }}</span></li>
                            @endif
                        </ul>
                    </div>
                </div>
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
                <div class="space-y-4">
                    @foreach($fases as $key => $label)
                        @php
                            $estado = $estados[$key]->estado ?? 'pendente';
                            $icon = $estado == 'concluida' ? 'check-circle' : ($estado == 'em_progresso' ? 'circle-dot' : 'circle');
                            $color = $estado == 'concluida' ? 'text-emerald-400' : ($estado == 'em_progresso' ? 'text-sky-400' : 'text-slate-600');
                        @endphp
                        <div class="flex items-start gap-3 relative">
                            <i data-lucide="{{ $icon }}" class="w-5 h-5 {{ $color }} mt-0.5 flex-shrink-0 relative z-10 bg-slate-950"></i>
                            <div>
                                <p class="text-xs font-bold text-white">{{ $label }}</p>
                                <p class="text-[10px] text-slate-500 uppercase font-mono tracking-wider">{{ str_replace('_', ' ', $estado) }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>

                @if($isAdmin && !$isViewer)
                    <div class="mt-6 pt-4 border-t border-slate-800">
                        <form action="{{ route('workspace.fase', $candidatura->id) }}" method="POST" class="space-y-2">
                            @csrf
                            <select name="fase" class="w-full bg-slate-900 border border-slate-700 rounded-lg text-xs p-2 text-slate-200 outline-none focus:border-sky-500 transition-colors">
                                @foreach($fases as $key => $label)
                                    <option value="{{ $key }}">{{ $label }}</option>
                                @endforeach
                            </select>
                            <select name="estado" class="w-full bg-slate-900 border border-slate-700 rounded-lg text-xs p-2 text-slate-200 outline-none focus:border-sky-500 transition-colors">
                                <option value="pendente">Pendente</option>
                                <option value="em_progresso">Em Progresso</option>
                                <option value="concluida">Concluída</option>
                            </select>
                            <textarea name="mensagem" rows="2" placeholder="Observação / Feedback (Opcional)..." class="w-full bg-slate-900 border border-slate-700 rounded-lg text-xs p-2 text-slate-200 outline-none focus:border-sky-500 transition-colors resize-none"></textarea>
                            <button type="submit" class="w-full py-2 bg-sky-600 hover:bg-sky-500 text-white rounded-lg text-xs font-bold transition-colors">Actualizar Fase</button>
                        </form>
                    </div>
                @endif
            </div>
        </aside>

        <!-- CENTER: CHAT & KANBAN AREA (55%) -->
        <section class="w-full md:w-[50%] lg:w-[60%] glass-panel rounded-2xl border border-slate-800/80 flex flex-col overflow-hidden relative shadow-2xl">
            
            <!-- TABS HEADER -->
            <div class="flex border-b border-slate-800 bg-slate-900/50">
                <button onclick="switchTab('chat')" id="tab-chat" class="flex-1 py-3 text-xs font-bold uppercase tracking-wider text-sky-400 border-b-2 border-sky-400 transition-colors">
                    <i data-lucide="message-square" class="w-4 h-4 inline-block mr-1"></i> Chat
                </button>
                <button onclick="switchTab('kanban')" id="tab-kanban" class="flex-1 py-3 text-xs font-bold uppercase tracking-wider text-slate-500 hover:text-slate-300 border-b-2 border-transparent transition-colors">
                    <i data-lucide="kanban" class="w-4 h-4 inline-block mr-1"></i> Quadro Kanban
                </button>
            </div>

            <!-- TAB CONTENT: CHAT -->
            <div id="content-chat" class="flex-grow flex flex-col overflow-hidden">
                <!-- Chat Messages -->
                <div class="flex-grow p-4 md:p-6 overflow-y-auto space-y-4" id="chat-box" data-last-id="{{ $messages->last()->id ?? 0 }}">
                    
                    <!-- Welcome Message -->
                    <div class="flex justify-center mb-6">
                        <span class="text-[10px] uppercase font-bold text-slate-500 font-mono bg-slate-900/50 px-3 py-1 rounded-full border border-slate-800">
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
                    
                    <!-- Messages Container -->
                    <div id="messages-container" class="space-y-4">
                        @foreach($messages as $msg)
                            @if($msg->sender_type === 'mentor')
                                <!-- Mentor Message (Left) -->
                                <div class="flex items-start gap-3 w-4/5">
                                    <div class="w-8 h-8 rounded-full bg-amber-500 flex items-center justify-center flex-shrink-0 shadow-lg shadow-amber-500/20">
                                        <i data-lucide="graduation-cap" class="w-4 h-4 text-white"></i>
                                    </div>
                                    <div>
                                        <div class="flex items-baseline gap-2 mb-1">
                                            <span class="text-xs font-bold text-amber-500">Docente Mentor</span>
                                            <span class="text-[10px] text-slate-500">{{ $msg->created_at->format('H:i') }}</span>
                                        </div>
                                        <div class="p-3 bg-slate-800 border border-slate-700 rounded-2xl rounded-tl-sm text-sm text-slate-200 whitespace-pre-wrap">{{ $msg->message }}</div>
                                    </div>
                                </div>
                            @else
                                <!-- Student Message (Right) -->
                                <div class="flex items-start gap-3 w-4/5 ml-auto justify-end">
                                    <div class="text-right">
                                        <div class="flex items-baseline gap-2 mb-1 justify-end">
                                            <span class="text-[10px] text-slate-500">{{ $msg->created_at->format('H:i') }}</span>
                                            <span class="text-xs font-bold text-sky-400">Grupo: {{ $candidatura->project_name }}</span>
                                        </div>
                                        <div class="p-3 bg-sky-600 border border-sky-500 rounded-2xl rounded-tr-sm text-sm text-white whitespace-pre-wrap text-left">{{ $msg->message }}</div>
                                    </div>
                                    <div class="w-8 h-8 rounded-full bg-slate-800 border border-slate-700 flex items-center justify-center flex-shrink-0">
                                        <i data-lucide="users" class="w-4 h-4 text-sky-400"></i>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>

                <!-- Input Area -->
                @if(!$isViewer)
                <div class="p-4 border-t border-slate-800 bg-slate-900/50 backdrop-blur-sm">
                    <form id="chat-form" action="{{ route('workspace.message', $candidatura->id) }}" method="POST" class="flex gap-2">
                        @csrf
                        <textarea name="message" id="message-input" rows="1" placeholder="Escreva uma mensagem..." required
                            class="w-full bg-slate-950 border border-slate-800 focus:border-sky-500 focus:outline-none rounded-xl px-4 py-3 text-sm text-slate-200 resize-none transition-colors overflow-hidden" 
                            oninput="this.style.height = ''; this.style.height = this.scrollHeight + 'px'"></textarea>
                        
                        <button type="submit" class="w-12 h-12 bg-sky-600 hover:bg-sky-500 text-white rounded-xl flex items-center justify-center flex-shrink-0 transition-colors shadow-lg shadow-sky-500/20">
                            <i data-lucide="send" class="w-5 h-5 ml-1"></i>
                        </button>
                    </form>
                </div>
                @else
                <div class="p-4 border-t border-slate-800 bg-slate-900/50 backdrop-blur-sm text-center text-xs text-slate-500">
                    Modo de visualização. Apenas estudantes e o mentor atribuído podem enviar mensagens.
                </div>
                @endif
            </div>

            <!-- TAB CONTENT: KANBAN -->
            <div id="content-kanban" class="hidden flex-grow flex flex-col overflow-hidden bg-slate-950">
                <!-- Kanban Toolbar -->
                <div class="p-3 border-b border-slate-800 flex justify-between items-center bg-slate-900/30">
                    <h3 class="text-xs font-bold text-slate-300 font-mono uppercase">Gestão de Tarefas</h3>
                    @if(!$isViewer)
                    <button onclick="openKanbanModal()" class="px-3 py-1.5 bg-sky-500/10 border border-sky-500/30 hover:bg-sky-500/20 text-sky-400 rounded-lg text-xs font-bold flex items-center gap-1 transition-colors">
                        <i data-lucide="plus" class="w-3.5 h-3.5"></i> Nova Tarefa
                    </button>
                    @endif
                </div>

                <!-- Kanban Board (Scrollable Container) -->
                <div class="flex-grow p-4 overflow-x-auto overflow-y-hidden flex gap-4 kanban-container scrollbar-thin">
                    
                    <!-- Coluna: A Fazer -->
                    <div class="w-64 flex-shrink-0 flex flex-col bg-slate-900/50 border border-slate-800/80 rounded-xl overflow-hidden h-full">
                        <div class="p-3 border-b border-slate-800 flex items-center justify-between bg-slate-800/30">
                            <span class="text-xs font-bold text-slate-300 uppercase tracking-wider flex items-center gap-1.5">
                                <span class="w-2 h-2 rounded-full bg-slate-500"></span> A Fazer
                            </span>
                        </div>
                        <div class="flex-grow p-2 overflow-y-auto space-y-2 kanban-column" data-status="todo" id="col-todo" ondrop="drop(event)" ondragover="allowDrop(event)">
                        </div>
                    </div>

                    <!-- Coluna: Em Progresso -->
                    <div class="w-64 flex-shrink-0 flex flex-col bg-slate-900/50 border border-slate-800/80 rounded-xl overflow-hidden h-full">
                        <div class="p-3 border-b border-slate-800 flex items-center justify-between bg-slate-800/30">
                            <span class="text-xs font-bold text-sky-400 uppercase tracking-wider flex items-center gap-1.5">
                                <span class="w-2 h-2 rounded-full bg-sky-500"></span> Em Progresso
                            </span>
                        </div>
                        <div class="flex-grow p-2 overflow-y-auto space-y-2 kanban-column" data-status="in_progress" id="col-in_progress" ondrop="drop(event)" ondragover="allowDrop(event)">
                        </div>
                    </div>

                    <!-- Coluna: Em Revisão -->
                    <div class="w-64 flex-shrink-0 flex flex-col bg-slate-900/50 border border-slate-800/80 rounded-xl overflow-hidden h-full">
                        <div class="p-3 border-b border-slate-800 flex items-center justify-between bg-slate-800/30">
                            <span class="text-xs font-bold text-amber-400 uppercase tracking-wider flex items-center gap-1.5">
                                <span class="w-2 h-2 rounded-full bg-amber-500"></span> Em Revisão
                            </span>
                        </div>
                        <div class="flex-grow p-2 overflow-y-auto space-y-2 kanban-column" data-status="review" id="col-review" ondrop="drop(event)" ondragover="allowDrop(event)">
                        </div>
                    </div>

                    <!-- Coluna: Concluído -->
                    <div class="w-64 flex-shrink-0 flex flex-col bg-slate-900/50 border border-slate-800/80 rounded-xl overflow-hidden h-full">
                        <div class="p-3 border-b border-slate-800 flex items-center justify-between bg-slate-800/30">
                            <span class="text-xs font-bold text-emerald-400 uppercase tracking-wider flex items-center gap-1.5">
                                <span class="w-2 h-2 rounded-full bg-emerald-500"></span> Concluído
                            </span>
                        </div>
                        <div class="flex-grow p-2 overflow-y-auto space-y-2 kanban-column" data-status="done" id="col-done" ondrop="drop(event)" ondragover="allowDrop(event)">
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <!-- SIDEBAR RIGHT: Files (25%) -->
        <aside class="w-full md:w-[25%] lg:w-[20%] glass-panel rounded-2xl border border-slate-800/80 p-5 flex flex-col hidden md:flex">
            <h3 class="text-sm font-bold text-white mb-4 flex items-center gap-2 border-b border-slate-800 pb-2">
                <i data-lucide="folder" class="w-4 h-4 text-sky-400"></i> Ficheiros e Recursos
            </h3>
            
            <div class="flex-grow overflow-y-auto space-y-3">
                @forelse($candidatura->ficheiros as $f)
                    @php
                        $ext = strtolower(pathinfo($f->nome_ficheiro, PATHINFO_EXTENSION));
                        $icon = 'file';
                        $iconColor = 'text-slate-400';
                        if(in_array($ext, ['pdf'])) { $icon = 'file-text'; $iconColor = 'text-rose-400'; }
                        elseif(in_array($ext, ['zip', 'rar', 'tar'])) { $icon = 'file-archive'; $iconColor = 'text-amber-400'; }
                        elseif(in_array($ext, ['png', 'jpg', 'jpeg', 'gif'])) { $icon = 'image'; $iconColor = 'text-sky-400'; }
                        elseif(in_array($ext, ['doc', 'docx'])) { $icon = 'file-text'; $iconColor = 'text-blue-500'; }
                    @endphp
                    <div class="p-3 bg-slate-900/50 border border-slate-800 rounded-xl flex items-center justify-between group hover:border-sky-500/50 transition-colors">
                        <div class="flex items-center gap-3 overflow-hidden pr-2">
                            <i data-lucide="{{ $icon }}" class="w-6 h-6 {{ $iconColor }} flex-shrink-0"></i>
                            <div class="overflow-hidden">
                                <p class="text-xs text-white truncate" title="{{ $f->nome_ficheiro }}">{{ $f->nome_ficheiro }}</p>
                                <div class="flex gap-2 items-center">
                                    <p class="text-[9px] text-slate-500 font-mono">{{ $f->created_at->format('d/m/Y') }}</p>
                                    <span class="text-[9px] px-1 bg-slate-800 rounded">{{ $f->uploaded_by }}</span>
                                </div>
                            </div>
                        </div>
                        <a href="{{ route('workspace.ficheiro.download', $f->id) }}" class="p-1.5 bg-slate-800 hover:bg-sky-600 text-sky-400 hover:text-white rounded-lg transition-colors flex-shrink-0 shadow-sm" title="Descarregar Ficheiro">
                            <i data-lucide="download" class="w-3.5 h-3.5"></i>
                        </a>
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
                <form action="{{ route('workspace.ficheiro', $candidatura->id) }}" method="POST" enctype="multipart/form-data" class="space-y-3">
                    @csrf
                    <div>
                        <input type="file" name="ficheiro" id="ficheiro" class="hidden" required>
                        <label for="ficheiro" class="w-full py-2 px-3 border border-dashed border-slate-600 hover:border-sky-500 rounded-lg flex items-center justify-center gap-2 cursor-pointer transition-colors text-xs text-slate-400 hover:text-sky-400">
                            <i data-lucide="upload-cloud" class="w-4 h-4"></i> Partilhar Ficheiro
                        </label>
                        <p id="file-name-display" class="text-[9px] text-slate-500 text-center mt-1 truncate"></p>
                    </div>
                    <button type="submit" class="w-full py-2 bg-slate-800 hover:bg-sky-600 text-white rounded-lg text-xs font-bold transition-colors">Fazer Upload</button>
                </form>
            </div>
            @endif
            <script>
                document.getElementById('ficheiro').addEventListener('change', function() {
                    const name = this.files[0] ? this.files[0].name : '';
                    document.getElementById('file-name-display').innerText = name;
                });
            </script>
        </aside>
    </main>

    <!-- KANBAN MODAL -->
    <div id="kanban-modal" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-50 flex items-center justify-center hidden opacity-0 transition-opacity duration-300">
        <div class="bg-slate-900 border border-slate-700 rounded-2xl w-full max-w-md p-6 transform scale-95 transition-transform duration-300 shadow-2xl" id="kanban-modal-content">
            <div class="flex justify-between items-center mb-5">
                <h2 class="text-lg font-bold text-white flex items-center gap-2">
                    <i data-lucide="layout-list" class="w-5 h-5 text-sky-400"></i> Nova Tarefa
                </h2>
                <button onclick="closeKanbanModal()" class="text-slate-400 hover:text-white transition-colors">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>
            
            <form id="kanban-form" onsubmit="submitKanbanTask(event)" class="space-y-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-400 uppercase mb-1">Título da Tarefa</label>
                    <input type="text" id="kanban-title" required class="w-full bg-slate-950 border border-slate-700 rounded-lg px-3 py-2 text-sm text-white focus:border-sky-500 focus:outline-none transition-colors">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-400 uppercase mb-1">Descrição (Opcional)</label>
                    <textarea id="kanban-description" rows="3" class="w-full bg-slate-950 border border-slate-700 rounded-lg px-3 py-2 text-sm text-white focus:border-sky-500 focus:outline-none transition-colors resize-none"></textarea>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-400 uppercase mb-1">Coluna Inicial</label>
                    <select id="kanban-status" class="w-full bg-slate-950 border border-slate-700 rounded-lg px-3 py-2 text-sm text-white focus:border-sky-500 focus:outline-none transition-colors">
                        <option value="todo">A Fazer</option>
                        <option value="in_progress">Em Progresso</option>
                        <option value="review">Em Revisão</option>
                        <option value="done">Concluído</option>
                    </select>
                </div>
                
                <div class="flex justify-end gap-2 mt-6">
                    <button type="button" onclick="closeKanbanModal()" class="px-4 py-2 bg-slate-800 hover:bg-slate-700 text-white rounded-lg text-sm transition-colors">Cancelar</button>
                    <button type="submit" class="px-4 py-2 bg-sky-600 hover:bg-sky-500 text-white rounded-lg text-sm font-bold transition-colors shadow-lg shadow-sky-500/20">Criar Tarefa</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        lucide.createIcons();
        
        const chatBox = document.getElementById('chat-box');
        const msgContainer = document.getElementById('messages-container');
        chatBox.scrollTop = chatBox.scrollHeight;

        // AJAX Polling
        let lastId = parseInt(chatBox.getAttribute('data-last-id')) || 0;
        const candidaturaId = {{ $candidatura->id }};
        const isAdmin = {{ $isAdmin ? 'true' : 'false' }};

        function fetchMessages() {
            fetch(`/api/workspace/${candidaturaId}/mensagens?last_id=${lastId}`)
                .then(res => res.json())
                .then(data => {
                    if(data.length > 0) {
                        const emptyState = document.getElementById('empty-chat-state');
                        if (emptyState) emptyState.remove();

                        data.forEach(msg => {
                            lastId = Math.max(lastId, msg.id);
                            chatBox.setAttribute('data-last-id', lastId);
                            
                            const date = new Date(msg.created_at);
                            const timeStr = date.getHours().toString().padStart(2, '0') + ':' + date.getMinutes().toString().padStart(2, '0');
                            
                            let html = '';
                            if (msg.sender_type === 'mentor') {
                                html = `
                                <div class="flex items-start gap-3 w-4/5 animate-fade-in">
                                    <div class="w-8 h-8 rounded-full bg-amber-500 flex items-center justify-center flex-shrink-0 shadow-lg shadow-amber-500/20">
                                        <i data-lucide="graduation-cap" class="w-4 h-4 text-white"></i>
                                    </div>
                                    <div>
                                        <div class="flex items-baseline gap-2 mb-1">
                                            <span class="text-xs font-bold text-amber-500">Docente Mentor</span>
                                            <span class="text-[10px] text-slate-500">${timeStr}</span>
                                        </div>
                                        <div class="p-3 bg-slate-800 border border-slate-700 rounded-2xl rounded-tl-sm text-sm text-slate-200 whitespace-pre-wrap">${msg.message}</div>
                                    </div>
                                </div>`;
                            } else {
                                html = `
                                <div class="flex items-start gap-3 w-4/5 ml-auto justify-end animate-fade-in">
                                    <div class="text-right">
                                        <div class="flex items-baseline gap-2 mb-1 justify-end">
                                            <span class="text-[10px] text-slate-500">${timeStr}</span>
                                            <span class="text-xs font-bold text-sky-400">Grupo: {{ addslashes($candidatura->project_name) }}</span>
                                        </div>
                                        <div class="p-3 bg-sky-600 border border-sky-500 rounded-2xl rounded-tr-sm text-sm text-white whitespace-pre-wrap text-left">${msg.message}</div>
                                    </div>
                                    <div class="w-8 h-8 rounded-full bg-slate-800 border border-slate-700 flex items-center justify-center flex-shrink-0">
                                        <i data-lucide="users" class="w-4 h-4 text-sky-400"></i>
                                    </div>
                                </div>`;
                            }
                            msgContainer.insertAdjacentHTML('beforeend', html);
                        });
                        lucide.createIcons();
                        chatBox.scrollTop = chatBox.scrollHeight;
                    }
                });
        }

        setInterval(fetchMessages, 5000); // Poll every 5s

        // Form submission via AJAX to avoid reload
        document.getElementById('chat-form').addEventListener('submit', function(e) {
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
        function switchTab(tab) {
            document.getElementById('content-chat').classList.add('hidden');
            document.getElementById('content-kanban').classList.add('hidden');
            document.getElementById('tab-chat').className = 'flex-1 py-3 text-xs font-bold uppercase tracking-wider text-slate-500 hover:text-slate-300 border-b-2 border-transparent transition-colors';
            document.getElementById('tab-kanban').className = 'flex-1 py-3 text-xs font-bold uppercase tracking-wider text-slate-500 hover:text-slate-300 border-b-2 border-transparent transition-colors';
            
            document.getElementById('content-' + tab).classList.remove('hidden');
            document.getElementById('tab-' + tab).className = 'flex-1 py-3 text-xs font-bold uppercase tracking-wider text-sky-400 border-b-2 border-sky-400 transition-colors';
            
            if (tab === 'kanban') loadKanbanTasks();
        }

        function loadKanbanTasks() {
            fetch(`/api/workspace/${candidaturaId}/kanban`)
                .then(res => res.json())
                .then(tasks => {
                    document.querySelectorAll('.kanban-column').forEach(col => col.innerHTML = '');
                    const counts = {todo: 0, in_progress: 0, review: 0, done: 0};
                    
                    tasks.forEach(task => {
                        const col = document.getElementById('col-' + task.status);
                        if(col) {
                            counts[task.status]++;
                            const badgeColor = task.created_by === 'mentor' ? 'bg-amber-500 text-white' : 'bg-slate-700 text-slate-300';
                            const badgeText = task.created_by === 'mentor' ? 'Docente' : 'Grupo';
                            
                            col.innerHTML += `
                            <div id="task-${task.id}" class="bg-slate-800 border border-slate-700 p-3 rounded-lg shadow-sm cursor-grab active:cursor-grabbing hover:border-sky-500 transition-colors" draggable="true" ondragstart="drag(event)">
                                <div class="flex justify-between items-start mb-2">
                                    <h4 class="text-sm font-bold text-slate-200 leading-tight">${task.title}</h4>
                                </div>
                                ${task.description ? `<p class="text-xs text-slate-400 mb-3 line-clamp-2">${task.description}</p>` : ''}
                                <div class="flex items-center justify-between">
                                    <span class="text-[9px] font-bold px-2 py-0.5 rounded ${badgeColor}">${badgeText}</span>
                                </div>
                            </div>`;
                        }
                    });
                    
                    for(let status in counts) {
                        const el = document.getElementById('count-' + status);
                        if(el) el.innerText = counts[status];
                    }
                });
        }

        // Drag and Drop
        function allowDrop(ev) {
            ev.preventDefault();
            ev.currentTarget.classList.add('bg-slate-800/50');
        }

        function drop(ev) {
            ev.preventDefault();
            document.querySelectorAll('.kanban-column').forEach(c => c.classList.remove('bg-slate-800/50'));
            
            let targetCol = ev.target.closest('.kanban-column');
            if(!targetCol) return;
            
            const taskIdFull = ev.dataTransfer.getData("text");
            const taskEl = document.getElementById(taskIdFull);
            if(taskEl) {
                targetCol.appendChild(taskEl);
                const taskId = taskIdFull.split('-')[1];
                const newStatus = targetCol.getAttribute('data-status');
                updateTaskStatus(taskId, newStatus);
            }
        }

        function drag(ev) {
            ev.dataTransfer.setData("text", ev.target.id);
        }

        document.querySelectorAll('.kanban-column').forEach(col => {
            col.addEventListener('dragleave', (e) => {
                e.currentTarget.classList.remove('bg-slate-800/50');
            });
        });

        function updateTaskStatus(taskId, status) {
            fetch(`/api/workspace/${candidaturaId}/kanban/${taskId}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ status: status })
            }).then(() => loadKanbanTasks());
        }

        // Kanban Modal
        function openKanbanModal() {
            document.getElementById('kanban-modal').classList.remove('hidden');
            setTimeout(() => document.getElementById('kanban-modal').classList.remove('opacity-0'), 10);
            document.getElementById('kanban-title').focus();
        }

        function closeKanbanModal() {
            document.getElementById('kanban-modal').classList.add('opacity-0');
            setTimeout(() => {
                document.getElementById('kanban-modal').classList.add('hidden');
                document.getElementById('kanban-form').reset();
            }, 300);
        }

        function submitKanbanTask(e) {
            e.preventDefault();
            const payload = {
                title: document.getElementById('kanban-title').value,
                description: document.getElementById('kanban-description').value,
                status: document.getElementById('kanban-status').value
            };
            
            fetch(`/api/workspace/${candidaturaId}/kanban`, {
                method: 'POST',
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
    </script>
    <style>
        .animate-fade-in { animation: fadeIn 0.3s ease-out forwards; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(5px); } to { opacity: 1; transform: translateY(0); } }
    </style>
</body>
</html>
