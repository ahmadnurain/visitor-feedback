@extends('layouts.app', [
    'title' => 'Terima Kasih',
])

@section('content')
<div class="min-h-screen flex items-center justify-center bg-slate-50 dark:bg-slate-950 px-4">
    <div class="max-w-md w-full text-center space-y-8 animate-slide-up">
        
        <div class="relative inline-block">
            <div class="absolute inset-0 bg-green-500/20 rounded-full blur-xl animate-pulse"></div>
            <div class="relative w-24 h-24 bg-green-100 dark:bg-green-900/30 text-green-600 rounded-full flex items-center justify-center mx-auto shadow-lg shadow-green-500/20 animate-bounce">
                <svg class="w-12 h-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                </svg>
            </div>
        </div>

        <div class="space-y-4">
            <h1 class="font-serif text-4xl font-bold text-slate-900 dark:text-white">Terima Kasih!</h1>
            <p class="text-slate-600 dark:text-slate-400 text-lg leading-relaxed">
                Ulasan Anda sangat berarti bagi kami. Bersama, kita wujudkan pariwisata Majalengka yang lebih baik.
            </p>
        </div>

        <div class="flex flex-col sm:flex-row gap-4 justify-center pt-4">
            <a href="{{ route('destinations.index') }}" class="px-8 py-3.5 rounded-xl bg-brand-600 hover:bg-brand-700 text-white font-bold shadow-lg shadow-brand-500/30 transition-all hover:-translate-y-1">
                Ulas Destinasi Lain
            </a>
            <a href="{{ route('home') }}" class="px-8 py-3.5 rounded-xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-700 dark:text-slate-300 font-bold hover:bg-slate-50 dark:hover:bg-slate-700 transition-all hover:-translate-y-1">
                Kembali ke Beranda
            </a>
        </div>

    </div>
</div>
@endsection
