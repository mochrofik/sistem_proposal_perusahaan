@extends('layouts.app')

@section('title', 'Create Proposal')

@section('content')

<div class="bg-white rounded-[2rem] border border-slate-200/60 shadow-sm overflow-hidden p-8">
    <form action="{{ route('web.proposal.store') }}" method="POST">
        @csrf
        
        <div class="mb-6">
            <label for="title" class="block text-sm font-medium text-slate-700 mb-2">Judul Proposal</label>
            <input type="text" name="title" id="title" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" value="{{ old('title') }}" required>
            @error('title')
                <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label for="description" class="block text-sm font-medium text-slate-700 mb-2">Deskripsi</label>
            <textarea name="description" id="description" rows="5" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" required>{{ old('description') }}</textarea>
            @error('description')
                <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center gap-4">
            <button type="submit" class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-xl transition-colors">
                Simpan Proposal
            </button>
            <a href="{{ route('web.proposal') }}" class="px-6 py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 font-medium rounded-xl transition-colors">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection

