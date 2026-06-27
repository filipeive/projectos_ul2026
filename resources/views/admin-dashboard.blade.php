<!DOCTYPE html>
<html lang="pt-PT" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel de Gestão | UniLicungo TechHub</title>
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        slate: {
                            950: '#070a13',
                            900: '#0b0f19',
                            800: '#121929',
                            750: '#182238',
                            700: '#1e293b',
                            600: '#334155'
                        },
                        sky: {
                            400: '#38bdf8',
                            500: '#0ea5e9',
                            600: '#0284c7'
                        }
                    }
                }
            }
        }
    </script>
    
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
    
    <!-- Custom CSS Styles -->
    <link rel="stylesheet" href="{{ asset('style.css') }}?v=theme-20260627">
    <script src="{{ asset('theme.js') }}?v=theme-20260627"></script>
</head>
<body class="h-screen bg-slate-950 text-slate-100 flex overflow-hidden antialiased">
    
    <!-- Mobile Sidebar Overlay -->
    <div id="mobile-overlay" onclick="toggleMobileMenu()" class="fixed inset-0 bg-black/60 z-40 hidden md:hidden backdrop-blur-sm transition-opacity opacity-0"></div>

    <!-- SIDEBAR -->
    <aside id="sidebar" class="w-64 bg-slate-900 border-r border-slate-800 flex-col hidden md:flex z-50 shadow-2xl absolute md:relative h-full transition-transform transform -translate-x-full md:translate-x-0">
        <div class="absolute inset-0 bg-gradient-to-b from-sky-500/5 to-transparent pointer-events-none"></div>
        <!-- Brand -->
        <div class="h-16 flex items-center px-6 border-b border-slate-800/80 gap-3 relative">
            <div class="w-8 h-8 bg-slate-950 p-1 rounded-lg border border-slate-800 flex items-center justify-center">
                <img src="{{ asset('ul.png') }}" alt="Logo" class="w-full h-full object-contain">
            </div>
            <div>
                <h1 class="text-sm font-bold text-white leading-tight">UniLicungo</h1>
                <p class="text-[10px] text-sky-400 font-mono tracking-wider">TechHub Admin</p>
            </div>
        </div>
        
        <!-- Navigation -->
        <nav class="flex-1 p-4 space-y-1.5 overflow-y-auto relative z-10" role="tablist" aria-label="Áreas do painel administrativo">
            <div class="text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-3 px-2">Menu Principal</div>
            
            <button onclick="switchAdminTab('grupos', this)" class="w-full flex items-center gap-3 px-3 py-2.5 text-sm rounded-xl bg-sky-500/10 text-sky-400 font-semibold admin-tab-btn transition-all border border-sky-500/20" role="tab" aria-selected="true" aria-controls="tab-grupos">
                <i data-lucide="layers" class="w-4 h-4"></i> Gestão de Grupos
            </button>
            
            @if($user->role === 'admin')
            <button onclick="switchAdminTab('users', this)" class="w-full flex items-center gap-3 px-3 py-2.5 text-sm rounded-xl text-slate-400 hover:text-white hover:bg-slate-800 font-medium admin-tab-btn transition-all border border-transparent hover:border-slate-700" role="tab" aria-selected="false" aria-controls="tab-users">
                <i data-lucide="users" class="w-4 h-4"></i> Gestão de Utilizadores
            </button>
            @endif
            
            <button onclick="switchAdminTab('perfil', this)" class="w-full flex items-center gap-3 px-3 py-2.5 text-sm rounded-xl text-slate-400 hover:text-white hover:bg-slate-800 font-medium admin-tab-btn transition-all border border-transparent hover:border-slate-700" role="tab" aria-selected="false" aria-controls="tab-perfil">
                <i data-lucide="user" class="w-4 h-4"></i> Meu Perfil
            </button>
        </nav>
        
        <!-- Footer / Logout -->
        <div class="p-4 border-t border-slate-800/80 relative z-10 bg-slate-900/50">
            <form action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full flex items-center gap-3 px-3 py-2.5 text-sm rounded-xl text-rose-400 hover:bg-rose-500/10 font-medium transition-all border border-transparent hover:border-rose-500/20">
                    <i data-lucide="log-out" class="w-4 h-4"></i> Terminar Sessão
                </button>
            </form>
        </div>
    </aside>

    <!-- MAIN CONTENT -->
    <div class="flex-1 flex flex-col h-screen overflow-hidden relative">
        <!-- Background glowing ambient blobs -->
        <div class="absolute top-0 left-1/4 w-[500px] h-[500px] bg-sky-500/10 rounded-full blur-[100px] pointer-events-none"></div>
        <div class="absolute bottom-0 right-1/4 w-[500px] h-[500px] bg-indigo-500/5 rounded-full blur-[100px] pointer-events-none"></div>

        <!-- TOPBAR -->
        <header class="h-16 bg-slate-950/80 backdrop-blur-md border-b border-slate-800/80 flex justify-between items-center px-4 md:px-8 relative z-20">
            <div class="flex items-center gap-4">
                <button onclick="toggleMobileMenu()" class="md:hidden text-slate-400 hover:text-white"><i data-lucide="menu" class="w-6 h-6"></i></button>
                <h2 class="text-lg font-bold text-white tracking-wide">Dashboard Geral</h2>
            </div>
            <div class="flex items-center gap-4">
                <a href="{{ route('portal.index') }}" target="_blank" class="px-3.5 py-1.5 bg-slate-900 hover:bg-slate-800 text-slate-300 rounded-lg text-xs font-semibold flex items-center gap-1.5 transition-colors border border-slate-800 hover:border-slate-700">
                    <i data-lucide="external-link" class="w-3.5 h-3.5"></i> Portal TechHub
                </a>
                <div class="h-6 w-px bg-slate-800 hidden sm:block"></div>
                <div class="flex items-center gap-3">
                    <div class="text-right hidden sm:block">
                        <div class="text-xs text-white font-semibold">{{ $user->name }}</div>
                        <div class="text-[10px] text-sky-400 font-mono tracking-wider uppercase">{{ $user->role }}</div>
                    </div>
                    <div class="w-9 h-9 rounded-full bg-sky-500/20 text-sky-400 flex items-center justify-center font-bold text-sm border border-sky-500/30 shadow-inner">
                        {{ substr($user->name, 0, 1) }}
                    </div>
                </div>
            </div>
        </header>

        <!-- CONTENT SCROLL -->
        <main class="flex-1 overflow-y-auto p-4 md:p-8 relative z-10 custom-scrollbar">
            
            <!-- BENTO GRID STATS -->
            <div class="grid grid-cols-2 md:grid-cols-12 gap-4 mb-8">
                <!-- Total (Featured) -->
                <div class="col-span-2 md:col-span-6 glass-panel border border-slate-800/80 rounded-3xl p-6 shadow-2xl flex flex-col justify-between relative overflow-hidden group min-h-[160px]">
                    <div class="absolute -right-10 -top-10 w-40 h-40 bg-sky-500/20 rounded-full blur-3xl group-hover:bg-sky-500/30 transition-all duration-500"></div>
                    <div class="flex items-start justify-between relative z-10">
                        <span class="text-xs sm:text-sm font-bold text-sky-400 uppercase tracking-wider font-mono">Total de Inscrições</span>
                        <div class="w-12 h-12 rounded-2xl bg-sky-500/10 border border-sky-500/20 flex items-center justify-center text-sky-400 shadow-inner group-hover:scale-110 transition-transform duration-300"><i data-lucide="folders" class="w-6 h-6"></i></div>
                    </div>
                    <div class="mt-4 relative z-10">
                        <span class="text-5xl sm:text-6xl font-black text-white leading-none tracking-tight">{{ $stats['total'] }}</span>
                        <p class="text-xs text-slate-400 mt-2 font-medium">Projetos submetidos na plataforma</p>
                    </div>
                </div>

                <!-- Em Avaliação -->
                <div class="col-span-1 md:col-span-3 glass-panel border border-slate-800/80 rounded-3xl p-5 shadow-2xl flex flex-col justify-between relative overflow-hidden group">
                    <div class="absolute inset-0 bg-gradient-to-br from-amber-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <div class="absolute left-0 top-0 bottom-0 w-1 bg-amber-500/80 rounded-l-3xl"></div>
                    <div class="flex items-start justify-between relative z-10">
                        <div class="w-10 h-10 rounded-xl bg-amber-500/10 border border-amber-500/20 flex items-center justify-center text-amber-500 shadow-inner group-hover:rotate-12 transition-transform duration-300"><i data-lucide="clock" class="w-5 h-5"></i></div>
                    </div>
                    <div class="mt-4 relative z-10">
                        <span class="text-3xl sm:text-4xl font-black text-amber-500 leading-none">{{ $stats['pendente'] }}</span>
                        <span class="block text-[10px] sm:text-xs font-bold text-slate-400 uppercase tracking-wider font-mono mt-2">Pendentes</span>
                    </div>
                </div>

                <!-- Aprovados -->
                <div class="col-span-1 md:col-span-3 glass-panel border border-slate-800/80 rounded-3xl p-5 shadow-2xl flex flex-col justify-between relative overflow-hidden group">
                    <div class="absolute inset-0 bg-gradient-to-br from-emerald-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <div class="absolute left-0 top-0 bottom-0 w-1 bg-emerald-500/80 rounded-l-3xl"></div>
                    <div class="flex items-start justify-between relative z-10">
                        <div class="w-10 h-10 rounded-xl bg-emerald-500/10 border border-emerald-500/20 flex items-center justify-center text-emerald-400 shadow-inner group-hover:scale-110 transition-transform duration-300"><i data-lucide="check-circle" class="w-5 h-5"></i></div>
                    </div>
                    <div class="mt-4 relative z-10">
                        <span class="text-3xl sm:text-4xl font-black text-emerald-400 leading-none">{{ $stats['aprovado'] }}</span>
                        <span class="block text-[10px] sm:text-xs font-bold text-slate-400 uppercase tracking-wider font-mono mt-2">Aprovados</span>
                    </div>
                </div>

                <!-- Rejeitados -->
                <div class="col-span-1 md:col-span-3 lg:col-span-12 glass-panel border border-slate-800/80 rounded-3xl p-3 sm:p-5 shadow-2xl flex flex-col lg:flex-row lg:items-center justify-between relative overflow-hidden group">
                    <div class="absolute inset-0 bg-gradient-to-br from-rose-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <div class="absolute left-0 top-0 bottom-0 w-1 bg-rose-500/80 rounded-l-3xl"></div>
                    <div class="flex items-center gap-4 relative z-10">
                        <div class="w-10 h-10 rounded-xl bg-rose-500/10 border border-rose-500/20 flex items-center justify-center text-rose-400 shadow-inner"><i data-lucide="x-circle" class="w-5 h-5"></i></div>
                        <span class="block text-[10px] sm:text-xs font-bold text-slate-400 uppercase tracking-wider font-mono">Rejeitados</span>
                    </div>
                    <div class="mt-2 lg:mt-0 relative z-10 text-right">
                        <span class="text-2xl sm:text-3xl font-black text-rose-400 leading-none">{{ $stats['rejeitado'] }}</span>
                    </div>
                </div>
            </div>

            <!-- TABS CONTENT -->
            <!-- TAB: GRUPOS -->
            <div id="tab-grupos" class="admin-tab-content block animate-fade-in space-y-6" role="tabpanel">
                
                <!-- Smart Filters -->
                <div class="glass-panel p-4 rounded-2xl border border-slate-800/80 shadow-lg flex flex-col sm:flex-row gap-4 items-center justify-between relative z-20">
                    <div class="relative w-full sm:w-96">
                        <i data-lucide="search" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400"></i>
                        <input type="text" id="project-search" onkeyup="filterProjects()" placeholder="Pesquisar por projeto, mentor ou tecnologia..." class="w-full bg-slate-900/80 border border-slate-700/80 rounded-xl pl-10 pr-4 py-2.5 text-sm text-slate-200 focus:border-sky-500 focus:ring-1 focus:ring-sky-500 outline-none transition-all placeholder:text-slate-500">
                    </div>
                    <div class="flex gap-2 w-full sm:w-auto overflow-x-auto pb-1 sm:pb-0 scrollbar-none">
                        <button onclick="filterStatus('Todos')" class="filter-btn px-4 py-2 rounded-xl text-xs font-bold bg-sky-500/10 text-sky-400 border border-sky-500/20 whitespace-nowrap transition-all" aria-pressed="true">Todos</button>
                        <button onclick="filterStatus('Pendente')" class="filter-btn px-4 py-2 rounded-xl text-xs font-bold bg-slate-800/50 text-slate-400 border border-slate-700/50 hover:bg-slate-800 whitespace-nowrap transition-all" aria-pressed="false">Pendentes</button>
                        <button onclick="filterStatus('Aprovado')" class="filter-btn px-4 py-2 rounded-xl text-xs font-bold bg-slate-800/50 text-slate-400 border border-slate-700/50 hover:bg-slate-800 whitespace-nowrap transition-all" aria-pressed="false">Aprovados</button>
                    </div>
                </div>

                <div class="bg-slate-900/80 backdrop-blur-xl rounded-3xl border border-slate-800/80 shadow-2xl overflow-hidden">
                    <div class="px-6 py-5 border-b border-slate-800/60 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <div>
                            <h3 class="text-base font-bold text-white flex items-center gap-2"><i data-lucide="layers" class="w-5 h-5 text-sky-500"></i> Projetos Submetidos</h3>
                            <p class="text-xs text-slate-400 mt-1">Gira, edite e aloque mentores aos projetos dos estudantes.</p>
                        </div>
                    </div>

                    @if($candidaturas->isEmpty())
                        <div class="py-20 text-center flex flex-col items-center justify-center">
                            <div class="w-16 h-16 bg-slate-800 rounded-full flex items-center justify-center mb-4">
                                <i data-lucide="inbox" class="w-8 h-8 text-slate-500"></i>
                            </div>
                            <h4 class="text-sm font-bold text-slate-300">Nenhum projeto encontrado</h4>
                            <p class="text-xs text-slate-500 mt-1 max-w-xs">As submissões dos estudantes aparecerão nesta tabela.</p>
                        </div>
                    @else
                        <div class="hidden md:block overflow-x-auto">
                            <table class="w-full text-left border-collapse text-xs whitespace-nowrap">
                                <thead>
                                    <tr class="bg-slate-950/50 text-slate-400 font-semibold uppercase tracking-wider text-[10px]">
                                        <th class="px-6 py-4">Projeto & Stack</th>
                                        <th class="px-6 py-4">Mentor</th>
                                        <th class="px-6 py-4 text-center">Estado</th>
                                        <th class="px-6 py-4 text-center">Fase</th>
                                        <th class="px-6 py-4 text-right">Ações Rápidas</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-800/50">
                                    @foreach($candidaturas as $c)
                                        <tr class="hover:bg-slate-800/30 transition-colors group">
                                            <!-- Project -->
                                            <td class="px-6 py-4">
                                                <div class="font-bold text-white text-sm">#{{ sprintf("%02d", $c->project_number) }} - {{ $c->project_name }}</div>
                                                <div class="text-[11px] text-sky-400 font-mono mt-1 flex items-center gap-1.5">
                                                    <i data-lucide="code" class="w-3 h-3"></i> {{ $c->technology }}
                                                </div>
                                            </td>
                                            
                                            <!-- Mentor -->
                                            <td class="px-6 py-4">
                                                @if($user->role === 'admin')
                                                    <select onchange="setDocente({{ $c->id }}, this.value)" class="text-xs bg-slate-950 border border-slate-700 text-slate-200 rounded-lg px-2 py-1.5 focus:outline-none focus:border-sky-500 focus:ring-1 focus:ring-sky-500 w-full max-w-[180px] shadow-sm transition-all">
                                                        <option value="">Sem mentor alocado</option>
                                                        @foreach($docentes as $d)
                                                            <option value="{{ $d->id }}" {{ $c->docente_id == $d->id ? 'selected' : '' }}>{{ $d->name }}</option>
                                                        @endforeach
                                                    </select>
                                                @else
                                                    <div class="inline-flex items-center gap-2 px-2.5 py-1 rounded-md bg-slate-950 border border-slate-800">
                                                        <i data-lucide="user" class="w-3 h-3 text-slate-500"></i>
                                                        <span class="text-xs text-slate-300">{{ $c->docente ? $c->docente->name : 'Nenhum' }}</span>
                                                    </div>
                                                @endif
                                            </td>
                                            
                                            <!-- Status -->
                                            <td class="px-6 py-4 text-center">
                                                <span id="badge-status-{{ $c->id }}" class="px-3 py-1 rounded-full font-bold text-[10px] uppercase tracking-wider shadow-sm
                                                    @if($c->status === 'Pendente') bg-amber-500/10 border border-amber-500/20 text-amber-500
                                                    @elseif($c->status === 'Aprovado') bg-emerald-500/10 border border-emerald-500/20 text-emerald-400
                                                    @else bg-rose-500/10 border border-rose-500/20 text-rose-400
                                                    @endif">
                                                    {{ $c->status }}
                                                </span>
                                            </td>

                                            <!-- Fase -->
                                            <td class="px-6 py-4 text-center">
                                                @php
                                                    $faseActual = 'Nenhuma';
                                                    if ($c->status === 'Aprovado') {
                                                        $faseActual = 'Sensibilização';
                                                        $estados = $c->progressos->keyBy('fase');
                                                        $fasesOrdem = ['artigo' => 'Artigo', 'exposicao' => 'Exposição', 'mvp' => 'MVP', 'campo' => 'Campo', 'sensibilizacao' => 'Sensib.'];
                                                        foreach($fasesOrdem as $key => $label) {
                                                            if(isset($estados[$key]) && $estados[$key]->estado !== 'pendente') {
                                                                $statusAbrev = $estados[$key]->estado == 'concluida' ? '✓' : '...';
                                                                $faseActual = $label . ' (' . $statusAbrev . ')';
                                                                break;
                                                            }
                                                        }
                                                    }
                                                @endphp
                                                <span class="inline-flex items-center justify-center px-2 py-1 bg-slate-950 border border-slate-800 rounded-md text-[10px] text-slate-400 font-medium">
                                                    {{ $faseActual }}
                                                </span>
                                            </td>
                                            
                                            <!-- Actions -->
                                            <td class="px-6 py-4 text-right">
                                                <div class="flex items-center justify-end gap-2">
                                                    <!-- Ver Detalhes (SaaS Modal) -->
                                                    <button onclick='viewDetails(@json($c))' class="p-2 bg-slate-800 hover:bg-slate-700 rounded-lg text-slate-300 transition-colors shadow-sm" title="Ver Detalhes do Projeto">
                                                        <i data-lucide="eye" class="w-4 h-4"></i>
                                                    </button>

                                                    <!-- Edit Group Email / Data -->
                                                    @if($user->role === 'admin')
                                                    <button onclick='editCandidatura(@json($c))' class="p-2 bg-sky-500/10 hover:bg-sky-500/20 border border-sky-500/20 rounded-lg text-sky-400 transition-colors shadow-sm" title="Editar Email e Dados">
                                                        <i data-lucide="edit-2" class="w-4 h-4"></i>
                                                    </button>
                                                    @endif
                                                    
                                                    <!-- Workspace -->
                                                    @if($c->status === 'Aprovado')
                                                    <a href="{{ route('workspace.index', $c->id) }}" class="p-2 bg-emerald-500/10 hover:bg-emerald-500/20 border border-emerald-500/20 rounded-lg text-emerald-400 transition-colors shadow-sm" title="Entrar no Workspace">
                                                        <i data-lucide="monitor" class="w-4 h-4"></i>
                                                    </a>
                                                    @endif

                                                    <!-- Set Status (Quick Approvals) -->
                                                    @if($user->role === 'admin' && $c->status === 'Pendente')
                                                    <button onclick="setStatus({{ $c->id }}, 'Aprovado')" class="p-2 bg-emerald-500 border border-emerald-400 rounded-lg text-white hover:bg-emerald-600 transition-colors shadow-lg shadow-emerald-500/20" title="Aprovar Agora">
                                                        <i data-lucide="check" class="w-4 h-4"></i>
                                                    </button>
                                                    @endif

                                                    <!-- Delete Candidatura (Rejected) -->
                                                    @if($user->role === 'admin' && $c->status === 'Rejeitado')
                                                    <button onclick="deleteCandidatura({{ $c->id }})" class="p-2 bg-rose-500/10 hover:bg-rose-500/20 border border-rose-500/20 rounded-lg text-rose-400 transition-colors shadow-sm" title="Eliminar Candidatura">
                                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                                    </button>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Grid de Candidaturas para Mobile -->
                        <div class="grid grid-cols-1 gap-4 md:hidden p-4">
                            @foreach($candidaturas as $c)
                                <div class="glass-panel p-4 rounded-xl border border-slate-800/80 space-y-3 bg-slate-900/40">
                                    <div class="flex items-start justify-between gap-2">
                                        <div>
                                            <div class="font-bold text-white text-sm">#{{ sprintf("%02d", $c->project_number) }} - {{ $c->project_name }}</div>
                                            <div class="text-[11px] text-sky-400 font-mono mt-1 flex items-center gap-1.5">
                                                <i data-lucide="code" class="w-3 h-3"></i> {{ $c->technology }}
                                            </div>
                                        </div>
                                        <span id="badge-status-mobile-{{ $c->id }}" class="px-2.5 py-0.5 rounded-full font-bold text-[9px] uppercase tracking-wider shadow-sm flex-shrink-0
                                            @if($c->status === 'Pendente') bg-amber-500/10 border border-amber-500/20 text-amber-500
                                            @elseif($c->status === 'Aprovado') bg-emerald-500/10 border border-emerald-500/20 text-emerald-400
                                            @else bg-rose-500/10 border border-rose-500/20 text-rose-400
                                            @endif">
                                            {{ $c->status }}
                                        </span>
                                    </div>
                                    
                                    <div class="flex flex-col gap-2 pt-2.5 border-t border-slate-800/60 text-xs">
                                        <div class="flex justify-between items-center gap-2">
                                            <span class="text-slate-400">Mentor:</span>
                                            @if($user->role === 'admin')
                                                <select onchange="setDocente({{ $c->id }}, this.value)" class="text-xs bg-slate-950 border border-slate-700 text-slate-200 rounded-lg px-2 py-1 focus:outline-none focus:border-sky-500 focus:ring-1 focus:ring-sky-500 w-full max-w-[150px] shadow-sm transition-all">
                                                    <option value="">Sem mentor</option>
                                                    @foreach($docentes as $d)
                                                        <option value="{{ $d->id }}" {{ $c->docente_id == $d->id ? 'selected' : '' }}>{{ $d->name }}</option>
                                                    @endforeach
                                                </select>
                                            @else
                                                <span class="text-slate-300 font-medium">{{ $c->docente ? $c->docente->name : 'Nenhum' }}</span>
                                            @endif
                                        </div>
                                        
                                        @php
                                            $faseActual = 'Nenhuma';
                                            if ($c->status === 'Aprovado') {
                                                $faseActual = 'Sensibilização';
                                                $estados = $c->progressos->keyBy('fase');
                                                $fasesOrdem = ['artigo' => 'Artigo', 'exposicao' => 'Exposição', 'mvp' => 'MVP', 'campo' => 'Campo', 'sensibilizacao' => 'Sensib.'];
                                                foreach($fasesOrdem as $key => $label) {
                                                    if(isset($estados[$key]) && $estados[$key]->estado !== 'pendente') {
                                                        $statusAbrev = $estados[$key]->estado == 'concluida' ? '✓' : '...';
                                                        $faseActual = $label . ' (' . $statusAbrev . ')';
                                                        break;
                                                    }
                                                }
                                            }
                                        @endphp
                                        <div class="flex justify-between items-center">
                                            <span class="text-slate-400">Fase Atual:</span>
                                            <span class="px-2 py-0.5 bg-slate-950 border border-slate-800 rounded text-[10px] text-slate-300 font-medium">
                                                {{ $faseActual }}
                                            </span>
                                        </div>
                                    </div>
                                    
                                    <div class="flex items-center justify-end gap-2 pt-2.5 border-t border-slate-800/60">
                                        <!-- Ver Detalhes -->
                                        <button onclick='viewDetails(@json($c))' class="p-2 bg-slate-800 hover:bg-slate-700 rounded-lg text-slate-300 transition-colors shadow-sm" title="Ver Detalhes">
                                            <i data-lucide="eye" class="w-4 h-4"></i>
                                        </button>

                                        <!-- Editar Dados -->
                                        @if($user->role === 'admin')
                                        <button onclick='editCandidatura(@json($c))' class="p-2 bg-sky-500/10 hover:bg-sky-500/20 border border-sky-500/20 rounded-lg text-sky-400 transition-colors shadow-sm" title="Editar Email e Dados">
                                            <i data-lucide="edit-2" class="w-4 h-4"></i>
                                        </button>
                                        @endif
                                        
                                        <!-- Workspace -->
                                        @if($c->status === 'Aprovado')
                                        <a href="{{ route('workspace.index', $c->id) }}" class="p-2 bg-emerald-500/10 hover:bg-emerald-500/20 border border-emerald-500/20 rounded-lg text-emerald-400 transition-colors shadow-sm" title="Entrar no Workspace">
                                            <i data-lucide="monitor" class="w-4 h-4"></i>
                                        </a>
                                        @endif

                                        <!-- Quick Approve -->
                                        @if($user->role === 'admin' && $c->status === 'Pendente')
                                        <button onclick="setStatus({{ $c->id }}, 'Aprovado')" class="p-2 bg-emerald-500 border border-emerald-400 rounded-lg text-white hover:bg-emerald-600 transition-colors shadow-lg shadow-emerald-500/20" title="Aprovar Agora">
                                            <i data-lucide="check" class="w-4 h-4"></i>
                                        </button>
                                        @endif

                                        <!-- Delete Candidatura (Rejected) -->
                                        @if($user->role === 'admin' && $c->status === 'Rejeitado')
                                        <button onclick="deleteCandidatura({{ $c->id }})" class="p-2 bg-rose-500/10 hover:bg-rose-500/20 border border-rose-500/20 rounded-lg text-rose-400 transition-colors shadow-sm" title="Eliminar Candidatura">
                                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                                        </button>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            <!-- TAB: UTILIZADORES -->
            @if($user->role === 'admin')
            <div id="tab-users" class="admin-tab-content hidden animate-fade-in space-y-6" role="tabpanel">
                <!-- Add User Form -->
                <div class="bg-slate-900/80 backdrop-blur-xl p-6 rounded-2xl border border-slate-800 shadow-2xl">
                    <h3 class="text-base font-bold text-white mb-5 flex items-center gap-2"><i data-lucide="user-plus" class="w-5 h-5 text-sky-500"></i> Registar Novo Utilizador</h3>
                    <form action="{{ route('admin.users.create') }}" method="POST" class="grid grid-cols-1 md:grid-cols-5 gap-4">
                        @csrf
                        <div class="md:col-span-1">
                            <label class="block text-[10px] font-bold uppercase tracking-wider text-slate-500 mb-1.5">Nome</label>
                            <input type="text" name="name" required class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-sky-500 focus:ring-1 focus:ring-sky-500 outline-none transition-all shadow-inner">
                        </div>
                        <div class="md:col-span-1">
                            <label class="block text-[10px] font-bold uppercase tracking-wider text-slate-500 mb-1.5">Email</label>
                            <input type="email" name="email" required class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-sky-500 focus:ring-1 focus:ring-sky-500 outline-none transition-all shadow-inner">
                        </div>
                        <div class="md:col-span-1">
                            <label class="block text-[10px] font-bold uppercase tracking-wider text-slate-500 mb-1.5">Senha</label>
                            <input type="password" name="password" required class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-sky-500 focus:ring-1 focus:ring-sky-500 outline-none transition-all shadow-inner">
                        </div>
                        <div class="md:col-span-1">
                            <label class="block text-[10px] font-bold uppercase tracking-wider text-slate-500 mb-1.5">Cargo / Papel</label>
                            <select name="role" required class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-2.5 text-sm text-white focus:border-sky-500 focus:ring-1 focus:ring-sky-500 outline-none transition-all shadow-inner">
                                <option value="docente">Docente / Mentor</option>
                                <option value="director_curso">Diretor de Curso</option>
                                <option value="admin">Administrador Geral</option>
                            </select>
                        </div>
                        <div class="md:col-span-1 flex items-end">
                            <button type="submit" class="w-full py-2.5 bg-sky-500 hover:bg-sky-400 text-white font-bold rounded-xl text-sm transition-all shadow-lg shadow-sky-500/20 flex items-center justify-center gap-2">
                                <i data-lucide="plus" class="w-4 h-4"></i> Guardar
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Users List -->
                <div class="bg-slate-900/80 backdrop-blur-xl rounded-2xl border border-slate-800 shadow-2xl overflow-hidden">
                    <div class="px-6 py-5 border-b border-slate-800/60">
                        <h3 class="text-base font-bold text-white flex items-center gap-2"><i data-lucide="users" class="w-5 h-5 text-sky-500"></i> Equipa e Docentes</h3>
                    </div>
                    <div class="hidden md:block overflow-x-auto">
                        <table class="w-full text-left border-collapse text-xs whitespace-nowrap">
                            <thead>
                                <tr class="bg-slate-950/50 text-slate-400 font-semibold uppercase tracking-wider text-[10px]">
                                    <th class="px-6 py-4">Membro</th>
                                    <th class="px-6 py-4">Contacto</th>
                                    <th class="px-6 py-4">Nível de Acesso</th>
                                    <th class="px-6 py-4 text-right">Ações</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-800/50">
                                @foreach(\App\Models\User::all() as $u)
                                    <tr class="hover:bg-slate-800/30 transition-colors">
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-3">
                                                <div class="w-8 h-8 rounded-full bg-slate-800 text-slate-300 flex items-center justify-center font-bold text-xs border border-slate-700">
                                                    {{ substr($u->name, 0, 1) }}
                                                </div>
                                                <span class="font-bold text-white">{{ $u->name }}</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-slate-400">{{ $u->email }}</td>
                                        <td class="px-6 py-4">
                                            <span class="px-2.5 py-1 rounded-md text-[10px] font-bold uppercase tracking-wider bg-slate-950 border border-slate-800 text-sky-400">
                                                {{ str_replace('_', ' ', $u->role) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            @if($u->id !== $user->id)
                                            <form action="{{ route('admin.users.delete', $u->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Eliminar o utilizador {{ $u->name }}?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="p-1.5 bg-rose-500/10 text-rose-400 border border-rose-500/20 hover:bg-rose-500 hover:text-white rounded-lg transition-colors shadow-sm" title="Eliminar Acesso">
                                                    <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                                                </button>
                                            </form>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Grid de Utilizadores para Mobile -->
                    <div class="grid grid-cols-1 gap-4 md:hidden p-4">
                        @foreach(\App\Models\User::all() as $u)
                            <div class="glass-panel p-4 rounded-xl border border-slate-800/80 flex items-center justify-between bg-slate-900/40">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-slate-800 text-slate-300 flex items-center justify-center font-bold text-xs border border-slate-700">
                                        {{ substr($u->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <span class="font-bold text-white text-xs block">{{ $u->name }}</span>
                                        <span class="text-[10px] text-slate-400 block">{{ $u->email }}</span>
                                        <span class="inline-block mt-1 px-1.5 py-0.5 rounded text-[8px] font-bold uppercase tracking-wider bg-slate-950 border border-slate-800 text-sky-400">
                                            {{ str_replace('_', ' ', $u->role) }}
                                        </span>
                                    </div>
                                </div>
                                <div>
                                    @if($u->id !== $user->id)
                                    <form action="{{ route('admin.users.delete', $u->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Eliminar o utilizador {{ $u->name }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1.5 bg-rose-500/10 text-rose-400 border border-rose-500/20 hover:bg-rose-500 hover:text-white rounded-lg transition-colors shadow-sm" title="Eliminar Acesso">
                                            <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif

            <!-- TAB: PERFIL -->
            <div id="tab-perfil" class="admin-tab-content hidden animate-fade-in" role="tabpanel">
                <div class="bg-slate-900/80 backdrop-blur-xl p-8 rounded-2xl border border-slate-800 shadow-2xl max-w-xl mx-auto mt-4">
                    <div class="flex flex-col items-center justify-center mb-8">
                        <div class="w-20 h-20 rounded-full bg-sky-500/10 text-sky-500 flex items-center justify-center font-bold text-3xl border-2 border-sky-500/30 shadow-lg mb-4">
                            {{ substr($user->name, 0, 1) }}
                        </div>
                        <h3 class="text-xl font-bold text-white">{{ $user->name }}</h3>
                        <p class="text-xs text-sky-400 font-mono mt-1 uppercase">{{ $user->role }}</p>
                    </div>

                    <form action="{{ route('admin.profile.update') }}" method="POST" class="space-y-5">
                        @csrf
                        <div>
                            <label class="block text-[10px] font-bold uppercase tracking-wider text-slate-500 mb-1.5">Nome Completo</label>
                            <input type="text" name="name" value="{{ $user->name }}" required class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-3 text-sm text-white focus:border-sky-500 focus:ring-1 focus:ring-sky-500 outline-none transition-all shadow-inner">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold uppercase tracking-wider text-slate-500 mb-1.5">Email de Acesso</label>
                            <input type="email" name="email" value="{{ $user->email }}" required class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-3 text-sm text-white focus:border-sky-500 focus:ring-1 focus:ring-sky-500 outline-none transition-all shadow-inner">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold uppercase tracking-wider text-slate-500 mb-1.5">Nova Palavra-passe <span class="text-slate-600 normal-case font-normal">(Deixe em branco para manter)</span></label>
                            <input type="password" name="password" class="w-full bg-slate-950 border border-slate-800 rounded-xl px-4 py-3 text-sm text-white focus:border-sky-500 focus:ring-1 focus:ring-sky-500 outline-none transition-all shadow-inner">
                        </div>
                        <div class="pt-4">
                            <button type="submit" class="w-full py-3.5 bg-sky-500 hover:bg-sky-400 text-white font-bold rounded-xl text-sm transition-all shadow-lg shadow-sky-500/20 flex justify-center items-center gap-2">
                                <i data-lucide="check-circle" class="w-5 h-5"></i> Atualizar Dados do Perfil
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            
            <div class="mt-12 text-center text-xs text-slate-600 flex items-center justify-center gap-1">
                <span>Painel SaaS Administrativo &copy; {{ date('Y') }}</span>
                <span class="mx-2 text-slate-800">|</span>
                <i data-lucide="code" class="w-3 h-3"></i> <span>por Filipe Santos</span>
            </div>
        </main>
    </div>

    <!-- Scripts -->
    <script>
        lucide.createIcons();

        // Flash Messages handler via SweetAlert2
        @if(session('success'))
            Swal.fire({
                toast: true, position: 'top-end', showConfirmButton: false, timer: 4000,
                icon: 'success', title: "{{ session('success') }}",
                background: '#0f172a', color: '#f8fafc',
                customClass: { popup: 'border border-slate-800 rounded-xl shadow-2xl' }
            });
        @endif
        @if($errors->any())
            Swal.fire({
                toast: true, position: 'top-end', showConfirmButton: false, timer: 4000,
                icon: 'error', title: "{{ $errors->first() }}",
                background: '#0f172a', color: '#f8fafc',
                customClass: { popup: 'border border-slate-800 rounded-xl shadow-2xl' }
            });
        @endif

        // Mobile Menu Toggle
        function toggleMobileMenu() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('mobile-overlay');
            
            if (sidebar.classList.contains('hidden')) {
                // Open
                sidebar.classList.remove('hidden');
                sidebar.classList.add('flex');
                setTimeout(() => {
                    sidebar.classList.remove('-translate-x-full');
                }, 10);
                
                overlay.classList.remove('hidden');
                setTimeout(() => {
                    overlay.classList.remove('opacity-0');
                }, 10);
            } else {
                // Close
                sidebar.classList.add('-translate-x-full');
                overlay.classList.add('opacity-0');
                
                setTimeout(() => {
                    sidebar.classList.add('hidden');
                    sidebar.classList.remove('flex');
                    overlay.classList.add('hidden');
                }, 300); // Wait for transition
            }
        }

        // Tab System
        function switchAdminTab(tabId, btn) {
            document.querySelectorAll('.admin-tab-content').forEach(c => c.classList.replace('block', 'hidden'));
            document.querySelectorAll('.admin-tab-btn').forEach(b => {
                b.classList.remove('bg-sky-500/10', 'text-sky-400', 'border-sky-500/20');
                b.classList.add('text-slate-400', 'border-transparent');
                b.setAttribute('aria-selected', 'false');
            });
            document.getElementById(`tab-${tabId}`).classList.replace('hidden', 'block');
            btn.classList.remove('text-slate-400', 'border-transparent');
            btn.classList.add('bg-sky-500/10', 'text-sky-400', 'border-sky-500/20');
            btn.setAttribute('aria-selected', 'true');

            // Close mobile menu if open
            const sidebar = document.getElementById('sidebar');
            if (window.innerWidth < 768 && sidebar && !sidebar.classList.contains('hidden')) {
                toggleMobileMenu();
            }
        }

        // View Full Details Modal
        function viewDetails(c) {
            let statusColor = c.status === 'Aprovado' ? 'emerald' : (c.status === 'Rejeitado' ? 'rose' : 'amber');
            
            Swal.fire({
                html: `
                    <div class="text-left">
                        <div class="flex items-center justify-between border-b border-slate-800 pb-4 mb-4">
                            <div>
                                <div class="text-[10px] font-mono text-sky-500 uppercase tracking-wider mb-1">Candidatura #${c.id}</div>
                                <h2 class="text-xl font-bold text-white">${c.project_name}</h2>
                            </div>
                            <span class="px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-${statusColor}-500/10 text-${statusColor}-400 border border-${statusColor}-500/20">
                                ${c.status}
                            </span>
                        </div>
                        
                        <div class="grid grid-cols-3 gap-4 mb-6">
                            <div class="bg-slate-900 p-3 rounded-xl border border-slate-800">
                                <div class="text-[10px] text-slate-500 uppercase font-bold mb-1">Tecnologia Principal</div>
                                <div class="text-sm font-mono text-sky-400">${c.technology}</div>
                            </div>
                            <div class="bg-slate-900 p-3 rounded-xl border border-slate-800">
                                <div class="text-[10px] text-slate-500 uppercase font-bold mb-1">Email de Contacto</div>
                                <div class="text-sm text-slate-300 truncate">${c.contact_email}</div>
                            </div>
                            <div class="bg-slate-900 p-3 rounded-xl border border-slate-800">
                                <div class="text-[10px] text-slate-500 uppercase font-bold mb-1">Telemóvel</div>
                                <div class="text-sm text-slate-300">${c.contact_phone || 'Não definido'}</div>
                            </div>
                        </div>

                        <div class="mb-6">
                            <div class="text-xs font-bold text-white mb-2 uppercase tracking-wider border-b border-slate-800 pb-1">Justificativa do Projeto</div>
                            <div class="text-sm text-slate-400 leading-relaxed bg-slate-900/50 p-4 rounded-xl italic border-l-2 border-l-sky-500">${c.rationale}</div>
                        </div>

                        <div>
                            <div class="text-xs font-bold text-white mb-2 uppercase tracking-wider border-b border-slate-800 pb-1">Membros do Grupo</div>
                            <ul class="space-y-2">
                                <li class="flex items-center justify-between text-sm bg-slate-900 px-3 py-2 rounded-lg border border-slate-800">
                                    <span class="text-white font-semibold flex items-center gap-2"><i data-lucide="award" class="w-4 h-4 text-amber-500"></i> ${c.member1_name}</span>
                                    <span class="text-slate-500 font-mono text-xs">${c.member1_code}</span>
                                </li>
                                ${c.member2_name ? `<li class="flex items-center justify-between text-sm bg-slate-900/50 px-3 py-2 rounded-lg border border-slate-800/50"><span class="text-slate-300 ml-6">${c.member2_name}</span><span class="text-slate-500 font-mono text-xs">${c.member2_code}</span></li>` : ''}
                                ${c.member3_name ? `<li class="flex items-center justify-between text-sm bg-slate-900/50 px-3 py-2 rounded-lg border border-slate-800/50"><span class="text-slate-300 ml-6">${c.member3_name}</span><span class="text-slate-500 font-mono text-xs">${c.member3_code}</span></li>` : ''}
                                ${c.member4_name ? `<li class="flex items-center justify-between text-sm bg-slate-900/50 px-3 py-2 rounded-lg border border-slate-800/50"><span class="text-slate-300 ml-6">${c.member4_name}</span><span class="text-slate-500 font-mono text-xs">${c.member4_code}</span></li>` : ''}
                            </ul>
                        </div>
                        
                        <div class="mt-6 pt-4 border-t border-slate-800 flex justify-between items-center">
                            <a href="/candidatura/${c.id}/pdf" target="_blank" class="text-xs text-sky-400 hover:text-sky-300 font-bold flex items-center gap-1"><i data-lucide="download" class="w-4 h-4"></i> Baixar Comprovativo</a>
                            ${c.status === 'Aprovado' ? `<a href="/workspace/${c.id}" class="px-4 py-2 bg-emerald-500 hover:bg-emerald-400 text-white rounded-xl font-bold text-xs flex items-center gap-2 shadow-lg shadow-emerald-500/20 transition-all"><i data-lucide="monitor" class="w-4 h-4"></i> Abrir Workspace do Projeto</a>` : ''}
                        </div>
                    </div>
                `,
                showConfirmButton: false,
                showCloseButton: true,
                width: 600,
                background: '#070a13',
                customClass: {
                    popup: 'border border-slate-800 rounded-2xl shadow-2xl',
                    closeButton: 'text-slate-400 hover:text-rose-400 transition-colors'
                },
                didOpen: () => { lucide.createIcons(); }
            });
        }

        // Edit Group / Email Modal
        function editCandidatura(c) {
            Swal.fire({
                title: 'Editar Definições do Grupo',
                html: `
                    <form id="edit-group-form" action="{{ url('/admin/candidaturas') }}/${c.id}" method="POST" class="text-left space-y-4 mt-2">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="_method" value="PUT">
                        
                        <div class="bg-sky-500/10 border border-sky-500/20 p-3 rounded-lg mb-4">
                            <p class="text-[11px] text-sky-400 leading-tight"><i data-lucide="info" class="w-3 h-3 inline"></i> <strong>Atenção:</strong> O "Email do Grupo" é crucial. É com este email que os estudantes conseguirão recuperar o PIN de acesso ao Workspace se o perderem.</p>
                        </div>

                        <div class="grid grid-cols-2 gap-3 mb-3">
                            <div>
                                <label class="block text-[10px] uppercase font-bold text-slate-500 mb-1">Email do Grupo <span class="text-rose-400">*</span></label>
                                <input type="email" name="contact_email" class="w-full bg-slate-950 border border-slate-800 rounded-xl p-2.5 text-white text-sm focus:border-sky-500 outline-none" value="${c.contact_email}" required>
                            </div>
                            <div>
                                <label class="block text-[10px] uppercase font-bold text-slate-500 mb-1">Contacto Telefónico</label>
                                <input type="text" name="contact_phone" class="w-full bg-slate-950 border border-slate-800 rounded-xl p-2.5 text-white text-sm focus:border-sky-500 outline-none" value="${c.contact_phone || ''}" placeholder="ex: 84xxxxxxx">
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-[10px] uppercase font-bold text-slate-500 mb-1">Nome do Projeto</label>
                            <input type="text" name="project_name" class="w-full bg-slate-950 border border-slate-800 rounded-xl p-2.5 text-white text-sm focus:border-sky-500 outline-none" value="${c.project_name}">
                        </div>
                        
                        <div class="grid grid-cols-2 gap-3 pt-2">
                            <div>
                                <label class="block text-[10px] uppercase font-bold text-slate-500 mb-1">Nome do Líder</label>
                                <input type="text" name="member1_name" class="w-full bg-slate-950 border border-slate-800 rounded-xl p-2.5 text-white text-sm focus:border-sky-500 outline-none" value="${c.member1_name}">
                            </div>
                            <div>
                                <label class="block text-[10px] uppercase font-bold text-slate-500 mb-1">N.º Mecanográfico</label>
                                <input type="text" name="member1_code" class="w-full bg-slate-950 border border-slate-800 rounded-xl p-2.5 text-white text-sm focus:border-sky-500 outline-none" value="${c.member1_code}">
                            </div>
                        </div>

                        <!-- Reset PIN Button Inside Edit -->
                        <div class="pt-4 mt-4 border-t border-slate-800 text-right">
                             <button type="button" onclick="resetPinInsideEdit(${c.id})" class="text-xs text-rose-400 hover:text-rose-300 font-bold flex items-center justify-end gap-1 w-full"><i data-lucide="key" class="w-3.5 h-3.5"></i> Gerar e Redefinir Novo PIN de Acesso</button>
                        </div>
                    </form>
                `,
                showCancelButton: true,
                confirmButtonText: 'Guardar Alterações',
                cancelButtonText: 'Cancelar',
                background: '#0b0f19',
                color: '#f8fafc',
                customClass: {
                    popup: 'border border-slate-800 rounded-2xl shadow-2xl',
                    confirmButton: 'bg-sky-500 hover:bg-sky-400 text-white px-5 py-2.5 rounded-xl font-bold shadow-lg',
                    cancelButton: 'bg-slate-800 hover:bg-slate-700 text-white px-5 py-2.5 rounded-xl font-bold ml-2'
                },
                buttonsStyling: false,
                didOpen: () => { lucide.createIcons(); },
                preConfirm: () => {
                    const form = document.getElementById('edit-group-form');
                    if(form.reportValidity()) form.submit();
                    else return false;
                }
            });
        }

        // Change Status (Approve/Reject)
        function setStatus(id, newStatus) {
            Swal.fire({
                title: `Confirmar ${newStatus}?`,
                text: "O estado do projeto será atualizado.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Sim, confirmar',
                cancelButtonText: 'Cancelar',
                background: '#0b0f19', color: '#fff',
                customClass: {
                    popup: 'border border-slate-800 rounded-2xl',
                    confirmButton: 'bg-emerald-500 hover:bg-emerald-400 text-white px-4 py-2 rounded-lg font-bold',
                    cancelButton: 'bg-slate-800 hover:bg-slate-700 text-white px-4 py-2 rounded-lg font-bold ml-2'
                },
                buttonsStyling: false
            }).then((result) => {
                if(result.isConfirmed) {
                    fetch(`{{ url('/admin/candidaturas') }}/${id}/status`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': "{{ csrf_token() }}",
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: JSON.stringify({ status: newStatus })
                    }).then(res => res.json()).then(data => {
                        if(data.success) window.location.reload();
                    });
                }
            });
        }

        // Delete Candidatura (Only for Rejected projects)
        function deleteCandidatura(id) {
            Swal.fire({
                title: 'Eliminar Candidatura?',
                text: "Esta ação é irreversível e apagará todos os dados associados a esta candidatura.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sim, eliminar',
                cancelButtonText: 'Cancelar',
                background: '#0b0f19', color: '#fff',
                customClass: {
                    popup: 'border border-slate-800 rounded-2xl',
                    confirmButton: 'bg-rose-500 hover:bg-rose-400 text-white px-4 py-2 rounded-lg font-bold',
                    cancelButton: 'bg-slate-800 hover:bg-slate-700 text-white px-4 py-2 rounded-lg font-bold ml-2'
                },
                buttonsStyling: false
            }).then((result) => {
                if(result.isConfirmed) {
                    fetch(`{{ url('/admin/candidaturas') }}/${id}`, {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': "{{ csrf_token() }}",
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    }).then(res => res.json()).then(data => {
                        if(data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Eliminado!',
                                text: data.message || 'Candidatura eliminada com sucesso.',
                                background: '#0b0f19', color: '#fff'
                            }).then(() => {
                                window.location.reload();
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Erro',
                                text: data.message || 'Ocorreu um erro ao tentar eliminar.',
                                background: '#0b0f19', color: '#fff'
                            });
                        }
                    });
                }
            });
        }

        // Set Docente Auto-Save
        function setDocente(id, docenteId) {
            fetch(`{{ url('/admin/candidaturas') }}/${id}/docente`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': "{{ csrf_token() }}",
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({ docente_id: docenteId })
            }).then(res => res.json()).then(data => {
                if(data.success) {
                    Swal.fire({
                        toast: true, position: 'top-end', showConfirmButton: false, timer: 3000,
                        icon: 'success', title: 'Mentor atualizado!',
                        background: '#0f172a', color: '#f8fafc'
                    });
                }
            });
        }

        // Reset PIN Logic
        function resetPinInsideEdit(id) {
            Swal.fire({
                title: 'Atenção!',
                text: 'Ao redefinir, o código antigo será inválido.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Redefinir PIN',
                background: '#0b0f19', color: '#fff',
                customClass: {
                    popup: 'border border-slate-800 rounded-2xl',
                    confirmButton: 'bg-rose-500 text-white px-4 py-2 rounded-lg font-bold',
                    cancelButton: 'bg-slate-800 text-white px-4 py-2 rounded-lg font-bold ml-2'
                },
                buttonsStyling: false
            }).then((res) => {
                if(res.isConfirmed) {
                    fetch(`{{ url('/admin/candidaturas') }}/${id}/reset-pin`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': "{{ csrf_token() }}",
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    }).then(r => r.json()).then(data => {
                        if(data.success) {
                            Swal.fire({
                                title: 'Novo PIN Gerado',
                                html: `O PIN de acesso agora é:<br><br><span class="text-4xl text-sky-500 font-mono tracking-widest font-bold">${data.new_pin}</span>`,
                                icon: 'success',
                                background: '#0b0f19', color: '#fff',
                                customClass: { popup: 'border border-slate-800 rounded-2xl', confirmButton: 'bg-sky-500 rounded-lg px-4 py-2' },
                                buttonsStyling: false
                            });
                        }
                    });
                }
            });
        }

        // Smart Filters Logic
        let currentStatusFilter = 'Todos';
        function filterStatus(status) {
            currentStatusFilter = status;
            
            // Update UI for buttons
            document.querySelectorAll('.filter-btn').forEach(btn => {
                const btnText = btn.innerText.trim();
                const isActive = (btnText === status) || 
                    (status === 'Pendente' && btnText === 'Pendentes') || 
                    (status === 'Aprovado' && btnText === 'Aprovados') ||
                    (status === 'Todos' && btnText === 'Todos');
                if (isActive) {
                    btn.className = 'filter-btn px-4 py-2 rounded-xl text-xs font-bold bg-sky-500/10 text-sky-400 border border-sky-500/20 whitespace-nowrap transition-all';
                } else {
                    btn.className = 'filter-btn px-4 py-2 rounded-xl text-xs font-bold bg-slate-800/50 text-slate-400 border border-slate-700/50 hover:bg-slate-800 whitespace-nowrap transition-all';
                }
                btn.setAttribute('aria-pressed', isActive ? 'true' : 'false');
            });
            filterProjects();
        }

        function filterProjects() {
            const query = document.getElementById('project-search').value.toLowerCase();
            const rowsDesktop = document.querySelectorAll('tbody tr');
            const cardsMobile = document.querySelectorAll('#tab-grupos .grid.grid-cols-1 > div');

            // Filter Desktop rows
            rowsDesktop.forEach(row => {
                const text = row.innerText.toLowerCase();
                const statusBadge = row.querySelector('[id^="badge-status-"]');
                const rowStatus = statusBadge ? statusBadge.innerText.trim() : '';
                
                const matchesSearch = text.includes(query);
                const matchesStatus = currentStatusFilter === 'Todos' || rowStatus === currentStatusFilter;
                
                row.style.display = (matchesSearch && matchesStatus) ? '' : 'none';
            });

            // Filter Mobile cards
            cardsMobile.forEach(card => {
                const text = card.innerText.toLowerCase();
                const statusBadge = card.querySelector('[id^="badge-status-mobile-"]');
                const cardStatus = statusBadge ? statusBadge.innerText.trim() : '';

                const matchesSearch = text.includes(query);
                const matchesStatus = currentStatusFilter === 'Todos' || cardStatus === currentStatusFilter;

                card.style.display = (matchesSearch && matchesStatus) ? '' : 'none';
            });
        }
    </script>
</body>
</html>
