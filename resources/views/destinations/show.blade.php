@extends('layouts.app', [
    'title' => $destination->name,
])

@php
  $banner = $destination->cover_url ?: asset('images/placeholder-destination.jpg');
@endphp

@section('content')
  {{-- HERO --}}
  <div class="relative h-[60vh] min-h-[500px] w-full overflow-hidden lg:mt-20 bg-slate-950">
    <div class="absolute inset-0">
      <img src="{{ $banner }}" alt="{{ $destination->name }}" class="w-full h-full object-cover animate-kenburns opacity-70">
      <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/50 to-transparent"></div>
    </div>
    
    <div class="absolute bottom-0 left-0 w-full p-6 pb-16 md:p-16 md:pb-32">
      <div class="container mx-auto max-w-7xl">
        <div class="max-w-4xl animate-slide-up">
          <div class="flex flex-wrap items-center gap-3 mb-4">
            @if($destination->category)
              <span class="px-4 py-1.5 rounded-full bg-white/20 backdrop-blur-md border border-white/30 text-white text-xs font-bold uppercase tracking-wider">
                {{ $destination->category->name }}
              </span>
            @endif
            <div class="flex items-center gap-1 text-amber-400 bg-black/30 backdrop-blur-md px-3 py-1.5 rounded-full border border-white/10">
              <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
              <span class="text-white text-xs font-bold">4.8 (120 Ulasan)</span>
            </div>
          </div>
          
          <h1 class="font-serif text-4xl md:text-7xl font-bold text-white mb-4 md:mb-6 leading-tight drop-shadow-xl">
            {{ $destination->name }}
          </h1>
          
          @if($destination->address)
            <div class="flex items-start md:items-center gap-3 text-slate-200 text-base md:text-lg max-w-2xl backdrop-blur-sm bg-black/20 p-4 rounded-2xl border border-white/10">
              <svg class="w-6 h-6 text-brand-400 shrink-0 mt-0.5 md:mt-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
              </svg>
              <span class="line-clamp-2 md:line-clamp-none">{{ $destination->address }}</span>
            </div>
          @endif
        </div>
      </div>
    </div>
  </div>

  {{-- CONTENT --}}
  <div class="relative z-10 -mt-12 md:-mt-20 pb-24">
    <div class="container mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
      <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        {{-- Main Content --}}
        <div class="lg:col-span-2 space-y-6 md:space-y-8">
          {{-- About --}}
          <div class="bg-white dark:bg-slate-900 rounded-[2rem] p-6 md:p-8 shadow-xl border border-slate-100 dark:border-slate-800 animate-slide-up" style="animation-delay: 0.2s;">
            <h2 class="font-serif text-2xl font-bold text-slate-900 dark:text-white mb-4">Tentang Destinasi</h2>
            <p class="text-slate-600 dark:text-slate-300 leading-relaxed text-base md:text-lg">
              {{ $destination->description ?? 'Selamat datang di ' . $destination->name . '. Tempat ini menawarkan pengalaman wisata yang unik di Majalengka. Kami berkomitmen untuk terus meningkatkan kualitas layanan dan fasilitas. Masukan Anda sangat berarti bagi pengembangan berkelanjutan destinasi ini.' }}
            </p>
            
            <div class="mt-8 grid grid-cols-2 md:grid-cols-4 gap-4">
              @foreach(['Parkir Luas', 'Toilet Bersih', 'Mushola', 'Kantin'] as $facility)
                <div class="flex flex-col items-center justify-center p-4 rounded-2xl bg-slate-50 dark:bg-slate-800 border border-slate-100 dark:border-slate-700">
                  <svg class="w-6 h-6 text-brand-500 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                  <span class="text-xs font-bold text-slate-600 dark:text-slate-300">{{ $facility }}</span>
                </div>
              @endforeach
            </div>
          </div>

          {{-- Map --}}
          <div class="bg-white dark:bg-slate-900 rounded-[2rem] p-6 md:p-8 shadow-xl border border-slate-100 dark:border-slate-800 animate-slide-up" style="animation-delay: 0.3s;">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-6 gap-2">
              <h2 class="font-serif text-2xl font-bold text-slate-900 dark:text-white">Peta Lokasi</h2>
              <a href="https://www.google.com/maps/search/?api=1&query={{ $destination->latitude ?? 0 }},{{ $destination->longitude ?? 0 }}" target="_blank" class="text-brand-600 font-bold text-sm hover:underline flex items-center gap-1">
                Buka Google Maps 
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
              </a>
            </div>
            <div class="h-64 md:h-80 w-full rounded-2xl overflow-hidden bg-slate-100 dark:bg-slate-800 relative z-0">
               @if($destination->latitude && $destination->longitude)
                 <div id="map-{{ $destination->id }}" class="w-full h-full"></div>
                 <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
               @else
                 <div class="flex items-center justify-center h-full text-slate-400">Koordinat belum tersedia</div>
               @endif
            </div>
          </div>
        </div>

        {{-- Sidebar Form --}}
        <div class="lg:col-span-1 animate-slide-up" style="animation-delay: 0.4s;">
          <div class="sticky top-24">
            <div class="bg-white dark:bg-slate-900 rounded-[2rem] shadow-2xl border border-slate-100 dark:border-slate-800 p-6 md:p-8 relative overflow-hidden">
              {{-- Decorative Blob --}}
              <div class="absolute -top-20 -right-20 w-64 h-64 bg-brand-500/10 rounded-full blur-3xl pointer-events-none"></div>
              
              <h3 class="font-serif text-2xl font-bold text-slate-900 dark:text-white mb-2 relative">Tulis Ulasan</h3>
              <p class="text-slate-500 dark:text-slate-400 text-sm mb-6 relative">Bagikan pengalaman kunjungan Anda.</p>

              @if ($errors->any())
                <div class="mb-6 p-4 rounded-xl bg-red-50 dark:bg-red-900/20 border border-red-100 dark:border-red-800 text-red-600 dark:text-red-300 text-sm">
                  <ul class="list-disc pl-4 space-y-1">
                    @foreach($errors->all() as $err) <li>{{ $err }}</li> @endforeach
                  </ul>
                </div>
              @endif

              <form action="{{ route('feedbacks.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5 relative z-10"
                x-data="{ 
                    rating: 0, 
                    files: [],
                    fileCheckError: false,
                    handleFileSelect(event) {
                        const uploaded = Array.from(event.target.files);
                        this.files = uploaded.map(file => ({
                            name: file.name,
                            url: URL.createObjectURL(file),
                            size: file.size,
                            invalid: file.size > 5242880 // 5MB in bytes
                        }));
                        
                        this.fileCheckError = this.files.some(f => f.invalid);
                    }
                }">
                @csrf
                <input type="hidden" name="destination_id" value="{{ $destination->id }}">

                <div>
                  <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Nama Pengunjung (Opsional)</label>
                  <input type="text" name="visitor_name" maxlength="50" class="w-full px-4 py-3 rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 focus:ring-2 focus:ring-brand-500 focus:border-transparent outline-none transition-all" placeholder="Nama Anda (Maks. 50 Karakter)">
                </div>

                <div>
                  <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Rating</label>
                  <div class="flex gap-2">
                    <input type="hidden" name="rating" :value="rating">
                    <template x-for="i in 5">
                      <button type="button" @click="rating = i" class="focus:outline-none transition-transform hover:scale-110">
                        <svg class="w-8 h-8" :class="i <= rating ? 'text-amber-400 fill-current' : 'text-slate-300 dark:text-slate-600 fill-current'" viewBox="0 0 20 20">
                          <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                      </button>
                    </template>
                  </div>
                </div>

                <div>
                  <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Kategori</label>
                  <div class="grid grid-cols-3 gap-2">
                    @foreach($feedbackCategories as $cat)
                      <label class="cursor-pointer">
                        <input type="radio" name="feedback_category_id" value="{{ $cat->id }}" class="peer sr-only" {{ $loop->first ? 'checked' : '' }}>
                        <div class="text-center py-2 rounded-xl border border-slate-200 dark:border-slate-700 text-sm font-medium text-slate-600 dark:text-slate-300 peer-checked:bg-brand-600 peer-checked:text-white peer-checked:border-brand-600 transition-all capitalize">
                          {{ $cat->name }}
                        </div>
                      </label>
                    @endforeach
                  </div>
                </div>

                <div>
                  <input type="text" name="title" required maxlength="100" class="w-full px-4 py-3 rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 focus:ring-2 focus:ring-brand-500 focus:border-transparent outline-none transition-all" placeholder="Judul Singkat (Maks. 100 Karakter)">
                </div>

                <div>
                  <textarea name="content" rows="4" required maxlength="5000" class="w-full px-4 py-3 rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 focus:ring-2 focus:ring-brand-500 focus:border-transparent outline-none transition-all resize-none" placeholder="Ceritakan pengalaman Anda..."></textarea>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Foto Dokumentasi (Opsional)</label>
                    
                    {{-- Error message area --}}
                    <div x-show="fileCheckError" class="mb-3 p-3 rounded-lg bg-red-50 border border-red-200 text-red-600 text-xs font-bold flex items-center gap-2 animate-pulse">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                        Ukuran file tidak boleh lebih dari 5 MB!
                    </div>

                    <div class="relative group w-full min-h-[120px] rounded-xl border-2 border-dashed transition-all overflow-hidden"
                         :class="fileCheckError ? 'border-red-300 bg-red-50/50' : 'border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-950 hover:border-brand-400'">
                        
                        {{-- Input File Overlay --}}
                        <input type="file" name="attachments[]" multiple accept="image/png, image/jpeg, image/webp" 
                            @change="handleFileSelect($event)"
                            class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-50">
                        
                        <div x-show="files.length === 0" class="absolute inset-0 flex flex-col items-center justify-center text-center p-4 pointer-events-none transition-opacity duration-300">
                            <svg class="w-8 h-8 text-slate-400 mb-2 group-hover:scale-110 transition-transform" :class="fileCheckError ? 'text-red-400' : 'text-slate-400'" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <p class="text-sm font-medium transition-colors" :class="fileCheckError ? 'text-red-500' : 'text-slate-600 dark:text-slate-300 group-hover:text-brand-500'">
                                Klik untuk upload foto
                            </p>
                            <p class="text-xs mt-1" :class="fileCheckError ? 'text-red-400' : 'text-slate-400'">Maks. 5 file (JPG, PNG)</p>
                        </div>

                        {{-- Image Previews (Adaptive Grid) --}}
                        <div x-show="files.length > 0" 
                             class="relative z-10 w-full h-full p-2 grid gap-2"
                             :class="{
                                'grid-cols-1': files.length === 1,
                                'grid-cols-2': files.length === 2,
                                'grid-cols-3': files.length >= 3
                             }">
                            <template x-for="(file, index) in files" :key="index">
                                <div class="relative rounded-lg overflow-hidden group/img shadow-sm border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900"
                                     :class="files.length === 1 ? 'aspect-video' : 'aspect-square'">
                                    
                                    <img :src="file.url" class="w-full h-full object-cover transition-transform duration-500 group-hover/img:scale-110" :alt="file.name">
                                    
                                    {{-- Hover Overlay --}}
                                    <div class="absolute inset-0 bg-black/60 opacity-0 group-hover/img:opacity-100 transition-opacity duration-300 flex flex-col items-center justify-center p-2 text-center pointer-events-none">
                                        <svg class="w-5 h-5 text-white mb-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" /></svg>
                                        <span class="text-[10px] font-bold text-white uppercase tracking-wider truncate w-full" x-text="file.name"></span>
                                        <span class="text-[9px] text-slate-300">Ganti File</span>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>

                <div class="pt-4 border-t border-slate-100 dark:border-slate-800">
                  <p class="text-xs text-slate-400 mb-3">Kontak (Opsional)</p>
                  <div class="grid grid-cols-2 gap-3">
                    <input type="email" name="contact_email" maxlength="50" class="w-full px-4 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 focus:ring-2 focus:ring-brand-500 outline-none text-sm" placeholder="Email (Maks. 50 Karakter)">
                    <input type="tel" name="contact_phone" maxlength="14" x-on:input="$el.value = $el.value.replace(/[^0-9]/g, '').slice(0, 14)" class="w-full px-4 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 focus:ring-2 focus:ring-brand-500 outline-none text-sm" placeholder="No. HP (08xxx)">
                  </div>
                </div>

                <button type="submit" 
                        :disabled="fileCheckError"
                        :class="fileCheckError ? 'bg-slate-300 cursor-not-allowed text-slate-500' : 'bg-brand-600 hover:bg-brand-700 text-white shadow-brand-500/30 hover:shadow-brand-500/50 hover:-translate-y-0.5'"
                        class="w-full py-4 rounded-xl font-bold shadow-lg transition-all duration-200">
                  Kirim Ulasan
                </button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  {{-- Success Modal --}}
  @if(session('feedback_submitted'))
    <div class="fixed inset-0 z-[100] flex items-center justify-center px-4" x-data="{ show: true }" x-show="show">
      <div class="absolute inset-0 bg-black/60 backdrop-blur-sm transition-opacity" @click="show = false"></div>
      <div class="bg-white dark:bg-slate-900 rounded-[2rem] p-8 max-w-md w-full relative z-10 shadow-2xl animate-slide-up text-center">
        <div class="w-20 h-20 bg-green-100 dark:bg-green-900/30 text-green-600 rounded-full flex items-center justify-center mx-auto mb-6">
          <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
        </div>
        <h3 class="font-serif text-2xl font-bold text-slate-900 dark:text-white mb-2">Terima Kasih!</h3>
        <p class="text-slate-500 dark:text-slate-400 mb-8">Ulasan Anda telah kami terima dan akan segera ditindaklanjuti oleh tim terkait.</p>
        <button @click="show = false" class="w-full py-3 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 font-bold hover:bg-slate-200 dark:hover:bg-slate-700 transition-colors">
          Tutup
        </button>
      </div>
    </div>
  @endif
@endsection

@push('scripts')
  @if($destination->latitude && $destination->longitude)
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
      document.addEventListener('DOMContentLoaded', function() {
        const lat = {{ $destination->latitude }};
        const lng = {{ $destination->longitude }};
        const map = L.map('map-{{ $destination->id }}', { center: [lat, lng], zoom: 15, scrollWheelZoom: false });
        L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png', {
          attribution: '&copy; OpenStreetMap &copy; CARTO',
          subdomains: 'abcd', maxZoom: 20
        }).addTo(map);
        L.marker([lat, lng]).addTo(map).bindPopup('<div class="font-bold">{{ addslashes($destination->name) }}</div>');
      });
    </script>
  @endif
@endpush