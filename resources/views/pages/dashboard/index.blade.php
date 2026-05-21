@extends('layouts.app')

@section('title', 'Dashboard')
@section('content')

 {{-- Greeting + role badge --}}
            <div class="flex items-start justify-between">
                <div>
                    <h2 class="text-gray-900 font-semibold text-lg">Selamat datang, {{ $user->name ?? 'Admin' }}</h2>
                    <p class="text-gray-500 text-sm mt-0.5">
                        @if($user->hasRole('Manager'))
                            Anda login sebagai <span class="font-medium text-blue-600">Manager</span>
                        @elseif($user->hasRole('Finance'))
                            Anda login sebagai <span class="font-medium text-violet-600">Finance</span>
                        @else
                            Anda login sebagai <span class="font-medium text-gray-700">{{ $user->division->name ?? 'Staff' }}</span> 
                        @endif
                    </p>
                </div>

                {{-- Role badge --}}
                @if($user->hasRole('Manager'))
                    <span class="flex-shrink-0 inline-flex items-center gap-1.5 text-xs font-semibold text-blue-700 bg-blue-50 border border-blue-200 px-3 py-1.5 rounded-full">
                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/></svg>
                        Manager
                    </span>
                @elseif($user->hasRole('Finance'))
                    <span class="flex-shrink-0 inline-flex items-center gap-1.5 text-xs font-semibold text-violet-700 bg-violet-50 border border-violet-200 px-3 py-1.5 rounded-full">
                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z"/><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd"/></svg>
                        Finance
                    </span>
                @else
                    <span class="flex-shrink-0 inline-flex items-center gap-1.5 text-xs font-semibold text-gray-600 bg-gray-100 border border-gray-200 px-3 py-1.5 rounded-full">
                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"/></svg>
                        {{ $user->division->name ?? 'Staff' }}
                    </span>
                @endif
            </div>

            <div class="bg-white border border-gray-200 rounded-xl overflow-hidden">

                <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
                    <div>
                        <h2 class="text-gray-900 font-semibold text-sm">Daftar Proposal</h2>
                        <p class="text-gray-400 text-xs mt-0.5">
                            @if($user->hasRole('Manager'))
                                Menampilkan semua proposal (akses Manager)
                            @elseif($user->hasRole('Finance'))
                                Menampilkan proposal yang telah disetujui (akses Finance)
                            @else
                                Menampilkan proposal divisi Anda & yang telah disetujui
                            @endif
                        </p>
                    </div>

                    {{-- Filter status --}}
                    <div class="flex items-center gap-2">
                        <select id="filter-status"
                            class="text-xs border border-gray-200 rounded-lg px-3 py-1.5 text-gray-600 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/30 focus:border-blue-400 transition-all">
                            <option value="">Semua Status</option>
                            @if($user->hasRole('Manager') || $user->division_id)
                                <option value="pending">Pending</option>
                            @endif
                            <option value="approved">Disetujui</option>
                            @if($user->hasRole('Manager') || $user->division_id)
                                <option value="rejected">Ditolak</option>
                            @endif
                        </select>
                    </div>
                </div>

                @if($proposals->isEmpty())
                    <div class="flex flex-col items-center justify-center py-16 text-center">
                        <div class="w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center mb-3">
                            <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                        <p class="text-gray-500 text-sm font-medium">Belum ada proposal</p>
                        <p class="text-gray-400 text-xs mt-1">Tidak ada proposal yang dapat Anda akses saat ini.</p>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full" id="proposal-table">
                            <thead class="bg-gray-50 border-b border-gray-100">
                                <tr>
                                    <th class="text-left text-gray-500 text-xs font-semibold uppercase tracking-wide px-6 py-3">Judul Proposal</th>
                                    <th class="text-left text-gray-500 text-xs font-semibold uppercase tracking-wide px-6 py-3">Pengaju</th>
                                    <th class="text-left text-gray-500 text-xs font-semibold uppercase tracking-wide px-6 py-3">Divisi</th>
                                    <th class="text-left text-gray-500 text-xs font-semibold uppercase tracking-wide px-6 py-3">Tanggal</th>
                                    <th class="text-left text-gray-500 text-xs font-semibold uppercase tracking-wide px-6 py-3">Status</th>
                                    @if($user->hasRole('Manager'))
                                    <th class="text-right text-gray-500 text-xs font-semibold uppercase tracking-wide px-6 py-3">Aksi</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100" id="proposal-tbody">
                                @foreach($proposals as $proposal)
                                <tr class="hover:bg-gray-50 transition-colors proposal-row" data-status="{{ $proposal->status }}">

                                    <td class="px-6 py-4">
                                        <p class="text-gray-800 text-sm font-medium">{{ $proposal->title }}</p>
                                        <p class="text-gray-400 text-xs mt-0.5 line-clamp-1">{{ $proposal->description }}</p>
                                    </td>

                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-2">
                                            <div class="w-6 h-6 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 text-xs font-bold flex-shrink-0">
                                                {{ strtoupper(substr($proposal->user->name ?? '?', 0, 1)) }}
                                            </div>
                                            <span class="text-gray-600 text-sm truncate max-w-[120px]">{{ $proposal->user->name ?? '-' }}</span>
                                        </div>
                                    </td>

                                    <td class="px-6 py-4">
                                        <span class="text-gray-500 text-sm">{{ $proposal->division->name ?? '-' }}</span>
                                    </td>

                                    <td class="px-6 py-4">
                                        <span class="text-gray-400 text-xs">{{ $proposal->created_at->format('d M Y') }}</span>
                                    </td>

                                    <td class="px-6 py-4">
                                        @if($proposal->status === 'approved')
                                            <span class="inline-flex items-center gap-1.5 text-xs font-semibold text-emerald-700 bg-emerald-50 border border-emerald-200 px-2.5 py-1 rounded-full">
                                                <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></span>
                                                Disetujui
                                            </span>
                                        @elseif($proposal->status === 'pending')
                                            <span class="inline-flex items-center gap-1.5 text-xs font-semibold text-amber-700 bg-amber-50 border border-amber-200 px-2.5 py-1 rounded-full">
                                                <span class="w-1.5 h-1.5 bg-amber-400 rounded-full animate-pulse"></span>
                                                Pending
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1.5 text-xs font-semibold text-red-700 bg-red-50 border border-red-200 px-2.5 py-1 rounded-full">
                                                <span class="w-1.5 h-1.5 bg-red-500 rounded-full"></span>
                                                Ditolak
                                            </span>
                                        @endif
                                    </td>
                                    @if($user->hasRole('Manager'))
                                    <td class="px-6 py-4 text-right">
                                        @if($proposal->status === 'pending')
                                            <form action="{{ route('web.proposal.approve', $proposal->id) }}" method="POST" class="inline-block">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="text-xs bg-emerald-600 hover:bg-emerald-700 text-white font-medium px-3 py-1.5 rounded-lg transition-colors">
                                                    Approve
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                    @endif
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                @endif
            </div>
@endsection