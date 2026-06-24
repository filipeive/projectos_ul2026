<!DOCTYPE html>
<html lang="pt-PT" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acesso Docente | UniLicungo TechHub</title>
    
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
            <h1 class="text-2xl font-extrabold text-white">Área de Administração</h1>
            <p class="text-xs text-slate-400 mt-1 font-light">Validação de candidaturas e gestão do portal</p>
        </div>

        <!-- Login Form Panel -->
        <div class="glass-panel p-6 rounded-3xl border border-slate-800/80 shadow-2xl">


            <form action="{{ url('/admin/login') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider font-mono mb-2" for="email">E-mail</label>
                    <div class="relative">
                        <i data-lucide="mail" class="w-4 h-4 absolute left-3.5 top-3.5 text-slate-500"></i>
                        <input type="email" name="email" id="email" placeholder="nome@unilicungo.ac.mz" required autofocus
                            class="w-full pl-10 pr-4 py-3 bg-slate-900 border border-slate-800 hover:border-slate-700 focus:border-sky-500 focus:outline-none rounded-xl text-sm transition-all text-slate-200">
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider font-mono mb-2" for="password">Senha de Acesso</label>
                    <div class="relative">
                        <i data-lucide="lock" class="w-4 h-4 absolute left-3.5 top-3.5 text-slate-500"></i>
                        <input type="password" name="password" id="password" placeholder="••••••••••••" required
                            class="w-full pl-10 pr-4 py-3 bg-slate-900 border border-slate-800 hover:border-slate-700 focus:border-sky-500 focus:outline-none rounded-xl text-sm transition-all text-slate-200">
                    </div>
                </div>

                <button type="submit" class="w-full py-3 bg-gradient-ul hover:opacity-90 active:opacity-100 text-white font-semibold rounded-xl text-sm transition-all flex items-center justify-center gap-2 shadow-lg shadow-sky-500/10">
                    <i data-lucide="key" class="w-4 h-4"></i> Entrar no Painel
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
    </script>
</body>
</html>
