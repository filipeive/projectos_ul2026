<!DOCTYPE html>
<html lang="pt-PT" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acesso | UniLicungo TechHub</title>
    
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
                        sky: { 400: '#38bdf8', 500: '#008ad2', 600: '#0284c7' },
                        amber: { 500: '#c27a1e' }
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
<body class="min-h-screen bg-slate-950 text-slate-100 flex items-center justify-center p-4 relative antialiased">
    
    <!-- Background glowing ambient blobs -->
    <div class="glow-blob-blue"></div>
    <div class="glow-blob-gold"></div>

    <div class="w-full max-w-md relative z-10 animate-zoom-in">
        
        <!-- Logo Header -->
        <div class="text-center mb-6">
            <div class="w-20 h-20 bg-slate-900/60 p-2 rounded-2xl border border-slate-800 flex items-center justify-center backdrop-blur-md mx-auto mb-4">
                <img src="{{ asset('ul.png') }}" alt="Logo UniLicungo" class="w-full h-full object-contain">
            </div>
            <h1 class="text-2xl font-extrabold text-white">Central de Acesso</h1>
            <p class="text-xs text-slate-400 mt-1 font-light">Selecione o seu perfil para continuar</p>
        </div>

        <!-- Login Form Panel -->
        <div class="glass-panel p-6 rounded-3xl border border-slate-800/80 shadow-2xl">
            
            <!-- Tabs -->
            <div class="flex p-1 bg-slate-900/50 rounded-xl border border-slate-800 mb-6">
                <button onclick="switchTab('estudante')" id="tab-estudante" class="flex-1 py-2 text-xs font-bold rounded-lg transition-all text-white bg-slate-800 shadow shadow-black/20 flex items-center justify-center gap-1.5">
                    <i data-lucide="users" class="w-4 h-4"></i> Estudante (Grupo)
                </button>
                <button onclick="switchTab('docente')" id="tab-docente" class="flex-1 py-2 text-xs font-bold rounded-lg transition-all text-slate-400 hover:text-slate-200 flex items-center justify-center gap-1.5">
                    <i data-lucide="shield" class="w-4 h-4"></i> Docente / Admin
                </button>
            </div>

            <!-- Formulário Estudante -->
            <form id="form-estudante" action="{{ route('workspace.login.submit') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2 font-mono">Email do Grupo</label>
                    <div class="relative">
                        <input type="email" name="contact_email" placeholder="estudante@unilicungo.ac.mz" required
                            class="w-full px-4 py-3 bg-slate-900 border border-slate-800 focus:border-sky-500 focus:outline-none rounded-xl text-white transition-colors pl-10 text-sm">
                        <i data-lucide="mail" class="w-4 h-4 text-slate-500 absolute left-3.5 top-3.5"></i>
                    </div>
                </div>
                <div>
                    <div class="flex justify-between items-center mb-2">
                        <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider font-mono">Senha do Grupo</label>
                        <!-- Link recuperar senha Estudante -->
                        <a href="{{ route('workspace.recover-pin-geral') }}" class="text-[10px] text-sky-400 hover:text-sky-300 font-semibold transition-colors">
                            Esqueceste a senha?
                        </a>
                    </div>
                    <div class="relative">
                        <input type="password" name="group_password" placeholder="••••••••" required
                            class="w-full px-4 py-3 bg-slate-900 border border-slate-800 focus:border-sky-500 focus:outline-none rounded-xl text-white transition-colors pl-10 text-sm">
                        <i data-lucide="key" class="w-4 h-4 text-slate-500 absolute left-3.5 top-3.5"></i>
                    </div>
                </div>

                <button type="submit" class="w-full py-3 bg-gradient-ul hover:opacity-90 active:opacity-100 text-white font-semibold rounded-xl text-sm transition-all flex items-center justify-center gap-2 shadow-lg shadow-sky-500/10">
                    <i data-lucide="log-in" class="w-4 h-4"></i> Entrar no Workspace
                </button>
            </form>

            <!-- Formulário Docente -->
            <form id="form-docente" action="{{ url('/admin/login') }}" method="POST" class="space-y-4 hidden">
                @csrf
                <div>
                    <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider font-mono mb-2" for="email">E-mail Institucional</label>
                    <div class="relative">
                        <i data-lucide="mail" class="w-4 h-4 absolute left-3.5 top-3.5 text-slate-500"></i>
                        <input type="email" name="email" id="email" placeholder="nome@unilicungo.ac.mz"
                            class="w-full pl-10 pr-4 py-3 bg-slate-900 border border-slate-800 hover:border-slate-700 focus:border-sky-500 focus:outline-none rounded-xl text-sm transition-all text-slate-200">
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider font-mono mb-2" for="password">Senha de Acesso</label>
                    <div class="relative">
                        <i data-lucide="lock" class="w-4 h-4 absolute left-3.5 top-3.5 text-slate-500"></i>
                        <input type="password" name="password" id="password" placeholder="••••••••••••"
                            class="w-full pl-10 pr-4 py-3 bg-slate-900 border border-slate-800 hover:border-slate-700 focus:border-sky-500 focus:outline-none rounded-xl text-sm transition-all text-slate-200">
                    </div>
                </div>

                <button type="submit" class="w-full py-3 bg-slate-800 hover:bg-slate-700 active:bg-slate-600 border border-slate-700 hover:border-slate-600 text-white font-semibold rounded-xl text-sm transition-all flex items-center justify-center gap-2 shadow-lg shadow-black/10">
                    <i data-lucide="shield-check" class="w-4 h-4"></i> Entrar no Painel Docente
                </button>
            </form>
        </div>

        <div class="text-center mt-6">
            <a href="{{ route('portal.index') }}" class="text-xs text-slate-500 hover:text-sky-400 transition-colors flex items-center justify-center gap-1.5 font-mono uppercase tracking-wider">
                <i data-lucide="arrow-left" class="w-3.5 h-3.5"></i> Voltar ao Catálogo
            </a>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        lucide.createIcons();

        // Tab Switching Logic
        function switchTab(tab) {
            const formEstudante = document.getElementById('form-estudante');
            const formDocente = document.getElementById('form-docente');
            const btnEstudante = document.getElementById('tab-estudante');
            const btnDocente = document.getElementById('tab-docente');

            if (tab === 'estudante') {
                formEstudante.classList.remove('hidden');
                formDocente.classList.add('hidden');
                
                btnEstudante.className = "flex-1 py-2 text-xs font-bold rounded-lg transition-all text-white bg-slate-800 shadow shadow-black/20 flex items-center justify-center gap-1.5";
                btnDocente.className = "flex-1 py-2 text-xs font-bold rounded-lg transition-all text-slate-400 hover:text-slate-200 flex items-center justify-center gap-1.5";
                
                // Disable required fields in docente so it doesn't block submit
                document.getElementById('email').required = false;
                document.getElementById('password').required = false;
                document.querySelector('input[name="contact_email"]').required = true;
                document.querySelector('input[name="group_password"]').required = true;

            } else {
                formEstudante.classList.add('hidden');
                formDocente.classList.remove('hidden');

                btnDocente.className = "flex-1 py-2 text-xs font-bold rounded-lg transition-all text-white bg-slate-800 shadow shadow-black/20 flex items-center justify-center gap-1.5";
                btnEstudante.className = "flex-1 py-2 text-xs font-bold rounded-lg transition-all text-slate-400 hover:text-slate-200 flex items-center justify-center gap-1.5";
                
                document.getElementById('email').required = true;
                document.getElementById('password').required = true;
                document.querySelector('input[name="contact_email"]').required = false;
                document.querySelector('input[name="group_password"]').required = false;
            }
        }
        
        // Setup initial required states based on visible tab
        switchTab('{{ session("tab") ?? "estudante" }}');

        // SweetAlert2 configuration for custom dark theme
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 4000,
            timerProgressBar: true,
            background: '#121929',
            color: '#f8fafc',
            iconColor: '#38bdf8',
            customClass: {
                popup: 'border border-slate-800 rounded-xl shadow-2xl'
            }
        });

        @if($errors->any())
            Toast.fire({
                icon: 'error',
                iconColor: '#f43f5e',
                title: "{{ $errors->first() }}"
            });
        @endif

        @if(session('success'))
            Toast.fire({
                icon: 'success',
                title: "{{ session('success') }}"
            });
        @endif

        @if(session('error'))
            Toast.fire({
                icon: 'error',
                iconColor: '#f43f5e',
                title: "{{ session('error') }}"
            });
        @endif
    </script>
</body>
</html>
