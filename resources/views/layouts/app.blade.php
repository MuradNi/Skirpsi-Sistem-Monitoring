<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'SD Perguruan Buddhi')</title>
  
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;800;900&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  
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
            secondary: '#F7B731',
            accent: '#FFF3F2',
            neutral: {
              900: '#1A1A2E',
              950: '#0F0F1A'
            }
          },
          fontFamily: {
            playfair: ['Playfair Display', 'serif'],
            jakarta: ['Plus Jakarta Sans', 'sans-serif']
          }
        }
      }
    }
  </script>
  <script src="https://unpkg.com/lucide@latest"></script>
  <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
  
  <style>
    h1, h2, h3 { font-family: 'Playfair Display', serif; }
    body { font-family: 'Plus Jakarta Sans', sans-serif; }
    .hover-scale {
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .hover-scale:hover {
      transform: translateY(-4px) scale(1.01);
      box-shadow: 0 20px 30px -10px rgba(229, 62, 47, 0.1);
    }
  </style>
</head>
<body class="bg-gray-50 text-gray-700 antialiased flex flex-col min-h-screen">

  <nav class="sticky top-0 z-50 bg-white/90 backdrop-blur-md border-b border-gray-100 shadow-sm">
    <div class="max-w-7xl mx-auto px-6 h-20 flex items-center justify-between">
      <a href="{{ route('beranda') }}" class="flex items-center gap-3">
        <div class="w-10 h-10 bg-primary rounded-xl flex items-center justify-center text-white shadow-lg shadow-primary/30">
          <i data-lucide="graduation-cap" class="w-6 h-6"></i>
        </div>
        <div>
          <p class="font-bold text-neutral-900 text-xs leading-tight uppercase tracking-wider">SD Perguruan</p>
          <p class="font-black text-primary text-lg leading-tight tracking-wide">Buddhi</p>
        </div>
      </a>

      <ul class="hidden md:flex items-center gap-8 font-bold text-sm text-gray-600">
        <li><a href="{{ route('beranda') }}#beranda" class="hover:text-primary transition">Beranda</a></li>
        <li><a href="{{ route('beranda') }}#profil" class="hover:text-primary transition">Tentang Kami</a></li>
        <li><a href="{{ route('beranda') }}#berita" class="hover:text-primary transition">Berita</a></li>
        <li><a href="{{ route('beranda') }}#fasilitas" class="hover:text-primary transition">Fasilitas</a></li>
        <li><a href="{{ route('beranda') }}#kontak" class="hover:text-primary transition">Kontak</a></li>
      </ul>

      <div class="flex items-center gap-3">
        @auth
          <a href="{{ route('dashboard.index') }}" class="px-5 py-2.5 bg-primary text-white font-bold rounded-xl text-sm hover:bg-primary-dark transition shadow-lg shadow-primary/20 flex items-center gap-1.5">
            <i data-lucide="layout-dashboard" class="w-4 h-4"></i> Dashboard
          </a>
        @else
          <a href="{{ route('login') }}" class="px-5 py-2.5 border-2 border-primary/20 text-primary font-bold rounded-xl text-sm hover:bg-primary hover:text-white transition duration-300">Login Portal</a>
        @endauth
      </div>
    </div>
  </nav>

  <main class="flex-grow">
    @yield('content')
  </main>

  <footer id="kontak" class="bg-neutral-950 text-gray-400 py-16 border-t border-gray-900">
    <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 md:grid-cols-4 gap-12">
      <div class="space-y-4">
        <div class="flex items-center gap-3">
          <div class="w-10 h-10 bg-primary rounded-xl flex items-center justify-center text-white font-bold"><i data-lucide="graduation-cap" class="w-5.5 h-5.5"></i></div>
          <h3 class="font-extrabold text-white text-lg">SD Perguruan Buddhi</h3>
        </div>
        <p class="text-xs leading-relaxed">
          Menyelenggarakan proses pembelajaran yang inovatif, berlandaskan budi pekerti luhur dan kasih universal.
        </p>
      </div>

      <div class="space-y-4">
        <h4 class="font-bold text-white text-sm uppercase tracking-wider">Navigasi</h4>
        <ul class="space-y-2 text-xs">
          <li><a href="{{ route('beranda') }}#beranda" class="hover:text-primary transition">Beranda</a></li>
          <li><a href="{{ route('beranda') }}#profil" class="hover:text-primary transition">Tentang Kami</a></li>
          <li><a href="{{ route('beranda') }}#berita" class="hover:text-primary transition">Berita</a></li>
          <li><a href="{{ route('beranda') }}#fasilitas" class="hover:text-primary transition">Fasilitas</a></li>
        </ul>
      </div>

      <div class="space-y-4">
        <h4 class="font-bold text-white text-sm uppercase tracking-wider">Hubungi Kami</h4>
        <ul class="space-y-2 text-xs">
          <li class="flex items-center gap-2"><i data-lucide="map-pin" class="w-4 h-4 text-primary shrink-0"></i> Jl. Imam Bonjol No. 41 Karawaci, Tangerang</li>
          <li class="flex items-center gap-2"><i data-lucide="phone" class="w-4 h-4 text-primary shrink-0"></i> (021) 555-888</li>
          <li class="flex items-center gap-2"><i data-lucide="mail" class="w-4 h-4 text-primary shrink-0"></i> sd@buddhi.sch.id</li>
        </ul>
      </div>

      <div class="space-y-4">
        <h4 class="font-bold text-white text-sm uppercase tracking-wider">Afiliasi Universitas</h4>
        <div class="flex items-center gap-3">
          <div class="w-10 h-10 bg-indigo-900/40 text-indigo-400 rounded-xl flex items-center justify-center"><i data-lucide="school" class="w-5.5 h-5.5"></i></div>
          <div>
            <p class="font-bold text-xs text-white">Universitas Buddhi Dharma</p>
            <p class="text-[10px] text-gray-500 font-bold uppercase">Yayasan Pendidikan Buddhi</p>
          </div>
        </div>
      </div>
    </div>

    <div class="max-w-7xl mx-auto px-6 border-t border-gray-900 mt-12 pt-6 flex flex-col sm:flex-row items-center justify-between text-xs gap-4">
      <p>© 2026 SD Perguruan Buddhi Tangerang. Hak Cipta Dilindungi.</p>
    </div>
  </footer>

  <script>
    // Initialize Lucide icons
    lucide.createIcons();
  </script>
</body>
</html>
