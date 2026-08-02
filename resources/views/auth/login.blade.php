<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Portal — SD Perguruan Buddhi</title>
  
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
  
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            primary: {
              DEFAULT: '#E53E2F',
              dark: '#B52A1C',
              light: '#FF6B5B'
            },
            softPink: '#FAD2D2',
            cardPink: '#F5B7B1'
          },
          fontFamily: {
            jakarta: ['Plus Jakarta Sans', 'sans-serif']
          }
        }
      }
    }
  </script>
  <script src="https://unpkg.com/lucide@latest"></script>
  <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
  
  <style>
    body {
      font-family: 'Plus Jakarta Sans', sans-serif;
    }
    .custom-shadow {
      box-shadow: 0 10px 30px -5px rgba(229, 62, 47, 0.15);
    }
  </style>
</head>
<body class="min-h-screen flex flex-col bg-white text-gray-800">

  <header class="bg-[#FAD2D2] border-b border-[#F7B1B1] py-4 px-6 md:px-12 flex justify-between items-center">
    
    <a href="{{ route('beranda') }}" class="flex items-center gap-3 group">
      <img src="{{ asset('img/sd_buddhi_logo.png') }}" alt="Logo SD Buddhi" class="w-12 h-12 object-contain rounded-full shadow-sm group-hover:scale-105 transition-transform">
      <span class="font-extrabold text-xl text-primary tracking-wide">SD Buddhi</span>
    </a>

    <nav class="hidden md:flex items-center gap-8 font-bold text-sm">
      <a href="{{ route('beranda') }}#beranda" class="text-gray-700 hover:text-primary transition">Beranda</a>
      <a href="{{ route('beranda') }}#profil" class="text-gray-700 hover:text-primary transition">Tentang Kami</a>
      <a href="{{ route('beranda') }}#fasilitas" class="text-gray-700 hover:text-primary transition">Fasilitas</a>
      <a href="{{ route('beranda') }}#berita" class="text-gray-700 hover:text-primary transition">Berita</a>
    </nav>

    <div>
      <a href="{{ route('beranda') }}#kontak" class="bg-primary hover:bg-primary-dark text-white font-bold text-sm px-6 py-2.5 rounded-full transition duration-300 shadow-md shadow-primary/20">
        Contact
      </a>
    </div>
  </header>

  <main class="flex-grow flex items-center justify-center p-4 md:p-12">
    
    <div class="w-full max-w-5xl bg-[#F5B7B1] rounded-[40px] p-6 md:p-10 flex flex-col md:flex-row gap-8 items-stretch shadow-xl border border-[#F2A29C]">

      <div 
        class="w-full md:w-1/2 rounded-[32px] overflow-hidden border-2 border-white bg-white relative shadow-inner aspect-[4/3] md:aspect-auto flex items-center justify-center"
        x-data="{
          activeSlide: 0,
          slides: [
            '{{ asset('img/Sd.jpg') }}',
            '{{ asset('img/sd_slide1.png') }}',
            '{{ asset('img/sd_slide2.png') }}',
            '{{ asset('img/mpls2026.jpg') }}',
            '{{ asset('img/eventbuddhi.jpg') }}',
            '{{ asset('img/imnusisasi.jpg') }}',
            '{{ asset('img/dunailiterasi.jpg') }}',
            '{{ asset('img/sikap.jpg') }}'
          ],
          init() {
            setInterval(() => {
              this.activeSlide = (this.activeSlide + 1) % this.slides.length;
            }, 4000);
          }
        }"
      >
        
        <template x-for="(slide, index) in slides" :key="index">
          <div 
            class="absolute inset-0 transition-opacity duration-1000 ease-in-out"
            x-show="activeSlide === index"
            x-transition:enter="transition-opacity duration-1000"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition-opacity duration-1000"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
          >
            <img :src="slide" alt="Slide Gambar Sekolah" class="w-full h-full object-cover">
          </div>
        </template>

        <div class="absolute bottom-4 left-4 right-4 bg-black/40 backdrop-blur-sm px-4 py-2.5 rounded-2xl text-white text-xs text-center border border-white/10 z-10">
          📍 Gedung & Fasilitas Pembelajaran SD Buddhi Tangerang
        </div>

        <div class="absolute bottom-16 left-1/2 -translate-x-1/2 flex gap-2 z-10">
          <template x-for="(slide, index) in slides" :key="index">
            <button 
              @click="activeSlide = index" 
              class="w-2.5 h-2.5 rounded-full transition-all duration-300"
              :class="activeSlide === index ? 'bg-primary scale-125 w-6' : 'bg-white/60 hover:bg-white'"
            ></button>
          </template>
        </div>
      </div>

      <div class="w-full md:w-1/2 bg-white rounded-[32px] p-6 md:p-10 flex flex-col justify-between shadow-lg relative" x-data="{ showDemo: false }">

        <div class="mb-6">
          <h2 class="text-3xl font-black text-gray-900 tracking-tight leading-none">Form Login</h2>
          <p class="text-gray-500 font-semibold text-sm mt-2">Silahkan Login</p>
        </div>

        @if ($errors->any())
          <div class="bg-red-50 border border-red-200 text-red-700 rounded-2xl p-3 text-xs font-semibold flex items-center gap-2 mb-4">
            <i data-lucide="alert-circle" class="w-4 h-4 shrink-0 text-red-600"></i>
            <span>{{ $errors->first() }}</span>
          </div>
        @endif

        <form action="{{ url('/login') }}" method="POST" class="space-y-5 flex-grow flex flex-col justify-center">
          @csrf

          <div>
            <label class="block text-xs font-bold text-gray-600 mb-1.5 uppercase tracking-wider ml-1">Username (Email)</label>
            <input 
              type="email" 
              name="email" 
              required 
              value="{{ old('email') }}" 
              placeholder="Username" 
              class="w-full px-5 py-3 border border-gray-300 rounded-full text-gray-800 text-sm focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition"
            >
          </div>

          <div>
            <label class="block text-xs font-bold text-gray-600 mb-1.5 uppercase tracking-wider ml-1">Password</label>
            <input 
              type="password" 
              name="password" 
              required 
              placeholder="Password" 
              class="w-full px-5 py-3 border border-gray-300 rounded-full text-gray-800 text-sm focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition"
            >
          </div>

          <button 
            type="submit" 
            class="w-full py-3 bg-[#FF0000] hover:bg-primary-dark text-white font-extrabold text-base rounded-full shadow-lg shadow-red-600/20 active:scale-95 transition-all duration-200 mt-2"
          >
            Login
          </button>
        </form>

        <div class="mt-6 border-t border-gray-100 pt-4">
          <button 
            @click="showDemo = !showDemo" 
            type="button" 
            class="w-full text-center text-xs font-bold text-gray-400 hover:text-primary flex items-center justify-center gap-1 transition"
          >
            <i data-lucide="help-circle" class="w-3.5 h-3.5"></i>
            <span>Tampilkan Akun Demo (Bantuan)</span>
            <i data-lucide="chevron-down" class="w-3.5 h-3.5 transition-transform" :class="showDemo ? 'rotate-180' : ''"></i>
          </button>

          <div 
            x-show="showDemo" 
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
            class="mt-3 bg-red-50/50 border border-red-100 rounded-2xl p-4 text-[11px] text-gray-600 space-y-2 leading-relaxed"
          >
            <p class="font-extrabold text-primary uppercase tracking-wide">💡 Demo Login (Password: password):</p>
            <ul class="space-y-1 font-mono">
              <li>• Admin: <span class="text-gray-900 font-semibold">admin@buddhi.sch.id</span></li>
              <li>• Guru: <span class="text-gray-900 font-semibold">guru1@buddhi.sch.id</span></li>
              <li>• Wali Kelas: <span class="text-gray-900 font-semibold">wali6a@buddhi.sch.id</span></li>
              <li>• Orang Tua / Siswa: <span class="text-gray-900 font-semibold">orangtua@buddhi.sch.id</span></li>
            </ul>
          </div>
        </div>

      </div>
    </div>
  </main>

  <footer class="bg-[#FAD2D2] border-t border-[#F7B1B1] py-6 px-6 md:px-12 flex flex-col md:flex-row items-center gap-6">
    
    <div class="flex items-center gap-4 shrink-0">
      <img src="{{ asset('img/ubd_logo.png') }}" alt="Logo Universitas Buddhi Dharma" class="w-16 h-16 object-contain rounded-full shadow-sm">
    </div>

    <div class="flex-grow text-center md:text-left space-y-1.5">
      <h3 class="font-extrabold text-lg text-primary tracking-wide leading-none uppercase">UNIVERSITAS BUDDHI DHARMA</h3>

      <div class="flex flex-col md:flex-row flex-wrap items-center gap-y-1 gap-x-6 text-xs text-gray-700 font-medium">
        <span class="flex items-center gap-1.5">
          <i data-lucide="map-pin" class="w-3.5 h-3.5 text-primary"></i>
          <span>Jl. Imam Bonjol No. 41 Karawaci Ilir, Tangerang</span>
        </span>
        <span class="flex items-center gap-1.5">
          <i data-lucide="phone" class="w-3.5 h-3.5 text-primary"></i>
          <span>021 5517853 / 021 5586822</span>
        </span>
        <span class="flex items-center gap-1.5">
          <i data-lucide="mail" class="w-3.5 h-3.5 text-primary"></i>
          <span>admin@buddhidharma.ac.id</span>
        </span>
      </div>
    </div>
  </footer>

  <script>
    // Initialize Lucide icons
    lucide.createIcons();
  </script>
</body>
</html>
