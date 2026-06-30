<!DOCTYPE html>
<html lang="pt-PT" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nova Senha | UniLicungo TechHub</title>
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
            <h1 class="text-2xl font-extrabold text-white">Definir Nova Senha</h1>
            <p class="text-xs text-slate-400 mt-1">A senha deve ter pelo menos 6 caracteres.</p>
        </div>

        <div class="glass-panel p-6 sm:p-8 rounded-3xl border border-slate-800/80 shadow-2xl">
            <form action="{{ route('password.update') }}" method="POST" class="space-y-4">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">

                <div>
                    <label for="email" class="block text-xs font-semibold text-slate-400 uppercase tracking-wider font-mono mb-2">E-mail institucional</label>
                    <input type="email" id="email" name="email" value="{{ old('email', $email) }}" required autocomplete="email"
                        class="w-full px-4 py-3 bg-slate-900 border border-slate-800 hover:border-slate-700 focus:border-sky-500 focus:ring-2 focus:ring-sky-500/20 focus:outline-none rounded-xl text-sm transition-all text-slate-200 placeholder-slate-500">
                </div>

                <div>
                    <label for="password" class="block text-xs font-semibold text-slate-400 uppercase tracking-wider font-mono mb-2">Nova senha</label>
                    <input type="password" id="password" name="password" required autocomplete="new-password"
                        class="w-full px-4 py-3 bg-slate-900 border border-slate-800 hover:border-slate-700 focus:border-sky-500 focus:ring-2 focus:ring-sky-500/20 focus:outline-none rounded-xl text-sm transition-all text-slate-200 placeholder-slate-500">
                </div>

                <div>
                    <label for="password_confirmation" class="block text-xs font-semibold text-slate-400 uppercase tracking-wider font-mono mb-2">Confirmar senha</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" required autocomplete="new-password"
                        class="w-full px-4 py-3 bg-slate-900 border border-slate-800 hover:border-slate-700 focus:border-sky-500 focus:ring-2 focus:ring-sky-500/20 focus:outline-none rounded-xl text-sm transition-all text-slate-200 placeholder-slate-500">
                </div>

                <button type="submit" class="w-full py-3 bg-slate-800 hover:bg-slate-750 border border-slate-700 hover:border-slate-600 text-white font-semibold rounded-xl text-sm transition-all flex items-center justify-center gap-2">
                    <i data-lucide="key-round" class="w-4 h-4"></i> Atualizar senha
                </button>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        lucide.createIcons();
        @if($errors->any())
            Swal.fire({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 4500,
                icon: 'error',
                title: "{{ $errors->first() }}",
                background: '#121929',
                color: '#f8fafc'
            });
        @endif
    </script>
</body>
</html>
