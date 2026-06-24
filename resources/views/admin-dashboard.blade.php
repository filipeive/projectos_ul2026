<!DOCTYPE html>
<html lang="pt-PT" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel de Gestão | UniLicungo TechHub</title>
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
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
                        indigo: {
                            400: '#38bdf8',
                            500: '#008ad2',
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
    <link rel="stylesheet" href="{{ asset('style.css') }}">
</head>
<body class="min-h-screen bg-slate-950 text-slate-100 flex flex-col relative antialiased pb-12">
    
    <!-- Background glowing ambient blobs -->
    <div class="glow-blob-blue"></div>
    <div class="glow-blob-gold"></div>

    <!-- HEADER / NAVIGATION -->
    <header class="relative z-10 w-full max-w-7xl mx-auto px-4 pt-6 pb-2">
        <div class="flex items-center justify-between border-b border-slate-900 pb-4">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 bg-slate-900/60 p-1.5 rounded-xl border border-slate-800 flex items-center justify-center backdrop-blur-md">
                    <img src="{{ asset('ul.png') }}" alt="Logo UniLicungo" class="w-full h-full object-contain">
                </div>
                <div>
                    <h1 class="text-xl font-bold text-white font-display">UniLicungo TechHub</h1>
                    <p class="text-xs text-sky-400 font-mono tracking-wider">Painel Administrativo do Docente</p>
                </div>
            </div>
            
            <form action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button type="submit" class="px-4 py-2 bg-slate-900 border border-slate-800 hover:border-slate-700 text-slate-300 hover:text-white rounded-xl text-xs font-semibold flex items-center gap-1.5 transition-all">
                    <i data-lucide="log-out" class="w-3.5 h-3.5"></i> Terminar Sessão
                </button>
            </form>
        </div>
    </header>

    <!-- MAIN BODY -->
    <main class="relative z-10 w-full max-w-7xl mx-auto px-4 py-6 flex-grow space-y-6">
        
        <!-- ALERT BOXES -->
        <div id="ajax-alert" class="hidden p-4 rounded-xl flex items-start gap-3 animate-fade-in">
            <i data-lucide="check-circle" class="w-5 h-5 mt-0.5 flex-shrink-0" id="ajax-alert-icon"></i>
            <div>
                <h4 class="text-sm font-bold text-white" id="ajax-alert-title">Sucesso!</h4>
                <p class="text-xs text-slate-300 mt-0.5" id="ajax-alert-message"></p>
            </div>
        </div>

        <!-- STATS GRID -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="glass-panel p-4 rounded-xl border border-slate-800/80 flex flex-col justify-between">
                <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider font-mono">Inscrições Totais</span>
                <span class="text-3xl font-extrabold text-white mt-2">{{ $stats['total'] }}</span>
            </div>
            <div class="glass-panel p-4 rounded-xl border border-slate-800/80 flex flex-col justify-between border-l-2 border-l-amber-500/50">
                <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider font-mono">Pendentes</span>
                <span class="text-3xl font-extrabold text-amber-500 mt-2" id="stat-pending-count">{{ $stats['pendente'] }}</span>
            </div>
            <div class="glass-panel p-4 rounded-xl border border-slate-800/80 flex flex-col justify-between border-l-2 border-l-emerald-500/50">
                <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider font-mono">Aprovados</span>
                <span class="text-3xl font-extrabold text-emerald-400 mt-2" id="stat-approved-count">{{ $stats['aprovado'] }}</span>
            </div>
            <div class="glass-panel p-4 rounded-xl border border-slate-800/80 flex flex-col justify-between border-l-2 border-l-rose-500/50">
                <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider font-mono">Rejeitados</span>
                <span class="text-3xl font-extrabold text-rose-400 mt-2" id="stat-rejected-count">{{ $stats['rejeitado'] }}</span>
            </div>
        </div>

        <!-- TABLE LIST -->
        <div class="glass-panel rounded-2xl border border-slate-800/80 overflow-hidden shadow-xl">
            <div class="px-6 py-4 border-b border-slate-800/60 bg-slate-900/40 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <h3 class="text-md font-bold text-white">Lista de Grupos Inscritos</h3>
                    <p class="text-xs text-slate-400 mt-0.5">Gerencie os projetos reservados e confirme a homologação para os eventos</p>
                </div>
                <div class="flex items-center gap-2">
                    <a href="{{ route('portal.index') }}" target="_blank" class="px-3.5 py-1.5 bg-sky-600 hover:bg-sky-500 text-white rounded-xl text-xs font-semibold flex items-center gap-1.5 transition-colors">
                        <i data-lucide="external-link" class="w-3.5 h-3.5"></i> Ver Portal
                    </a>
                </div>
            </div>

            @if($candidaturas->isEmpty())
                <div class="py-16 text-center">
                    <i data-lucide="folder-open" class="w-12 h-12 text-slate-700 mx-auto mb-3"></i>
                    <h4 class="text-sm font-bold text-slate-400">Nenhuma candidatura registada</h4>
                    <p class="text-xs text-slate-500 mt-1 max-w-xs mx-auto">As inscrições enviadas pelos estudantes do 1.º ano aparecerão neste painel.</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse text-xs">
                        <thead>
                            <tr class="border-b border-slate-800/80 bg-slate-900/10 text-slate-400 font-semibold">
                                <th class="p-4 font-mono">ID</th>
                                <th class="p-4">Projeto</th>
                                <th class="p-4">Tecnologia</th>
                                <th class="p-4">Integrantes (Líder / N.º)</th>
                                <th class="p-4">Data Envio</th>
                                <th class="p-4 text-center">Estado</th>
                                <th class="p-4 text-right">Ações</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-900">
                            @foreach($candidaturas as $c)
                                <tr class="hover:bg-slate-900/20 transition-colors" id="row-candidatura-{{ $c->id }}">
                                    <!-- ID -->
                                    <td class="p-4 font-mono text-slate-500">#{{ $c->id }}</td>
                                    
                                    <!-- Project -->
                                    <td class="p-4">
                                        <div class="font-semibold text-white">#{{ sprintf("%02d", $c->project_number) }} - {{ $c->project_name }}</div>
                                        <div class="text-[10px] text-slate-500 mt-0.5">Mentor: {{ $c->mentor ?: 'Sem mentor' }}</div>
                                    </td>
                                    
                                    <!-- Technology -->
                                    <td class="p-4 font-mono text-sky-400">{{ $c->technology }}</td>
                                    
                                    <!-- Members -->
                                    <td class="p-4 space-y-1">
                                        <div><strong class="text-slate-300">1. {{ $c->member1_name }}</strong> <span class="text-slate-500">({{ $c->member1_code }})</span></div>
                                        <div>2. {{ $c->member2_name }} <span class="text-slate-500">({{ $c->member2_code }})</span></div>
                                        @if($c->member3_name)
                                            <div>3. {{ $c->member3_name }} <span class="text-slate-500">({{ $c->member3_code }})</span></div>
                                        @endif
                                        @if($c->member4_name)
                                            <div>4. {{ $c->member4_name }} <span class="text-slate-500">({{ $c->member4_code }})</span></div>
                                        @endif
                                    </td>

                                    <!-- Date -->
                                    <td class="p-4 text-slate-400">{{ $c->created_at->format('d/m/Y H:i') }}</td>
                                    
                                    <!-- Status -->
                                    <td class="p-4 text-center">
                                        <span id="badge-status-{{ $c->id }}" class="px-2.5 py-1 rounded-full font-semibold text-[10px] uppercase tracking-wider
                                            @if($c->status === 'Pendente') bg-amber-500/10 border border-amber-500/30 text-amber-500
                                            @elseif($c->status === 'Aprovado') bg-emerald-500/10 border border-emerald-500/30 text-emerald-400
                                            @else bg-rose-500/10 border border-rose-500/30 text-rose-400
                                            @endif">
                                            {{ $c->status }}
                                        </span>
                                    </td>
                                    
                                    <!-- Actions -->
                                    <td class="p-4 text-right">
                                        <div class="flex items-center justify-end gap-1.5">
                                            <!-- Toggle Rationale -->
                                            <button onclick="toggleRationale({{ $c->id }})" class="p-1.5 bg-slate-900 border border-slate-850 hover:border-slate-700 rounded-lg text-slate-400 hover:text-white transition-colors" title="Ver Justificativa">
                                                <i data-lucide="eye" class="w-3.5 h-3.5"></i>
                                            </button>
                                            <!-- Approve -->
                                            <button onclick="setStatus({{ $c->id }}, 'Aprovado')" class="p-1.5 bg-emerald-500/10 border border-emerald-500/30 hover:bg-emerald-500/20 rounded-lg text-emerald-400 transition-colors" title="Aprovar Projeto">
                                                <i data-lucide="check" class="w-3.5 h-3.5"></i>
                                            </button>
                                            <!-- Reject -->
                                            <button onclick="setStatus({{ $c->id }}, 'Rejeitado')" class="p-1.5 bg-rose-500/10 border border-rose-500/30 hover:bg-rose-500/20 rounded-lg text-rose-400 transition-colors" title="Rejeitar Candidatura">
                                                <i data-lucide="x" class="w-3.5 h-3.5"></i>
                                            </button>
                                            <!-- Set Pending -->
                                            <button onclick="setStatus({{ $c->id }}, 'Pendente')" class="p-1.5 bg-slate-900 border border-slate-850 hover:border-slate-700 rounded-lg text-amber-500 transition-colors" title="Voltar a Pendente">
                                                <i data-lucide="clock" class="w-3.5 h-3.5"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                
                                <!-- Rationale Hidden Row -->
                                <tr id="rationale-row-{{ $c->id }}" class="hidden bg-slate-900/10">
                                    <td colspan="7" class="p-4 border-b border-slate-900">
                                        <div class="p-4 bg-slate-950 rounded-xl border border-slate-900 space-y-2">
                                            <span class="text-[10px] font-bold text-sky-400 uppercase font-mono tracking-wider">Justificativa e Impacto Local (Quelimane):</span>
                                            <p class="text-xs text-slate-300 leading-relaxed font-light">{{ $c->rationale }}</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
        
    </main>

    <!-- FOOTER -->
    <footer class="relative z-10 w-full max-w-7xl mx-auto px-4 mt-8 border-t border-slate-900 pt-6 flex flex-col md:flex-row items-center justify-between text-xs text-slate-500 gap-4">
        <div class="flex items-center gap-4">
            <div class="flex items-center gap-1 text-slate-600">
                <span>Desenvolvido por</span>
                <a href="http://146.235.224.99/" target="_blank" class="inline-flex items-center gap-0.5 text-slate-400 hover:text-sky-400 transition-colors font-medium">
                    Filipe Domingos dos Santos
                </a>
            </div>
            <span class="text-slate-800">|</span>
            <a href="https://wa.me/258862134230" target="_blank" class="hover:text-emerald-400 text-slate-500 transition-colors flex items-center gap-1 font-semibold uppercase tracking-wider font-mono">
                <i data-lucide="message-circle" class="w-3.5 h-3.5 text-emerald-500"></i> WhatsApp
            </a>
        </div>
        <div>
            © {{ date('Y') }} Curso de Informática - Universidade Licungo.
        </div>
    </footer>

    <!-- Scripts -->
    <script>
        lucide.createIcons();

        // Toggle Expandable rationale row
        function toggleRationale(id) {
            const row = document.getElementById(`rationale-row-${id}`);
            if (row.classList.contains('hidden')) {
                row.classList.remove('hidden');
            } else {
                row.classList.add('hidden');
            }
        }

        // Change Application Status via AJAX
        function setStatus(id, newStatus) {
            const csrfToken = "{{ csrf_token() }}";
            let url = "{{ route('admin.update-status', ['candidatura' => ':id']) }}";
            url = url.replace(':id', id);
            
            fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({ status: newStatus })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Falha na resposta do servidor.');
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    // Update the status badge in UI
                    const badge = document.getElementById(`badge-status-${id}`);
                    badge.innerText = data.status;
                    
                    // Reset class and set correct color classes
                    badge.className = "px-2.5 py-1 rounded-full font-semibold text-[10px] uppercase tracking-wider";
                    if (data.status === 'Pendente') {
                        badge.classList.add('bg-amber-500/10', 'border', 'border-amber-500/30', 'text-amber-500');
                    } else if (data.status === 'Aprovado') {
                        badge.classList.add('bg-emerald-500/10', 'border', 'border-emerald-500/30', 'text-emerald-400');
                    } else if (data.status === 'Rejeitado') {
                        badge.classList.add('bg-rose-500/10', 'border', 'border-rose-500/30', 'text-rose-400');
                    }

                    // Show success alert toast
                    showAlert('emerald', 'Operação bem-sucedida', data.message);
                    
                    // Reload page stats values without full reload (could query or update dynamically)
                    // For safety and correctness, we reload the counts if we want, or simple page reload.
                    // Let's reload counts by querying database or simply trigger page reload after 800ms
                    setTimeout(() => {
                        window.location.reload();
                    }, 1000);
                }
            })
            .catch(error => {
                showAlert('rose', 'Erro de Servidor', error.message);
            });
        }

        // Alert helper toast
        function showAlert(color, title, message) {
            const alertBox = document.getElementById('ajax-alert');
            const alertIcon = document.getElementById('ajax-alert-icon');
            const alertTitle = document.getElementById('ajax-alert-title');
            const alertMsg = document.getElementById('ajax-alert-message');

            alertBox.className = `p-4 rounded-xl flex items-start gap-3 animate-fade-in bg-${color}-500/10 border border-${color}-500/30 text-${color}-400`;
            alertTitle.innerText = title;
            alertMsg.innerText = message;
            alertBox.classList.remove('hidden');

            setTimeout(() => {
                alertBox.classList.add('hidden');
            }, 4000);
        }
    </script>
</body>
</html>
