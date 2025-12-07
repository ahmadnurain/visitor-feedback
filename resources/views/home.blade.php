@extends('layouts.app', [
    'title' => 'Suara Wisata Majalengka',
    'metaDescription' => 'Platform resmi aspirasi wisatawan Majalengka.',
])

@php
  // Images
  $heroImage = '/image/hero/Wisata-Majalengka-2-Kompas.jpg';
  $workflowImage = '/image/hero/view-terraced-rice-field-chiangmai-thailand_1045824-4569.jpg';
  
  $gallery = [
    '/image/Gallery/Keindahan-Sunrise-di-Puncak-Gunung-Ciremai-yang-Mesti-Kamu-Nikmati.jpg',
    '/image/Gallery/Nature-4-585x401.jpg.crdownload',
    '/image/Gallery/al-imam-grand-mosque-largest-mosque-center-islamic-activities-majalengka-regency-west-java-indonesia-al-imam-grand-342959304.webp',
    '/image/Gallery/bali-beach-indonesia-nature-1802246.jpg',
    '/image/Gallery/istockphoto-994005936-612x612.jpg',
    '/image/Gallery/river-tubing-cikadongdong_1.jpg',
  ];
  $fallbackThumb = 'https://source.unsplash.com/800x600/?nature,indonesia';
@endphp

