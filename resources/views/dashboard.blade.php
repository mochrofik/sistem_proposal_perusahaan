@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="min-h-screen bg-gray-50 flex">

    {{-- ===== SIDEBAR ===== --}}
    <aside class="flex-shrink-0 w-60 bg-white border-r border-gray-200 flex flex-col">

        {{-- Logo --}}
        <div class="flex items-center gap-3 px-5 py-5 border-b border-gray-100">
            <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center flex-shrink-0">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
            </div>
            <div>
                <p class="text-gray-900 font-semibold text-sm leading-tight">Sistem Proposal</p>
                <p class="text-gray-400 text-xs">PT KMB</p>
            </div>
        </div>

        {{-- Navigation --}}
        <nav class="flex-1 px-3 py-4 space-y-0.5">

            {{-- Dashboard --}}
            <a href="{{ route('web.dashboard') }}" id="nav-dashboard"
               class="nav-item group flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-150
                      bg-blue-50 text-blue-700 border border-blue-100">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                Dashboard
            </a>

            {{-- Proposal --}}
            <a href="#" id="nav-proposal"
               class="nav-item group flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-150
                      text-gray-600 hover:bg-gray-100 hover:text-gray-900">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Proposal
                @if($stats['total'] > 0)
                    <span class="ml-auto text-xs font-semibold bg-blue-100 text-blue-600 px-2 py-0.5 rounded-full">
                        {{ $stats['total'] }}
                    </span>
                @endif
            </a>

        </nav>

        {{-- User info bottom --}}
        <div class="px-4 py-4 border-t border-gray-100">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-full bg-blue-600 flex items-center justify-center text-white text-xs font-bold flex-shrink-0">
                    {{ strtoupper(substr($user->name ?? 'A', 0, 1)) }}
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-gray-800 text-xs font-semibold truncate">{{ $user->name ?? 'Admin' }}</p>
                    <p class="text-gray-400 text-xs truncate">
                        @if($user->hasRole('Manager'))
                            Manager
                        @elseif($user->hasRole('Finance'))
                            Finance
                        @else
                            {{ $user->division->name ?? 'Staff' }}
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </aside>

    {{-- ===== MAIN CONTENT ===== --}}
    <div class="flex-1 flex flex-col min-w-0 overflow-hidden">

        {{-- Top Navbar --}}
        <header class="flex-shrink-0 h-14 bg-white border-b border-gray-200 flex items-center justify-between px-6">
            <div>
                <h1 class="text-gray-900 font-semibold text-base">Dashboard</h1>
            </div>
            <form method="POST" action="{{ route('web.logout') }}">
                @csrf
                <button type="submit" id="btn-logout"
                    class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-red-600 hover:bg-red-50 border border-gray-200 hover:border-red-200 px-3 py-1.5 rounded-lg transition-all duration-150 font-medium">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                    Keluar
                </button>
            </form>
        </header>

        {{-- Page Content --}}
        <main class="flex-1 overflow-y-auto p-6 space-y-6">

                @yield('content')

           

        </main>
    </div>
</div>

<script>
    // ─── Filter by status ─────────────────────────────────────────────────────
    const filterSelect = document.getElementById('filter-status');
    const tableCount   = document.getElementById('table-count');

    if (filterSelect) {
        filterSelect.addEventListener('change', function () {
            const val  = this.value;
            const rows = document.querySelectorAll('.proposal-row');
            let visible = 0;

            rows.forEach(row => {
                const status = row.dataset.status;
                const show   = !val || status === val;
                row.style.display = show ? '' : 'none';
                if (show) visible++;
            });

            if (tableCount) {
                tableCount.textContent = `Menampilkan ${visible} proposal${val ? ' (' + filterSelect.options[filterSelect.selectedIndex].text + ')' : ''}`;
            }
        });
    }

    // ─── Sidebar nav active state ─────────────────────────────────────────────
    document.querySelectorAll('.nav-item').forEach(item => {
        item.addEventListener('click', function (e) {
            if (this.getAttribute('href') === '#') e.preventDefault();

            document.querySelectorAll('.nav-item').forEach(el => {
                el.classList.remove('bg-blue-50', 'text-blue-700', 'border', 'border-blue-100');
                el.classList.add('text-gray-600', 'hover:bg-gray-100', 'hover:text-gray-900');
            });

            this.classList.add('bg-blue-50', 'text-blue-700', 'border', 'border-blue-100');
            this.classList.remove('text-gray-600', 'hover:bg-gray-100', 'hover:text-gray-900');
        });
    });
</script>
@endsection
