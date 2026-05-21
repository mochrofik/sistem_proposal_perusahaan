@extends('layouts.app')

@section('title', 'Proposal')

@section('content')

 <div class="bg-white rounded-[2rem] border border-slate-200/60 shadow-sm overflow-hidden">
     <div class="p-6 border-b border-slate-100 flex justify-between items-center">
         <h2 class="text-lg font-bold text-slate-800">Daftar Proposal</h2>
         @if(auth()->user()->hasRole('Finance'))
         <a href="{{ route('web.proposal.create') }}" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-xl transition-colors">
             Buat Proposal
         </a>
         @endif
     </div>

     <div class="overflow-x-auto custom-scrollbar">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 text-slate-500 text-[10px] uppercase tracking-widest font-bold">
                        <th class="px-8 py-5">No</th>
                        <th class="px-6 py-5">Pengaju</th>
                        <th class="px-6 py-5 hidden lg:table-cell">Divisi</th>
                        <th class="px-6 py-5 hidden xl:table-cell">Title</th>
                        <th class="px-6 py-5 hidden lg:table-cell">Deskripsi</th>
                        <th class="px-8 py-5 text-right">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($proposals as $index => $proposal)
                    <tr class="hover:bg-slate-50 transition-colors group">
                        <td class="px-8 py-5 text-sm text-slate-500">{{ $index + 1 }}</td>
                        <td class="px-6 py-5">
                            <div class="flex items-center gap-3">
                                <div>
                                    <p class="text-sm font-semibold text-slate-800">{{ $proposal->user->name ?? 'Unknown' }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-5 hidden lg:table-cell text-sm text-slate-500">
                            {{ $proposal->division->name ?? 'Unknown' }}
                        </td>
                        <td class="px-6 py-5 hidden xl:table-cell text-sm text-slate-800 font-medium">
                            {{ $proposal->title }}
                        </td>
                        <td class="px-6 py-5 hidden lg:table-cell text-sm text-slate-500 max-w-xs truncate">
                            {{ $proposal->description }}
                        </td>
                        <td class="px-8 py-5 text-right">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-{{ $proposal->status_color }}-100 text-{{ $proposal->status_color }}-800">
                                {{ $proposal->status_label }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-8 py-8 text-center text-sm text-slate-500">
                            Belum ada proposal yang diajukan.
                        </td>
                    </tr>
                    @endforelse                </tbody>

            </table>
     </div>

 </div>


@endsection

