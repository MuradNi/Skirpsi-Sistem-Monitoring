@extends('layouts.dashboard')

@section('title', 'Raport Digital — SD Perguruan Buddhi')
@section('page_title', 'Laporan Capaian Belajar Siswa (Raport)')

@section('dashboard_content')
<div class="space-y-8">

  @if (in_array(auth()->user()->role, ['admin', 'wali_kelas']))
    <div class="no-print p-6 bg-white border border-gray-100 rounded-3xl flex flex-wrap gap-4 items-center justify-between shadow-sm">
      <div class="flex items-center gap-3">
        <span class="text-xs font-bold text-gray-400 uppercase">Pilih Siswa:</span>
        <select id="siswaReportSelector" onchange="window.location.href='/dashboard/raport/' + this.value" class="text-xs font-bold border border-gray-200 rounded-xl px-4 py-2 text-gray-700 focus:border-primary outline-none">
          @foreach($siswaList as $s)
            <option value="{{ $s->id }}" {{ $siswa->id == $s->id ? 'selected' : '' }}>{{ $s->nama_lengkap }} (Kelas {{ $s->kelas->nama }})</option>
          @endforeach
        </select>
      </div>
      <p class="text-xs text-gray-400 font-bold">Tekan tombol cetak di bawah raport untuk mengunduh versi cetak A4.</p>
    </div>
  @endif

  <div id="raport-sheet" class="print-container bg-white border border-gray-200 rounded-[32px] p-8 md:p-12 shadow-xl space-y-8 relative overflow-hidden">

    <div class="flex flex-col sm:flex-row items-center justify-between border-b-2 border-gray-900 pb-6 gap-6">
      <div class="flex items-center gap-4">
        <div class="w-16 h-16 bg-primary text-white rounded-2xl flex items-center justify-center shrink-0">
          <i data-lucide="graduation-cap" class="w-10 h-10"></i>
        </div>
        <div>
          <h2 class="text-2xl font-black text-gray-900 tracking-wide leading-tight font-playfair">SD PERGURUAN BUDDHI</h2>
          <p class="text-xs text-gray-400 font-bold uppercase tracking-widest leading-none">Terakreditasi A — BAN-SM</p>
          <p class="text-[10px] text-gray-500 mt-1">Alamat: Jl. Imam Bonjol No. 41 Karawaci, Tangerang · Telp: (021) 555-888</p>
        </div>
      </div>
      <div class="text-center sm:text-right">
        <h3 class="text-lg font-black text-primary font-playfair uppercase leading-none">LAPORAN HASIL BELAJAR</h3>
        <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mt-1">REKAPITULASI RAPORT SEMESTER GENAP</p>
      </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6 text-xs font-bold py-2 border-b border-gray-100">
      <div class="space-y-1"><p class="text-gray-400 uppercase tracking-wider font-semibold">Nama Siswa</p><p class="text-gray-900 text-sm">{{ $siswa->nama_lengkap }}</p></div>
      <div class="space-y-1"><p class="text-gray-400 uppercase tracking-wider font-semibold">Nomor Induk Siswa (NIS)</p><p class="text-gray-900 text-sm font-mono">{{ $siswa->nis }}</p></div>
      <div class="space-y-1"><p class="text-gray-400 uppercase tracking-wider font-semibold">Kelas / Tahun Ajaran</p><p class="text-gray-900 text-sm">Kelas {{ $siswa->kelas->nama }} / {{ $siswa->kelas->tahun_ajaran }}</p></div>
      <div class="space-y-1"><p class="text-gray-400 uppercase tracking-wider font-semibold">Guru Wali Kelas</p><p class="text-gray-900 text-sm">{{ $siswa->kelas->waliKelas->nama ?? 'Belum Ditentukan' }}</p></div>
    </div>

    <div class="bg-white border border-gray-100 rounded-[24px] p-6 space-y-6 shadow-sm no-print">
      <div class="flex items-center justify-between flex-wrap gap-4">
        <div>
          <h4 class="font-black text-gray-900 text-base border-l-4 border-primary pl-2 uppercase">Grafik Perkembangan Nilai Siswa</h4>
          <p class="text-xs text-gray-400 font-medium">Perbandingan Nilai Siswa, Rata-rata Kelas, dan Batas Kelulusan KKM</p>
        </div>
        
        <div class="flex items-center gap-2">
          <span class="text-xs font-bold text-gray-400 uppercase">Mata Pelajaran:</span>
          <select id="selectSubjectFilter" class="text-xs font-bold border border-gray-200 rounded-xl px-4 py-2 text-gray-700 bg-white focus:border-primary outline-none">
            <option value="all">Semua Mata Pelajaran (Rata-rata)</option>
            @foreach($raports as $r)
              <option value="{{ $r->mata_pelajaran_id }}">{{ $r->mataPelajaran->nama }}</option>
            @endforeach
          </select>
        </div>
      </div>
      <div class="h-80 relative">
        <canvas id="chartMilestones"></canvas>
      </div>
      <p class="text-[10px] text-gray-400 leading-relaxed font-medium">
        * Grafik menampilkan data perkembangan nilai harian (UH 1, UH 2) dan nilai ujian (UTS, UAS) siswa.
      </p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">

      <div class="lg:col-span-2 space-y-4">
        <h4 class="font-black text-gray-900 text-sm border-l-4 border-primary pl-2 uppercase">Daftar Nilai Kriteria Kelulusan</h4>
        
        <div class="overflow-hidden border border-gray-200 rounded-2xl">
          <table class="w-full text-left text-xs">
            <thead class="bg-gray-50 border-b border-gray-200 text-gray-500 font-bold uppercase tracking-wider">
              <tr>
                <th class="px-4 py-3 w-10 text-center">No</th>
                <th class="px-4 py-3">Mata Pelajaran</th>
                <th class="px-4 py-3 text-center">KKM</th>
                <th class="px-4 py-3 text-center">UH 1</th>
                <th class="px-4 py-3 text-center">UTS</th>
                <th class="px-4 py-3 text-center">UH 2</th>
                <th class="px-4 py-3 text-center">UAS</th>
                <th class="px-4 py-3 text-center">Nilai Akhir</th>
                <th class="px-4 py-3 text-center">Huruf</th>
                <th class="px-4 py-3 text-center">Kelulusan</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 font-bold">
              @foreach($raports as $index => $r)
                <tr class="hover:bg-gray-50 transition">
                  <td class="px-4 py-3 text-center text-gray-400">{{ $index + 1 }}</td>
                  <td class="px-4 py-3 text-gray-900">{{ $r->mataPelajaran->nama }}</td>
                  <td class="px-4 py-3 text-center text-gray-400">{{ $r->mataPelajaran->kkm }}</td>
                  <td class="px-4 py-3 text-center text-gray-600 font-mono">{{ round($r->nilai_uh1) }}</td>
                  <td class="px-4 py-3 text-center text-gray-600 font-mono">{{ round($r->nilai_uts) }}</td>
                  <td class="px-4 py-3 text-center text-gray-600 font-mono">{{ round($r->nilai_uh2) }}</td>
                  <td class="px-4 py-3 text-center text-gray-600 font-mono">{{ round($r->nilai_uas) }}</td>
                  <td class="px-4 py-3 text-center text-primary text-sm font-extrabold font-mono">{{ $r->nilai_akhir }}</td>
                  <td class="px-4 py-3 text-center text-gray-800">{{ $r->grade }}</td>
                  <td class="px-4 py-3 text-center">
                    <span class="px-2 py-0.5 rounded text-[10px] {{ $r->tuntas ? 'text-emerald-600 bg-emerald-50' : 'text-red-500 bg-red-50' }}">
                      {{ $r->tuntas ? 'Tuntas' : 'Remedial' }}
                    </span>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>

      <div class="space-y-4">
        <h4 class="font-black text-gray-900 text-sm border-l-4 border-primary pl-2 uppercase">Ringkasan Statistik</h4>
        <div class="bg-gray-50 border border-gray-100 p-6 rounded-3xl space-y-6 font-bold shadow-sm">
          <div class="text-center">
            <p class="text-gray-400 font-semibold mb-1 uppercase tracking-wider text-[10px]">RATA-RATA NILAI</p>
            <p class="text-3xl font-black text-primary font-mono">{{ $avgScore }}</p>
          </div>
          <div class="border-t border-gray-200/60 my-4"></div>
          <div class="text-center">
            <p class="text-gray-400 font-semibold mb-1 uppercase tracking-wider text-[10px]">GRADE KELULUSAN</p>
            <p class="text-3xl font-black text-gray-900">{{ $gradeAkhir }}</p>
          </div>
          <div class="border-t border-gray-200/60 my-4"></div>
          <div class="text-center">
            <p class="text-gray-400 font-semibold mb-1 uppercase tracking-wider text-[10px]">TINGKAT TUNTAS KKM</p>
            <p class="text-3xl font-black text-emerald-600 font-mono">{{ $passingRate }}%</p>
          </div>
        </div>
      </div>

    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 border-t border-gray-100 pt-6 text-xs font-bold">
      <div class="space-y-2">
        <p class="text-gray-400 uppercase tracking-wider pl-2 border-l-2 border-primary">Catatan & Masukan Wali Kelas</p>
        <div class="bg-gray-50 border border-gray-100 p-4 rounded-2xl font-medium text-gray-600 min-h-[90px] leading-relaxed">
          Berdasarkan pemantauan akademis Semester Genap, siswa menunjukkan kesantunan budi pekerti yang sangat tinggi, aktif di kegiatan ekstra olahraga, serta memiliki kemampuan bahasa yang terus berkembang. Sangat direkomendasikan mempertahankan fokus belajarnya di bidang eksakta Matematika.
        </div>
      </div>

      <div class="grid grid-cols-2 gap-4 text-center items-end h-[90px] pt-4">
        <div>
          <p class="text-gray-400 mb-10 leading-none">Orang Tua / Wali Murid</p>
          <div class="w-24 border-b border-gray-900 mx-auto"></div>
          <p class="text-[10px] text-gray-400 uppercase tracking-widest mt-1">Tanda Tangan</p>
        </div>
        <div>
          <p class="text-gray-400 mb-10 leading-none">{{ $siswa->kelas->waliKelas->nama ?? 'Wali Kelas' }}</p>
          <div class="w-32 border-b border-gray-900 mx-auto"></div>
          <p class="text-[10px] text-gray-400 uppercase tracking-widest mt-1">NIP. 19880122 201211 2 001</p>
        </div>
      </div>
    </div>

    <div class="no-print border-t border-gray-100 pt-6 flex items-center justify-end">
      <a href="{{ route('dashboard.raport.cetak', $siswa->id) }}" target="_blank"
         class="px-6 py-3 bg-gray-900 hover:bg-primary text-white text-xs font-bold rounded-xl transition shadow-lg shadow-gray-900/20 flex items-center gap-1.5 hover:translate-y-[-1px]">
        <i data-lucide="printer" class="w-4 h-4"></i> Cetak Dokumen A4 (PDF)
      </a>
    </div>

  </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    let chartInst = null;

    function loadRaportChart(mapelId = 'all') {
      axios.get('/dashboard/api/raport/{{ $siswa->id }}?mapel_id=' + mapelId)
        .then(response => {
          const data = response.data;
          const ctx = document.getElementById('chartMilestones').getContext('2d');
          
          if (chartInst) {
            chartInst.destroy();
          }

          chartInst = new Chart(ctx, {
            type: 'bar', // ChartJS Tipe Bar
            data: {
              labels: data.labels, // Label Data ['UH Sebelum UTS', 'UTS', 'UH Sebelum UAS', 'UAS']
              datasets: [
                {
                  label: 'Nilai Siswa',
                  data: data.siswa_grades,
                  backgroundColor: '#f4b942', 
                  borderColor: '#ffffff',
                  borderWidth: 2,
                  borderRadius: 6
                },
                {
                  label: 'Rata-rata Kelas',
                  data: data.class_averages,
                  backgroundColor: '#8ec5ff', 
                  borderColor: '#ffffff',
                  borderWidth: 2,
                  borderRadius: 6
                },
                {
                  label: 'Standar KKM',
                  data: data.kkm,
                  backgroundColor: '#bdbdbd', 
                  borderColor: '#ffffff',
                  borderWidth: 2,
                  borderRadius: 6
                }
              ]
            },
            options: {
              responsive: true,
              maintainAspectRatio: false,
              plugins: {
                legend: {
                  display: true,
                  position: 'top',
                  labels: {
                    usePointStyle: true,
                    boxWidth: 8,
                    padding: 15
                  }
                },
                tooltip: {
                  backgroundColor: '#1a1a2e',
                  padding: 12
                }
              },
              scales: {
                y: {
                  beginAtZero: true,
                  min: 0, max: 100,
                  grid: { color: '#e5e5e5' }
                },
                x: {
                  grid: { display: false }
                }
              }
            }
          });
        });
    }

    // Load initial chart
    loadRaportChart('all');

    // Add filter change listener
    document.getElementById('selectSubjectFilter').addEventListener('change', function(e) {
      loadRaportChart(e.target.value);
    });
  });
</script>
@endsection
