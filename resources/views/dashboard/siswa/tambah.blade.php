@extends('layouts.dashboard')

@section('title', 'Tambah Siswa — SD Perguruan Buddhi')
@section('page_title', 'Tambah Profil Siswa Baru')

@section('dashboard_content')
<div class="max-w-2xl bg-white border border-gray-100 rounded-3xl p-8 shadow-sm">
  
  <div class="mb-6">
    <a href="{{ route('dashboard.siswa.index') }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-gray-400 hover:text-primary transition mb-3">
      <i data-lucide="arrow-left" class="w-3.5 h-3.5"></i> Kembali ke Daftar Siswa
    </a>
    <h3 class="font-extrabold text-gray-900 text-lg">Formulir Pendaftaran Siswa</h3>
    <p class="text-xs text-gray-400">Harap isi seluruh field bertanda bintang dengan benar.</p>
  </div>

  @if($errors->any())
    <div class="bg-red-500/15 border border-red-500/30 rounded-xl p-4 mb-6 text-red-500 font-bold text-xs">
      <ul>
        @foreach($errors->all() as $error)
          <li>• {{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form action="{{ route('dashboard.siswa.store') }}" method="POST" class="space-y-6">
    @csrf

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
      <div>
        <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Nomor Induk Siswa (NIS) *</label>
        <input type="text" name="nis" required value="{{ old('nis') }}" class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm outline-none focus:border-primary">
      </div>
      <div>
        <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Nama Lengkap Siswa *</label>
        <input type="text" name="nama_lengkap" required value="{{ old('nama_lengkap') }}" class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm outline-none focus:border-primary">
      </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
      <div>
        <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Pilih Kelas *</label>
        <select name="kelas_id" required class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm outline-none focus:border-primary bg-white">
          <option value="">-- Pilih Kelas --</option>
          @foreach($kelasList as $kelas)
            <option value="{{ $kelas->id }}" {{ old('kelas_id') == $kelas->id ? 'selected' : '' }}>Kelas {{ $kelas->nama }}</option>
          @endforeach
        </select>
      </div>
      <div>
        <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Jenis Kelamin *</label>
        <select name="jenis_kelamin" required class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm outline-none focus:border-primary bg-white">
          <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
          <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
        </select>
      </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
      <div>
        <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Tanggal Lahir *</label>
        <input type="date" name="tanggal_lahir" required value="{{ old('tanggal_lahir') }}" class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm outline-none focus:border-primary">
      </div>
      <div>
        <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">URL Foto Siswa (Opsional)</label>
        <input type="text" name="foto" value="{{ old('foto') }}" placeholder="https://..." class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm outline-none focus:border-primary">
      </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 pt-4 border-t border-gray-100">
      <div>
        <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Tautkan User Akun Siswa (Opsional)</label>
        <select name="user_id" class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm outline-none focus:border-primary bg-white">
          <option value="">-- Tanpa Tautan --</option>
          @foreach($users as $user)
            <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>{{ $user->nama }} ({{ $user->email }})</option>
          @endforeach
        </select>
      </div>
      <div>
        <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Tautkan User Akun Orang Tua (Opsional)</label>
        <select name="parent_user_id" class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm outline-none focus:border-primary bg-white">
          <option value="">-- Tanpa Tautan --</option>
          @foreach($parents as $parent)
            <option value="{{ $parent->id }}" {{ old('parent_user_id') == $parent->id ? 'selected' : '' }}>{{ $parent->nama }} ({{ $parent->email }})</option>
          @endforeach
        </select>
      </div>
    </div>

    <div class="flex items-center justify-end gap-3 pt-6">
      <a href="{{ route('dashboard.siswa.index') }}" class="px-5 py-2.5 border border-gray-200 text-gray-500 text-xs font-bold rounded-xl hover:bg-gray-50 transition">Batal</a>
      <button type="submit" class="px-5 py-2.5 bg-primary text-white text-xs font-bold rounded-xl hover:bg-primary-dark transition shadow-lg shadow-primary/20">Daftarkan Siswa</button>
    </div>
  </form>
</div>
@endsection