@section('content')
  {{-- HERO SECTION --}}
  <section class="relative min-h-[100vh] flex items-center pt-24 pb-12 overflow-hidden bg-slate-950">
    {{-- Background Video/Image --}}
    <div class="absolute inset-0 z-0">
      <img src="{{ $heroImage }}" alt="Hero" class="w-full h-full object-cover opacity-60 animate-kenburns">
      <div class="absolute inset-0 bg-gradient-to-r from-slate-950 via-slate-950/80 to-transparent"></div>
      <div class="absolute bottom-0 left-0 w-full h-32 bg-gradient-to-t from-slate-950 to-transparent"></div>
    </div>

    <div class="container mx-auto px-6 sm:px-6 lg:px-8 relative z-10">
      <div class="grid lg:grid-cols-2 gap-12 items-center">
        <div class="max-w-2xl space-y-8 animate-slide-up">
          <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-brand-500/10 border border-brand-500/20 backdrop-blur-md text-brand-300 text-sm font-medium">
            <span class="relative flex h-2 w-2">
              <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-brand-400 opacity-75"></span>
              <span class="relative inline-flex rounded-full h-2 w-2 bg-brand-500"></span>
            </span>
            Official Feedback Platform
          </div>

          <h1 class="font-serif text-4xl sm:text-5xl md:text-7xl font-bold text-white leading-[1.1] tracking-tight">
            Suara Anda, <br>
            <span class="text-transparent bg-clip-text bg-gradient-to-r from-brand-300 to-emerald-200">Wajah Wisata Kita.</span>
          </h1>

          <p class="text-base sm:text-lg text-slate-300 leading-relaxed max-w-lg">
            Bantu kami meningkatkan kualitas pariwisata Majalengka. Sampaikan pengalaman, keluhan, dan apresiasi Anda secara langsung.
          </p>

          <div class="flex flex-col sm:flex-row gap-4 pt-4">
            <a href="{{ route('destinations.index') }}" class="px-8 py-4 bg-brand-600 hover:bg-brand-500 text-white rounded-full font-bold shadow-lg shadow-brand-500/25 transition-all hover:-translate-y-1 flex items-center justify-center gap-2">
              Mulai Jelajah
              <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>
            </a>
            <a href="#features" class="px-8 py-4 bg-white/5 hover:bg-white/10 border border-white/10 text-white rounded-full font-semibold backdrop-blur-sm transition-all text-center">
              Pelajari Cara Kerja
            </a>
          </div>

          {{-- Quick Stats --}}
          <div class="grid grid-cols-3 gap-4 sm:gap-8 pt-8 border-t border-white/10 relative z-20">
            <div>
              <p class="text-2xl sm:text-3xl font-bold text-white drop-shadow-md">100+</p>
              <p class="text-xs sm:text-sm text-slate-300 drop-shadow-sm">Destinasi</p>
            </div>
            <div>
              <p class="text-2xl sm:text-3xl font-bold text-white drop-shadow-md">5k+</p>
              <p class="text-xs sm:text-sm text-slate-300 drop-shadow-sm">Ulasan</p>
            </div>
            <div>
              <p class="text-2xl sm:text-3xl font-bold text-white drop-shadow-md">24h</p>
              <p class="text-xs sm:text-sm text-slate-300 drop-shadow-sm">Respon Cepat</p>
            </div>
          </div>
        </div>

        {{-- Floating Cards (Decorative) --}}
        <div class="hidden lg:block relative h-[600px]">
          <div class="absolute top-10 right-10 w-72 bg-white/10 backdrop-blur-xl border border-white/20 p-6 rounded-3xl shadow-2xl animate-float" style="animation-delay: 0s;">
            <div class="flex items-center gap-4 mb-4">
              <div class="w-12 h-12 rounded-full bg-cover shadow-md" style="background-image: url('{{ $gallery[0] }}')"></div>
              <div>
                <p class="text-white font-bold">Panyaweuyan</p>
                <div class="flex text-amber-400 text-xs">★★★★★</div>
              </div>
            </div>
            <p class="text-slate-200 text-sm italic">"Pemandangan yang luar biasa indah! Fasilitas juga sudah sangat memadai."</p>
          </div>

          <div class="absolute bottom-20 left-10 w-72 bg-white/10 backdrop-blur-xl border border-white/20 p-6 rounded-3xl shadow-2xl animate-float" style="animation-delay: 2s;">
            <div class="flex items-center gap-4 mb-4">
              <div class="w-12 h-12 rounded-full bg-cover shadow-md" style="background-image: url('{{ $gallery[5] }}')"></div>
              <div>
                <p class="text-white font-bold">Cikadongdong</p>
                <div class="flex text-amber-400 text-xs">★★★★★</div>
              </div>
            </div>
            <p class="text-slate-200 text-sm italic">"River tubing terseru di Majalengka. Guide-nya ramah banget!"</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  {{-- BENTO GRID FEATURES --}}
  <section id="features" class="py-16 md:py-24 bg-slate-50 dark:bg-slate-950">
    <div class="container mx-auto px-6 sm:px-6 lg:px-8">
      <div class="text-center max-w-3xl mx-auto mb-12 md:mb-16 animate-slide-up" style="animation-delay: 0.2s;">
        <h2 class="font-serif text-3xl md:text-4xl font-bold text-slate-900 dark:text-white mb-4">Mengapa Suara Anda Penting?</h2>
        <p class="text-slate-600 dark:text-slate-400 text-base md:text-lg">Platform ini didesain untuk menghubungkan wisatawan langsung dengan pengelola destinasi.</p>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-3 gap-6 animate-slide-up" style="animation-delay: 0.4s;">
        {{-- Card 1: Large Span --}}
        <div class="md:col-span-2 bg-white dark:bg-slate-900 rounded-[2rem] p-6 md:p-8 shadow-sm border border-slate-100 dark:border-slate-800 relative overflow-hidden group hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
          <div class="absolute top-0 right-0 w-64 h-64 bg-brand-500/5 rounded-full blur-3xl -mr-16 -mt-16 group-hover:bg-brand-500/10 transition-colors"></div>
          <div class="relative z-10 h-full flex flex-col justify-between min-h-[200px] md:min-h-[240px]">
            <div class="w-12 h-12 md:w-14 md:h-14 bg-brand-50 dark:bg-brand-900/20 text-brand-600 rounded-2xl flex items-center justify-center text-xl md:text-2xl mb-6 shadow-sm">📢</div>
            <div>
              <h3 class="text-xl md:text-2xl font-bold text-slate-900 dark:text-white mb-2 group-hover:text-brand-600 transition-colors">Dampak Langsung</h3>
              <p class="text-slate-600 dark:text-slate-400 max-w-md text-sm md:text-base">Laporan Anda tidak hanya disimpan, tetapi diteruskan langsung ke dinas terkait untuk tindak lanjut nyata di lapangan.</p>
            </div>
          </div>
        </div>

        {{-- Card 2: Tall Span --}}
        <div class="md:row-span-2 bg-slate-900 text-white rounded-[2rem] p-6 md:p-8 shadow-xl relative overflow-hidden group hover:-translate-y-1 transition-all duration-300 min-h-[300px] md:min-h-[400px]">
          <img src="{{ $workflowImage }}" class="absolute inset-0 w-full h-full object-cover opacity-50 group-hover:scale-105 transition-transform duration-700" alt="Workflow">
          <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-slate-900/60 to-transparent"></div>
          <div class="relative z-10 h-full flex flex-col justify-end">
            <div class="w-12 h-12 md:w-14 md:h-14 bg-white/10 backdrop-blur-md rounded-2xl flex items-center justify-center text-xl md:text-2xl mb-6 border border-white/20">👁️</div>
            <h3 class="text-xl md:text-2xl font-bold mb-2">Transparansi</h3>
            <p class="text-slate-300 text-sm md:text-base">Pantau status laporan Anda dari "Terkirim" hingga "Selesai" secara real-time melalui dashboard publik.</p>
          </div>
        </div>

        {{-- Card 3 --}}
        <div class="bg-white dark:bg-slate-900 rounded-[2rem] p-6 md:p-8 shadow-sm border border-slate-100 dark:border-slate-800 group hover:shadow-xl hover:-translate-y-1 transition-all duration-300 min-h-[200px] md:min-h-[240px]">
          <div class="w-12 h-12 md:w-14 md:h-14 bg-amber-50 dark:bg-amber-900/20 text-amber-600 rounded-2xl flex items-center justify-center text-xl md:text-2xl mb-6 shadow-sm">⚡</div>
          <h3 class="text-lg md:text-xl font-bold text-slate-900 dark:text-white mb-2 group-hover:text-amber-600 transition-colors">Respon Cepat</h3>
          <p class="text-slate-600 dark:text-slate-400 text-sm md:text-base">Tim kami berdedikasi untuk merespon setiap masukan dalam 1x24 jam kerja.</p>
        </div>

        {{-- Card 4 --}}
        <div class="bg-white dark:bg-slate-900 rounded-[2rem] p-6 md:p-8 shadow-sm border border-slate-100 dark:border-slate-800 group hover:shadow-xl hover:-translate-y-1 transition-all duration-300 min-h-[200px] md:min-h-[240px]">
          <div class="w-12 h-12 md:w-14 md:h-14 bg-blue-50 dark:bg-blue-900/20 text-blue-600 rounded-2xl flex items-center justify-center text-xl md:text-2xl mb-6 shadow-sm">🤝</div>
          <h3 class="text-lg md:text-xl font-bold text-slate-900 dark:text-white mb-2 group-hover:text-blue-600 transition-colors">Kolaborasi</h3>
          <p class="text-slate-600 dark:text-slate-400 text-sm md:text-base">Membangun ekosistem wisata yang ramah, aman, dan nyaman bersama-sama.</p>
        </div>
      </div>
    </div>
  </section>

  {{-- FEATURED DESTINATIONS SLIDER (Horizontal Scroll) --}}
  <section class="py-16 md:py-24 overflow-hidden bg-white dark:bg-slate-900 animate-slide-up" style="animation-delay: 0.6s;">
    <div class="container mx-auto px-6 sm:px-6 lg:px-8 mb-8 md:mb-12 flex justify-between items-end">
      <div>
        <h2 class="font-serif text-3xl md:text-4xl font-bold text-slate-900 dark:text-white">Destinasi Populer</h2>
        <p class="text-slate-600 dark:text-slate-400 mt-2 text-sm md:text-base">Pilihan favorit wisatawan bulan ini.</p>
      </div>
      <a href="{{ route('destinations.index') }}" class="hidden md:flex items-center gap-2 text-brand-600 font-bold hover:text-brand-700 transition-colors">
        Lihat Semua <span aria-hidden="true">&rarr;</span>
      </a>
    </div>

    {{-- Slider Container with Buttons --}}
    <div class="relative group" x-data="{
        active: false,
        startX: 0,
        scrollLeft: 0,
        start(e) {
            this.active = true;
            this.startX = e.pageX - $refs.slider.offsetLeft;
            this.scrollLeft = $refs.slider.scrollLeft;
        },
        stop() {
            this.active = false;
        },
        move(e) {
            if (!this.active) return;
            e.preventDefault();
            const x = e.pageX - $refs.slider.offsetLeft;
            const walk = (x - this.startX) * 2;
            $refs.slider.scrollLeft = this.scrollLeft - walk;
        },
        scrollNext() {
            $refs.slider.scrollBy({ left: 320, behavior: 'smooth' });
        },
        scrollPrev() {
            $refs.slider.scrollBy({ left: -320, behavior: 'smooth' });
        }
    }">
      
      {{-- Prev Button (Visible on Mobile now) --}}
      <button @click="scrollPrev()" class="absolute left-2 md:left-4 top-1/2 -translate-y-1/2 z-20 w-10 h-10 md:w-12 md:h-12 rounded-full bg-white/80 dark:bg-slate-800/80 backdrop-blur shadow-lg flex items-center justify-center text-slate-900 dark:text-white hover:scale-110 transition-all opacity-100 md:opacity-0 md:group-hover:opacity-100">
        <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
      </button>

      {{-- Next Button (Visible on Mobile now) --}}
      <button @click="scrollNext()" class="absolute right-2 md:right-4 top-1/2 -translate-y-1/2 z-20 w-10 h-10 md:w-12 md:h-12 rounded-full bg-white/80 dark:bg-slate-800/80 backdrop-blur shadow-lg flex items-center justify-center text-slate-900 dark:text-white hover:scale-110 transition-all opacity-100 md:opacity-0 md:group-hover:opacity-100">
        <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
      </button>

      <div x-ref="slider"
        @mousedown="start($event)"
        @mouseleave="stop"
        @mouseup="stop"
        @mousemove="move($event)"
        class="flex overflow-x-auto pb-12 gap-4 md:gap-6 px-6 sm:px-6 lg:px-8 snap-x snap-mandatory hide-scrollbar cursor-grab active:cursor-grabbing select-none">
        @if($featured instanceof \Illuminate\Support\Collection && $featured->isNotEmpty())
          @foreach ($featured as $d)
            <div onclick="if(!window.getSelection().toString()) window.location.href='{{ route('destinations.show', $d->slug) }}'" 
                 class="snap-center shrink-0 w-[280px] md:w-[380px] group/card relative rounded-[2rem] overflow-hidden aspect-[3/4] shadow-lg hover:shadow-2xl transition-all duration-500 cursor-pointer">
              <img src="{{ $d->cover_url ?? $fallbackThumb }}" alt="{{ $d->name }}" class="w-full h-full object-cover group-hover/card:scale-110 transition-transform duration-700 pointer-events-none">
              <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/20 to-transparent opacity-80 group-hover/card:opacity-90 transition-opacity pointer-events-none"></div>
              
              <div class="absolute top-4 right-4 pointer-events-none">
                 <span class="px-3 py-1 bg-white/20 backdrop-blur-md border border-white/30 rounded-full text-xs font-bold text-white uppercase tracking-wider">
                  {{ $d->category->name ?? 'Wisata' }}
                </span>
              </div>

              <div class="absolute bottom-0 left-0 p-6 md:p-8 w-full pointer-events-none">
                <h3 class="text-xl md:text-2xl font-bold text-white mb-2 leading-tight">{{ $d->name }}</h3>
                <p class="text-slate-300 text-xs md:text-sm line-clamp-2 mb-4">{{ $d->address }}</p>
                <div class="flex items-center text-brand-300 text-sm font-bold gap-1 group-hover/card:translate-x-2 transition-transform">
                  Lihat Detail &rarr;
                </div>
              </div>
            </div>
          @endforeach
        @else
          <div class="w-full text-center py-12 bg-slate-50 dark:bg-slate-800 rounded-3xl border border-dashed border-slate-200 dark:border-slate-700">
            <p class="text-slate-500">Belum ada data destinasi.</p>
          </div>
        @endif
      </div>
    </div>
    
    {{-- Mobile View All Link --}}
    <div class="md:hidden text-center mt-4">
        <a href="{{ route('destinations.index') }}" class="inline-flex items-center gap-2 text-brand-600 font-bold hover:text-brand-700 transition-colors">
            Lihat Semua Destinasi <span aria-hidden="true">&rarr;</span>
        </a>
    </div>
  </section>

  {{-- CTA --}}
  <section class="py-20 md:py-32 bg-brand-900 relative overflow-hidden animate-slide-up" style="animation-delay: 0.8s;">
    <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')]"></div>
    <div class="absolute top-0 left-0 w-full h-full overflow-hidden pointer-events-none">
        <div class="absolute top-[-20%] right-[-10%] w-[600px] h-[600px] bg-brand-500/20 rounded-full blur-[120px]"></div>
        <div class="absolute bottom-[-20%] left-[-10%] w-[500px] h-[500px] bg-emerald-500/20 rounded-full blur-[100px]"></div>
    </div>

    <div class="container mx-auto px-6 text-center relative z-10">
      <h2 class="font-serif text-3xl md:text-6xl font-bold text-white mb-6 md:mb-8 leading-tight">
        Siap Berbagi Cerita?
      </h2>
      <p class="text-brand-100 text-lg md:text-xl max-w-2xl mx-auto mb-8 md:mb-12 font-light leading-relaxed">
        Setiap ulasan Anda adalah langkah kecil menuju perubahan besar bagi pariwisata Majalengka.
      </p>
      <a href="{{ route('destinations.index') }}" class="inline-flex items-center gap-3 px-8 py-4 md:px-10 md:py-5 bg-white text-brand-900 rounded-full font-bold text-base md:text-lg hover:bg-brand-50 transition-all shadow-[0_0_40px_rgba(255,255,255,0.3)] hover:scale-105 hover:shadow-[0_0_60px_rgba(255,255,255,0.4)]">
        <span>Tulis Ulasan Sekarang</span>
        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" /></svg>
      </a>
    </div>
  </section>

  <style>
    .hide-scrollbar::-webkit-scrollbar {
      display: none;
    }
    .hide-scrollbar {
      -ms-overflow-style: none;
      scrollbar-width: none;
    }
    @keyframes kenburns {
      0% { transform: scale(1); }
      100% { transform: scale(1.15); }
    }
    .animate-kenburns {
      animation: kenburns 20s ease-out infinite alternate;
    }
  </style>
@endsection
