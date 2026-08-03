<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'Dashboard — SD Perguruan Buddhi')</title>
  
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  
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
            accent: '#FFF3F2'
          },
          fontFamily: {
            jakarta: ['Plus Jakarta Sans', 'sans-serif']
          }
        }
      }
    }
  </script>
  
  <script src="https://unpkg.com/lucide@latest"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

  <style>
    body { font-family: 'Plus Jakarta Sans', sans-serif; }
    /* Scrollbars */
    ::-webkit-scrollbar { width: 6px; height: 6px; }
    ::-webkit-scrollbar-track { background: #f3f4f6; }
    ::-webkit-scrollbar-thumb { background: #d1d5db; border-radius: 3px; }
    ::-webkit-scrollbar-thumb:hover { background: #9ca3af; }
    
    @media print {
      .no-print { display: none !important; }
      .print-container {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
        margin: 0;
        padding: 0;
        box-shadow: none !important;
        border: none !important;
      }
    }
  </style>
</head>
<body class="bg-gray-100 text-gray-800 antialiased flex h-screen overflow-hidden">

  <aside class="no-print w-64 bg-gray-900 border-r border-gray-800 flex flex-col shrink-0">
    
    <div class="h-20 flex items-center gap-3 px-6 border-b border-gray-800">
      <a href="{{ route('beranda') }}" class="w-9 h-9 bg-primary text-white rounded-lg flex items-center justify-center">
        <i data-lucide="graduation-cap" class="w-5 h-5"></i>
      </a>
      <div>
        <h3 class="font-extrabold text-white text-sm leading-tight uppercase">SD Buddhi</h3>
        <p class="text-[10px] text-gray-500 font-bold uppercase tracking-wider">
          Role: {{ str_replace('_', ' ', auth()->user()->role) }}
        </p>
      </div>
    </div>

    <nav class="flex-grow px-4 py-6 space-y-1.5 overflow-y-auto">

      @if (in_array(auth()->user()->role, ['admin', 'guru', 'wali_kelas']))
        <a href="{{ route('dashboard.index') }}" 
           class="flex items-center gap-3.5 px-4 py-3 rounded-xl text-sm transition font-bold 
                  {{ request()->routeIs('dashboard.index') ? 'bg-primary text-white shadow-lg shadow-primary/30' : 'text-gray-400 hover:text-white hover:bg-gray-800' }}">
          <i data-lucide="layout-dashboard" class="w-5 h-5"></i>
          <span>Dashboard</span>
        </a>
      @endif

      @if (auth()->user()->role === 'admin')
        <a href="{{ route('dashboard.siswa.index') }}" 
           class="flex items-center gap-3.5 px-4 py-3 rounded-xl text-sm transition font-bold 
                  {{ request()->routeIs('dashboard.siswa.*') ? 'bg-primary text-white shadow-lg shadow-primary/30' : 'text-gray-400 hover:text-white hover:bg-gray-800' }}">
          <i data-lucide="users" class="w-5 h-5"></i>
          <span>Data Siswa</span>
        </a>
      @endif

      @if (auth()->user()->role === 'guru')
        <a href="{{ route('dashboard.nilai.index') }}" 
           class="flex items-center gap-3.5 px-4 py-3 rounded-xl text-sm transition font-bold 
                  {{ request()->routeIs('dashboard.nilai.*') ? 'bg-primary text-white shadow-lg shadow-primary/30' : 'text-gray-400 hover:text-white hover:bg-gray-800' }}">
          <i data-lucide="edit-3" class="w-5 h-5"></i>
          <span>Input Nilai Siswa</span>
        </a>
      @endif

      @if (auth()->user()->role === 'siswa')
        @php
          $match = \App\Models\Siswa::where('user_id', auth()->id())->first();
        @endphp
        @if ($match)
          <a href="{{ route('dashboard.raport.show', $match->id) }}" 
             class="flex items-center gap-3.5 px-4 py-3 rounded-xl text-sm transition font-bold 
                    {{ request()->routeIs('dashboard.raport.*') ? 'bg-primary text-white shadow-lg shadow-primary/30' : 'text-gray-400 hover:text-white hover:bg-gray-800' }}">
            <i data-lucide="file-text" class="w-5 h-5"></i>
            <span>Raport Saya</span>
          </a>
        @endif
      @elseif (auth()->user()->role === 'orang_tua')
        @php
          $match = \App\Models\Siswa::where('parent_user_id', auth()->id())->first();
        @endphp
        @if ($match)
          <a href="{{ route('dashboard.raport.show', $match->id) }}" 
             class="flex items-center gap-3.5 px-4 py-3 rounded-xl text-sm transition font-bold 
                    {{ request()->routeIs('dashboard.raport.*') ? 'bg-primary text-white shadow-lg shadow-primary/30' : 'text-gray-400 hover:text-white hover:bg-gray-800' }}">
            <i data-lucide="file-text" class="w-5 h-5"></i>
            <span>Raport Anak</span>
          </a>
        @endif
      @elseif (in_array(auth()->user()->role, ['admin', 'guru']))
        @php
          if (auth()->user()->role === 'guru') {
            $guruKelas = \App\Models\Kelas::where('wali_kelas_id', auth()->id())->first();
            $firstSiswa = $guruKelas ? \App\Models\Siswa::where('kelas_id', $guruKelas->id)->first() : \App\Models\Siswa::first();
          } else {
            $firstSiswa = \App\Models\Siswa::first();
          }
        @endphp
        @if ($firstSiswa)
          <a href="{{ route('dashboard.raport.show', $firstSiswa->id) }}" 
             class="flex items-center gap-3.5 px-4 py-3 rounded-xl text-sm transition font-bold 
                    {{ request()->routeIs('dashboard.raport.*') ? 'bg-primary text-white shadow-lg shadow-primary/30' : 'text-gray-400 hover:text-white hover:bg-gray-800' }}">
            <i data-lucide="file-text" class="w-5 h-5"></i>
            <span>Raport Digital</span>
          </a>
        @endif
      @endif

    </nav>

    <div class="p-4 border-t border-gray-800 bg-gray-950/60 flex items-center justify-between">
      <div class="flex items-center gap-3">
        <div class="min-w-0">
          <p class="text-xs font-extrabold text-white truncate w-32">{{ auth()->user()->nama }}</p>
          <p class="text-[10px] text-gray-500 font-bold uppercase capitalize">{{ auth()->user()->role }}</p>
        </div>
      </div>
      <form action="{{ route('logout') }}" method="POST" class="inline">
        @csrf
        <button type="submit" class="text-gray-500 hover:text-red-400 transition" title="Logout">
          <i data-lucide="log-out" class="w-4 h-4"></i>
        </button>
      </form>
    </div>
  </aside>

  <div class="flex-grow flex flex-col overflow-hidden">

    <header class="no-print h-20 bg-white border-b border-gray-200 flex items-center justify-between px-8 shadow-sm z-10 shrink-0">
      <h1 class="text-xl font-black text-gray-900">@yield('page_title', 'Dashboard')</h1>
      
      <div class="flex items-center gap-6">
        <span class="text-xs text-gray-400 font-bold uppercase tracking-wider hidden sm:inline-block">
          Tahun Ajaran: <span class="text-gray-800">2024/2025 (Genap)</span>
        </span>
        
        <button class="relative w-10 h-10 rounded-xl bg-gray-50 border border-gray-100 flex items-center justify-center hover:bg-gray-100 transition">
          <i data-lucide="bell" class="w-5 h-5 text-gray-500"></i>
          <span class="absolute top-2 right-2 w-2 h-2 bg-primary rounded-full"></span>
        </button>
        
        <div class="flex items-center gap-2">
          <span class="text-xs font-bold text-gray-800 hidden md:inline-block">{{ auth()->user()->nama }}</span>
        </div>
      </div>
    </header>

    <main class="flex-grow overflow-y-auto p-8">
      @if (session('success'))
        <div class="no-print bg-emerald-500/15 border border-emerald-500/30 rounded-2xl p-4 mb-6 text-emerald-600 font-bold text-sm flex items-center gap-2.5">
          <i data-lucide="check-circle" class="w-5 h-5 shrink-0"></i>
          <span>{{ session('success') }}</span>
        </div>
      @endif

      @yield('dashboard_content')
    </main>

  </div>

  <script>
    lucide.createIcons();
  </script>
</body>
</html>
