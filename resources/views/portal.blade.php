<!DOCTYPE html>
<html lang="pt-PT" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UniLicungo TechHub | Catálogo de Projetos de Informática</title>
    <meta name="description" content="Portal académico de projectos de informática da Universidade Licungo, Quelimane. Catálogo de 52+ ideias de sistemas para estudantes do 1.º ano com guias de pesquisa científica.">
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <link rel="shortcut icon" href="{{ asset('favicon.png') }}">
    
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
                            600: '#334155',
                            500: '#64748b'
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
<body class="min-h-screen bg-slate-950 text-slate-100 flex flex-col relative antialiased selection:bg-sky-500 selection:text-white pb-12">
    
    <!-- Background glowing ambient blobs -->
    <div class="glow-blob-blue"></div>
    <div class="glow-blob-gold"></div>
    <div class="glow-blob-center"></div>

    <!-- Top utility bar -->
    <div class="bg-slate-900 border-b border-slate-800">
        <div class="max-w-7xl mx-auto px-4 py-2 flex justify-between items-center text-xs font-mono">
            <span class="text-slate-500 hidden md:block">Faculdade de Ciências e Tecnologias</span>
            <div class="flex gap-4 items-center">
                <a href="#section-form" class="text-sky-400 hover:text-sky-300 flex items-center gap-1.5 transition-colors" onclick="document.querySelector('.nav-tab-btn[data-tab=\'estudante\']').click(); return false;">
                    <i data-lucide="plus-circle" class="w-3.5 h-3.5"></i> Cadastrar Projeto
                </a>
                <span class="text-slate-800">|</span>
                <a href="{{ route('workspace.login') }}" class="text-slate-400 hover:text-white flex items-center gap-1.5 transition-colors">
                    <i data-lucide="log-in" class="w-3.5 h-3.5"></i> Central de Acesso
                </a>
            </div>
        </div>
    </div>

    <!-- HEADER / HERO -->
    <header class="relative z-10 w-full max-w-7xl mx-auto px-4 pt-6 pb-4">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 border-b border-slate-900 pb-6">
            <div class="flex items-center gap-4">
                <!-- University Logo -->
                <div class="w-16 h-16 md:w-20 md:h-20 bg-slate-900/60 p-2 rounded-2xl border border-slate-800 flex items-center justify-center backdrop-blur-md">
                    <img src="{{ asset('ul.png') }}" alt="Logo UniLicungo" class="w-full h-full object-contain">
                </div>
                
                <div>
                    <!-- Badge -->
                    <div class="inline-flex items-center gap-2 px-3 py-0.5 rounded-full bg-sky-500/10 border border-sky-500/20 text-sky-400 text-xs font-semibold mb-2">
                        <span class="w-1.5 h-1.5 rounded-full bg-sky-400 animate-pulse"></span>
                        Universidade Licungo · Quelimane
                    </div>
                    <!-- Title -->
                    <h1 class="text-3xl md:text-4xl font-extrabold tracking-tight text-white">
                        UniLicungo <span class="text-gradient-primary">TechHub</span>
                    </h1>
                    <p class="text-sm text-slate-400 max-w-2xl font-light">
                        Guia Oficial de Projetos Tecnológicos e Investigação Científica para Estudantes do 1.º Ano.
                    </p>
                </div>
            </div>
            
            <!-- Quick info stats banner -->
            <div class="glass-panel p-4 rounded-xl flex items-center gap-4 max-w-md border border-slate-800">
                <div class="w-10 h-10 rounded-lg bg-sky-500/10 border border-sky-500/20 flex items-center justify-center text-sky-400 shadow-lg">
                    <i data-lucide="award" class="w-5 h-5"></i>
                </div>
                <div class="text-left">
                    <h4 class="text-xs font-bold text-white uppercase tracking-wider font-mono">Próximos Eventos</h4>
                    <p class="text-xs text-sky-400 font-medium mt-0.5">15 Ago: Dia da Informática (MVP)</p>
                    <p class="text-xs text-amber-500 font-medium">Setembro: Jornadas Científicas (Artigo)</p>
                </div>
            </div>
        </div>
        
        <!-- Navigation Tab bar -->
        <nav class="flex border-b border-slate-800/80 mt-6 relative z-20 overflow-x-auto">
            <button class="nav-tab-btn whitespace-nowrap px-6 py-3 border-b-2 border-sky-500 text-sky-400 font-medium text-sm transition-all focus:outline-none" data-tab="catalogo">
                <span class="flex items-center gap-2">
                    <i data-lucide="grid" class="w-4 h-4"></i> Catálogo de Ideias ({{ count($projects) }})
                </span>
            </button>
            <button class="nav-tab-btn whitespace-nowrap px-6 py-3 border-b-2 border-transparent text-slate-400 hover:text-slate-200 font-medium text-sm transition-all focus:outline-none" data-tab="mobilizacao">
                <span class="flex items-center gap-2">
                    <i data-lucide="calendar" class="w-4 h-4"></i> Linha de Ação & Mentoria
                </span>
            </button>
            <button class="nav-tab-btn whitespace-nowrap px-6 py-3 border-b-2 border-transparent text-slate-400 hover:text-slate-200 font-medium text-sm transition-all focus:outline-none" data-tab="boilerplates">
                <span class="flex items-center gap-2">
                    <i data-lucide="code-2" class="w-4 h-4"></i> Kit do Estudante (Starter)
                </span>
            </button>
            <button class="nav-tab-btn whitespace-nowrap px-6 py-3 border-b-2 border-transparent text-slate-400 hover:text-slate-200 font-medium text-sm transition-all focus:outline-none" data-tab="guia">
                <span class="flex items-center gap-2">
                    <i data-lucide="graduation-cap" class="w-4 h-4"></i> Guia do Investigador
                </span>
            </button>
            <button class="nav-tab-btn whitespace-nowrap px-6 py-3 border-b-2 border-transparent text-slate-400 hover:text-slate-200 font-medium text-sm transition-all focus:outline-none" data-tab="estudante">
                <span class="flex items-center gap-2">
                    <i data-lucide="file-text" class="w-4 h-4"></i> Inscrição de Grupo
                </span>
            </button>
        </nav>
    </header>

    <!-- MAIN CONTENT CONTAINER -->
    <main class="relative z-10 w-full max-w-7xl mx-auto px-4 py-4 flex-grow">
        
        <!-- ALERT MESSAGES -->
        @if(session('success'))
            <div class="mb-6 p-4 bg-emerald-500/10 border border-emerald-500/30 rounded-2xl flex items-start gap-3 animate-fade-in">
                <i data-lucide="check-circle" class="w-5 h-5 text-emerald-400 mt-0.5 flex-shrink-0"></i>
                <div>
                    <h4 class="text-sm font-bold text-white">Submissão bem-sucedida!</h4>
                    <p class="text-xs text-slate-300 mt-0.5">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        @if($errors->any())
            <div class="mb-6 p-4 bg-rose-500/10 border border-rose-500/30 rounded-2xl flex items-start gap-3 animate-fade-in">
                <i data-lucide="alert-triangle" class="w-5 h-5 text-rose-400 mt-0.5 flex-shrink-0"></i>
                <div>
                    <h4 class="text-sm font-bold text-white">Erro de validação</h4>
                    <ul class="text-xs text-slate-300 mt-1 list-disc pl-4 space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif
        
        <!-- 1. SECTION: CATALOG -->
        <section id="section-catalogo" class="content-section">
            
            <!-- Global Stats Banner -->
            <div class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-6">
                <div class="glass-panel p-4 rounded-xl border border-slate-800/80 flex flex-col">
                    <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider font-mono">Total Ideias</span>
                    <span id="stat-total-projects" class="text-2xl font-extrabold text-white mt-1">{{ $stats['total'] ?? 0 }}</span>
                </div>
                <div class="glass-panel p-4 rounded-xl border border-slate-800/80 flex flex-col">
                    <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider font-mono">Sectores</span>
                    <span id="stat-sectors" class="text-2xl font-extrabold text-sky-400 mt-1">{{ $stats['sectores'] ?? 0 }}</span>
                </div>
                <div class="glass-panel p-4 rounded-xl border border-slate-800/80 flex flex-col border-l-2 border-l-emerald-500/50">
                    <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider font-mono">Nível Fácil</span>
                    <span id="stat-facil" class="text-2xl font-extrabold text-emerald-400 mt-1">{{ $stats['facil'] ?? 0 }}</span>
                </div>
                <div class="glass-panel p-4 rounded-xl border border-slate-800/80 flex flex-col border-l-2 border-l-amber-500/50">
                    <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider font-mono">Nível Médio</span>
                    <span id="stat-medio" class="text-2xl font-extrabold text-amber-500 mt-1">{{ $stats['medio'] ?? 0 }}</span>
                </div>
                <div class="glass-panel p-4 rounded-xl border border-slate-800/80 flex flex-col border-l-2 border-l-rose-500/50">
                    <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider font-mono">Nível Avançado</span>
                    <span id="stat-avancado" class="text-2xl font-extrabold text-rose-400 mt-1">{{ $stats['avancado'] ?? 0 }}</span>
                </div>
            </div>

            <!-- AI Startup Advisor Banner -->
            <div class="glass-panel p-6 rounded-2xl border border-sky-500/30 bg-sky-900/10 mb-6 flex flex-col md:flex-row items-center justify-between gap-4 relative overflow-hidden">
                <div class="absolute -right-10 -top-10 w-40 h-40 bg-sky-500/10 rounded-full blur-2xl"></div>
                <div class="relative z-10">
                    <h3 class="text-lg font-bold text-white flex items-center gap-2">
                        <i data-lucide="sparkles" class="w-5 h-5 text-sky-400"></i> Sem Ideias para o Projeto?
                    </h3>
                    <p class="text-sm text-slate-300 mt-1 max-w-xl">
                        Usa a nossa Inteligência Artificial para te dar ideias de projetos de startup inovadores baseados no que mais gostas de fazer!
                    </p>
                </div>
                <button onclick="openAiModal()" class="relative z-10 px-5 py-2.5 bg-sky-600 hover:bg-sky-500 text-white text-sm font-bold rounded-xl transition-all shadow-lg shadow-sky-500/20 flex items-center gap-2 whitespace-nowrap">
                    <i data-lucide="bot" class="w-4 h-4"></i> Pedir Ideia à IA
                </button>
            </div>

            <!-- Filters Area -->
            <div class="glass-panel p-5 rounded-2xl border border-slate-800/80 mb-6 flex flex-col gap-4">
                <!-- Row 1: Search & Dropdowns -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-3">
                    <!-- Search input -->
                    <div class="relative md:col-span-2">
                        <i data-lucide="search" class="w-4 h-4 absolute left-3.5 top-3.5 text-slate-500"></i>
                        <input type="text" id="search-input" placeholder="Pesquisar projeto, palavra-chave, tecnologia..." 
                            class="w-full pl-10 pr-4 py-2.5 bg-slate-900 border border-slate-800 hover:border-slate-700 focus:border-sky-500 focus:outline-none rounded-xl text-sm placeholder:text-slate-500 transition-all text-slate-200">
                    </div>
                    
                    <!-- Difficulty select -->
                    <div>
                        <select id="filter-difficulty" class="w-full px-4 py-2.5 bg-slate-900 border border-slate-800 hover:border-slate-700 focus:border-sky-500 focus:outline-none rounded-xl text-sm text-slate-300 transition-all cursor-pointer">
                            <option value="Todos">Dificuldade (Todas)</option>
                            <option value="Fácil">Fácil</option>
                            <option value="Médio">Médio</option>
                            <option value="Avançado">Avançado</option>
                        </select>
                    </div>

                    <!-- Tech select -->
                    <div>
                        <select id="filter-tech" class="w-full px-4 py-2.5 bg-slate-900 border border-slate-800 hover:border-slate-700 focus:border-sky-500 focus:outline-none rounded-xl text-sm text-slate-300 transition-all cursor-pointer">
                            <option value="Todos">Tecnologia (Todas)</option>
                            <option value="Laravel">Laravel</option>
                            <option value="PHP">PHP (Puro)</option>
                            <option value="Flutter">Flutter (Mobile)</option>
                            <option value="React">React</option>
                            <option value="Python">Python</option>
                            <option value="Inteligência Artificial">Inteligência Artificial (IA)</option>
                        </select>
                    </div>
                </div>

                <!-- Row 2: Sector Buttons and Reset -->
                <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 pt-3 border-t border-slate-800/60">
                    <div class="flex flex-wrap gap-2 items-center">
                        <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider font-mono mr-2">Sectores:</span>
                        <button class="sector-filter-btn px-3 py-1.5 rounded-lg border border-slate-800 hover:border-slate-700 text-xs font-medium transition-all tab-active flex items-center gap-1.5" data-sector="Todos">
                            <i data-lucide="layers" class="w-3.5 h-3.5"></i> Todos
                        </button>
                        <button class="sector-filter-btn px-3 py-1.5 rounded-lg border border-slate-800 hover:border-slate-700 text-xs font-medium transition-all flex items-center gap-1.5" data-sector="Saúde">
                            <i data-lucide="heart-pulse" class="w-3.5 h-3.5"></i> Saúde
                        </button>
                        <button class="sector-filter-btn px-3 py-1.5 rounded-lg border border-slate-800 hover:border-slate-700 text-xs font-medium transition-all flex items-center gap-1.5" data-sector="Educação">
                            <i data-lucide="graduation-cap" class="w-3.5 h-3.5"></i> Educação
                        </button>
                        <button class="sector-filter-btn px-3 py-1.5 rounded-lg border border-slate-800 hover:border-slate-700 text-xs font-medium transition-all flex items-center gap-1.5" data-sector="Agricultura e Ambiente">
                            <i data-lucide="sprout" class="w-3.5 h-3.5"></i> Agricultura
                        </button>
                        <button class="sector-filter-btn px-3 py-1.5 rounded-lg border border-slate-800 hover:border-slate-700 text-xs font-medium transition-all flex items-center gap-1.5" data-sector="Empreendedorismo e PMEs">
                            <i data-lucide="shopping-bag" class="w-3.5 h-3.5"></i> PMEs / Negócios
                        </button>
                        <button class="sector-filter-btn px-3 py-1.5 rounded-lg border border-slate-800 hover:border-slate-700 text-xs font-medium transition-all flex items-center gap-1.5" data-sector="Inclusão Social">
                            <i data-lucide="accessibility" class="w-3.5 h-3.5"></i> Inclusão
                        </button>
                        <button class="sector-filter-btn px-3 py-1.5 rounded-lg border border-slate-800 hover:border-slate-700 text-xs font-medium transition-all flex items-center gap-1.5" data-sector="Governação">
                            <i data-lucide="landmark" class="w-3.5 h-3.5"></i> Governação
                        </button>
                        <button class="sector-filter-btn px-3 py-1.5 rounded-lg border border-slate-800 hover:border-slate-700 text-xs font-medium transition-all flex items-center gap-1.5" data-sector="Inteligência Artificial">
                            <i data-lucide="cpu" class="w-3.5 h-3.5"></i> I.A.
                        </button>
                    </div>
                    
                    <button id="reset-filters-btn" class="flex items-center gap-1.5 text-xs font-semibold text-sky-400 hover:text-sky-300 transition-colors uppercase tracking-wider font-mono self-end lg:self-auto">
                        <i data-lucide="refresh-cw" class="w-3.5 h-3.5"></i> Limpar Filtros
                    </button>
                </div>
            </div>

            <!-- Empty State -->
            <div id="empty-state" class="hidden py-16 text-center glass-panel rounded-2xl border border-slate-800">
                <i data-lucide="alert-circle" class="w-12 h-12 mx-auto text-slate-600 mb-4"></i>
                <h3 class="text-md font-bold text-white mb-1">Nenhum projeto encontrado</h3>
                <p class="text-xs text-slate-400 max-w-md mx-auto">Tente ajustar seus termos de pesquisa ou redefinir os filtros selecionados.</p>
            </div>

            <!-- Grid of Cards -->
            <div id="projects-grid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Dynamically loaded -->
            </div>
            
        </section>

        <!-- 2. SECTION: ROADMAP & STRATEGY -->
        <section id="section-mobilizacao" class="content-section hidden">
            
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Timeline Column -->
                <div class="lg:col-span-2 space-y-6">
                    <h2 class="text-2xl font-bold text-white font-display flex items-center gap-2">
                        <i data-lucide="calendar" class="w-6 h-6 text-sky-400"></i> Cronograma de Ação (Junho - Setembro)
                    </h2>
                    
                    <div class="glass-panel p-6 rounded-2xl border border-slate-800/80 space-y-6">
                        <!-- Timeline Item 1 -->
                        <div class="timeline-item relative pl-8 pb-4">
                            <div class="absolute left-0 top-1 w-5 h-5 rounded-full bg-sky-500 border-4 border-slate-950 z-10 flex items-center justify-center"></div>
                            <div>
                                <span class="text-xs font-bold text-sky-400 uppercase font-mono tracking-wider">Junho (Semanas 1-2)</span>
                                <h3 class="text-md font-bold text-slate-100 mt-0.5">Sensibilização & Criação de Grupos</h3>
                                <p class="text-sm text-slate-400 mt-1 leading-relaxed">
                                    Inscrição dos grupos no portal. Organização dos estudantes do 1.º ano em grupos de 2 a 4 elementos. Escolha da ideia e contacto com mentores finalistas para acompanhamento técnico.
                                </p>
                            </div>
                        </div>
                        
                        <!-- Timeline Item 2 -->
                        <div class="timeline-item relative pl-8 pb-4">
                            <div class="absolute left-0 top-1 w-5 h-5 rounded-full bg-sky-500 border-4 border-slate-950 z-10 flex items-center justify-center"></div>
                            <div>
                                <span class="text-xs font-bold text-sky-400 uppercase font-mono tracking-wider">Junho - Julho (Semanas 3-6)</span>
                                <h3 class="text-md font-bold text-slate-100 mt-0.5">Investigação de Campo & Modelação</h3>
                                <p class="text-sm text-slate-400 mt-1 leading-relaxed">
                                    Os grupos visitam e realizam pesquisas junto a farmácias, escolas, machambas ou lojas comerciais locais em Quelimane. Formulação das perguntas de investigação científica e desenho da base de dados.
                                </p>
                            </div>
                        </div>

                        <!-- Timeline Item 3 -->
                        <div class="timeline-item relative pl-8 pb-4">
                            <div class="absolute left-0 top-1 w-5 h-5 rounded-full bg-sky-500 border-4 border-slate-950 z-10 flex items-center justify-center"></div>
                            <div>
                                <span class="text-xs font-bold text-sky-400 uppercase font-mono tracking-wider">Julho - Agosto (Semanas 7-10)</span>
                                <h3 class="text-md font-bold text-slate-100 mt-0.5">Desenvolvimento do MVP</h3>
                                <p class="text-sm text-slate-400 mt-1 leading-relaxed">
                                    Programação do esqueleto do site/sistema. Criação dos formulários de recolha de dados (CRUD) no PHP Puro ou Laravel. Ligação com a base de dados MySQL.
                                </p>
                            </div>
                        </div>

                        <!-- Timeline Item 4 -->
                        <div class="timeline-item relative pl-8 pb-4">
                            <div class="absolute left-0 top-1 w-5 h-5 rounded-full bg-amber-500 border-4 border-slate-950 z-10 flex items-center justify-center"></div>
                            <div>
                                <span class="text-xs font-bold text-amber-500 uppercase font-mono tracking-wider">15 de Agosto</span>
                                <h3 class="text-md font-bold text-amber-400 mt-0.5">Exposição: Dia da Informática</h3>
                                <p class="text-sm text-slate-300 mt-1 leading-relaxed font-medium">
                                    Apresentação pública dos protótipos em stands e demonstrações em tempo real para docentes, empresas locais e visitantes.
                                </p>
                            </div>
                        </div>

                        <!-- Timeline Item 5 -->
                        <div class="timeline-item relative pl-8">
                            <div class="absolute left-0 top-1 w-5 h-5 rounded-full bg-emerald-500 border-4 border-slate-950 z-10 flex items-center justify-center"></div>
                            <div>
                                <span class="text-xs font-bold text-emerald-400 uppercase font-mono tracking-wider">Agosto - Setembro</span>
                                <h3 class="text-md font-bold text-slate-100 mt-0.5">Escrita do Artigo Científico</h3>
                                <p class="text-sm text-slate-400 mt-1 leading-relaxed">
                                    Refinamento técnico das funcionalidades. Elaboração do artigo científico de 5 a 8 páginas que resume o problema, metodologia e resultados para submissão nas Jornadas Científicas.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Mentorship and Criteria Column -->
                <div class="space-y-6">
                    <h2 class="text-2xl font-bold text-white font-display flex items-center gap-2">
                        <i data-lucide="users" class="w-6 h-6 text-sky-400"></i> Mentoria Colectiva
                    </h2>
                    
                    <div class="glass-panel p-5 rounded-2xl border border-slate-800/80 space-y-4">
                        <p class="text-xs text-slate-400 leading-relaxed">
                            Para evitar desistências e motivar a equipa, adota-se a estrutura em cascata de apoio ao estudante:
                        </p>
                        
                        <!-- Hierarchy Visual -->
                        <div class="space-y-3 pt-2">
                            <div class="p-3 bg-sky-500/10 border border-sky-500/30 rounded-xl text-center">
                                <span class="text-[10px] font-bold uppercase font-mono text-sky-300">Coordenação Científica</span>
                                <h4 class="text-xs font-bold text-white mt-0.5">Filipe (Professor Orientador)</h4>
                            </div>
                            <div class="flex justify-center"><i data-lucide="chevron-down" class="w-4 h-4 text-slate-600"></i></div>
                            <div class="p-3 bg-amber-500/10 border border-amber-500/30 rounded-xl text-center">
                                <span class="text-[10px] font-bold uppercase font-mono text-amber-300">Apoio Tecnológico</span>
                                <h4 class="text-xs font-bold text-white mt-0.5">Estudantes Finalistas (3.º e 4.º Ano)</h4>
                            </div>
                            <div class="flex justify-center"><i data-lucide="chevron-down" class="w-4 h-4 text-slate-600"></i></div>
                            <div class="p-3 bg-emerald-500/10 border border-emerald-500/30 rounded-xl text-center">
                                <span class="text-[10px] font-bold uppercase font-mono text-emerald-300">Executores</span>
                                <h4 class="text-xs font-bold text-white mt-0.5">Caloiros (1.º Ano)</h4>
                            </div>
                        </div>
                    </div>

                    <h2 class="text-2xl font-bold text-white font-display flex items-center gap-2 pt-2">
                        <i data-lucide="check-square" class="w-6 h-6 text-sky-400"></i> O que é avaliado?
                    </h2>
                    
                    <div class="glass-panel p-5 rounded-2xl border border-slate-800/80 space-y-4">
                        <div class="border-b border-slate-800 pb-2">
                            <h4 class="text-xs font-bold text-sky-400 uppercase font-mono tracking-wider">Protótipo MVP (Dia da Informática)</h4>
                            <ul class="text-[11px] text-slate-400 mt-2 space-y-1">
                                <li>· Resolução de problema prático local (30%)</li>
                                <li>· Funcionamento CRUD básico em PHP/BD (30%)</li>
                                <li>· Apresentação e Explicação do Stand (20%)</li>
                                <li>· Esforço Técnico do Grupo (20%)</li>
                            </ul>
                        </div>
                        <div>
                            <h4 class="text-xs font-bold text-amber-500 uppercase font-mono tracking-wider">Artigo Científico (Jornadas)</h4>
                            <ul class="text-[11px] text-slate-400 mt-2 space-y-1">
                                <li>· Estruturação científica (Resumo, Introdução, Metodologia, Resultados, Conclusão) (40%)</li>
                                <li>· Qualidade da fundamentação teórica (30%)</li>
                                <li>· Discussão e conclusões empíricas (30%)</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            
        </section>

        <!-- 3. SECTION: BOILERPLATES / STARTER KIT -->
        <section id="section-boilerplates" class="content-section hidden">
            
            <div class="max-w-4xl mx-auto space-y-6">
                <div class="glass-panel p-6 rounded-2xl border border-slate-800/80 mb-6">
                    <h2 class="text-2xl font-bold text-white font-display flex items-center gap-2 mb-2">
                        <i data-lucide="info" class="w-6 h-6 text-sky-400"></i> Como preparar o seu computador
                    </h2>
                    <p class="text-sm text-slate-400 leading-relaxed mb-4">
                        Para programar com sucesso a base do seu projeto, certifique-se de que tem instaladas as ferramentas base na sua máquina local:
                    </p>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-xs text-slate-300">
                        <div class="p-4 bg-slate-900/50 rounded-xl border border-slate-800">
                            <h4 class="font-bold text-sky-400 mb-1.5 flex items-center gap-1.5">
                                <i data-lucide="server" class="w-4 h-4"></i> 1. XAMPP
                            </h4>
                            <p class="text-slate-400">Pacote tudo-em-um para correr o servidor web Apache e o banco de dados MySQL no Windows/Linux.</p>
                        </div>
                        <div class="p-4 bg-slate-900/50 rounded-xl border border-slate-800">
                            <h4 class="font-bold text-sky-400 mb-1.5 flex items-center gap-1.5">
                                <i data-lucide="terminal" class="w-4 h-4"></i> 2. Composer & PHP
                            </h4>
                            <p class="text-slate-400">Necessário se for trabalhar com Laravel. Instale o PHP 8.2+ e o Composer no sistema local.</p>
                        </div>
                        <div class="p-4 bg-slate-900/50 rounded-xl border border-slate-800">
                            <h4 class="font-bold text-sky-400 mb-1.5 flex items-center gap-1.5">
                                <i data-lucide="edit-3" class="w-4 h-4"></i> 3. VS Code
                            </h4>
                            <p class="text-slate-400">Editor leve recomendado. Instale as extensões PHP Intelephense e Blade Highlighter.</p>
                        </div>
                    </div>

                    <!-- Nota de Criatividade & Protótipos -->
                    <div class="p-4 bg-amber-500/10 border border-amber-500/20 rounded-xl flex items-start gap-3 mt-5">
                        <i data-lucide="sparkles" class="w-5 h-5 text-amber-400 shrink-0 mt-0.5 animate-pulse"></i>
                        <div>
                            <h4 class="text-xs font-bold text-amber-400 uppercase font-mono tracking-wider">Criatividade & Flexibilidade nos Projetos</h4>
                            <p class="text-xs text-slate-300 mt-1 leading-relaxed">
                                <strong>Liberdade Tecnológica:</strong> As tecnologias listadas em cada projeto são sugestões de orientação. Os grupos podem ser criativos e utilizar outras ferramentas ou linguagens de programação.
                            </p>
                            <p class="text-xs text-slate-400 mt-1 leading-relaxed">
                                <strong>Uso de Protótipos:</strong> Caso não haja tempo hábil para codificação total, os estudantes podem apresentar protótipos de alta fidelidade desenhados em ferramentas como Figma, Canva, Penpot ou plataformas low-code/no-code para o <strong>Dia da Informática</strong>. O desenvolvimento será guiado e apoiado de perto pelo docente responsável.
                            </p>
                        </div>
                    </div>
                </div>
                
                <h2 class="text-2xl font-bold text-white font-display flex items-center gap-2 mb-4">
                    <i data-lucide="code-2" class="w-6 h-6 text-sky-400"></i> Modelos Base de Código (Starter Kit)
                </h2>
                
                <div id="boilerplates-container" class="space-y-6">
                    <!-- Loaded dynamically from app.js -->
                </div>
            </div>
            
        </section>

        <!-- NEW SECTION: GUIA DO INVESTIGADOR -->
        <section id="section-guia" class="content-section hidden">
            <div class="max-w-4xl mx-auto space-y-6">
                <!-- Header Card -->
                <div class="glass-panel p-6 rounded-2xl border border-slate-800/80 mb-6 flex flex-col md:flex-row items-center gap-6">
                    <div class="w-16 h-16 rounded-2xl bg-sky-500/10 border border-sky-500/25 flex items-center justify-center text-sky-400 shadow-xl flex-shrink-0">
                        <i data-lucide="graduation-cap" class="w-8 h-8"></i>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-white font-display">Guia do Investigador Científico</h2>
                        <p class="text-sm text-slate-400 leading-relaxed mt-1">
                            Bem-vindo ao teu portal de apoio académico. Este guia prático foi desenhado especialmente para orientar os estudantes do 1.º ano de Engenharia Informática na redação do seu primeiro artigo científico para as <strong>Jornadas Científicas da UniLicungo 2026</strong>.
                        </p>
                    </div>
                </div>

                <!-- Accordions Container -->
                <div class="space-y-4">
                    <!-- ACCORDION 1: APA 7 RULES -->
                    <div class="glass-panel rounded-2xl border border-slate-800 overflow-hidden transition-all duration-300">
                        <button class="w-full px-6 py-5 flex items-center justify-between text-left focus:outline-none hover:bg-slate-900/30 transition-colors" onclick="toggleAccordion('acc-apa')">
                            <span class="flex items-center gap-3 font-bold text-white text-md font-display">
                                <span class="w-7 h-7 rounded-lg bg-sky-500/10 text-sky-400 flex items-center justify-center text-xs font-mono">3a</span>
                                Citação e Referenciação Científica (Regras APA 7.ª Edição)
                            </span>
                            <i id="icon-acc-apa" data-lucide="chevron-down" class="w-5 h-5 text-slate-400 transition-transform duration-300"></i>
                        </button>
                        <div id="content-acc-apa" class="max-h-0 overflow-hidden transition-all duration-300 ease-in-out bg-slate-900/10">
                            <div class="px-6 pb-6 pt-2 space-y-4 border-t border-slate-900/60 text-xs text-slate-300 leading-relaxed">
                                <p>
                                    A norma <strong>APA 7.ª Edição</strong> (American Psychological Association) é o padrão internacionalmente aceite para trabalhos académicos na nossa faculdade. Ela dita como deves referenciar as tuas leituras no corpo do texto e na lista final.
                                </p>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-2">
                                    <div class="p-4 bg-slate-950/60 rounded-xl border border-slate-800/80">
                                        <h4 class="font-bold text-sky-400 mb-2 flex items-center gap-1.5">
                                            <i data-lucide="quote" class="w-3.5 h-3.5"></i> Citação no Corpo do Texto
                                        </h4>
                                        <ul class="space-y-2 list-disc pl-4 text-slate-400">
                                            <li><strong>Citação Direta Curta:</strong> "A transição digital requer infraestrutura resiliente" (Cossa & Mandlate, 2021, p. 16).</li>
                                            <li><strong>Citação Indireta (Paráfrase):</strong> Segundo Langa e Nhantumbo (2020), as limitações de internet em Quelimane podem ser contornadas com o paradigma offline-first.</li>
                                            <li><strong>Três ou mais autores:</strong> Menciona apenas o primeiro seguido de "et al." (ex: Sambo et al., 2022).</li>
                                        </ul>
                                    </div>
                                    
                                    <div class="p-4 bg-slate-950/60 rounded-xl border border-slate-800/80">
                                        <h4 class="font-bold text-sky-400 mb-2 flex items-center gap-1.5">
                                            <i data-lucide="list" class="w-3.5 h-3.5"></i> Exemplos de Referências Bibliográficas
                                        </h4>
                                        <ul class="space-y-2.5 text-slate-400">
                                            <li>
                                                <strong class="text-slate-300 block text-[10px] uppercase font-mono tracking-wider">Livro Impresso:</strong>
                                                Rogers, E. M. (2018). <em>Diffusion of innovations</em> (5.ª ed.). Free Press.
                                            </li>
                                            <li>
                                                <strong class="text-slate-300 block text-[10px] uppercase font-mono tracking-wider">Artigo de Jornal Científico:</strong>
                                                Cossa, H., & Mandlate, F. (2021). Digital health interventions in Mozambique. <em>African Journal of Health Informatics</em>, 5(2), 14–23.
                                            </li>
                                            <li>
                                                <strong class="text-slate-300 block text-[10px] uppercase font-mono tracking-wider">Relatório de Organizações (Web):</strong>
                                                UNICEF. (2022). <em>The state of the world's children in Mozambique</em>. UNICEF Mozambique. https://www.unicef.org/mozambique/relatorios
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ACCORDION 2: IMRaD STRUCTURE -->
                    <div class="glass-panel rounded-2xl border border-slate-800 overflow-hidden transition-all duration-300">
                        <button class="w-full px-6 py-5 flex items-center justify-between text-left focus:outline-none hover:bg-slate-900/30 transition-colors" onclick="toggleAccordion('acc-imrad')">
                            <span class="flex items-center gap-3 font-bold text-white text-md font-display">
                                <span class="w-7 h-7 rounded-lg bg-emerald-500/10 text-emerald-400 flex items-center justify-center text-xs font-mono">3b</span>
                                Estrutura do Artigo Científico (O Modelo IMRaD)
                            </span>
                            <i id="icon-acc-imrad" data-lucide="chevron-down" class="w-5 h-5 text-slate-400 transition-transform duration-300"></i>
                        </button>
                        <div id="content-acc-imrad" class="max-h-0 overflow-hidden transition-all duration-300 ease-in-out bg-slate-900/10">
                            <div class="px-6 pb-6 pt-2 space-y-4 border-t border-slate-900/60 text-xs text-slate-300 leading-relaxed">
                                <p>
                                    O acrónimo <strong>IMRaD</strong> representa a espinha dorsal de um artigo de investigação empírica nas ciências tecnológicas. Ele divide o documento em quatro partes cruciais que respondem a quatro perguntas lógicas:
                                </p>
                                
                                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mt-2">
                                    <div class="p-3 bg-slate-950/60 rounded-xl border border-slate-800/80 flex flex-col justify-between">
                                        <div>
                                            <span class="text-emerald-400 font-bold text-sm block font-mono">I - Introdução</span>
                                            <span class="text-[10px] text-slate-500 block uppercase font-mono mt-0.5">O que estudou e porquê?</span>
                                            <p class="text-slate-400 mt-2">Apresenta o problema prático, a sua contextualização em Quelimane, a justificação, a revisão da literatura básica e o objetivo do protótipo desenvolvido.</p>
                                        </div>
                                    </div>
                                    <div class="p-3 bg-slate-950/60 rounded-xl border border-slate-800/80 flex flex-col justify-between">
                                        <div>
                                            <span class="text-emerald-400 font-bold text-sm block font-mono">M - Metodologia</span>
                                            <span class="text-[10px] text-slate-500 block uppercase font-mono mt-0.5">Como foi estudado?</span>
                                            <p class="text-slate-400 mt-2">Descreve de forma reprodutível a stack tecnológica (Laravel, Flutter, SQLite), o desenho da base de dados, a modelagem UML e os testes de usabilidade piloto aplicados.</p>
                                        </div>
                                    </div>
                                    <div class="p-3 bg-slate-950/60 rounded-xl border border-slate-800/80 flex flex-col justify-between">
                                        <div>
                                            <span class="text-emerald-400 font-bold text-sm block font-mono">R - Resultados</span>
                                            <span class="text-[10px] text-slate-500 block uppercase font-mono mt-0.5">O que descobriu/criou?</span>
                                            <p class="text-slate-400 mt-2">Apresenta os ecrãs do protótipo, a estrutura de tabelas em SQL implementada, as respostas e tempos de execução medidos nos testes com utilizadores.</p>
                                        </div>
                                    </div>
                                    <div class="p-3 bg-slate-950/60 rounded-xl border border-slate-800/80 flex flex-col justify-between">
                                        <div>
                                            <span class="text-emerald-400 font-bold text-sm block font-mono">D - Discussão & Conclusão</span>
                                            <span class="text-[10px] text-slate-500 block uppercase font-mono mt-0.5">O que significa isso tudo?</span>
                                            <p class="text-slate-400 mt-2">Interpreta os resultados perante a literatura. Conclui apontando as limitações físicas e propondo as melhorias e extensões futuras para o projeto.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ACCORDION 3: ETHICAL GUIDELINES -->
                    <div class="glass-panel rounded-2xl border border-slate-800 overflow-hidden transition-all duration-300">
                        <button class="w-full px-6 py-5 flex items-center justify-between text-left focus:outline-none hover:bg-slate-900/30 transition-colors" onclick="toggleAccordion('acc-ethics')">
                            <span class="flex items-center gap-3 font-bold text-white text-md font-display">
                                <span class="w-7 h-7 rounded-lg bg-amber-500/10 text-amber-500 flex items-center justify-center text-xs font-mono">3c</span>
                                Ética e Integridade na Pesquisa Científica
                            </span>
                            <i id="icon-acc-ethics" data-lucide="chevron-down" class="w-5 h-5 text-slate-400 transition-transform duration-300"></i>
                        </button>
                        <div id="content-acc-ethics" class="max-h-0 overflow-hidden transition-all duration-300 ease-in-out bg-slate-900/10">
                            <div class="px-6 pb-6 pt-2 space-y-4 border-t border-slate-900/60 text-xs text-slate-300 leading-relaxed">
                                <p>
                                    Toda a produção académica na <strong>Universidade Licungo</strong> baseia-se nos princípios da honestidade intelectual, integridade e respeito mútuo. Ao recolheres dados ou testares sistemas de saúde ou educação locais, observa o seguinte:
                                </p>
                                
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-2">
                                    <div class="p-4 bg-slate-950/60 rounded-xl border border-slate-800/80">
                                        <h4 class="font-bold text-amber-500 mb-1.5 flex items-center gap-1.5">
                                            <i data-lucide="user-x" class="w-4 h-4"></i> Combate ao Plágio
                                        </h4>
                                        <p class="text-slate-400 leading-relaxed">
                                            A apropriação indevida de ideias, textos ou códigos sem citar a devida fonte é considerada infração grave. Todas as ideias de terceiros devem ser rigorosamente identificadas e referenciadas.
                                        </p>
                                    </div>
                                    
                                    <div class="p-4 bg-slate-950/60 rounded-xl border border-slate-800/80">
                                        <h4 class="font-bold text-amber-500 mb-1.5 flex items-center gap-1.5">
                                            <i data-lucide="shield-check" class="w-4 h-4"></i> Consentimento Informado
                                        </h4>
                                        <p class="text-slate-400 leading-relaxed">
                                            Se realizares inquéritos ou recolheres feedback de utilizadores em Quelimane, deves explicar claramente o objectivo académico do estudo e pedir a sua autorização verbal ou escrita antes do teste.
                                        </p>
                                    </div>
                                    
                                    <div class="p-4 bg-slate-950/60 rounded-xl border border-slate-800/80">
                                        <h4 class="font-bold text-amber-500 mb-1.5 flex items-center gap-1.5">
                                            <i data-lucide="lock" class="w-4 h-4"></i> Tratamento de Dados Sensíveis
                                        </h4>
                                        <p class="text-slate-400 leading-relaxed">
                                            Para projetos nas áreas de saúde e segurança (ex: MaterniCare, VacinaMoz), nunca registes dados de pacientes reais no teu protótipo sem autorização expressa do MISAU ou do hospital parceiro.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- 4. SECTION: APPLICATION GENERATOR -->
        <section id="section-estudante" class="content-section hidden">
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 max-w-6xl mx-auto">
                <!-- Form Column -->
                <div class="space-y-6">
                    <h2 class="text-2xl font-bold text-white font-display flex items-center gap-2">
                        <i data-lucide="edit" class="w-6 h-6 text-sky-400"></i> Ficha de Candidatura do Grupo
                    </h2>
                    
                    <form action="{{ route('portal.submit') }}" method="POST" class="glass-panel p-6 rounded-2xl border border-slate-800/80 space-y-4">
                        @csrf
                        
                        <!-- Project Select -->
                        <div>
                            <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider font-mono mb-2" for="app-project-select">1. Escolher Ideia de Projeto</label>
                            <select name="project_number" id="app-project-select" onchange="updateProjectFields()" class="w-full px-4 py-2.5 bg-slate-900 border border-slate-800 hover:border-slate-700 focus:border-sky-500 focus:outline-none rounded-xl text-sm text-slate-300 transition-all cursor-pointer">
                                @foreach($projects as $p)
                                    @php
                                        $isReserved = in_array($p['number'], $approvedProjects);
                                    @endphp
                                    <option value="{{ $p['number'] }}" data-name="{{ $p['name'] }}" {{ $isReserved ? 'disabled' : '' }}>
                                        #{{ sprintf("%02d", $p['number']) }} - {{ $p['name'] }} {!! $isReserved ? ' (Reservado 🔒)' : '' !!}
                                    </option>
                                @endforeach
                            </select>
                            <input type="hidden" name="project_name" id="app-project-name-hidden">
                        </div>

                        <!-- Tech Select -->
                        <div>
                            <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider font-mono mb-2" for="app-tech-select">2. Tecnologia Principal Selecionada</label>
                            <select name="technology" id="app-tech-select" class="w-full px-4 py-2.5 bg-slate-900 border border-slate-800 hover:border-slate-700 focus:border-sky-500 focus:outline-none rounded-xl text-sm text-slate-300 transition-all cursor-pointer">
                                <option value="PHP Puro + MySQL (Web App)">PHP Puro + MySQL (Web App)</option>
                                <option value="Laravel + MySQL (Web Framework)">Laravel + MySQL (Web Framework)</option>
                                <option value="Flutter + SQLite / API Laravel (Mobile)">Flutter + SQLite / API Laravel (Mobile)</option>
                                <option value="React.js + Node.js (Full Stack SPA)">React.js + Node.js (Full Stack SPA)</option>
                                <option value="Python + Flask API + SQLite">Python + Flask API + SQLite</option>
                            </select>
                        </div>

                        <!-- Mentor Suggested -->
                        <div>
                            <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider font-mono mb-2" for="app-mentor">3. Mentor Sugerido (Finalista de Informática)</label>
                            <input type="text" name="mentor" id="app-mentor" value="{{ old('mentor') }}" placeholder="Nome do estudante do 3.º ou 4.º ano (opcional)" 
                                class="w-full px-4 py-2.5 bg-slate-900 border border-slate-800 hover:border-slate-700 focus:border-sky-500 focus:outline-none rounded-xl text-sm transition-all text-slate-200">
                        </div>

                        <!-- Members of the group -->
                        <div>
                            <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider font-mono mb-2">4. Integrantes do Grupo (Estudantes do 1.º Ano)</label>
                            
                            <div class="mb-3">
                                <input type="email" name="contact_email" value="{{ old('contact_email') }}" placeholder="Email de Contacto do Grupo (Importante para recuperar PIN)" class="w-full px-3 py-2 bg-slate-900 border border-slate-800 hover:border-slate-700 focus:border-sky-500 focus:outline-none rounded-lg text-xs transition-all text-slate-200" required>
                            </div>

                            <div class="grid grid-cols-3 gap-2 mb-2">
                                <input type="text" name="member1_name" value="{{ old('member1_name') }}" placeholder="Nome Estudante 1 (Líder)" class="col-span-2 px-3 py-2 bg-slate-900 border border-slate-800 hover:border-slate-700 focus:border-sky-500 focus:outline-none rounded-lg text-xs transition-all text-slate-200" required>
                                <input type="text" name="member1_code" value="{{ old('member1_code') }}" placeholder="N.º Mec." class="px-3 py-2 bg-slate-900 border border-slate-800 hover:border-slate-700 focus:border-sky-500 focus:outline-none rounded-lg text-xs transition-all text-slate-200" required>
                            </div>
                            
                            <div class="grid grid-cols-3 gap-2 mb-2">
                                <input type="text" name="member2_name" value="{{ old('member2_name') }}" placeholder="Nome Estudante 2" class="col-span-2 px-3 py-2 bg-slate-900 border border-slate-800 hover:border-slate-700 focus:border-sky-500 focus:outline-none rounded-lg text-xs transition-all text-slate-200" required>
                                <input type="text" name="member2_code" value="{{ old('member2_code') }}" placeholder="N.º Mec." class="px-3 py-2 bg-slate-900 border border-slate-800 hover:border-sky-500 focus:outline-none rounded-lg text-xs transition-all text-slate-200" required>
                            </div>

                            <div class="grid grid-cols-3 gap-2 mb-2">
                                <input type="text" name="member3_name" value="{{ old('member3_name') }}" placeholder="Nome Estudante 3 (Opcional)" class="col-span-2 px-3 py-2 bg-slate-900 border border-slate-800 hover:border-slate-700 focus:border-sky-500 focus:outline-none rounded-lg text-xs transition-all text-slate-200">
                                <input type="text" name="member3_code" value="{{ old('member3_code') }}" placeholder="N.º Mec." class="px-3 py-2 bg-slate-900 border border-slate-800 hover:border-sky-500 focus:outline-none rounded-lg text-xs transition-all text-slate-200">
                            </div>

                            <div class="grid grid-cols-3 gap-2">
                                <input type="text" name="member4_name" value="{{ old('member4_name') }}" placeholder="Nome Estudante 4 (Opcional)" class="col-span-2 px-3 py-2 bg-slate-900 border border-slate-800 hover:border-slate-700 focus:border-sky-500 focus:outline-none rounded-lg text-xs transition-all text-slate-200">
                                <input type="text" name="member4_code" value="{{ old('member4_code') }}" placeholder="N.º Mec." class="px-3 py-2 bg-slate-900 border border-slate-800 hover:border-sky-500 focus:outline-none rounded-lg text-xs transition-all text-slate-200">
                            </div>
                        </div>

                        <!-- Motivation and context -->
                        <div>
                            <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider font-mono mb-2" for="app-rationale">5. Porquê este Projeto? (Desafios locais em Quelimane)</label>
                            <textarea name="rationale" id="app-rationale" rows="4" placeholder="Descreva por que o seu grupo escolheu este projeto e que impacto espera causar em Quelimane ou na Província da Zambézia." 
                                class="w-full px-4 py-2.5 bg-slate-900 border border-slate-800 hover:border-slate-700 focus:border-sky-500 focus:outline-none rounded-xl text-xs transition-all text-slate-200 resize-none" required>{{ old('rationale') }}</textarea>
                        </div>
                        
                        <!-- Submit Action -->
                        <button type="submit" class="w-full py-2.5 bg-gradient-ul hover:opacity-90 active:opacity-100 text-white font-semibold rounded-xl text-sm transition-all flex items-center justify-center gap-2 shadow-lg shadow-sky-500/10">
                            <i data-lucide="check" class="w-4 h-4"></i> Registar Grupo no Sistema
                        </button>
                    </form>
                </div>

                <!-- Preview Column -->
                <div class="space-y-6">
                    <h2 class="text-2xl font-bold text-white font-display flex items-center gap-2">
                        <i data-lucide="file-text" class="w-6 h-6 text-sky-400"></i> Ficha de Proposta Gerada
                    </h2>
                    
                    @if(session('candidatura_id'))
                        <!-- Output area -->
                        <div id="generated-output-container" class="glass-panel p-6 rounded-2xl border border-slate-800/80 space-y-4 h-[calc(100%-3rem)] flex flex-col items-center justify-center text-center">
                            
                            <div class="w-16 h-16 bg-emerald-500/10 rounded-full flex items-center justify-center mb-2 shadow-lg shadow-emerald-500/20">
                                <i data-lucide="check" class="w-8 h-8 text-emerald-400"></i>
                            </div>

                            <h3 class="text-xl font-bold text-white font-display">Registo Concluído!</h3>
                            <p class="text-sm text-slate-300 max-w-sm">
                                O vosso grupo foi registado com sucesso no projecto <strong class="text-sky-400">{{ session('project_name') }}</strong>.
                            </p>
                            
                            <div class="w-full bg-slate-900/50 p-4 border border-slate-800 rounded-xl my-4">
                                <p class="text-xs text-slate-400 mb-1">A vossa Senha de Acesso ao Workspace é:</p>
                                <p class="text-2xl font-mono font-bold text-amber-500 tracking-widest">{{ session('generated_pin') }}</p>
                                <p class="text-[10px] text-rose-400 mt-2">Atenção: Por questões de segurança, esta senha não voltará a ser mostrada. Guarde-a!</p>
                            </div>

                            <a href="{{ route('candidatura.pdf', session('candidatura_id')) }}" target="_blank" class="w-full py-3 bg-sky-600 hover:bg-sky-500 active:bg-sky-700 text-white font-bold rounded-xl text-sm transition-all flex items-center justify-center gap-2 shadow-lg shadow-sky-500/20">
                                <i data-lucide="download-cloud" class="w-5 h-5"></i> Baixar Comprovativo PDF
                            </a>
                            
                            <p class="text-[10px] text-slate-500 mt-2">
                                O ficheiro PDF contém as credenciais e orientações. Entregue ao docente Filipe para homologação.
                            </p>
                        </div>
                    @else
                        <!-- Initial Placeholder State -->
                        <div id="proposal-placeholder" class="py-24 text-center glass-panel rounded-2xl border border-slate-800 flex flex-col items-center justify-center h-[calc(100%-3rem)]">
                            <i data-lucide="file-text" class="w-12 h-12 text-slate-700 mb-4"></i>
                            <h3 class="text-sm font-bold text-slate-400">Nenhuma ficha gerada ainda</h3>
                            <p class="text-xs text-slate-500 max-w-xs mx-auto mt-1 leading-normal">
                                Preencha as informações do grupo à esquerda e clique em "Registar Grupo" para submeter e gerar a ficha técnica em tempo real.
                            </p>
                        </div>
                    @endif
                </div>
            </div>
            
        </section>
        
    </main>

    <!-- AI STARTUP ADVISOR MODAL -->
    <div id="ai-advisor-modal" class="fixed inset-0 z-[60] bg-slate-950/80 backdrop-blur-md hidden items-center justify-center p-4 sm:p-6">
        <div class="glass-panel w-full max-w-xl max-h-[90vh] rounded-3xl border border-slate-800/80 shadow-2xl flex flex-col relative animate-zoom-in overflow-hidden">
            <!-- Modal Header -->
            <div class="p-4 sm:px-6 sm:py-4 border-b border-slate-800/80 bg-slate-900/60 flex items-center justify-between flex-shrink-0">
                <div class="flex items-center gap-2 sm:gap-3">
                    <div class="w-8 h-8 rounded-full bg-sky-500/10 border border-sky-500/30 flex items-center justify-center text-sky-400">
                        <i data-lucide="bot" class="w-4 h-4"></i>
                    </div>
                    <h2 class="text-sm sm:text-md font-bold text-white font-display">TechHub AI Advisor</h2>
                </div>
                <button onclick="closeAiModal()" class="w-8 h-8 rounded-lg bg-slate-800 hover:bg-slate-700 text-slate-400 hover:text-white transition-colors flex items-center justify-center focus:outline-none">
                    <i data-lucide="x" class="w-4 h-4"></i>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="p-4 sm:p-6 overflow-y-auto scrollbar-thin">
                <p class="text-sm text-slate-300 mb-4">
                    Escreve um pouco sobre ti. De que temas gostas? O que gostarias de resolver na tua comunidade? A IA vai sugerir-te um projeto.
                </p>
                
                <textarea id="ai-interest-input" rows="3" placeholder="Ex: Gosto de futebol, saúde ou negócios. Gostava de ajudar as farmácias locais..." class="w-full px-4 py-3 bg-slate-900 border border-slate-800 hover:border-slate-700 focus:border-sky-500 focus:outline-none rounded-xl text-sm transition-all text-slate-200 resize-none mb-4"></textarea>

                <button id="btn-ask-ai" onclick="askAiForIdea()" class="w-full py-2.5 bg-gradient-ul hover:opacity-90 active:opacity-100 text-white font-semibold rounded-xl text-sm transition-all flex items-center justify-center gap-2 shadow-lg shadow-sky-500/10 flex-shrink-0">
                    <i data-lucide="sparkles" class="w-4 h-4"></i> Gerar Ideia Mágica
                </button>

                <!-- AI Response Area -->
                <div id="ai-response-area" class="mt-6 hidden">
                    <div class="border-t border-slate-800/80 pt-6">
                        <div class="flex items-center gap-2 mb-3">
                            <i data-lucide="zap" class="w-4 h-4 text-amber-400"></i>
                            <h4 class="text-sm font-bold text-amber-400 uppercase tracking-wider font-mono">Sugestão da IA</h4>
                        </div>
                        <div id="ai-suggestion-content" class="text-sm text-slate-300 leading-relaxed bg-slate-900/50 p-4 rounded-xl border border-slate-800/80 prose prose-invert prose-p:mb-2 prose-strong:text-sky-400">
                            <!-- Content generated by AI -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- FOOTER -->
    <footer class="relative z-10 w-full max-w-7xl mx-auto px-4 mt-12 border-t border-slate-900 pt-6 flex flex-col md:flex-row items-center justify-between text-xs text-slate-500 gap-4">
        <div class="flex flex-col gap-1">
            <div>
                © {{ date('Y') }} Curso de Informática - Universidade Licungo (Faculdade de Ciências e Tecnologia).
            </div>
            <div class="flex items-center gap-1 text-slate-600">
                <span>Desenvolvido por</span>
                <a href="http://146.235.224.99/" target="_blank" class="inline-flex items-center gap-0.5 text-slate-400 hover:text-sky-400 transition-colors font-medium">
                    Dr.Filipe Domingos dos Santos
                </a>
            </div>
        </div>
        <div class="flex items-center gap-4">
            <a href="https://wa.me/258862134230" target="_blank" class="hover:text-emerald-400 text-slate-500 transition-colors flex items-center gap-1 font-semibold uppercase tracking-wider font-mono">
                <i data-lucide="message-circle" class="w-3.5 h-3.5 text-emerald-500"></i> WhatsApp
            </a>
            <a href="{{ route('workspace.login') }}" class="hover:text-sky-400 transition-colors flex items-center gap-1 font-semibold uppercase tracking-wider font-mono">
                <i data-lucide="lock" class="w-3.5 h-3.5"></i> Acesso Reservado
            </a>
        </div>
    </footer>

    <!-- PROJECT DETAIL DIALOG (MODAL) -->
    <div id="project-modal" class="fixed inset-0 z-50 bg-slate-950/80 backdrop-blur-md hidden items-center justify-center p-2 sm:p-4 overflow-y-auto">
        <div class="glass-panel w-full max-w-5xl rounded-2xl sm:rounded-3xl border border-slate-800/80 shadow-2xl flex flex-col max-h-[95vh] sm:max-h-[90vh] overflow-hidden animate-zoom-in">
            <!-- Modal Header -->
            <div class="p-4 sm:px-6 sm:py-4 border-b border-slate-800/80 flex items-start sm:items-center justify-between bg-slate-900/60 flex-shrink-0">
                <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-3 pr-2">
                    <div class="flex items-center gap-2">
                        <span id="modal-project-number" class="text-xs sm:text-sm font-bold font-mono text-sky-400">#00</span>
                        <span id="modal-project-difficulty" class="px-2 py-0.5 rounded-full text-[10px] sm:text-xs font-semibold whitespace-nowrap">Dificuldade</span>
                    </div>
                    <h2 id="modal-project-name" class="text-sm sm:text-lg font-bold text-white font-display leading-tight">Nome do Projeto</h2>
                </div>
                <div class="flex items-center gap-2 flex-shrink-0 mt-1 sm:mt-0">
                    <button onclick="printProject()" class="hidden md:flex px-3 py-1.5 bg-slate-800 hover:bg-slate-700 text-xs font-semibold rounded-lg text-slate-300 transition-colors items-center gap-1.5 focus:outline-none">
                        <i data-lucide="printer" class="w-3.5 h-3.5"></i> Imprimir
                    </button>
                    <button onclick="closeModal()" class="w-8 h-8 rounded-lg bg-slate-800 hover:bg-slate-700 text-slate-400 hover:text-white transition-colors flex items-center justify-center focus:outline-none">
                        <i data-lucide="x" class="w-4 h-4"></i>
                    </button>
                </div>
            </div>

            <!-- Modal Tabs Selection -->
            <div class="px-4 sm:px-6 py-2 border-b border-slate-800/80 bg-slate-900/30 flex gap-2 sm:gap-4 flex-shrink-0 overflow-x-auto scrollbar-none">
                <button id="modal-tab-details" class="px-3 sm:px-4 py-2 border-b-2 border-sky-500 text-sky-400 text-xs font-bold transition-all focus:outline-none flex items-center justify-center gap-1.5 whitespace-nowrap" onclick="switchModalTab('details')">
                    <i data-lucide="file-text" class="w-3.5 h-3.5"></i> Ficha Técnica
                </button>
                <button id="modal-tab-article" class="px-3 sm:px-4 py-2 border-b-2 border-transparent text-slate-400 hover:text-slate-200 text-xs font-bold transition-all focus:outline-none flex items-center justify-center gap-1.5 whitespace-nowrap" onclick="switchModalTab('article')">
                    <i data-lucide="graduation-cap" class="w-3.5 h-3.5"></i> Para o teu Artigo
                </button>
            </div>
            
            <!-- Modal Body (Scrollable) -->
            <div class="p-4 sm:p-6 overflow-y-auto flex-grow">
                <!-- Details tab content container -->
                <div id="modal-content-details" class="space-y-6">
                    <!-- Subtitle / Concept -->
                    <div class="border-b border-slate-900 pb-3">
                        <span class="text-[10px] font-semibold text-slate-500 uppercase tracking-wider font-mono">Subtítulo / Conceito</span>
                        <h4 id="modal-project-subtitle" class="text-md font-bold text-sky-400 mt-0.5">Subtítulo</h4>
                    </div>
                    
                    <!-- Main details grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Column 1: Core Details -->
                        <div class="space-y-4">
                            <div class="p-4 bg-slate-900/40 rounded-xl border border-slate-900/60">
                                <span class="text-[10px] font-semibold text-slate-500 uppercase tracking-wider font-mono">Problema Relacionado</span>
                                <p id="modal-val-problema" class="text-xs text-slate-300 mt-1.5 leading-relaxed">...</p>
                            </div>
                            
                            <div class="p-4 bg-slate-900/40 rounded-xl border border-slate-900/60">
                                <span class="text-[10px] font-semibold text-slate-500 uppercase tracking-wider font-mono">Público-Alvo Directo</span>
                                <p id="modal-val-publico" class="text-xs text-slate-300 mt-1.5 leading-relaxed">...</p>
                            </div>

                            <div class="p-4 bg-slate-900/40 rounded-xl border border-slate-900/60">
                                <span class="text-[10px] font-semibold text-slate-500 uppercase tracking-wider font-mono">Impacto Social Esperado</span>
                                <p id="modal-val-impacto" class="text-xs text-slate-300 mt-1.5 leading-relaxed">...</p>
                            </div>
                        </div>
                        
                        <!-- Column 2: Tech and Execution -->
                        <div class="space-y-4">
                            <div class="p-4 bg-slate-900/40 rounded-xl border border-slate-900/60">
                                <span class="text-[10px] font-semibold text-slate-500 uppercase tracking-wider font-mono">Tecnologias Recomendadas</span>
                                <p id="modal-val-tecnologias" class="text-xs text-sky-400 mt-1.5 font-bold">...</p>
                            </div>

                            <div class="p-4 bg-slate-900/40 rounded-xl border border-slate-900/60">
                                <span class="text-[10px] font-semibold text-slate-500 uppercase tracking-wider font-mono">Viabilidade Comercial / Startup</span>
                                <p id="modal-val-startup" class="text-xs text-slate-300 mt-1.5 leading-relaxed">...</p>
                            </div>

                            <div class="p-4 bg-slate-900/40 rounded-xl border border-slate-900/60">
                                <span class="text-[10px] font-semibold text-slate-500 uppercase tracking-wider font-mono">Parcerias e Integração Institucional</span>
                                <p id="modal-val-parcerias" class="text-xs text-slate-300 mt-1.5 leading-relaxed">...</p>
                            </div>
                        </div>
                    </div>

                    <!-- Features & Future Scope -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="p-4 bg-slate-900/40 rounded-xl border border-slate-900/60">
                            <span class="text-[10px] font-semibold text-slate-500 uppercase tracking-wider font-mono">Funcionalidades Principais</span>
                            <p id="modal-val-funcionalidades" class="text-xs text-slate-300 mt-1.5 leading-relaxed">...</p>
                        </div>
                        <div class="p-4 bg-slate-900/40 rounded-xl border border-slate-900/60">
                            <span class="text-[10px] font-semibold text-slate-500 uppercase tracking-wider font-mono">Melhorias Futuras Sugeridas</span>
                            <p id="modal-val-melhorias" class="text-xs text-slate-300 mt-1.5 leading-relaxed">...</p>
                        </div>
                    </div>

                    <!-- Study Guide / Dev tips -->
                    <div class="p-5 bg-amber-500/5 border border-amber-500/20 rounded-2xl space-y-3">
                        <span class="text-xs font-bold text-amber-500 uppercase font-mono tracking-wider flex items-center gap-1.5">
                            <i data-lucide="help-circle" class="w-4.5 h-4.5"></i> Dicas de Estudo e Programação (1.º Ano)
                        </span>
                        <p class="text-[11px] text-slate-400 leading-normal">
                            Como o seu grupo de caloiros deve iniciar o desenvolvimento deste sistema de forma incremental:
                        </p>
                        <p id="modal-val-dicas" class="text-xs text-slate-300 leading-relaxed font-light">
                            ...
                        </p>
                    </div>

                    <!-- Database Design Block (SQL Generator) -->
                    <div class="p-5 bg-slate-950 rounded-2xl border border-slate-900 space-y-3">
                        <div class="flex items-center justify-between border-b border-slate-900 pb-2">
                            <div class="flex items-center gap-2">
                                <i data-lucide="database" class="w-4 h-4 text-sky-400"></i>
                                <span class="text-xs font-bold text-white uppercase font-mono tracking-wider">Modelagem de Dados (SQL Relacional)</span>
                            </div>
                            <button id="copy-sql-btn" class="px-3 py-1 bg-slate-800 hover:bg-slate-700 text-xs font-semibold rounded text-slate-300 transition-colors flex items-center focus:outline-none">
                                <i data-lucide="copy" class="w-3.5 h-3.5 mr-1"></i> Copiar SQL
                            </button>
                        </div>
                        <pre class="text-xs font-mono text-slate-400 overflow-x-auto leading-relaxed max-h-[200px]"><code id="modal-val-db-schema">...</code></pre>
                    </div>

                    <!-- MVP Roadmap Breakdown -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Step 1 MVP -->
                        <div class="p-4 bg-sky-500/5 border border-sky-500/20 rounded-xl space-y-2">
                            <span class="text-xs font-bold text-sky-400 uppercase font-mono tracking-wider flex items-center gap-1.5">
                                <i data-lucide="check-circle" class="w-4 h-4"></i> Entregável Dia da Informática (15 Ago)
                            </span>
                            <div id="modal-val-mvp-step1" class="text-xs text-slate-300 space-y-1.5 leading-relaxed font-light">
                                <!-- Populated dynamically -->
                            </div>
                        </div>
                        <!-- Step 2 Extension -->
                        <div class="p-4 bg-amber-500/5 border border-amber-500/20 rounded-xl space-y-2">
                            <span class="text-xs font-bold text-amber-500 uppercase font-mono tracking-wider flex items-center gap-1.5">
                                <i data-lucide="trending-up" class="w-4 h-4"></i> Extensão Jornadas Científicas (Setembro)
                            </span>
                            <div id="modal-val-mvp-step2" class="text-xs text-slate-300 space-y-1.5 leading-relaxed font-light">
                                <!-- Populated dynamically -->
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Article tab content container -->
                <div id="modal-content-article" class="hidden space-y-6">
                    <!-- 2a. Perguntas de Investigação Científica -->
                    <div class="p-5 bg-sky-500/5 border border-sky-500/20 rounded-2xl space-y-3">
                        <span class="text-xs font-bold text-sky-400 uppercase font-mono tracking-wider flex items-center gap-1.5">
                            <i data-lucide="search" class="w-4.5 h-4.5"></i> 2a. Perguntas de Investigação Científica
                        </span>
                        <p class="text-[11px] text-slate-400 leading-normal">
                            Para fundamentar o seu artigo para as <strong>Jornadas Científicas</strong>, pesquise e procure responder a estas questões focadas no contexto local (Quelimane/Zambézia):
                        </p>
                        <ul id="modal-val-perguntas-cientificas" class="text-xs text-slate-300 space-y-2.5 list-disc pl-5 leading-relaxed">
                            <!-- Populated dynamically -->
                        </ul>
                    </div>

                    <!-- 2b. Referências Bibliográficas Sugeridas (APA 7) -->
                    <div class="p-5 bg-indigo-500/5 border border-indigo-500/20 rounded-2xl space-y-3">
                        <span class="text-xs font-bold text-indigo-400 uppercase font-mono tracking-wider flex items-center gap-1.5">
                            <i data-lucide="book-open" class="w-4.5 h-4.5"></i> 2b. Referências Bibliográficas Sugeridas (APA 7)
                        </span>
                        <p class="text-[11px] text-slate-400 leading-normal">
                            Use estas referências académicas para fundamentar a sua Revisão de Literatura (inclui pelo menos uma fonte moçambicana ou africana):
                        </p>
                        <div id="modal-val-referencias" class="space-y-3">
                            <!-- Populated dynamically with list of references and copy buttons -->
                        </div>
                    </div>

                    <!-- 2c. Template IMRaD Personalizado -->
                    <div class="p-5 bg-emerald-500/5 border border-emerald-500/20 rounded-2xl space-y-3">
                        <span class="text-xs font-bold text-emerald-400 uppercase font-mono tracking-wider flex items-center gap-1.5">
                            <i data-lucide="layout" class="w-4.5 h-4.5"></i> 2c. Estrutura de Artigo Sugerida (Template IMRaD)
                        </span>
                        <p class="text-[11px] text-slate-400 leading-normal">
                            Diretrizes específicas do que escrever em cada secção principal do seu artigo científico:
                        </p>
                        
                        <div class="space-y-3.5 mt-2">
                            <div class="p-3 bg-slate-900/50 rounded-xl border border-slate-800/80">
                                <span class="text-[10px] font-bold text-emerald-400 uppercase tracking-wider font-mono">Introdução (O quê e Porquê?)</span>
                                <p id="modal-val-imrad-intro" class="text-xs text-slate-300 mt-1 leading-relaxed font-light">...</p>
                            </div>
                            
                            <div class="p-3 bg-slate-900/50 rounded-xl border border-slate-800/80">
                                <span class="text-[10px] font-bold text-emerald-400 uppercase tracking-wider font-mono">Metodologia (Como?)</span>
                                <p id="modal-val-imrad-metodo" class="text-xs text-slate-300 mt-1 leading-relaxed font-light">...</p>
                            </div>
                            
                            <div class="p-3 bg-slate-900/50 rounded-xl border border-slate-800/80">
                                <span class="text-[10px] font-bold text-emerald-400 uppercase tracking-wider font-mono">Resultados (O que foi descoberto/desenvolvido?)</span>
                                <p id="modal-val-imrad-resultado" class="text-xs text-slate-300 mt-1 leading-relaxed font-light">...</p>
                            </div>
                            
                            <div class="p-3 bg-slate-900/50 rounded-xl border border-slate-800/80">
                                <span class="text-[10px] font-bold text-emerald-400 uppercase tracking-wider font-mono">Conclusão (O que significa?)</span>
                                <p id="modal-val-imrad-conclusao" class="text-xs text-slate-300 mt-1 leading-relaxed font-light">...</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Modal Footer -->
            <div class="p-4 sm:px-6 sm:py-4 border-t border-slate-800/80 bg-slate-900/60 flex flex-col sm:flex-row items-center justify-between gap-3 sm:gap-0 flex-shrink-0">
                <span class="text-[10px] sm:text-xs text-slate-500 text-center sm:text-left">Sector: <span id="modal-project-sector" class="text-slate-300">Saúde</span></span>
                <div class="flex flex-col sm:flex-row items-center gap-2 sm:gap-3 w-full sm:w-auto">
                    <button onclick="closeModal()" class="w-full sm:w-auto px-4 py-2 border border-slate-700 hover:bg-slate-800 text-slate-300 text-xs font-semibold rounded-xl transition-colors order-2 sm:order-1">
                        Fechar
                    </button>
                    <button id="modal-apply-btn" class="w-full sm:w-auto px-4 py-2 bg-sky-500 hover:bg-sky-600 text-white text-xs font-semibold rounded-xl transition-colors flex items-center justify-center gap-1.5 order-1 sm:order-2">
                        <i data-lucide="file-text" class="w-4 h-4"></i> <span class="whitespace-nowrap">Escolher Projeto</span>
                    </button>
                    <a id="modal-workspace-btn" href="#" class="hidden w-full sm:w-auto px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white text-xs font-bold rounded-xl transition-colors items-center justify-center gap-1.5 shadow-lg shadow-amber-500/20 order-1 sm:order-3">
                        <i data-lucide="users" class="w-4 h-4"></i> <span class="whitespace-nowrap">Aceder Workspace</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script>
        // Pass JSON database from Laravel PHP to JavaScript
        const projectsData = @json($projects);
        const approvedProjects = @json($approvedProjects);
    </script>
    
    <!-- JavaScript Application Logic -->
    <script>
        // Tab switching logic
        document.querySelectorAll('.nav-tab-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                // Remove active classes
                document.querySelectorAll('.nav-tab-btn').forEach(b => {
                    b.classList.remove('border-sky-500', 'text-sky-400');
                    b.classList.add('border-transparent', 'text-slate-400', 'hover:text-slate-200');
                });
                
                // Add active to current
                btn.classList.add('border-sky-500', 'text-sky-400');
                btn.classList.remove('border-transparent', 'text-slate-400', 'hover:text-slate-200');
                
                const tab = btn.getAttribute('data-tab');
                
                // Hide all sections
                document.querySelectorAll('.content-section').forEach(sec => {
                    sec.classList.add('hidden');
                });
                
                // Show current section
                document.getElementById(`section-${tab}`).classList.remove('hidden');
            });
        });

        // Initialize elements
        let currentProjects = [...projectsData];
        let activeSector = "Todos";

        // DOM elements
        const projectsGrid = document.getElementById('projects-grid');
        const emptyState = document.getElementById('empty-state');
        const searchInput = document.getElementById('search-input');
        const difficultySelect = document.getElementById('filter-difficulty');
        const techSelect = document.getElementById('filter-tech');

        let currentPage = 1;
        const ITEMS_PER_PAGE = 6;

        // Render projects list
        function renderProjects() {
            // Only clear grid if we're on page 1
            if (currentPage === 1) {
                projectsGrid.innerHTML = '';
            }
            
            if (currentProjects.length === 0) {
                emptyState.classList.remove('hidden');
                document.getElementById('load-more-btn-container')?.remove();
                return;
            }
            emptyState.classList.add('hidden');

            const startIndex = (currentPage - 1) * ITEMS_PER_PAGE;
            const endIndex = startIndex + ITEMS_PER_PAGE;
            const projectsToShow = currentProjects.slice(startIndex, endIndex);

            projectsToShow.forEach(project => {
                const card = document.createElement('div');
                card.className = 'glass-card p-5 rounded-2xl border border-slate-900/60 flex flex-col justify-between cursor-pointer animate-fade-in relative overflow-hidden';
                
                // Check if project is reserved
                const isReserved = approvedProjects.includes(project.number);
                
                let reservationBadge = '';
                if (isReserved) {
                    reservationBadge = `<div class="absolute inset-0 bg-slate-950/70 backdrop-blur-[1px] z-10 flex items-center justify-center p-4 text-center">
                        <div class="bg-rose-500/10 border border-rose-500/20 px-3 py-2 rounded-xl text-rose-400 text-xs font-semibold flex flex-col items-center gap-1">
                            <i data-lucide="lock" class="w-4 h-4"></i>
                            <span>RESERVADO POR GRUPO</span>
                        </div>
                    </div>`;
                }

                const sectorIcon = getSectorIcon(project.sector);
                const sectorTagClass = getSectorTagClass(project.sector);
                const diffClass = getDifficultyClass(project.dificuldade);
                
                card.innerHTML = `
                    ${reservationBadge}
                    <div>
                        <!-- Top Section with Number and Icon -->
                        <div class="flex items-center justify-between mb-3">
                            <span class="text-xs font-mono text-slate-500 font-bold">#${String(project.number).padStart(2, '0')}</span>
                            <div class="w-9 h-9 rounded-lg flex items-center justify-center ${sectorTagClass} bg-opacity-20 border border-opacity-30">
                                <i data-lucide="${sectorIcon}" class="w-5 h-5"></i>
                            </div>
                        </div>
                        
                        <!-- Title & Subtitle -->
                        <h3 class="text-md font-bold text-white mb-1 group-hover:text-sky-400 transition-colors">${project.name}</h3>
                        <p class="text-xs text-sky-400/90 font-medium mb-3">${project.subtitle}</p>
                        
                        <!-- Description snippet -->
                        <p class="text-xs text-slate-400 line-clamp-3 mb-4 leading-relaxed">${project.problema}</p>
                    </div>

                    <div>
                        <!-- Tech Tags -->
                        <div class="flex flex-wrap gap-1.5 mb-4">
                            ${project.tecnologias.split(' + ').slice(0, 3).map(tech => `
                                <span class="px-2 py-0.5 bg-slate-900 border border-slate-800 rounded text-[10px] text-slate-300 font-mono">${tech.trim()}</span>
                            `).join('')}
                        </div>
                        
                        <!-- Bottom row with badges -->
                        <div class="flex items-center justify-between border-t border-slate-900 pt-3">
                            <span class="text-[10px] font-semibold text-slate-500 uppercase tracking-wider">${project.sector}</span>
                            <span class="px-2 py-0.5 rounded text-[10px] font-semibold ${diffClass}">${project.dificuldade}</span>
                        </div>
                    </div>
                `;
                
                // Add click listener (all cards clickable now, even reserved)
                card.addEventListener('click', () => openModal(project));
                
                projectsGrid.appendChild(card);
            });

            // Handle Load More Button
            let loadMoreContainer = document.getElementById('load-more-btn-container');
            if (endIndex < currentProjects.length) {
                if (!loadMoreContainer) {
                    loadMoreContainer = document.createElement('div');
                    loadMoreContainer.id = 'load-more-btn-container';
                    loadMoreContainer.className = 'w-full flex justify-center mt-8 col-span-full';
                    
                    const loadMoreBtn = document.createElement('button');
                    loadMoreBtn.className = 'px-6 py-2.5 bg-slate-900 border border-slate-800 hover:border-sky-500 rounded-xl text-sky-400 font-bold transition-all text-sm flex items-center gap-2';
                    loadMoreBtn.innerHTML = '<i data-lucide="plus-circle" class="w-4 h-4"></i> Ver Mais Projetos';
                    loadMoreBtn.onclick = () => {
                        currentPage++;
                        renderProjects();
                    };
                    loadMoreContainer.appendChild(loadMoreBtn);
                    projectsGrid.parentNode.insertBefore(loadMoreContainer, projectsGrid.nextSibling);
                }
            } else if (loadMoreContainer) {
                loadMoreContainer.remove();
            }

            // Re-render Lucide icons inside cards
            lucide.createIcons();
        }

        // Get CSS class for sector tags
        function getSectorTagClass(sector) {
            switch (sector) {
                case 'Saúde': return 'tag-saude';
                case 'Educação': return 'tag-educacao';
                case 'Agricultura e Ambiente': return 'tag-agro';
                case 'Empreendedorismo e PMEs': return 'tag-pme';
                case 'Inclusão Social': return 'tag-inclusao';
                case 'Governação': return 'tag-governacao';
                case 'Inteligência Artificial': return 'tag-ia';
                default: return 'bg-slate-800 border border-slate-700 text-slate-300';
            }
        }

        // Get icon for sectors
        function getSectorIcon(sector) {
            switch (sector) {
                case 'Saúde': return 'heart-pulse';
                case 'Educação': return 'graduation-cap';
                case 'Agricultura e Ambiente': return 'sprout';
                case 'Empreendedorismo e PMEs': return 'shopping-bag';
                case 'Inclusão Social': return 'accessibility';
                case 'Governação': return 'landmark';
                case 'Inteligência Artificial': return 'cpu';
                default: return 'help-circle';
            }
        }

        // Get difficulty badge styles
        function getDifficultyClass(dif) {
            switch (dif) {
                case 'Fácil': return 'badge-facil';
                case 'Médio': return 'badge-medio';
                case 'Avançado': return 'badge-avancado';
                default: return 'bg-slate-800 text-slate-400';
            }
        }

        // Toggle Accordion Panels
        function toggleAccordion(id) {
            const content = document.getElementById(`content-${id}`);
            const icon = document.getElementById(`icon-${id}`);
            
            // Check if it's currently open
            if (content.style.maxHeight && content.style.maxHeight !== '0px') {
                content.style.maxHeight = '0px';
                icon.style.transform = 'rotate(0deg)';
            } else {
                // First close all other accordions for a accordion-group behavior
                document.querySelectorAll('[id^="content-acc-"]').forEach(c => {
                    c.style.maxHeight = '0px';
                });
                document.querySelectorAll('[id^="icon-acc-"]').forEach(i => {
                    i.style.transform = 'rotate(0deg)';
                });

                // Open this one
                content.style.maxHeight = content.scrollHeight + 'px';
                icon.style.transform = 'rotate(180deg)';
            }
        }

        // Filter projects
        function applyFilters() {
            currentPage = 1;
            let filtered = [...projectsData];

            // Filter by search text
            const query = searchInput.value.toLowerCase().trim();
            if (query) {
                filtered = filtered.filter(p => 
                    p.name.toLowerCase().includes(query) ||
                    p.subtitle.toLowerCase().includes(query) ||
                    p.problema.toLowerCase().includes(query) ||
                    p.tecnologias.toLowerCase().includes(query)
                );
            }

            // Filter by Sector
            if (activeSector !== "Todos") {
                filtered = filtered.filter(p => p.sector === activeSector);
            }

            // Filter by Difficulty
            const diff = difficultySelect.value;
            if (diff !== "Todos") {
                filtered = filtered.filter(p => p.dificuldade === diff);
            }

            // Filter by Tech
            const tech = techSelect.value;
            if (tech !== "Todos") {
                filtered = filtered.filter(p => p.tecnologias.includes(tech));
            }

            currentProjects = filtered;
            renderProjects();
        }

        // Sector buttons selection
        document.querySelectorAll('.sector-filter-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                document.querySelectorAll('.sector-filter-btn').forEach(b => b.classList.remove('tab-active'));
                btn.classList.add('tab-active');
                activeSector = btn.getAttribute('data-sector');
                applyFilters();
            });
        });

        // Search inputs change
        searchInput.addEventListener('input', applyFilters);
        difficultySelect.addEventListener('change', applyFilters);
        techSelect.addEventListener('change', applyFilters);

        // Reset button
        document.getElementById('reset-filters-btn').addEventListener('click', () => {
            searchInput.value = '';
            difficultySelect.value = 'Todos';
            techSelect.value = 'Todos';
            activeSector = 'Todos';
            document.querySelectorAll('.sector-filter-btn').forEach(b => b.classList.remove('tab-active'));
            document.querySelector('.sector-filter-btn[data-sector="Todos"]').classList.add('tab-active');
            applyFilters();
        });

        // Calculate statistics dynamically
        function updateStats() {
            document.getElementById('stat-total-projects').innerText = projectsData.length;
            
            const sectors = [...new Set(projectsData.map(p => p.sector))].length;
            document.getElementById('stat-sectors').innerText = sectors;

            const easy = projectsData.filter(p => p.dificuldade === 'Fácil').length;
            const medium = projectsData.filter(p => p.dificuldade === 'Médio').length;
            const hard = projectsData.filter(p => p.dificuldade === 'Avançado').length;

            document.getElementById('stat-facil').innerText = easy;
            document.getElementById('stat-medio').innerText = medium;
            document.getElementById('stat-avancado').innerText = hard;
        }

        // Open details modal
        const modal = document.getElementById('project-modal');
        function openModal(project) {
            // Reset to details tab first
            switchModalTab('details');

            document.getElementById('modal-project-number').innerText = `#${String(project.number).padStart(2, '0')}`;
            document.getElementById('modal-project-name').innerText = project.name;
            document.getElementById('modal-project-subtitle').innerText = project.subtitle;
            document.getElementById('modal-project-sector').innerText = project.sector;
            
            const diffBadge = document.getElementById('modal-project-difficulty');
            diffBadge.innerText = project.dificuldade;
            diffBadge.className = `px-2.5 py-0.5 rounded-full text-xs font-semibold ${getDifficultyClass(project.dificuldade)}`;

            document.getElementById('modal-val-problema').innerText = project.problema;
            document.getElementById('modal-val-publico').innerText = project.publico_alvo;
            document.getElementById('modal-val-impacto').innerText = project.impacto;
            document.getElementById('modal-val-tecnologias').innerText = project.tecnologias;
            document.getElementById('modal-val-startup').innerText = project.potencial_startup || project.startup;
            document.getElementById('modal-val-parcerias').innerText = project.parcerias_sugeridas || project.parcerias;
            document.getElementById('modal-val-funcionalidades').innerText = project.funcionalidades_principais || project.funcionalidades;
            document.getElementById('modal-val-melhorias').innerText = project.melhorias_futuras || project.melhorias;
            
            // Set Dicas de Estudo
            document.getElementById('modal-val-dicas').innerText = project.dicas_estudo || "Comece por modelar a base de dados. Crie telas simples com HTML/CSS.";
            
            // Populate Scientific Research Questions (Tab 2)
            const pcList = document.getElementById('modal-val-perguntas-cientificas');
            pcList.innerHTML = '';
            (project.perguntas_artigo || []).forEach(q => {
                const li = document.createElement('li');
                li.innerText = q;
                pcList.appendChild(li);
            });

            // Populate References (Tab 2)
            const refContainer = document.getElementById('modal-val-referencias');
            refContainer.innerHTML = '';
            (project.referencias_artigo || []).forEach((ref) => {
                const div = document.createElement('div');
                div.className = "flex items-start justify-between gap-3 p-2 bg-slate-900/60 rounded-lg border border-slate-800/60 hover:border-slate-700/80 transition-colors";
                
                const textSpan = document.createElement('span');
                textSpan.className = "text-xs text-slate-300 leading-normal pr-2";
                textSpan.innerHTML = ref.replace(/\*(.*?)\*/g, '<em>$1</em>');
                
                const copyBtn = document.createElement('button');
                copyBtn.className = "px-2 py-1 bg-slate-800 hover:bg-slate-750 text-[10px] font-semibold rounded text-slate-400 hover:text-white transition-colors flex-shrink-0 flex items-center gap-1 focus:outline-none";
                copyBtn.innerHTML = `<i data-lucide="copy" class="w-3 h-3"></i> Copiar`;
                copyBtn.onclick = () => {
                    const cleanRef = ref.replace(/\*/g, '');
                    navigator.clipboard.writeText(cleanRef).then(() => {
                        copyBtn.innerHTML = `<i data-lucide="check" class="w-3 h-3 text-emerald-400"></i> Copiado!`;
                        lucide.createIcons();
                        setTimeout(() => {
                            copyBtn.innerHTML = `<i data-lucide="copy" class="w-3 h-3"></i> Copiar`;
                            lucide.createIcons();
                        }, 2000);
                    });
                };
                
                div.appendChild(textSpan);
                div.appendChild(copyBtn);
                refContainer.appendChild(div);
            });

            // Populate IMRaD Guide (Tab 2)
            const imrad = project.imrad_artigo || {};
            document.getElementById('modal-val-imrad-intro').innerText = imrad.introducao || '';
            document.getElementById('modal-val-imrad-metodo').innerText = imrad.metodologia || '';
            document.getElementById('modal-val-imrad-resultado').innerText = imrad.resultados || '';
            document.getElementById('modal-val-imrad-conclusao').innerText = imrad.conclusao || '';

            // Database Design (SQL)
            const sqlBlock = document.getElementById('modal-val-db-schema');
            sqlBlock.innerText = getDatabaseSchema(project.sector, project.name);

            // MVP Roadmap
            const mvpDetails = getMVPDetails(project.sector);
            const mvp1Container = document.getElementById('modal-val-mvp-step1');
            const mvp2Container = document.getElementById('modal-val-mvp-step2');
            
            mvp1Container.innerHTML = mvpDetails.mvp.map(item => `<div>• ${item}</div>`).join('');
            mvp2Container.innerHTML = mvpDetails.extension.map(item => `<div>• ${item}</div>`).join('');

            // Apply button and Workspace button logic
            const applyBtn = document.getElementById('modal-apply-btn');
            const workspaceBtn = document.getElementById('modal-workspace-btn');
            
            const isReserved = approvedProjects.includes(project.number);
            
            if (isReserved) {
                applyBtn.classList.add('hidden');
                workspaceBtn.classList.remove('hidden');
                workspaceBtn.href = `{{ url('/workspace/login') }}?project_number=${project.number}`;
            } else {
                applyBtn.classList.remove('hidden');
                workspaceBtn.classList.add('hidden');
                applyBtn.onclick = () => {
                    closeModal();
                    selectProjectForRegistration(project.number);
                };
            }

            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.style.overflow = 'hidden';
            
            lucide.createIcons();
        }

        // Tab switcher inside modal
        function switchModalTab(tabId) {
            const detailsTabBtn = document.getElementById('modal-tab-details');
            const articleTabBtn = document.getElementById('modal-tab-article');
            const detailsContent = document.getElementById('modal-content-details');
            const articleContent = document.getElementById('modal-content-article');

            if (tabId === 'details') {
                detailsTabBtn.classList.add('border-sky-500', 'text-sky-400');
                detailsTabBtn.classList.remove('border-transparent', 'text-slate-400', 'hover:text-slate-200');
                articleTabBtn.classList.add('border-transparent', 'text-slate-400', 'hover:text-slate-200');
                articleTabBtn.classList.remove('border-sky-500', 'text-sky-400');

                detailsContent.classList.remove('hidden');
                articleContent.classList.add('hidden');
            } else {
                articleTabBtn.classList.add('border-sky-500', 'text-sky-400');
                articleTabBtn.classList.remove('border-transparent', 'text-slate-400', 'hover:text-slate-200');
                detailsTabBtn.classList.add('border-transparent', 'text-slate-400', 'hover:text-slate-200');
                detailsTabBtn.classList.remove('border-sky-500', 'text-sky-400');

                articleContent.classList.remove('hidden');
                detailsContent.classList.add('hidden');
            }
        }

        // Print active project technical details
        function printProject() {
            window.print();
        }

        // Close details modal
        function closeModal() {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.style.overflow = 'auto';
        }

        // Close modal on overlay click
        modal.addEventListener('click', (e) => {
            if (e.target === modal) closeModal();
        });

        // Copy SQL code helper
        document.getElementById('copy-sql-btn').addEventListener('click', () => {
            const sqlText = document.getElementById('modal-val-db-schema').innerText;
            navigator.clipboard.writeText(sqlText).then(() => {
                const btn = document.getElementById('copy-sql-btn');
                btn.innerHTML = `<i data-lucide="check" class="w-3.5 h-3.5 mr-1"></i> Copiado!`;
                lucide.createIcons();
                setTimeout(() => {
                    btn.innerHTML = `<i data-lucide="copy" class="w-3.5 h-3.5 mr-1"></i> Copiar SQL`;
                    lucide.createIcons();
                }, 2000);
            });
        });

        // Copy generated proposal helper
        const copyProposalBtn = document.getElementById('copy-proposal-btn');
        if (copyProposalBtn) {
            copyProposalBtn.addEventListener('click', () => {
                const proposalText = document.getElementById('generated-proposal-text').value;
                navigator.clipboard.writeText(proposalText).then(() => {
                    copyProposalBtn.innerHTML = `<i data-lucide="check" class="w-3.5 h-3.5 mr-1"></i> Copiado!`;
                    lucide.createIcons();
                    setTimeout(() => {
                        copyProposalBtn.innerHTML = `<i data-lucide="copy" class="w-3.5 h-3.5 mr-1"></i> Copiar Ficha (Markdown)`;
                        lucide.createIcons();
                    }, 2000);
                });
            });
        }

        // Handle project selection for form
        function selectProjectForRegistration(projectNumber) {
            // Switch to form tab
            const formTabBtn = document.querySelector('.nav-tab-btn[data-tab="estudante"]');
            if (formTabBtn) formTabBtn.click();
            
            // Select the option in dropdown
            const select = document.getElementById('app-project-select');
            select.value = projectNumber;
            updateProjectFields();
        }

        function updateProjectFields() {
            const select = document.getElementById('app-project-select');
            const selectedOption = select.options[select.selectedIndex];
            if (selectedOption) {
                const projectName = selectedOption.getAttribute('data-name');
                document.getElementById('app-project-name-hidden').value = projectName;
            }
        }

        // Get generic database schema suggested for students
        function getDatabaseSchema(sector, projectName) {
            const cleanProjectName = projectName.toLowerCase()
                .normalize("NFD").replace(/[\u0300-\u036f]/g, "") // remove accents
                .replace(/[^a-z0-9]/g, "_")
                .substring(0, 20);

            let schema = `CREATE DATABASE IF NOT EXISTS db_${cleanProjectName};\nUSE db_${cleanProjectName};\n\n`;
            
            // Default user tables
            schema += `-- Tabela de Controlo de Acesso e Utilizadores\n`;
            schema += `CREATE TABLE utilizadores (\n`;
            schema += `    id INT AUTO_INCREMENT PRIMARY KEY,\n`;
            schema += `    nome VARCHAR(100) NOT NULL,\n`;
            schema += `    email VARCHAR(100) UNIQUE NOT NULL,\n`;
            schema += `    senha VARCHAR(255) NOT NULL,\n`;
            schema += `    perfil ENUM('Estudante', 'Docente', 'Administrador') DEFAULT 'Estudante',\n`;
            schema += `    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP\n`;
            schema += `);\n\n`;

            if (sector === 'Saúde') {
                schema += `-- Tabela de Pacientes (Utentes do Hospital/Clínica)\n`;
                schema += `CREATE TABLE pacientes (\n`;
                schema += `    id INT AUTO_INCREMENT PRIMARY KEY,\n`;
                schema += `    nome_completo VARCHAR(150) NOT NULL,\n`;
                schema += `    data_nascimento DATE NOT NULL,\n`;
                schema += `    genero ENUM('M', 'F') NOT NULL,\n`;
                schema += `    contacto_telemovel VARCHAR(20) NOT NULL,\n`;
                schema += `    endereco_bairro VARCHAR(100) DEFAULT 'Quelimane',\n`;
                schema += `    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP\n`;
                schema += `);\n\n`;
                
                schema += `-- Tabela de Consultas e Registos Clínicos\n`;
                schema += `CREATE TABLE consultas (\n`;
                schema += `    id INT AUTO_INCREMENT PRIMARY KEY,\n`;
                schema += `    paciente_id INT NOT NULL,\n`;
                schema += `    data_consulta DATETIME NOT NULL,\n`;
                schema += `    sintomas TEXT NOT NULL,\n`;
                schema += `    diagnostico TEXT NOT NULL,\n`;
                schema += `    tratamento_receitado TEXT,\n`;
                schema += `    medico_responsavel VARCHAR(100),\n`;
                schema += `    FOREIGN KEY (paciente_id) REFERENCES pacientes(id) ON DELETE CASCADE\n`;
                schema += `);\n`;
            } else if (sector === 'Educação') {
                schema += `-- Tabela de Estudantes\n`;
                schema += `CREATE TABLE alunos (\n`;
                schema += `    id INT AUTO_INCREMENT PRIMARY KEY,\n`;
                schema += `    numero_matricula VARCHAR(30) UNIQUE NOT NULL,\n`;
                schema += `    nome_completo VARCHAR(150) NOT NULL,\n`;
                schema += `    turma_classe VARCHAR(20) NOT NULL,\n`;
                schema += `    contacto_encarregado VARCHAR(25)\n`;
                schema += `);\n\n`;

                schema += `-- Tabela de Lançamento de Notas / Avaliações\n`;
                schema += `CREATE TABLE avaliacoes (\n`;
                schema += `    id INT AUTO_INCREMENT PRIMARY KEY,\n`;
                schema += `    aluno_id INT NOT NULL,\n`;
                schema += `    disciplina VARCHAR(80) NOT NULL,\n`;
                schema += `    nota_avaliacao DECIMAL(4,2) NOT NULL,\n`;
                schema += `    tipo_teste ENUM('Teste 1', 'Teste 2', 'Trabalho', 'Exame') NOT NULL,\n`;
                schema += `    data_lancamento TIMESTAMP DEFAULT CURRENT_TIMESTAMP,\n`;
                schema += `    FOREIGN KEY (aluno_id) REFERENCES alunos(id) ON DELETE CASCADE\n`;
                schema += `);\n`;
            } else if (sector === 'Agricultura e Ambiente') {
                schema += `-- Tabela de Produtores e Associações Agrícolas\n`;
                schema += `CREATE TABLE produtores (\n`;
                schema += `    id INT AUTO_INCREMENT PRIMARY KEY,\n`;
                schema += `    nome_completo VARCHAR(150) NOT NULL,\n`;
                schema += `    localizacao_distrito VARCHAR(80) DEFAULT 'Quelimane',\n`;
                schema += `    cultura_principal VARCHAR(100) NOT NULL,\n`;
                schema += `    tamanho_machamba_hectares DECIMAL(5,2),\n`;
                schema += `    contacto_contacto VARCHAR(25)\n`;
                schema += `);\n\n`;

                schema += `-- Tabela de Registo de Vendas e Escoamento de Culturas\n`;
                schema += `CREATE TABLE vendas_produtos (\n`;
                schema += `    id INT AUTO_INCREMENT PRIMARY KEY,\n`;
                schema += `    produtor_id INT NOT NULL,\n`;
                schema += `    produto_nome VARCHAR(100) NOT NULL,\n`;
                schema += `    quantidade_kg DECIMAL(8,2) NOT NULL,\n`;
                schema += `    preco_por_kg DECIMAL(10,2) NOT NULL,\n`;
                schema += `    data_venda DATE NOT NULL,\n`;
                schema += `    FOREIGN KEY (produtor_id) REFERENCES produtores(id) ON DELETE CASCADE\n`;
                schema += `);\n`;
            } else {
                schema += `-- Tabela Geral de Itens / Entidades Principais\n`;
                schema += `CREATE TABLE items (\n`;
                schema += `    id INT AUTO_INCREMENT PRIMARY KEY,\n`;
                schema += `    titulo VARCHAR(100) NOT NULL,\n`;
                schema += `    descricao TEXT NOT NULL,\n`;
                schema += `    categoria VARCHAR(50),\n`;
                schema += `    estado VARCHAR(30) DEFAULT 'Ativo',\n`;
                schema += `    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP\n`;
                schema += `);\n\n`;

                schema += `-- Tabela de Registos de Transações / Atividades\n`;
                schema += `CREATE TABLE registo_actividades (\n`;
                schema += `    id INT AUTO_INCREMENT PRIMARY KEY,\n`;
                schema += `    item_id INT NOT NULL,\n`;
                schema += `    utilizador_id INT NOT NULL,\n`;
                schema += `    descricao_actividade TEXT NOT NULL,\n`;
                schema += `    data_registo TIMESTAMP DEFAULT CURRENT_TIMESTAMP,\n`;
                schema += `    FOREIGN KEY (item_id) REFERENCES items(id) ON DELETE CASCADE,\n`;
                schema += `    FOREIGN KEY (utilizador_id) REFERENCES utilizadores(id)\n`;
                schema += `);\n`;
            }
            return schema;
        }

        // Get generic roadmaps for MVP and extensions
        function getMVPDetails(sector) {
            switch (sector) {
                case 'Saúde':
                    return {
                        mvp: [
                            "Interface Web simples em PHP/Laravel com formulário de cadastro de pacientes e médicos.",
                            "Validação básica dos dados introduzidos (campos obrigatórios e formato de telemóvel).",
                            "Ecrã de listagem de pacientes registados com opção de eliminar ou pesquisar pelo nome.",
                            "Estrutura base de dados funcional instalada e conectada ao MySQL local."
                        ],
                        extension: [
                            "Geração de relatórios automáticos em PDF com gráficos de atendimento diário.",
                            "Serviço simulado de envio automático de SMS para lembrar a data da consulta.",
                            "Painel de controlo (Dashboard) para o médico ver estatísticas de patologias frequentes.",
                            "Suporte básico a funcionamento offline para registo de dados sem internet."
                        ]
                    };
                case 'Educação':
                    return {
                        mvp: [
                            "Sistema básico de presenças de alunos em salas de aula.",
                            "Páginas HTML simples para professores selecionarem a disciplina e marcar 'Presença' ou 'Falta'.",
                            "Tabela que mostra o resumo de faltas acumuladas por cada aluno.",
                            "Script SQL de alunos importados para evitar registo manual demorado."
                        ],
                        extension: [
                            "Visualização gráfica do aproveitamento de notas por turma usando Chart.js.",
                            "Portal simplificado para encarregados de educação consultarem faltas via telemóvel.",
                            "Exportação de pautas de aproveitamento directamente para ficheiros Excel.",
                            "Sistema de alertas automáticos quando o aluno ultrapassa o limite legal de faltas."
                        ]
                    };
                case 'Agricultura e Ambiente':
                    return {
                        mvp: [
                            "Registo de produtores locais e os seus principais produtos para venda.",
                            "Catálogo público simples com imagens dos produtos, preços recomendados e contactos.",
                            "Área administrativa para o produtor actualizar o stock e os preços na base de dados.",
                            "Painel de navegação responsivo adaptado para ecrãs de telemóveis antigos."
                        ],
                        extension: [
                            "Integração com API de geolocalização para desenhar um mapa simples com os pontos de venda em Quelimane.",
                            "API simulada de pagamentos móveis (M-Pesa/e-Mola) para reserva dos produtos.",
                            "Alertas de previsão meteorológica local integrados no painel do agricultor.",
                            "Versão offline em SQLite que sincroniza quando detecta ligação Wi-Fi."
                        ]
                    };
                default:
                    return {
                        mvp: [
                            "Interface gráfica limpa baseada em grelha para visualização de itens.",
                            "Formulário CRUD completo (Adicionar, Ver, Editar e Eliminar) ligado a base de dados MySQL.",
                            "Pesquisa instantânea simples por palavra-chave no ecrã de listagem.",
                            "Manual de instalação rápida para o júri correr o projeto localmente."
                        ],
                        extension: [
                            "Níveis diferenciados de acessos com níveis de privilégios (Estudante/Docente).",
                            "Gráficos estatísticos que resumem os dados inseridos nas tabelas.",
                            "Exportação dos dados de qualquer listagem para formato CSV/Excel.",
                            "Implementação de API RESTful que permite ligação com outras aplicações externas."
                        ]
                    };
            }
        }

        // On Load Page Initialization
        window.addEventListener('DOMContentLoaded', () => {
            updateStats();
            applyFilters();
            updateProjectFields();
            
            // Check if there is a newly generated proposal/PDF to show
            @if(session('candidatura_id'))
                // Switch to form tab automatically so the user can see the output
                const formTabBtn = document.querySelector('.nav-tab-btn[data-tab="estudante"]');
                if (formTabBtn) formTabBtn.click();
            @endif


        });
        // AI Startup Advisor Functions
        function openAiModal() {
            document.getElementById('ai-advisor-modal').classList.remove('hidden');
            document.getElementById('ai-advisor-modal').classList.add('flex');
            document.body.style.overflow = 'hidden';
        }

        function closeAiModal() {
            document.getElementById('ai-advisor-modal').classList.add('hidden');
            document.getElementById('ai-advisor-modal').classList.remove('flex');
            document.body.style.overflow = '';
        }

        async function askAiForIdea() {
            const interest = document.getElementById('ai-interest-input').value;
            const btn = document.getElementById('btn-ask-ai');
            const responseArea = document.getElementById('ai-response-area');
            const suggestionContent = document.getElementById('ai-suggestion-content');

            // Loading state
            btn.innerHTML = '<i data-lucide="loader-2" class="w-4 h-4 animate-spin"></i> A Pensar...';
            btn.disabled = true;
            btn.classList.add('opacity-50', 'cursor-not-allowed');
            lucide.createIcons();

            try {
                const response = await fetch("{{ route('ai.suggest_idea') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ interest: interest })
                });

                const data = await response.json();

                if (data.success) {
                    suggestionContent.innerHTML = data.suggestion;
                } else {
                    suggestionContent.innerHTML = '<div class="text-rose-400"><i data-lucide="alert-triangle" class="w-4 h-4 inline mr-1"></i> Erro: ' + (data.error || 'Ocorreu um erro ao contactar a IA.') + '</div>';
                }
                
                responseArea.classList.remove('hidden');
            } catch (error) {
                suggestionContent.innerHTML = '<div class="text-rose-400"><i data-lucide="alert-triangle" class="w-4 h-4 inline mr-1"></i> Falha na ligação. Tente novamente.</div>';
                responseArea.classList.remove('hidden');
            } finally {
                // Reset button
                btn.innerHTML = '<i data-lucide="sparkles" class="w-4 h-4"></i> Pedir Outra Ideia';
                btn.disabled = false;
                btn.classList.remove('opacity-50', 'cursor-not-allowed');
                lucide.createIcons();
            }
        }
    </script>
    <!-- FLOATING WHATSAPP BUTTON -->
    <a href="https://wa.me/258862134230" target="_blank" class="fixed bottom-6 right-6 z-50 bg-emerald-500 hover:bg-emerald-600 active:scale-95 text-white p-3.5 rounded-full shadow-2xl flex items-center justify-center transition-all duration-300 hover:shadow-emerald-500/20 group" title="Dúvidas no WhatsApp">
        <i data-lucide="message-circle" class="w-6 h-6"></i>
        <span class="max-w-0 overflow-hidden group-hover:max-w-xs group-hover:ml-2 text-xs font-semibold whitespace-nowrap transition-all duration-500 ease-in-out font-mono">
            Dúvidas? Enviar WhatsApp
        </span>
    </a>

</body>
</html>
