@extends('layouts.app')

@section('title', 'SD Perguruan Buddhi — Membentuk Karakter Luhur & Unggul')

@section('content')
  <!-- Hero Section -->
  <section id="beranda" class="min-h-[80vh] bg-gradient-to-br from-red-50/70 via-white to-white flex items-center py-12">
    <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 lg:grid-cols-2 gap-12 items-center w-full">
      <!-- Left Info -->
      <div class="space-y-6">
        <span class="inline-flex items-center gap-2 px-4 py-2 bg-primary/10 text-primary rounded-full text-xs font-extrabold uppercase tracking-wide">
          🏆 Sekolah Terakreditasi A Terbaik
        </span>
        <h1 class="text-5xl lg:text-6xl font-black text-gray-900 leading-tight">
          SD Perguruan <br>
          <span class="text-primary font-playfair">Buddhi</span>
        </h1>
        <p class="text-lg text-gray-500 leading-relaxed max-w-lg">
          SD Perguruan Buddhi berkomitmen menyelenggarakan pendidikan dasar modern berlandaskan cinta kasih, mengembangkan potensi intelektual, spiritual, dan bakat unik setiap anak.
        </p>
        <div class="flex flex-wrap items-center gap-4 pt-2">
          <a href="{{ route('login') }}" class="px-7 py-4 bg-primary text-white rounded-xl font-bold hover:bg-primary-dark transition shadow-xl shadow-primary/30 flex items-center gap-2">
            Masuk Portal Akademik <i data-lucide="arrow-right" class="w-4 h-4"></i>
          </a>
          <a href="#profil" class="px-7 py-4 border-2 border-gray-300 text-gray-600 rounded-xl font-bold hover:border-primary hover:text-primary transition">
            Tentang Kami
          </a>
        </div>
        <!-- Stats -->
        <div class="grid grid-cols-3 gap-6 pt-8 border-t border-gray-100">
          <div>
            <p class="text-3xl font-black text-primary">1.200+</p>
            <p class="text-xs font-bold text-gray-400 uppercase tracking-wide">Siswa Aktif</p>
          </div>
          <div>
            <p class="text-3xl font-black text-primary">98%</p>
            <p class="text-xs font-bold text-gray-400 uppercase tracking-wide">Tingkat Kelulusan</p>
          </div>
          <div>
            <p class="text-3xl font-black text-primary">45+</p>
            <p class="text-xs font-bold text-gray-400 uppercase tracking-wide">Prestasi Nasional</p>
          </div>
        </div>
      </div>

      <!-- Right Graphic -->
      <div class="relative">
        <div class="absolute -top-12 -right-12 w-80 h-80 bg-primary/10 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-8 -left-8 w-60 h-60 bg-yellow-500/10 rounded-full blur-2xl"></div>

        <div class="relative z-10 p-2 bg-white/60 border border-white backdrop-blur-md rounded-3xl shadow-2xl overflow-hidden hover-scale">
          <img src="{{ asset('img/Sd.jpg') }}" alt="Gedung Buddhi" class="rounded-2xl w-full h-[380px] object-cover">
          
          <div class="absolute -bottom-6 -left-6 z-20 bg-white rounded-2xl shadow-2xl border border-gray-100 p-4 flex items-center gap-3">
            <div class="w-12 h-12 bg-emerald-100 text-emerald-600 rounded-xl flex items-center justify-center">
              <i data-lucide="award" class="w-6 h-6"></i>
            </div>
            <div>
              <p class="font-extrabold text-sm text-gray-900 leading-tight">Akreditasi A</p>
              <p class="text-xs font-bold text-gray-400 uppercase">BAN-SM 2024</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Profil Section -->
  <section id="profil" class="py-20 bg-gray-50 border-t border-gray-100">
    <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
      <div>
        <img src="{{ asset('img/Sd.jpg') }}" alt="Siswa SD Buddhi" class="rounded-3xl shadow-xl w-full h-[400px] object-cover hover-scale">
      </div>
      <div class="space-y-6">
        <span class="text-xs font-extrabold text-primary uppercase tracking-widest block">Tentang Kami</span>
        <h2 class="text-4xl font-extrabold text-gray-900 font-playfair leading-tight">Mendidik dengan Cinta Kasih untuk Masa Depan Cemerlang</h2>
        <p class="text-gray-500 leading-relaxed">
          SD Perguruan Buddhi Tangerang berdiri di bawah naungan Perkumpulan Buddhi Dharma. Kami mengintegrasikan kurikulum nasional standar tinggi dengan pendidikan etika budi pekerti yang kuat, menyiapkan siswa tidak hanya siap akademis melainkan bermental luhur, toleran, dan mandiri.
        </p>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 pt-2">
          <div class="flex gap-3">
            <div class="w-10 h-10 bg-primary/10 text-primary rounded-xl flex items-center justify-center shrink-0"><i data-lucide="check" class="w-5 h-5"></i></div>
            <div><h4 class="font-bold text-gray-900 text-sm">Kurikulum Merdeka</h4><p class="text-xs text-gray-400">Pembelajaran berbasis minat bakat dan projek riil.</p></div>
          </div>
          <div class="flex gap-3">
            <div class="w-10 h-10 bg-primary/10 text-primary rounded-xl flex items-center justify-center shrink-0"><i data-lucide="check" class="w-5 h-5"></i></div>
            <div><h4 class="font-bold text-gray-900 text-sm">Pendidikan Karakter</h4><p class="text-xs text-gray-400">Penerapan nilai toleransi dan cinta kasih.</p></div>
          </div>
          <div class="flex gap-3">
            <div class="w-10 h-10 bg-primary/10 text-primary rounded-xl flex items-center justify-center shrink-0"><i data-lucide="check" class="w-5 h-5"></i></div>
            <div><h4 class="font-bold text-gray-900 text-sm">Fasilitas Modern</h4><p class="text-xs text-gray-400">Smart Classroom, Lab Komputer, dan E-Library.</p></div>
          </div>
          <div class="flex gap-3">
            <div class="w-10 h-10 bg-primary/10 text-primary rounded-xl flex items-center justify-center shrink-0"><i data-lucide="check" class="w-5 h-5"></i></div>
            <div><h4 class="font-bold text-gray-900 text-sm">Ekstrakurikuler Kaya</h4><p class="text-xs text-gray-400">Seni, robotik, olahraga, musik, pramuka, olimpiade.</p></div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Berita / Informasi (Alpine-filtered) -->
  <section id="berita" class="py-20 bg-white" x-data="{ activeFilter: 'Semua' }">
    <div class="max-w-7xl mx-auto px-6 space-y-12">
      <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
        <div class="space-y-3">
          <span class="text-xs font-extrabold text-primary uppercase tracking-widest">Seputar Informasi</span>
          <h2 class="text-4xl font-extrabold text-gray-900 font-playfair">Berita & Kegiatan Terbaru</h2>
        </div>
        <!-- Filter Tabs -->
        <div class="flex items-center gap-1.5 bg-gray-100 p-1.5 rounded-2xl text-sm shrink-0">
          <button @click="activeFilter = 'Semua'" :class="activeFilter === 'Semua' ? 'bg-primary text-white font-bold' : 'text-gray-600 hover:bg-gray-200'" class="px-4 py-2 rounded-xl transition">Semua</button>
          <button @click="activeFilter = 'Prestasi'" :class="activeFilter === 'Prestasi' ? 'bg-primary text-white font-bold' : 'text-gray-600 hover:bg-gray-200'" class="px-4 py-2 rounded-xl transition">Prestasi</button>
          <button @click="activeFilter = 'Kegiatan'" :class="activeFilter === 'Kegiatan' ? 'bg-primary text-white font-bold' : 'text-gray-600 hover:bg-gray-200'" class="px-4 py-2 rounded-xl transition">Kegiatan</button>
          <button @click="activeFilter = 'Pengumuman'" :class="activeFilter === 'Pengumuman' ? 'bg-primary text-white font-bold' : 'text-gray-600 hover:bg-gray-200'" class="px-4 py-2 rounded-xl transition">Pengumuman</button>
        </div>
      </div>

      <!-- News grid -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach($newsFeed as $item)
          <article x-show="activeFilter === 'Semua' || activeFilter === '{{ $item['kategori'] }}'" class="group bg-white rounded-3xl overflow-hidden border border-gray-100 hover:shadow-2xl transition duration-300 flex flex-col hover-scale">
            <div class="overflow-hidden h-52 relative">
              <img src="{{ $item['thumbnail'] }}" alt="{{ $item['judul'] }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
              <span class="absolute top-4 left-4 bg-primary/95 text-white font-bold text-[10px] px-3 py-1 rounded-full uppercase tracking-wider backdrop-blur-sm">
                {{ $item['kategori'] }}
              </span>
            </div>
            <div class="p-6 flex-1 flex flex-col justify-between space-y-4">
              <div class="space-y-2">
                <h3 class="font-extrabold text-gray-900 group-hover:text-primary transition duration-300 line-clamp-2">
                  {{ $item['judul'] }}
                </h3>
                <p class="text-sm text-gray-500 line-clamp-3 leading-relaxed">
                  {{ $item['excerpt'] }}
                </p>
              </div>
              <div class="flex items-center justify-between pt-4 border-t border-gray-50">
                <span class="text-xs font-medium text-gray-400">
                  {{ Carbon\Carbon::parse($item['created_at'])->format('d M Y') }}
                </span>
                <a href="{{ route('berita.show', $item['id']) }}" class="text-xs font-bold text-primary hover:underline flex items-center gap-1">
                  Baca Selengkapnya <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                </a>
              </div>
            </div>
          </article>
        @endforeach
      </div>
    </div>
  </section>

  <!-- Fasilitas Section -->
  <section id="fasilitas" class="py-20 bg-gray-50 border-t border-gray-100">
    <div class="max-w-7xl mx-auto px-6 space-y-12">
      <div class="text-center space-y-3 max-w-xl mx-auto">
        <span class="text-xs font-extrabold text-primary uppercase tracking-widest block">Lingkungan Belajar Kondusif</span>
        <h2 class="text-4xl font-extrabold text-gray-900 font-playfair">Fasilitas Penunjang Pendidikan Lengkap</h2>
        <p class="text-gray-500">
          Kami menyediakan infrastruktur modern terstandarisasi untuk menjamin kemudahan belajar dan keamanan siswa.
        </p>
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        @foreach($facilities as $fac)
          <div class="group p-6 bg-white border border-gray-100 rounded-2xl hover:border-primary/20 hover:shadow-xl hover-scale flex flex-col justify-between h-48">
            <div class="w-12 h-12 bg-primary/10 text-primary rounded-xl flex items-center justify-center shrink-0 group-hover:bg-primary group-hover:text-white transition duration-300">
              <i data-lucide="{{ $fac['ikon'] }}" class="w-6 h-6"></i>
            </div>
            <div class="space-y-1 mt-4">
              <h4 class="font-extrabold text-gray-900 text-sm">{{ $fac['nama'] }}</h4>
              <p class="text-xs text-gray-400 leading-relaxed">{{ $fac['deskripsi'] }}</p>
            </div>
          </div>
        @endforeach
      </div>
    </div>
  </section>
@endsection
