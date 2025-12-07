<!DOCTYPE html>
<html lang="id" class="scroll-smooth" data-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Majalengka Visitor Feedback' }}</title>
    <meta name="description" content="{{ $metaDescription ?? 'Platform aspirasi dan ulasan wisatawan Majalengka.' }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.3/dist/cdn.min.js"></script>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Outfit', 'sans-serif'],
                        serif: ['"DM Serif Display"', 'serif'],
                    },
                    colors: {
                        brand: {
                            50: '#ecfdf5',
                            100: '#d1fae5',
                            200: '#a7f3d0',
                            300: '#6ee7b7',
                            400: '#34d399',
                            500: '#10b981',
                            600: '#059669',
                            700: '#047857',
                            800: '#065f46',
                            900: '#064e3b',
                            950: '#022c22',
                        },
                        slate: {
                            850: '#1e293b', 
                            900: '#0f172a',
                            950: '#020617',
                        }
                    },
                    boxShadow: {
                        'soft': '0 10px 40px -10px rgba(0, 0, 0, 0.08)',
                        'glow': '0 0 20px rgba(16, 185, 129, 0.4)',
                    },
                    animation: {
                        'float': 'float 6s ease-in-out infinite',
                        'slide-up': 'slideUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards',
                    },
                    keyframes: {
                        float: {
                            '0%, 100%': { transform: 'translateY(0)' },
                            '50%': { transform: 'translateY(-10px)' },
                        },
                        slideUp: {
                            '0%': { transform: 'translateY(20px)', opacity: '0' },
                            '100%': { transform: 'translateY(0)', opacity: '1' },
                        }
                    }
                }
            }
        }
    </script>

    <style>
        [x-cloak] { display: none !important; }
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
        .dark ::-webkit-scrollbar-thumb { background: #334155; }
        .dark ::-webkit-scrollbar-thumb:hover { background: #475569; }

        /* Consistent Navbar Style */
        .glass-nav {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border-bottom: 1px solid rgba(226, 232, 240, 1);
        }
        .dark .glass-nav {
            background: rgba(2, 6, 23, 0.9);
            border-bottom: 1px solid rgba(30, 41, 59, 1);
        }
    </style>
</head>
<body class="antialiased bg-slate-50 text-slate-900 dark:bg-slate-950 dark:text-slate-100 transition-colors duration-300"
      x-data="{ 
          darkMode: localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches),
          toggleTheme() {
              this.darkMode = !this.darkMode;
              localStorage.setItem('theme', this.darkMode ? 'dark' : 'light');
              if (this.darkMode) {
                  document.documentElement.classList.add('dark');
              } else {
                  document.documentElement.classList.remove('dark');
              }
          }
      }"
      x-init="$watch('darkMode', val => val ? document.documentElement.classList.add('dark') : document.documentElement.classList.remove('dark')); if(darkMode) document.documentElement.classList.add('dark');"
