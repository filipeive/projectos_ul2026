<!DOCTYPE html>
<html lang="pt-PT" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acesso ao Workspace | UniLicungo TechHub</title>
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
<body class="min-h-screen bg-slate-950 text-slate-100 flex items-center justify-center p-4 relative antialiased">
    <div class="glow-blob-blue"></div>
    <div class="glow-blob-gold"></div>

    <div class="glass-panel max-w-md w-full p-6 sm:p-8 rounded-2xl border border-slate-800/80 relative z-10 shadow-2xl animate-zoom-in">
        <div class="text-center mb-8">
            <div class="w-16 h-16 mx-auto bg-slate-900 border border-slate-800 rounded-2xl flex items-center justify-center mb-4 shadow-inner">
                <i data-lucide="key-round" class="w-8 h-8 text-amber-400 animate-pulse"></i>
            </div>
            <h1 class="text-2xl font-bold text-white font-display">Recuperar PIN</h1>
            <p class="text-xs text-slate-400 mt-2">Insira o email ou telemóvel de contacto do grupo associado ao projeto <br><span class="text-sky-400 font-semibold">{{ $candidatura->project_name }}</span></p>
        </div>

        <form action="{{ route('workspace.recover-pin.submit', $candidatura->id) }}" method="POST" class="space-y-4" id="recover-form">
            @csrf
            
            <div>
                <label for="contact_input" class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2 font-mono">Contacto do Grupo</label>
                <div class="relative">
                    <input type="text" id="contact_input" name="contact_email" placeholder="Email ou Telemóvel..." required autocomplete="username"
                        class="peer w-full px-4 py-3 bg-slate-900 border border-slate-800 focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20 focus:outline-none rounded-xl text-white transition-all duration-300 pl-10 text-sm placeholder-slate-500 focus:placeholder-slate-400">
                    <i data-lucide="user" class="w-4 h-4 text-slate-500 absolute left-3.5 top-3.5 transition-colors duration-300 peer-focus:text-amber-400"></i>
                </div>
            </div>

            <button type="submit" class="w-full py-3 bg-amber-600 hover:bg-amber-550 hover:-translate-y-0.5 active:translate-y-0 text-white font-bold rounded-xl transition-all duration-300 shadow-lg flex items-center justify-center gap-2 focus:outline-none focus-visible:ring-2 focus-visible:ring-amber-500 focus-visible:ring-offset-2 focus-visible:ring-offset-slate-950">
                <i data-lucide="send" class="w-4 h-4"></i> Enviar Novo PIN
            </button>
        </form>

        <div class="mt-6 flex flex-col gap-3 text-center">
            <a href="{{ route('workspace.login', ['project_number' => $candidatura->project_number]) }}" class="text-xs text-slate-500 hover:text-sky-400 transition-colors flex items-center justify-center gap-1 font-mono focus:outline-none focus-visible:underline">
                <i data-lucide="arrow-left" class="w-3 h-3"></i> Voltar ao Login
            </a>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        lucide.createIcons();

        // Form Submit Loading Micro-interaction
        document.getElementById('recover-form').addEventListener('submit', function() {
            const btn = this.querySelector('button[type="submit"]');
            if (btn) {
                btn.disabled = true;
                btn.innerHTML = `<span class="inline-block w-4 h-4 border-2 border-white/30 border-t-white rounded-full animate-spin"></span> A enviar...`;
                btn.className = "w-full py-3 bg-amber-800 text-white/80 font-bold rounded-xl flex items-center justify-center gap-2 cursor-not-allowed opacity-75 transition-all duration-300";
            }
        });

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
