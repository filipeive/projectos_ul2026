<!DOCTYPE html>
<html lang="pt-PT" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Senha | UniLicungo TechHub</title>
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
                    }
                }
            }
        }
    </script>
</head>
<body class="min-h-screen bg-slate-950 text-slate-100 flex items-center justify-center p-4 relative antialiased">
    <div class="glow-blob-blue"></div>
    <div class="glow-blob-gold"></div>

    <div class="glass-panel max-w-md w-full p-8 rounded-2xl border border-slate-800/80 relative z-10 shadow-2xl animate-zoom-in">
        <div class="text-center mb-8">
            <div class="w-16 h-16 mx-auto bg-slate-900 border border-slate-800 rounded-2xl flex items-center justify-center mb-4 shadow-inner">
                <i data-lucide="key" class="w-8 h-8 text-sky-400"></i>
            </div>
            <h1 class="text-2xl font-bold text-white font-display">Recuperar Senha</h1>
            <p class="text-xs text-slate-400 mt-2">Insira o email de contacto do grupo para receber um novo PIN.</p>
        </div>

        <form action="{{ route('workspace.recover-pin-geral.submit') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2 font-mono">Email do Grupo</label>
                <div class="relative">
                    <input type="email" name="contact_email" placeholder="estudante@unilicungo.ac.mz" required
                        class="w-full px-4 py-3 bg-slate-900 border border-slate-800 focus:border-sky-500 focus:outline-none rounded-xl text-white transition-colors pl-10 text-sm">
                    <i data-lucide="mail" class="w-4 h-4 text-slate-500 absolute left-3.5 top-3.5"></i>
                </div>
            </div>

            <button type="submit" class="w-full py-3 bg-sky-600 hover:bg-sky-500 text-white font-bold rounded-xl transition-all shadow-lg flex items-center justify-center gap-2">
                <i data-lucide="send" class="w-4 h-4"></i> Enviar novo PIN
            </button>
        </form>

        <div class="mt-6 text-center">
            <a href="{{ route('workspace.login') }}" class="text-xs text-slate-500 hover:text-slate-300 transition-colors flex items-center justify-center gap-1 font-mono">
                <i data-lucide="arrow-left" class="w-3 h-3"></i> Voltar ao Login
            </a>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        lucide.createIcons();

        const Toast = Swal.mixin({
            toast: true, position: 'top-end', showConfirmButton: false, timer: 4000,
            timerProgressBar: true, background: '#121929', color: '#f8fafc',
            customClass: { popup: 'border border-slate-800 rounded-xl shadow-2xl' }
        });

        @if($errors->any())
            Toast.fire({ icon: 'error', iconColor: '#f43f5e', title: "{{ $errors->first() }}" });
        @endif
        @if(session('error'))
            Toast.fire({ icon: 'error', iconColor: '#f43f5e', title: "{{ session('error') }}" });
        @endif
    </script>
</body>
</html>
