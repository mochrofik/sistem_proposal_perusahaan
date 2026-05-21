<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Sistem Proposal Perusahaan - PT Karunia Mitra Bersama">
    <title>Daftar | PT Karunia Mitra Bersama</title>

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
                Bergabung dengan<br>Tim Kami
            </h1>
            <p class="text-blue-200 text-base leading-relaxed max-w-xs">
                Buat akun untuk mulai mengajukan dan mengelola proposal di perusahaan Anda.
            </p>
        </div>

        {{-- Bottom --}}
        <p class="relative text-blue-300 text-xs">&copy; {{ date('Y') }} PT Karunia Mitra Bersama</p>
    </div>

    {{-- ===== RIGHT PANEL (register form) ===== --}}
    <div class="flex-1 flex items-center justify-center px-6 py-12">
        <div class="w-full max-w-md">

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
                <h2 class="text-2xl font-bold text-gray-900">Buat Akun Baru</h2>
                <p class="text-gray-500 text-sm mt-1">Lengkapi form di bawah ini untuk mendaftar</p>
            </div>

            {{-- Form --}}
            <form method="POST" action="{{ route('web.register.post') }}" class="space-y-4">
                @csrf

                {{-- Name --}}
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1.5">Nama Lengkap</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" required
                        class="w-full bg-white border @error('name') border-red-400 focus:ring-red-400 @else border-gray-300 focus:ring-blue-500 @enderror text-gray-900 placeholder-gray-400 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:border-transparent transition-all">
                    @error('name')
                        <p class="text-red-600 text-xs mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Email --}}
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1.5">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="nama@perusahaan.com" required
                        class="w-full bg-white border @error('email') border-red-400 focus:ring-red-400 @else border-gray-300 focus:ring-blue-500 @enderror text-gray-900 placeholder-gray-400 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:border-transparent transition-all">
                    @error('email')
                        <p class="text-red-600 text-xs mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Role and Division --}}
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="role" class="block text-sm font-medium text-gray-700 mb-1.5">Peran (Role)</label>
                        <select id="role" name="role" required class="w-full bg-white border @error('role') border-red-400 focus:ring-red-400 @else border-gray-300 focus:ring-blue-500 @enderror text-gray-900 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:border-transparent transition-all">
                            <option value="">Pilih Peran</option>
                            @foreach($roles as $role)
                                <option value="{{ $role->name }}" {{ old('role') == $role->name ? 'selected' : '' }}>{{ $role->name }}</option>
                            @endforeach
                        </select>
                        @error('role')
                            <p class="text-red-600 text-xs mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="division_id" class="block text-sm font-medium text-gray-700 mb-1.5">Divisi</label>
                        <select id="division_id" name="division_id" required class="w-full bg-white border @error('division_id') border-red-400 focus:ring-red-400 @else border-gray-300 focus:ring-blue-500 @enderror text-gray-900 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:border-transparent transition-all">
                            <option value="">Pilih Divisi</option>
                            @foreach($divisions as $division)
                                <option value="{{ $division->id }}" {{ old('division_id') == $division->id ? 'selected' : '' }}>{{ $division->name }}</option>
                            @endforeach
                        </select>
                        @error('division_id')
                            <p class="text-red-600 text-xs mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Password --}}
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1.5">Password</label>
                        <input type="password" id="password" name="password" required
                            class="w-full bg-white border @error('password') border-red-400 focus:ring-red-400 @else border-gray-300 focus:ring-blue-500 @enderror text-gray-900 placeholder-gray-400 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:border-transparent transition-all">
                        @error('password')
                            <p class="text-red-600 text-xs mt-1.5">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1.5">Konfirmasi Password</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" required
                            class="w-full bg-white border border-gray-300 focus:ring-blue-500 text-gray-900 placeholder-gray-400 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:border-transparent transition-all">
                    </div>
                </div>

                {{-- Submit --}}
                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 active:bg-blue-800 text-white font-semibold py-2.5 px-4 rounded-lg transition-colors duration-150 text-sm mt-6 shadow-sm">
                    Daftar Sekarang
                </button>
                
                <p class="text-center text-sm text-gray-500 mt-4">
                    Sudah punya akun? <a href="{{ route('web.login') }}" class="text-blue-600 hover:text-blue-700 font-medium">Masuk di sini</a>
                </p>
            </form>
        </div>
    </div>
</div>

</body>
</html>
