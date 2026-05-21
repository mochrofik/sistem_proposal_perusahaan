
<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Sistem Proposal Perusahaan - PT Karunia Mitra Bersama">
    <title>@yield('title', 'Sistem Proposal') | PT Karunia Mitra Bersama</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full font-['Inter',sans-serif] antialiased">


<div class="min-h-screen bg-gray-50 flex">

    {{-- ===== LEFT PANEL (branding) ===== --}}
    <div class="hidden lg:flex lg:w-1/2 bg-blue-600 flex-col justify-between p-12 relative overflow-hidden">

        {{-- Subtle pattern --}}
        <div class="absolute inset-0 opacity-10"
             style="background-image: radial-gradient(circle at 20% 50%, white 1px, transparent 1px), radial-gradient(circle at 80% 20%, white 1px, transparent 1px); background-size: 60px 60px;">
        </div>

        {{-- Top logo --}}
        <div class="relative flex items-center gap-3">
            <div class="w-9 h-9 bg-white/20 rounded-xl flex items-center justify-center">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
            </div>
            <span class="text-white font-bold text-lg">Sistem Proposal</span>
        </div>

        {{-- Center text --}}
        <div class="relative">
            <h1 class="text-white text-4xl font-bold leading-tight mb-4">
                Kelola Proposal<br>Perusahaan Anda
            </h1>
            <p class="text-blue-200 text-base leading-relaxed max-w-xs">
                Platform manajemen proposal terintegrasi untuk PT Karunia Mitra Bersama.
            </p>

            {{-- Stats --}}
            <div class="flex gap-8 mt-10">
                <div>
                    <p class="text-white text-2xl font-bold">48</p>
                    <p class="text-blue-200 text-sm">Proposal Aktif</p>
                </div>
                <div>
                    <p class="text-white text-2xl font-bold">31</p>
                    <p class="text-blue-200 text-sm">Disetujui</p>
                </div>
                <div>
                    <p class="text-white text-2xl font-bold">4.2M</p>
                    <p class="text-blue-200 text-sm">Total Nilai</p>
                </div>
            </div>
        </div>

        {{-- Bottom --}}
        <p class="relative text-blue-300 text-xs">&copy; {{ date('Y') }} PT Karunia Mitra Bersama</p>
    </div>

    {{-- ===== RIGHT PANEL (login form) ===== --}}
    <div class="flex-1 flex items-center justify-center px-6 py-12">
        <div class="w-full max-w-sm">

            {{-- Header --}}
            <div class="mb-8">
                <div class="flex items-center gap-2 mb-6 lg:hidden">
                    <div class="w-7 h-7 bg-blue-600 rounded-lg flex items-center justify-center">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <span class="text-gray-900 font-bold text-base">Sistem Proposal</span>
                </div>
                <h2 class="text-2xl font-bold text-gray-900">Masuk ke Akun</h2>
                <p class="text-gray-500 text-sm mt-1">Silakan masukkan kredensial Anda</p>
            </div>

            {{-- Error alert --}}
            @if(session('error'))
            <div class="mb-5 flex items-center gap-3 px-4 py-3 bg-red-50 border border-red-200 rounded-lg text-red-700 text-sm">
                <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                </svg>
                {{ session('error') }}
            </div>
            @endif

            {{-- Form --}}
            <form method="POST" action="{{ route('web.login.post') }}" class="space-y-4" id="form-login">
                @csrf

                {{-- Email --}}
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1.5">Email</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="nama@perusahaan.com"
                        autocomplete="email"
                        required
                        class="w-full bg-white border @error('email') border-red-400 focus:ring-red-400 @else border-gray-300 focus:ring-blue-500 @enderror text-gray-900 placeholder-gray-400 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:border-transparent transition-all"
                    >
                    @error('email')
                        <p class="text-red-600 text-xs mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Password --}}
                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                        <a href="#" class="text-xs text-blue-600 hover:text-blue-700 font-medium">Lupa password?</a>
                    </div>
                    <div class="relative">
                        <input
                            type="password"
                            id="password"
                            name="password"
                            placeholder="••••••••"
                            autocomplete="current-password"
                            required
                            class="w-full bg-white border @error('password') border-red-400 focus:ring-red-400 @else border-gray-300 focus:ring-blue-500 @enderror text-gray-900 placeholder-gray-400 rounded-lg px-4 py-2.5 pr-10 text-sm focus:outline-none focus:ring-2 focus:border-transparent transition-all"
                        >
                        <button type="button" id="toggle-password" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 transition-colors">
                            <svg id="eye-open" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            <svg id="eye-closed" class="w-4 h-4 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                            </svg>
                        </button>
                    </div>
                    @error('password')
                        <p class="text-red-600 text-xs mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Remember --}}
                <div class="flex items-center gap-2">
                    <input
                        type="checkbox"
                        id="remember"
                        name="remember"
                        value="1"
                        class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500 focus:ring-offset-0 cursor-pointer"
                    >
                    <label for="remember" class="text-sm text-gray-600 cursor-pointer select-none">Ingat saya</label>
                </div>

                {{-- Submit --}}
                <button
                    type="submit"
                    id="btn-login"
                    class="w-full bg-blue-600 hover:bg-blue-700 active:bg-blue-800 text-white font-semibold py-2.5 px-4 rounded-lg transition-colors duration-150 text-sm mt-2 shadow-sm"
                >
                    Masuk
                </button>
                
                <p class="text-center text-sm text-gray-500 mt-4">
                    Belum punya akun? <a href="{{ route('web.register') }}" class="text-blue-600 hover:text-blue-700 font-medium">Daftar sekarang</a>
                </p>
            </form>
        </div>
    </div>
</div>

<script>
    // Toggle password visibility
    document.getElementById('toggle-password').addEventListener('click', () => {
        const input    = document.getElementById('password');
        const isHidden = input.type === 'password';
        input.type = isHidden ? 'text' : 'password';
        document.getElementById('eye-open').classList.toggle('hidden', isHidden);
        document.getElementById('eye-closed').classList.toggle('hidden', !isHidden);
    });
</script>

</body>
</html>
