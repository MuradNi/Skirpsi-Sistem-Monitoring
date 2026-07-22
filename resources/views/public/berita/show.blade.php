@extends('layouts.app')

@section('title', $berita->judul . ' — SD Perguruan Buddhi')

@section('content')
  <article class="py-16 max-w-4xl mx-auto px-6 space-y-8">
    <a href="{{ route('beranda') }}#berita" class="inline-flex items-center gap-2 text-sm font-bold text-gray-500 hover:text-primary transition">
      <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali ke Beranda
    </a>

    <div class="h-[400px] w-full overflow-hidden rounded-3xl shadow-lg relative">
      <img src="{{ $berita->thumbnail }}" alt="{{ $berita->judul }}" class="w-full h-full object-cover">
      <span class="absolute bottom-6 left-6 bg-primary text-white text-xs font-bold px-4 py-1.5 rounded-full uppercase tracking-wider shadow-md">
        {{ $berita->kategori }}
      </span>
    </div>

    <div class="space-y-4">
      <span class="text-xs font-semibold text-gray-400">
        Diterbitkan pada {{ Carbon\Carbon::parse($berita->created_at)->format('d M Y') }}
      </span>
      <h1 class="text-4xl lg:text-5xl font-black text-gray-900 leading-tight">
        {{ $berita->judul }}
      </h1>
    </div>

    <div class="prose max-w-none text-gray-600 leading-relaxed text-base whitespace-pre-line border-t border-gray-100 pt-6">
      {{ $berita->body }}
    </div>
  </article>
@endsection
