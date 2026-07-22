@extends('layouts.dashboard')

@section('title', 'Dashboard Overview — SD Perguruan Buddhi')
@section('page_title', 'Statistik & Analisis Akademik')

@section('dashboard_content')
<div class="space-y-8">

  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
    @foreach ($kpiCards as $card)
      <div class="p-6 bg-white border border-gray-100 rounded-3xl hover:shadow-lg transition flex justify-between items-start">
        <div class="space-y-1">
          <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">{{ $card['label'] }}</p>
          <h3 class="text-3xl font-black text-gray-900">{{ $card['value'] }}</h3>
          <span class="text-[10px] {{ $card['trend'] > 0 ? 'text-emerald-500' : 'text-gray-400' }} font-bold">
            {{ $card['trend'] > 0 ? '↑ '.$card['trend'].'%' : 'Stabil' }}
          </span>
        </div>
        <div class="w-12 h-12 rounded-2xl flex items-center justify-center text-2xl" style="background: {{ $card['bg'] }}">
          {{ $card['icon'] }}
        </div>
      </div>
    @endforeach
  </div>

  <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

    <div class="bg-white p-6 border border-gray-100 rounded-3xl space-y-6">
      <div class="flex items-center justify-between">
        <div>
          <h3 class="font-extrabold text-gray-900 text-base">Perkembangan Nilai per Milestone Evaluasi</h3>
          <p class="text-xs text-gray-400 font-medium">Tren Nilai Rata-rata UH 1, UTS, UH 2, dan UAS Semua Mata Pelajaran</p>
        </div>
        
        <select id="selectClassFilter" class="text-xs border border-gray-200 rounded-xl px-3 py-2 text-gray-600 font-bold focus:border-primary outline-none">
          <option value="all">Semua Kelas</option>
          @foreach($kelasList as $kelas)
            <option value="{{ $kelas->id }}">Kelas {{ $kelas->nama }}</option>
          @endforeach
        </select>
      </div>
      <div class="h-64 relative">
        <canvas id="chartMapel"></canvas>
      </div>
    </div>

    <div class="bg-white p-6 border border-gray-100 rounded-3xl space-y-6">
      <div>
        <h3 class="font-extrabold text-gray-900 text-base">Distribusi Kualifikasi Grade</h3>
        <p class="text-xs text-gray-400 font-medium">Persentase pengelompokan grade pencapaian siswa</p>
      </div>
      <div class="flex items-center gap-8 justify-around">
        <div class="w-48 h-48 shrink-0 relative">
          <canvas id="chartGrade"></canvas>
        </div>
        <div class="space-y-2 font-bold text-xs flex-1">
          @foreach($gradeData as $grade => $data)
            <div class="flex items-center justify-between">
              <span class="flex items-center gap-2">
                <span class="w-3 h-3 rounded-full" style="background: {{ $data['color'] }}"></span>
                Grade {{ $grade }}
              </span>
              <span class="text-gray-400">{{ $data['count'] }} Siswa ({{ $data['persen'] }}%)</span>
            </div>
          @endforeach
        </div>
      </div>
    </div>

  </div>

  <div class="bg-white p-6 border border-gray-100 rounded-3xl space-y-6">
    <div>
      <h3 class="font-extrabold text-gray-900 text-base">Tren Perkembangan Nilai Akhir</h3>
      <p class="text-xs text-gray-400 font-medium">Perbandingan rata-rata capaian Semester 1 vs Semester 2</p>
    </div>
    <div class="h-64 relative">
      <canvas id="chartTren"></canvas>
    </div>
  </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
  document.addEventListener('DOMContentLoaded', function() {

    Chart.defaults.font.family = "'Plus Jakarta Sans', sans-serif";
    Chart.defaults.color = '#9CA3AF';

    const colors = {
      primary: '#E53E2F',
      info: '#3B82F6',
      success: '#10B981',
      warning: '#F59E0B',
      danger: '#EF4444',
      neutral400: '#9CA3AF',
      neutral900: '#1A1A2E'
    };

    let chartMapelInst = null;
    let chartGradeInst = null;
    let chartTrenInst = null;

    function loadChartMapel(kelasId = 'all') {
      axios.get(`{{ route('dashboard.api.chart.mapel') }}?kelas_id=${kelasId}`)
        .then(response => {
          const data = response.data;
          const ctx = document.getElementById('chartMapel').getContext('2d');
          
          if (chartMapelInst) {
            chartMapelInst.destroy();
          }

          chartMapelInst = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: data.labels, // ['UH Sebelum UTS', 'UTS', 'UH Sebelum UAS', 'UAS']
                datasets: [
                {
                    type: 'line',
                    label: 'Nilai Tertinggi',
                    data: data.max_nilai,
                    borderColor: '#f4b942',
                    backgroundColor: 'rgba(244,185,66,0.35)',
                    fill: true,
                    tension: 0,
                    pointBackgroundColor: '#fff',
                    pointBorderColor: '#f4b942',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    order: -1
                },
                {
                    label: 'Rata-rata Nilai',
                    data: data.rata_rata,
                    backgroundColor: '#8ec5ff',
                    borderColor: '#ffffff',
                    borderWidth: 2
                },
                {
                    label: 'Standar KKM',
                    data: data.kkm,
                    backgroundColor: '#bdbdbd',
                    borderColor: '#ffffff',
                    borderWidth: 2
                }]
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
                        backgroundColor: colors.neutral900,
                        padding: 12
                    }
                },
                scales: {
                    x: {
                        grid: {
                            color: '#e5e5e5'
                        }
                    },
                    y: {
                        beginAtZero: true,
                        min: 0,
                        max: 100,
                        grid: {
                            color: '#e5e5e5'
                        }
                    }
                }
            }
          });
        });
    }

    function loadChartGrade() {
      axios.get('{{ route('dashboard.api.chart.grade') }}')
        .then(response => {
          const data = response.data;
          const ctx = document.getElementById('chartGrade').getContext('2d');

          if (chartGradeInst) {
            chartGradeInst.destroy();
          }

          chartGradeInst = new Chart(ctx, {
            type: 'doughnut',
            data: {
              labels: data.labels,
              datasets: [{
                data: data.values,
                backgroundColor: [
                  colors.success,
                  colors.info,
                  colors.warning,
                  colors.danger,
                  colors.neutral400
                ],
                borderWidth: 0,
                hoverOffset: 8
              }]
            },
            options: {
              responsive: true,
              maintainAspectRatio: false,
              cutout: '70%',
              plugins: {
                legend: { display: false }
              }
            }
          });
        });
    }

    function loadChartTren() {
      axios.get('{{ route('dashboard.api.chart.tren') }}')
        .then(response => {
          const data = response.data;
          const ctx = document.getElementById('chartTren').getContext('2d');

          if (chartTrenInst) {
            chartTrenInst.destroy();
          }

          const grad1 = ctx.createLinearGradient(0, 0, 0, 250);
          grad1.addColorStop(0, 'rgba(229, 62, 47, 0.15)');
          grad1.addColorStop(1, 'rgba(229, 62, 47, 0)');

          const grad2 = ctx.createLinearGradient(0, 0, 0, 250);
          grad2.addColorStop(0, 'rgba(59, 130, 246, 0.15)');
          grad2.addColorStop(1, 'rgba(59, 130, 246, 0)');

          chartTrenInst = new Chart(ctx, {
            type: 'line',
            data: {
              labels: data.labels,
              datasets: [
                {
                  label: 'Semester 1',
                  data: data.trenSem1,
                  borderColor: colors.primary,
                  backgroundColor: grad1,
                  borderWidth: 3,
                  pointBackgroundColor: colors.primary,
                  pointRadius: 6,
                  tension: 0.4,
                  fill: true
                },
                {
                  label: 'Semester 2',
                  data: data.trenSem2,
                  borderColor: colors.info,
                  backgroundColor: grad2,
                  borderWidth: 3,
                  pointBackgroundColor: colors.info,
                  pointRadius: 6,
                  tension: 0.4,
                  fill: true
                }
              ]
            },
            options: {
              responsive: true,
              maintainAspectRatio: false,
              interaction: { mode: 'index', intersect: false },
              plugins: {
                legend: {
                  position: 'top',
                  align: 'end',
                  labels: { usePointStyle: true }
                }
              },
              scales: {
                y: {
                  min: 60, max: 100,
                  grid: { color: 'rgba(0, 0, 0, 0.04)' }
                },
                x: { grid: { display: false } }
              }
            }
          });
        });
    }

    loadChartMapel();
    loadChartGrade();
    loadChartTren();

    document.getElementById('selectClassFilter').addEventListener('change', function(e) {
      loadChartMapel(e.target.value);
    });

  });
</script>
@endsection
