@extends('layouts.dashboard')

@section('title', 'Manajemen Siswa — SD Perguruan Buddhi')
@section('page_title', 'Manajemen Informasi Siswa')

@section('dashboard_content')
<div class="space-y-6">

  <div class="bg-white border border-gray-100 rounded-3xl overflow-hidden shadow-sm">

    <div class="p-6 border-b border-gray-100 flex flex-wrap gap-4 items-center justify-between">
      <div class="flex items-center gap-3">
        <form action="{{ route('dashboard.siswa.index') }}" method="GET" class="flex items-center gap-3">
          <span class="text-xs font-bold text-gray-400 uppercase">Pilih Kelas:</span>
          <select name="kelas_id" onchange="this.form.submit()" class="text-xs font-bold border border-gray-200 rounded-xl px-4 py-2 text-gray-700 focus:border-primary outline-none">
            <option value="all">Semua Kelas</option>
            @foreach($kelasList as $kelas)
              <option value="{{ $kelas->id }}" {{ $kelasId == $kelas->id ? 'selected' : '' }}>Kelas {{ $kelas->nama }}</option>
            @endforeach
          </select>
        </form>
      </div>

      <a href="{{ route('dashboard.siswa.create') }}" class="px-5 py-2.5 bg-primary hover:bg-primary-dark text-white text-xs font-bold rounded-xl transition shadow-lg shadow-primary/30 flex items-center gap-1.5 hover:translate-y-[-1px]">
        <i data-lucide="plus" class="w-4 h-4"></i> Tambah Siswa Baru
      </a>
    </div>

    <div class="overflow-x-auto">
      <table class="w-full text-left text-sm">
        <thead class="bg-gray-50 border-b border-gray-100 text-gray-400 font-bold text-xs uppercase tracking-wider">
          <tr>
            <th class="px-6 py-4">Foto</th>
            <th class="px-6 py-4">NIS</th>
            <th class="px-6 py-4">Nama Lengkap</th>
            <th class="px-6 py-4">Kelas</th>
            <th class="px-6 py-4">Jenis Kelamin</th>
            <th class="px-6 py-4">Tanggal Lahir</th>
            <th class="px-6 py-4 text-right">Aksi</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-100 font-medium">
          @forelse($siswaList as $siswa)
            <tr class="hover:bg-gray-50 transition duration-150">
              <td class="px-6 py-4">
                <img src="{{ $siswa->foto ?? 'https://api.dicebear.com/7.x/adventurer/svg?seed='.$siswa->nama_lengkap }}" alt="{{ $siswa->nama_lengkap }}" class="w-10 h-10 rounded-full object-cover border border-gray-100 bg-gray-50">
              </td>
              <td class="px-6 py-4 font-mono text-xs text-gray-400">{{ $siswa->nis }}</td>
              <td class="px-6 py-4 font-bold text-gray-900">{{ $siswa->nama_lengkap }}</td>
              <td class="px-6 py-4 text-gray-500">Kelas {{ $siswa->kelas->nama }}</td>
              <td class="px-6 py-4 text-gray-500">{{ $siswa->jenis_kelamin }}</td>
              <td class="px-6 py-4 text-gray-400">{{ Carbon\Carbon::parse($siswa->tanggal_lahir)->format('d M Y') }}</td>
              <td class="px-6 py-4 text-right">
                <div class="flex items-center justify-end gap-2">
                  <a href="{{ route('dashboard.raport.show', $siswa->id) }}" class="p-2 hover:bg-gray-100 text-gray-700 hover:text-primary rounded-xl transition" title="Lihat Raport">
                    <i data-lucide="file-text" class="w-4 h-4"></i>
                  </a>
                  <a href="{{ route('dashboard.siswa.edit', $siswa->id) }}" class="p-2 hover:bg-gray-100 text-gray-700 hover:text-indigo-600 rounded-xl transition" title="Edit Profil">
                    <i data-lucide="edit" class="w-4 h-4"></i>
                  </a>
                  <form action="{{ route('dashboard.siswa.destroy', $siswa->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data siswa ini?')" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="p-2 hover:bg-red-50 text-gray-400 hover:text-red-500 rounded-xl transition" title="Hapus Siswa">
                      <i data-lucide="trash-2" class="w-4 h-4"></i>
                    </button>
                  </form>
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="7" class="px-6 py-12 text-center text-gray-400 font-bold">Tidak ada data siswa ditemukan.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection
