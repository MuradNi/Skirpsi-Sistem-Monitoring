@extends('layouts.dashboard')

@section('title', 'Input Nilai — SD Perguruan Buddhi')
@section('page_title', 'Portal Penginputan Nilai Siswa')

@section('dashboard_content')
<div class="space-y-6" x-data="{ 
  siswas: {{ json_encode($inputGrades) }}, 
  kkm: {{ $selectedMapel->kkm }},
  isOpen: false,
  activeSiswa: { id: null, nama_lengkap: '', nis: '', nilai_uh1: null, nilai_uts: null, nilai_uh2: null, nilai_uas: null, keterangan: '', uh1_scores: [], uh2_scores: [] },
  openModal(siswa) {
    this.activeSiswa = JSON.parse(JSON.stringify(siswa));
    this.activeSiswa.uh1_scores.forEach(s => { s.isEditing = false; s.tempNilai = s.nilai; s.tempKeterangan = s.keterangan; });
    this.activeSiswa.uh2_scores.forEach(s => { s.isEditing = false; s.tempNilai = s.nilai; s.tempKeterangan = s.keterangan; });
    this.isOpen = true;
  },
  init() {
    @if(request()->has('open_siswa_id'))
      const openId = {{ request()->input('open_siswa_id') }};
      const found = this.siswas.find(s => s.id === openId);
      if (found) {
        this.openModal(found);
      }
    @endif
  }
}">
  
  <div class="bg-white border border-gray-100 rounded-3xl overflow-hidden shadow-sm">

    <div class="p-6 border-b border-gray-100 bg-gray-50/50 flex flex-wrap gap-4 items-center justify-between">
      <div class="flex flex-wrap gap-4 items-center">
        
        <form action="{{ route('dashboard.nilai.index') }}" method="GET" class="flex flex-wrap gap-4 items-center">
          <div class="flex items-center gap-2">
            <span class="text-xs font-bold text-gray-400 uppercase">Kelas:</span>
            <select name="kelas_id" onchange="this.form.submit()" class="text-xs font-bold border border-gray-200 rounded-xl px-4 py-2 text-gray-700 bg-white focus:border-primary outline-none">
              @foreach($kelasList as $kelas)
                <option value="{{ $kelas->id }}" {{ $kelasId == $kelas->id ? 'selected' : '' }}>Kelas {{ $kelas->nama }}</option>
              @endforeach
            </select>
          </div>
          
          <div class="flex items-center gap-2">
            <span class="text-xs font-bold text-gray-400 uppercase">Mata Pelajaran:</span>
            <select name="mata_pelajaran_id" onchange="this.form.submit()" class="text-xs font-bold border border-gray-200 rounded-xl px-4 py-2 text-gray-700 bg-white focus:border-primary outline-none">
              @foreach($mapelList as $mapel)
                <option value="{{ $mapel->id }}" {{ $mapelId == $mapel->id ? 'selected' : '' }}>{{ $mapel->nama }}</option>
              @endforeach
            </select>
          </div>
        </form>

      </div>
    </div>

    <div class="overflow-x-auto">
      <table class="w-full text-left text-sm whitespace-nowrap">
        <thead class="bg-gray-50 border-b border-gray-100 text-gray-400 font-bold text-xs uppercase tracking-wider">
          <tr>
            <th class="px-6 py-4 w-16 text-center">No</th>
            <th class="px-6 py-4 w-28">NIS</th>
            <th class="px-6 py-4">Nama Lengkap</th>
            <th class="px-6 py-4 w-24 text-center">UH 1</th>
            <th class="px-6 py-4 w-24 text-center">UTS</th>
            <th class="px-6 py-4 w-24 text-center">UH 2</th>
            <th class="px-6 py-4 w-24 text-center">UAS</th>
            <th class="px-6 py-4 w-24 text-center">Rata-rata</th>
            <th class="px-6 py-4 w-24 text-center">Batas KKM</th>
            <th class="px-6 py-4 w-24 text-center">Status</th>
            <th class="px-6 py-4">Catatan Keterangan</th>
            <th class="px-6 py-4 text-right">Aksi</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-100 font-medium">
          
          @forelse($inputGrades as $idx => $siswa)
            <tr class="hover:bg-gray-50 transition duration-150">
              <td class="px-6 py-4 text-center font-bold text-gray-400">{{ $idx + 1 }}</td>
              <td class="px-6 py-4 font-mono text-xs text-gray-400">{{ $siswa['nis'] }}</td>
              <td class="px-6 py-4 font-bold text-gray-900">{{ $siswa['nama_lengkap'] }}</td>
              
              <td class="px-6 py-4 text-center">
                <span class="{{ ($siswa['nilai_uh1'] !== null && $siswa['nilai_uh1'] >= $selectedMapel->kkm) ? 'text-emerald-600 font-extrabold' : ($siswa['nilai_uh1'] !== null ? 'text-red-500 font-extrabold' : 'text-gray-300') }}">
                  {{ $siswa['nilai_uh1'] !== null ? round($siswa['nilai_uh1']) : '-' }}
                </span>
              </td>
              
              <td class="px-6 py-4 text-center">
                <span class="{{ ($siswa['nilai_uts'] !== null && $siswa['nilai_uts'] >= $selectedMapel->kkm) ? 'text-emerald-600 font-extrabold' : ($siswa['nilai_uts'] !== null ? 'text-red-500 font-extrabold' : 'text-gray-300') }}">
                  {{ $siswa['nilai_uts'] !== null ? round($siswa['nilai_uts']) : '-' }}
                </span>
              </td>
              
              <td class="px-6 py-4 text-center">
                <span class="{{ ($siswa['nilai_uh2'] !== null && $siswa['nilai_uh2'] >= $selectedMapel->kkm) ? 'text-emerald-600 font-extrabold' : ($siswa['nilai_uh2'] !== null ? 'text-red-500 font-extrabold' : 'text-gray-300') }}">
                  {{ $siswa['nilai_uh2'] !== null ? round($siswa['nilai_uh2']) : '-' }}
                </span>
              </td>
              
              <td class="px-6 py-4 text-center">
                <span class="{{ ($siswa['nilai_uas'] !== null && $siswa['nilai_uas'] >= $selectedMapel->kkm) ? 'text-emerald-600 font-extrabold' : ($siswa['nilai_uas'] !== null ? 'text-red-500 font-extrabold' : 'text-gray-300') }}">
                  {{ $siswa['nilai_uas'] !== null ? round($siswa['nilai_uas']) : '-' }}
                </span>
              </td>
              
              <td class="px-6 py-4 text-center font-extrabold text-sm font-mono text-gray-800">
                @if($siswa['nilai_uh1'] !== null || $siswa['nilai_uts'] !== null || $siswa['nilai_uh2'] !== null || $siswa['nilai_uas'] !== null)
                  {{ round(($siswa['nilai_uh1'] * 0.2) + ($siswa['nilai_uts'] * 0.3) + ($siswa['nilai_uh2'] * 0.2) + ($siswa['nilai_uas'] * 0.3), 1) }}
                @else
                  -
                @endif
              </td>
              
              <td class="px-6 py-4 text-center font-extrabold text-gray-400">{{ $selectedMapel->kkm }}</td>
              
              <td class="px-6 py-4 text-center">
                @if($siswa['nilai_uh1'] !== null || $siswa['nilai_uts'] !== null || $siswa['nilai_uh2'] !== null || $siswa['nilai_uas'] !== null)
                  @php
                    $nilaiAkhir = ($siswa['nilai_uh1'] * 0.2) + ($siswa['nilai_uts'] * 0.3) + ($siswa['nilai_uh2'] * 0.2) + ($siswa['nilai_uas'] * 0.3);
                    $tuntas = $nilaiAkhir >= $selectedMapel->kkm;
                  @endphp
                  <span class="px-2.5 py-1 rounded-full text-[10px] font-bold whitespace-nowrap {{ $tuntas ? 'bg-emerald-100 text-emerald-700' : 'bg-red-100 text-red-600' }}">
                    {{ $tuntas ? '✓ Tuntas' : '✗ Belum' }}
                  </span>
                @else
                  <span class="px-2.5 py-1 rounded-full text-[10px] font-bold whitespace-nowrap bg-gray-100 text-gray-400">
                    Belum Ada
                  </span>
                @endif
              </td>
              
              <td class="px-6 py-4 text-xs text-gray-500 max-w-[150px] truncate" title="{{ $siswa['keterangan'] }}">
                {{ $siswa['keterangan'] ?: '-' }}
              </td>
              
              <td class="px-6 py-4 text-right">
                <button type="button" @click="openModal(siswas[{{ $idx }}])" class="inline-flex items-center gap-1 px-3.5 py-1.5 bg-primary/10 hover:bg-primary text-primary hover:text-white rounded-xl text-xs font-bold transition">
                  <i data-lucide="edit" class="w-3.5 h-3.5"></i>
                  <span>Input / Edit</span>
                </button>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="12" class="px-6 py-12 text-center text-gray-400 font-bold bg-gray-50/20">Tidak ada data siswa ditemukan di kelas ini.</td>
            </tr>
          @endforelse
          
        </tbody>
      </table>
    </div>

  </div>

  <!-- Modal Background Backdrop -->
  <div 
    x-show="isOpen" 
    class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm"
    x-transition:enter="transition ease-out duration-200"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-150"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    style="display: none;"
  >
    <!-- Modal Card -->
    <div 
      class="w-full max-w-xl bg-white rounded-[32px] overflow-hidden shadow-2xl border border-gray-100 p-8 space-y-6 max-h-[90vh] overflow-y-auto"
      @click.away="isOpen = false"
      x-transition:enter="transition ease-out duration-300 transform"
      x-transition:enter-start="opacity-0 scale-95 translate-y-4"
      x-transition:enter-end="opacity-100 scale-100 translate-y-0"
      x-transition:leave="transition ease-in duration-200 transform"
      x-transition:leave-start="opacity-100 scale-100 translate-y-0"
      x-transition:leave-end="opacity-0 scale-95 translate-y-4"
    >
      <div class="flex items-center justify-between">
        <div>
          <h3 class="font-extrabold text-gray-900 text-lg">Input / Edit Nilai Siswa</h3>
          <p class="text-xs text-gray-400">Masukkan nilai komponen evaluasi akademik.</p>
        </div>
        <button type="button" @click="isOpen = false" class="p-2 text-gray-400 hover:text-gray-600 rounded-xl hover:bg-gray-100 transition">
          <i data-lucide="x" class="w-5 h-5"></i>
        </button>
      </div>

      <div class="bg-gray-50 p-4 rounded-2xl flex items-center gap-3">
        <div class="w-10 h-10 bg-primary/10 text-primary rounded-xl flex items-center justify-center font-black text-sm uppercase">
          <span x-text="activeSiswa.nama_lengkap.substring(0,2)"></span>
        </div>
        <div>
          <h4 class="font-extrabold text-sm text-gray-900" x-text="activeSiswa.nama_lengkap"></h4>
          <p class="text-[10px] text-gray-400 font-mono font-bold" x-text="'NIS: ' + activeSiswa.nis"></p>
        </div>
      </div>

      <!-- Success Notification inside Modal -->
      @if (session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 p-4 rounded-2xl text-xs font-bold flex items-center gap-2">
          <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-emerald-600 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
          <span>{{ session('success') }}</span>
        </div>
      @endif

      <!-- SECTION 1: ULANGAN HARIAN 1 (UH 1) -->
      <div class="space-y-3 border-t border-gray-100 pt-4">
        <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider">Komponen Nilai UH 1 (Sebelum UTS)</label>
        
        <!-- List of UH1 scores -->
        <div class="space-y-2 max-h-36 overflow-y-auto pr-1">
          <template x-for="(score, idx) in activeSiswa.uh1_scores" :key="score.id">
            <div>
              <!-- Read-only mode -->
              <template x-if="!score.isEditing">
                <div class="flex items-center justify-between bg-gray-50 p-2.5 rounded-xl border border-gray-100 text-xs">
                  <div class="flex items-center gap-2">
                    <span class="w-7 text-center font-extrabold text-xs px-1.5 py-0.5 rounded bg-primary/10 text-primary" x-text="Math.round(score.nilai)"></span>
                    <span class="text-gray-700 font-bold max-w-[150px] truncate" x-text="score.keterangan || 'Nilai UH 1'"></span>
                    <span class="text-[10px] text-gray-400 font-mono" x-text="'(' + score.tanggal + ')'"></span>
                  </div>
                  <div class="flex items-center gap-1 shrink-0">
                    <!-- Edit Button -->
                    <button type="button" @click="score.isEditing = true" class="text-gray-400 hover:text-primary p-1 hover:bg-gray-100 rounded-lg transition" title="Ubah Nilai">
                      <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/><path d="m15 5 4 4"/></svg>
                    </button>
                    <!-- Delete Form -->
                    <form :action="'/dashboard/nilai/delete-uh/' + score.id" method="POST" class="inline">
                      @csrf
                      <input type="hidden" name="siswa_id" :value="activeSiswa.id">
                      <input type="hidden" name="kelas_id" value="{{ $kelasId }}">
                      <input type="hidden" name="mata_pelajaran_id" value="{{ $mapelId }}">
                      <button type="submit" class="text-gray-400 hover:text-red-500 p-1 hover:bg-red-50 rounded-lg transition" title="Hapus Nilai">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/></svg>
                      </button>
                    </form>
                  </div>
                </div>
              </template>

              <!-- Inline Edit form -->
              <template x-if="score.isEditing">
                <form :action="'/dashboard/nilai/update-uh/' + score.id" method="POST" class="bg-primary/5 p-2.5 rounded-xl border border-primary/20 flex items-center gap-2 text-xs">
                  @csrf
                  <input type="hidden" name="siswa_id" :value="activeSiswa.id">
                  <input type="hidden" name="kelas_id" value="{{ $kelasId }}">
                  <input type="hidden" name="mata_pelajaran_id" value="{{ $mapelId }}">
                  
                  <div class="w-14 shrink-0">
                    <input type="number" min="0" max="100" name="nilai" x-model="score.tempNilai" required class="w-full px-2 py-1 border border-gray-200 rounded-md text-xs font-bold outline-none focus:border-primary">
                  </div>
                  <div class="flex-grow">
                    <input type="text" name="keterangan" x-model="score.tempKeterangan" placeholder="Keterangan" class="w-full px-2 py-1 border border-gray-200 rounded-md text-xs outline-none focus:border-primary">
                  </div>
                  <div class="flex items-center gap-1 shrink-0">
                    <button type="submit" class="text-emerald-600 hover:text-emerald-800 p-1 hover:bg-emerald-50 rounded-lg transition" title="Simpan Perubahan">
                      <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                    </button>
                    <button type="button" @click="score.isEditing = false" class="text-gray-400 hover:text-gray-600 p-1 hover:bg-gray-100 rounded-lg transition" title="Batal">
                      <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                    </button>
                  </div>
                </form>
              </template>
            </div>
          </template>
          <template x-if="activeSiswa.uh1_scores.length === 0">
            <p class="text-[11px] text-gray-400 italic bg-gray-50/50 p-2 rounded-xl text-center">Belum ada nilai harian UH 1.</p>
          </template>
        </div>

        <!-- Add UH1 form -->
        <form action="{{ route('dashboard.nilai.add-uh') }}" method="POST" class="bg-gray-50/50 border border-gray-100 p-3.5 rounded-2xl space-y-2">
          @csrf
          <input type="hidden" name="siswa_id" :value="activeSiswa.id">
          <input type="hidden" name="kelas_id" value="{{ $kelasId }}">
          <input type="hidden" name="mata_pelajaran_id" value="{{ $mapelId }}">
          <input type="hidden" name="jenis" value="uh1">
          
          <div class="flex gap-2">
            <div class="w-16 shrink-0">
              <input type="number" min="0" max="100" name="nilai" placeholder="Nilai" required class="w-full px-2.5 py-1.5 border border-gray-200 rounded-lg text-xs font-bold outline-none focus:border-primary">
            </div>
            <div class="flex-grow">
              <input type="text" name="keterangan" placeholder="Keterangan (e.g. Bab 1)" class="w-full px-2.5 py-1.5 border border-gray-200 rounded-lg text-xs outline-none focus:border-primary">
            </div>
            <div class="w-28 shrink-0">
              <input type="date" name="tanggal" value="{{ date('Y-m-d') }}" required class="w-full px-2 py-1.5 border border-gray-200 rounded-lg text-[10px] font-bold outline-none focus:border-primary">
            </div>
            <button type="submit" class="px-3 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg text-xs font-bold transition flex items-center gap-1 shrink-0">
              <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
              <span>Tambah</span>
            </button>
          </div>
        </form>
      </div>

      <!-- SECTION 2: ULANGAN HARIAN 2 (UH 2) -->
      <div class="space-y-3 border-t border-gray-100 pt-4">
        <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider">Komponen Nilai UH 2 (Sebelum UAS)</label>
        
        <!-- List of UH2 scores -->
        <div class="space-y-2 max-h-36 overflow-y-auto pr-1">
          <template x-for="(score, idx) in activeSiswa.uh2_scores" :key="score.id">
            <div>
              <!-- Read-only mode -->
              <template x-if="!score.isEditing">
                <div class="flex items-center justify-between bg-gray-50 p-2.5 rounded-xl border border-gray-100 text-xs">
                  <div class="flex items-center gap-2">
                    <span class="w-7 text-center font-extrabold text-xs px-1.5 py-0.5 rounded bg-primary/10 text-primary" x-text="Math.round(score.nilai)"></span>
                    <span class="text-gray-700 font-bold max-w-[150px] truncate" x-text="score.keterangan || 'Nilai UH 2'"></span>
                    <span class="text-[10px] text-gray-400 font-mono" x-text="'(' + score.tanggal + ')'"></span>
                  </div>
                  <div class="flex items-center gap-1 shrink-0">
                    <!-- Edit Button -->
                    <button type="button" @click="score.isEditing = true" class="text-gray-400 hover:text-primary p-1 hover:bg-gray-100 rounded-lg transition" title="Ubah Nilai">
                      <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/><path d="m15 5 4 4"/></svg>
                    </button>
                    <!-- Delete Form -->
                    <form :action="'/dashboard/nilai/delete-uh/' + score.id" method="POST" class="inline">
                      @csrf
                      <input type="hidden" name="siswa_id" :value="activeSiswa.id">
                      <input type="hidden" name="kelas_id" value="{{ $kelasId }}">
                      <input type="hidden" name="mata_pelajaran_id" value="{{ $mapelId }}">
                      <button type="submit" class="text-gray-400 hover:text-red-500 p-1 hover:bg-red-50 rounded-lg transition" title="Hapus Nilai">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/></svg>
                      </button>
                    </form>
                  </div>
                </div>
              </template>

              <!-- Inline Edit form -->
              <template x-if="score.isEditing">
                <form :action="'/dashboard/nilai/update-uh/' + score.id" method="POST" class="bg-primary/5 p-2.5 rounded-xl border border-primary/20 flex items-center gap-2 text-xs">
                  @csrf
                  <input type="hidden" name="siswa_id" :value="activeSiswa.id">
                  <input type="hidden" name="kelas_id" value="{{ $kelasId }}">
                  <input type="hidden" name="mata_pelajaran_id" value="{{ $mapelId }}">
                  
                  <div class="w-14 shrink-0">
                    <input type="number" min="0" max="100" name="nilai" x-model="score.tempNilai" required class="w-full px-2 py-1 border border-gray-200 rounded-md text-xs font-bold outline-none focus:border-primary">
                  </div>
                  <div class="flex-grow">
                    <input type="text" name="keterangan" x-model="score.tempKeterangan" placeholder="Keterangan" class="w-full px-2 py-1 border border-gray-200 rounded-md text-xs outline-none focus:border-primary">
                  </div>
                  <div class="flex items-center gap-1 shrink-0">
                    <button type="submit" class="text-emerald-600 hover:text-emerald-800 p-1 hover:bg-emerald-50 rounded-lg transition" title="Simpan Perubahan">
                      <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                    </button>
                    <button type="button" @click="score.isEditing = false" class="text-gray-400 hover:text-gray-600 p-1 hover:bg-gray-100 rounded-lg transition" title="Batal">
                      <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                    </button>
                  </div>
                </form>
              </template>
            </div>
          </template>
          <template x-if="activeSiswa.uh2_scores.length === 0">
            <p class="text-[11px] text-gray-400 italic bg-gray-50/50 p-2 rounded-xl text-center">Belum ada nilai harian UH 2.</p>
          </template>
        </div>

        <!-- Add UH2 form -->
        <form action="{{ route('dashboard.nilai.add-uh') }}" method="POST" class="bg-gray-50/50 border border-gray-100 p-3.5 rounded-2xl space-y-2">
          @csrf
          <input type="hidden" name="siswa_id" :value="activeSiswa.id">
          <input type="hidden" name="kelas_id" value="{{ $kelasId }}">
          <input type="hidden" name="mata_pelajaran_id" value="{{ $mapelId }}">
          <input type="hidden" name="jenis" value="uh2">
          
          <div class="flex gap-2">
            <div class="w-16 shrink-0">
              <input type="number" min="0" max="100" name="nilai" placeholder="Nilai" required class="w-full px-2.5 py-1.5 border border-gray-200 rounded-lg text-xs font-bold outline-none focus:border-primary">
            </div>
            <div class="flex-grow">
              <input type="text" name="keterangan" placeholder="Keterangan (e.g. Bab 1)" class="w-full px-2.5 py-1.5 border border-gray-200 rounded-lg text-xs outline-none focus:border-primary">
            </div>
            <div class="w-28 shrink-0">
              <input type="date" name="tanggal" value="{{ date('Y-m-d') }}" required class="w-full px-2 py-1.5 border border-gray-200 rounded-lg text-[10px] font-bold outline-none focus:border-primary">
            </div>
            <button type="submit" class="px-3 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg text-xs font-bold transition flex items-center gap-1 shrink-0">
              <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
              <span>Tambah</span>
            </button>
          </div>
        </form>
      </div>

      <!-- SECTION 3: UTS & UAS & CATATAN -->
      <form action="{{ route('dashboard.nilai.store') }}" method="POST" class="space-y-5 border-t border-gray-100 pt-4">
        @csrf
        <input type="hidden" name="siswa_id" :value="activeSiswa.id">
        <input type="hidden" name="kelas_id" value="{{ $kelasId }}">
        <input type="hidden" name="mata_pelajaran_id" value="{{ $mapelId }}">

        <div class="grid grid-cols-2 gap-4">
          <div>
            <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-1.5">Nilai UTS</label>
            <input type="number" min="0" max="100" name="nilai_uts" x-model="activeSiswa.nilai_uts" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm font-bold outline-none focus:border-primary">
          </div>
          <div>
            <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-1.5">Nilai UAS</label>
            <input type="number" min="0" max="100" name="nilai_uas" x-model="activeSiswa.nilai_uas" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm font-bold outline-none focus:border-primary">
          </div>
        </div>

        <div>
          <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-1.5">Catatan Keterangan Guru</label>
          <textarea name="keterangan" x-model="activeSiswa.keterangan" rows="2" placeholder="Catatan perkembangan belajar siswa..." class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm outline-none focus:border-primary resize-none"></textarea>
        </div>

        <div class="bg-gray-50 p-4 rounded-2xl flex items-center justify-between text-xs font-bold border border-gray-100/60">
          <div>
            <p class="text-gray-400 text-[10px] uppercase">Rata-rata Nilai Akhir</p>
            <p class="text-lg font-black text-gray-900 font-mono mt-0.5" x-text="Math.round(((Number(activeSiswa.nilai_uh1 || 0)*0.2) + (Number(activeSiswa.nilai_uts || 0)*0.3) + (Number(activeSiswa.nilai_uh2 || 0)*0.2) + (Number(activeSiswa.nilai_uas || 0)*0.3)) * 10) / 10"></p>
          </div>
          <div class="text-right">
            <p class="text-gray-400 text-[10px] uppercase">Status KKM (Batas: <span x-text="kkm"></span>)</p>
            <span 
              :class="(((Number(activeSiswa.nilai_uh1 || 0)*0.2) + (Number(activeSiswa.nilai_uts || 0)*0.3) + (Number(activeSiswa.nilai_uh2 || 0)*0.2) + (Number(activeSiswa.nilai_uas || 0)*0.3)) >= kkm) ? 'text-emerald-700 bg-emerald-100' : 'text-red-700 bg-red-100'"
              class="inline-block px-2.5 py-0.5 rounded-full text-[10px] mt-1"
              x-text="(((Number(activeSiswa.nilai_uh1 || 0)*0.2) + (Number(activeSiswa.nilai_uts || 0)*0.3) + (Number(activeSiswa.nilai_uh2 || 0)*0.2) + (Number(activeSiswa.nilai_uas || 0)*0.3)) >= kkm) ? '✓ Tuntas' : '✗ Remedial'"
            ></span>
          </div>
        </div>

        <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
          <button type="button" @click="isOpen = false" class="px-5 py-2.5 border border-gray-200 text-gray-500 text-xs font-bold rounded-xl hover:bg-gray-50 transition">
            Batal
          </button>
          <button type="submit" class="px-5 py-2.5 bg-primary hover:bg-primary-dark text-white text-xs font-bold rounded-xl transition shadow-lg shadow-primary/20">
            Simpan Nilai
          </button>
        </div>
      </form>
    </div>
  </div>

</div>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    lucide.createIcons();
  });
</script>
@endsection
