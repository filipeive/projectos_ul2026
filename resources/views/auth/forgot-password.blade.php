<!DOCTYPE html>
<html lang="pt-PT" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Senha | UniLicungo TechHub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <link rel="stylesheet" href="{{ asset('style.css') }}?v=theme-20260627">
    <script src="{{ asset('theme.js') }}?v=theme-20260627"></script>
</head>
<body class="min-h-screen bg-slate-950 text-slate-100 flex items-center justify-center p-4 antialiased">
    <div class="w-full max-w-md">
        <div class="text-center mb-6">
            <div class="w-20 h-20 bg-slate-900/60 p-2 rounded-2xl border border-slate-800 flex items-center justify-center mx-auto mb-4">
                <img src="{{ asset('ul.png') }}" alt="Logo UniLicungo" class="w-full h-full object-contain">
            </div>
            <h1 class="text-2xl font-extrabold text-white">Recuperar Senha</h1>
            <p class="text-xs text-slate-400 mt-1">Docentes, diretores de curso e administradores</p>
        </div>

        <div class="glass-panel p-6 sm:p-8 rounded-3xl border border-slate-800/80 shadow-2xl">
            <form action="{{ route('password.email') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label for="email" class="block text-xs font-semibold text-slate-400 uppercase tracking-wider font-mono mb-2">E-mail institucional</label>
                    <div class="relative">
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="nome@unilicungo.ac.mz"
                            class="peer w-full pl-10 pr-4 py-3 bg-slate-900 border border-slate-800 hover:border-slate-700 focus:border-sky-500 focus:ring-2 focus:ring-sky-500/20 focus:outline-none rounded-xl text-sm transition-all text-slate-200 placeholder-slate-500">
                        <i data-lucide="mail" class="w-4 h-4 absolute left-3.5 top-3.5 text-slate-500 peer-focus:text-sky-400"></i>
                    </div>
                </div>

                <button type="submit" class="w-full py-3 bg-slate-800 hover:bg-slate-750 border border-slate-700 hover:border-slate-600 text-white font-semibold rounded-xl text-sm transition-all flex items-center justify-center gap-2">
                    <i data-lucide="send" class="w-4 h-4"></i> Enviar link de recuperação
                </button>
            </form>
        </div>

        <div class="text-center mt-6">
            <a href="{{ route('admin.login') }}" class="text-xs text-slate-500 hover:text-sky-400 transition-colors inline-flex items-center gap-1.5 font-mono uppercase tracking-wider">
                <i data-lucide="arrow-left" class="w-3.5 h-3.5"></i> Voltar ao login
            </a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        lucide.createIcons();
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 4500,
            timerProgressBar: true,
            background: '#121929',
            color: '#f8fafc',
            customClass: { popup: 'border border-slate-800 rounded-xl shadow-2xl' }
        });

        @if($errors->any())
            Toast.fire({ icon: 'error', iconColor: '#f43f5e', title: "{{ $errors->first() }}" });
        @endif

        @if(session('success'))
            Toast.fire({ icon: 'success', title: "{{ session('success') }}" });
        @endif
    </script>
</body>
</html>
