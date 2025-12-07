@extends('layouts.app', [
    'title' => 'Jelajahi Destinasi',
])

@php
  $fallback = fn($seed) => "https://images.unsplash.com/photo-1526772662000-3f88f10405ff?q=80&w=1200&auto=format&fit=crop&ixlib=rb-4.0.3&sig={$seed}";
@endphp

@section('content')
  <div class="bg-slate-50 dark:bg-slate-950 min-h-screen pt-24 pb-20">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
      
      {{-- Header --}}
      <div class="flex flex-col md:flex-row justify-between items-end mb-8 md:mb-10 gap-6 animate-slide-up">
        <div>
          <h1 class="font-serif text-3xl md:text-5xl font-bold text-slate-900 dark:text-white mb-3">Destinasi Wisata</h1>
          <p class="text-slate-600 dark:text-slate-400 text-base md:text-lg">Temukan tempat terbaik untuk liburan Anda berikutnya.</p>
        </div>
      </div>

      {{-- Filter Bar --}}
      <div class="bg-white dark:bg-slate-900 rounded-2xl p-4 md:p-6 shadow-sm border border-slate-200 dark:border-slate-800 mb-8 md:mb-12 sticky top-24 z-30 animate-slide-up" style="animation-delay: 0.1s;">
        <form action="{{ route('destinations.index') }}" method="GET" class="flex flex-col md:flex-row gap-4">
          <div class="flex-1 relative">
            <svg class="absolute left-4 top-3.5 w-5 h-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari destinasi..." 
                   class="w-full pl-12 pr-4 py-3 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl focus:ring-2 focus:ring-brand-500 focus:border-transparent outline-none transition-all text-slate-900 dark:text-white">
          </div>
          
          <div class="w-full md:w-64 relative">
            <select name="kategori" class="w-full pl-4 pr-10 py-3 bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl focus:ring-2 focus:ring-brand-500 focus:border-transparent outline-none appearance-none cursor-pointer text-slate-900 dark:text-white">
              <option value="">Semua Kategori</option>
              @foreach($categories as $c)
                <option value="{{ $c->slug }}" {{ request('kategori') == $c->slug ? 'selected' : '' }}>{{ $c->name }}</option>
              @endforeach
            </select>
            <svg class="absolute right-4 top-3.5 w-5 h-5 text-slate-400 pointer-events-none" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
          </div>

          <button type="submit" class="w-full md:w-auto px-8 py-3 bg-brand-600 hover:bg-brand-700 text-white font-bold rounded-xl transition-colors shadow-lg shadow-brand-500/20">
            Terapkan
          </button>
          
          @if(request()->hasAny(['q', 'kategori']))
            <a href="{{ route('destinations.index') }}" class="w-full md:w-auto px-4 py-3 border border-slate-200 dark:border-slate-800 text-slate-600 dark:text-slate-400 rounded-xl hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors flex items-center justify-center">
              <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
              <span class="md:hidden ml-2">Reset Filter</span>
            </a>
          @endif
        </form>
      </div>

      {{-- Grid --}}
      @if($destinations->isEmpty())
        <div class="text-center py-24 animate-slide-up" style="animation-delay: 0.2s;">
          <div class="w-20 h-20 bg-slate-100 dark:bg-slate-800 rounded-full flex items-center justify-center mx-auto mb-6 text-4xl">🔍</div>
          <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-2">Tidak ditemukan</h3>
          <p class="text-slate-500 dark:text-slate-400">Coba kata kunci lain atau reset filter Anda.</p>
        </div>
      @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8 animate-slide-up" style="animation-delay: 0.2s;">
          @foreach($destinations as $d)
            <a href="{{ route('destinations.show', $d->slug) }}" class="group bg-white dark:bg-slate-900 rounded-[2rem] overflow-hidden border border-slate-100 dark:border-slate-800 shadow-sm hover:shadow-2xl hover:-translate-y-1 transition-all duration-300 flex flex-col h-full">
              {{-- Image --}}
              <div class="relative aspect-[4/3] overflow-hidden">
                <img src="{{ $d->cover_url ?? $fallback($d->id) }}" alt="{{ $d->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                
                @if($d->category)
                  <span class="absolute top-4 left-4 px-3 py-1 bg-white/90 dark:bg-slate-900/90 backdrop-blur text-xs font-bold uppercase tracking-wider rounded-lg shadow-sm text-slate-900 dark:text-white">
                    {{ $d->category->name }}
                  </span>
                @endif
              </div>

              {{-- Content --}}
              <div class="p-5 md:p-6 flex-1 flex flex-col">
                <div class="flex justify-between items-start mb-2">
                  <h3 class="font-serif text-lg md:text-xl font-bold text-slate-900 dark:text-white group-hover:text-brand-600 transition-colors line-clamp-1">
                    {{ $d->name }}
                  </h3>
                  {{-- Mock Rating --}}
                  <div class="flex items-center gap-1 text-amber-400 text-xs md:text-sm font-bold shrink-0">
                    <span>★</span> 4.8
                  </div>
                </div>
                
                @if($d->address)
                  <p class="text-xs md:text-sm text-slate-500 dark:text-slate-400 mb-4 flex items-start gap-1.5 line-clamp-2">
                    <svg class="w-4 h-4 shrink-0 mt-0.5 text-brand-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                    {{ $d->address }}
                  </p>
                @endif

                <div class="mt-auto pt-4 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between text-xs md:text-sm">
                  <span class="text-slate-400">Lihat detail</span>
                  <div class="w-8 h-8 rounded-full bg-slate-50 dark:bg-slate-800 flex items-center justify-center text-slate-400 group-hover:bg-brand-600 group-hover:text-white transition-all">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" /></svg>
                  </div>
                </div>
              </div>
            </a>
          @endforeach
        </div>

        <div class="mt-12 animate-slide-up" style="animation-delay: 0.3s;">
          {{ $destinations->onEachSide(1)->links() }}
        </div>
      @endif
    </div>
  </div>
@endsection