>

    <!-- Navigation (Consistent Everywhere) -->
    <nav class="glass-nav fixed top-0 w-full z-50 transition-all duration-300">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <!-- Logo -->
                <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-brand-600 to-brand-500 text-white flex items-center justify-center shadow-lg shadow-brand-500/20 group-hover:scale-105 transition-transform duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <div class="flex flex-col">
                        <span class="font-serif text-xl font-bold tracking-tight leading-none text-slate-900 dark:text-white">
                            Majalengka
                        </span>
                        <span class="text-[10px] uppercase tracking-widest font-bold text-brand-600 dark:text-brand-400">
                            Visitor Feedback
                        </span>
                    </div>
                </a>

                <!-- Desktop Menu -->
                <div class="hidden md:flex items-center gap-8">
                    <a href="{{ route('home') }}" 
                       class="text-sm font-semibold transition-colors hover:text-brand-600 {{ request()->routeIs('home') ? 'text-brand-600' : 'text-slate-600 dark:text-slate-300' }}">
                       Beranda
                    </a>
                    <a href="{{ route('destinations.index') }}" 
                       class="text-sm font-semibold transition-colors hover:text-brand-600 {{ request()->routeIs('destinations.*') ? 'text-brand-600' : 'text-slate-600 dark:text-slate-300' }}">
                       Destinasi
                    </a>
                    
                    <!-- Theme Toggle -->
                    <button @click="toggleTheme()" 
                            class="p-2 rounded-full transition-colors hover:bg-slate-100 dark:hover:bg-slate-800 text-slate-500 dark:text-slate-400">
                        <svg x-show="!darkMode" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" /></svg>
                        <svg x-show="darkMode" x-cloak class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                    </button>

                    <a href="{{ route('destinations.index') }}" 
                       class="px-6 py-2.5 rounded-full text-sm font-bold shadow-lg transition-all hover:-translate-y-0.5 bg-brand-600 hover:bg-brand-700 text-white shadow-brand-500/30">
                        Mulai Ulas
                    </a>
                </div>

                <!-- Mobile Menu Button -->
                <div class="md:hidden flex items-center gap-4">
                    <button @click="toggleTheme()" class="p-2 rounded-full transition-colors hover:bg-slate-100 dark:hover:bg-slate-800 text-slate-500 dark:text-slate-400">
                        <svg x-show="!darkMode" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" /></svg>
                        <svg x-show="darkMode" x-cloak class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                    </button>
                    <button x-data="{ open: false }" @click="open = !open" class="relative z-50 p-2 text-slate-700 dark:text-slate-200">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path x-show="!open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            <path x-show="open" x-cloak stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        
                        <!-- Mobile Dropdown -->
                        <div x-show="open" x-cloak 
                             @click.away="open = false"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 translate-y-2"
                             x-transition:enter-end="opacity-100 translate-y-0"
                             class="absolute top-full right-0 mt-4 w-56 bg-white dark:bg-slate-900 rounded-2xl shadow-xl border border-slate-100 dark:border-slate-800 py-2 overflow-hidden text-left">
                            <a href="{{ route('home') }}" class="block px-6 py-3 text-sm font-medium text-slate-700 dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-800">Beranda</a>
                            <a href="{{ route('destinations.index') }}" class="block px-6 py-3 text-sm font-medium text-slate-700 dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-800">Destinasi</a>
                        </div>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        {{ $slot ?? '' }}
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-white dark:bg-slate-950 border-t border-slate-200 dark:border-slate-800 pt-20 pb-10">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 mb-16">
                <div class="space-y-6">
                    <a href="/" class="flex items-center gap-2">
                        <div class="w-10 h-10 rounded-xl bg-brand-600 flex items-center justify-center text-white shadow-lg shadow-brand-500/20">
                            <span class="font-serif font-bold text-xl">M</span>
                        </div>
                        <span class="font-serif text-xl font-bold text-slate-900 dark:text-white">Majalengka</span>
                    </a>
                    <p class="text-slate-500 dark:text-slate-400 leading-relaxed text-sm">
                        Membangun pariwisata yang lebih baik melalui suara Anda. Platform resmi Dinas Pariwisata & Kebudayaan.
                    </p>
                </div>
                
                <div>
                    <h4 class="font-bold text-slate-900 dark:text-white mb-6">Jelajahi</h4>
                    <ul class="space-y-4 text-sm text-slate-500 dark:text-slate-400">
                        <li><a href="#" class="hover:text-brand-600 transition-colors">Destinasi Unggulan</a></li>
                        <li><a href="#" class="hover:text-brand-600 transition-colors">Kategori Wisata</a></li>
                        <li><a href="#" class="hover:text-brand-600 transition-colors">Peta Lokasi</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="font-bold text-slate-900 dark:text-white mb-6">Dukungan</h4>
                    <ul class="space-y-4 text-sm text-slate-500 dark:text-slate-400">
                        <li><a href="#" class="hover:text-brand-600 transition-colors">Panduan Pengguna</a></li>
                        <li><a href="#" class="hover:text-brand-600 transition-colors">Kebijakan Privasi</a></li>
                        <li><a href="#" class="hover:text-brand-600 transition-colors">Kontak Kami</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="font-bold text-slate-900 dark:text-white mb-6">Newsletter</h4>
                    <form class="space-y-4">
                        <div class="relative">
                            <input type="email" placeholder="Email Anda" class="w-full pl-4 pr-12 py-3 rounded-xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 focus:ring-2 focus:ring-brand-500 focus:border-transparent outline-none transition-all text-sm">
                            <button type="button" class="absolute right-2 top-2 p-1.5 bg-brand-600 text-white rounded-lg hover:bg-brand-700 transition-colors shadow-md">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" /></svg>
                            </button>
                        </div>
                        <p class="text-xs text-slate-400">Kami tidak akan mengirimkan spam.</p>
                    </form>
                </div>
            </div>

            <div class="border-t border-slate-100 dark:border-slate-800 pt-8 flex flex-col md:flex-row justify-between items-center gap-4">
                <p class="text-sm text-slate-500 text-center md:text-left">
                    © {{ date('Y') }} Disparbud Majalengka. All rights reserved.
                </p>
                <div class="flex gap-6">
                    <a href="#" class="text-slate-400 hover:text-brand-600 transition-colors"><span class="sr-only">Instagram</span><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg></a>
                </div>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
