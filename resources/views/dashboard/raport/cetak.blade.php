<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cetak Raport — {{ $siswa->nama_lengkap }}</title>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap');

    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    html, body {
      font-family: 'Inter', 'Arial', sans-serif;
      font-size: 11pt;
      background: #f5f5f5;
      color: #1a1a1a;
    }

    /* ── Screen wrapper ─────────────────────────── */
    .page-wrap {
      max-width: 210mm;
      margin: 20px auto;
      background: #fff;
      padding: 0;
      box-shadow: 0 4px 32px rgba(0,0,0,.12);
      border-radius: 8px;
      overflow: hidden;
    }

    /* ── Top toolbar (screen only) ──────────────── */
    .toolbar {
      background: #1a1a2e;
      color: #fff;
      padding: 12px 24px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 12px;
    }
    .toolbar span { font-size: 13px; font-weight: 600; opacity: .85; }
    .toolbar-btns { display: flex; gap: 10px; }
    .btn-print {
      background: #f4b942;
      color: #1a1a2e;
      border: none;
      padding: 8px 20px;
      border-radius: 6px;
      font-weight: 800;
      font-size: 12px;
      cursor: pointer;
      letter-spacing: .4px;
      transition: background .15s;
    }
    .btn-print:hover { background: #f8c960; }
    .btn-back {
      background: rgba(255,255,255,.1);
      color: #fff;
      border: 1px solid rgba(255,255,255,.2);
      padding: 8px 16px;
      border-radius: 6px;
      font-weight: 600;
      font-size: 12px;
      cursor: pointer;
      text-decoration: none;
      transition: background .15s;
    }
    .btn-back:hover { background: rgba(255,255,255,.2); }

    /* ── Document area ──────────────────────────── */
    .doc {
      padding: 28mm 20mm 20mm 20mm;
    }

    /* ── KOP SEKOLAH ────────────────────────────── */
    .kop {
      border-bottom: 3px solid #1a1a2e;
      padding-bottom: 10px;
      margin-bottom: 10px;
      display: flex;
      align-items: center;
      gap: 18px;
    }
    .kop-logo {
      width: 70px;
      height: 70px;
      border: 2px solid #1a1a2e;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 22px;
      font-weight: 900;
      color: #1a1a2e;
      background: #f4f4f4;
      flex-shrink: 0;
      letter-spacing: -1px;
    }
    .kop-text { flex: 1; text-align: center; }
    .kop-text h1 {
      font-size: 17pt;
      font-weight: 900;
      text-transform: uppercase;
      letter-spacing: 1px;
      color: #1a1a2e;
      line-height: 1.1;
    }
    .kop-text p {
      font-size: 9pt;
      color: #555;
      margin-top: 3px;
      line-height: 1.5;
    }
    .kop-text .akreditasi {
      display: inline-block;
      background: #1a1a2e;
      color: #f4b942;
      padding: 1px 10px;
      border-radius: 3px;
      font-size: 8pt;
      font-weight: 700;
      margin-top: 4px;
      letter-spacing: 1px;
      text-transform: uppercase;
    }

    /* ── Judul Dokumen ──────────────────────────── */
    .judul-doc {
      text-align: center;
      margin: 16px 0 18px;
    }
    .judul-doc h2 {
      font-size: 14pt;
      font-weight: 900;
      text-transform: uppercase;
      letter-spacing: 2px;
      color: #1a1a2e;
    }
    .judul-doc p {
      font-size: 9pt;
      color: #666;
      margin-top: 2px;
    }
    .judul-doc .underline-dec {
      width: 60px;
      height: 3px;
      background: #f4b942;
      margin: 6px auto 0;
      border-radius: 2px;
    }

    /* ── Identitas Siswa ────────────────────────── */
    .identitas {
      border: 1.5px solid #d0d0d0;
      border-radius: 6px;
      padding: 14px 18px;
      margin-bottom: 18px;
      background: #fafafa;
    }
    .identitas-title {
      font-size: 8pt;
      font-weight: 800;
      text-transform: uppercase;
      letter-spacing: 1.5px;
      color: #888;
      margin-bottom: 10px;
      padding-bottom: 6px;
      border-bottom: 1px solid #e8e8e8;
    }
    .identitas-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 8px 24px;
    }
    .id-row {
      display: flex;
      gap: 8px;
      font-size: 10pt;
    }
    .id-row .label {
      color: #888;
      min-width: 110px;
      font-size: 9.5pt;
    }
    .id-row .sep { color: #bbb; }
    .id-row .val {
      font-weight: 700;
      color: #1a1a2e;
    }

    /* ── Tabel Nilai ────────────────────────────── */
    .section-title {
      font-size: 9.5pt;
      font-weight: 800;
      text-transform: uppercase;
      letter-spacing: 1.5px;
      color: #1a1a2e;
      margin-bottom: 8px;
      padding-left: 10px;
      border-left: 3px solid #f4b942;
    }

    table.nilai-table {
      width: 100%;
      border-collapse: collapse;
      font-size: 9.5pt;
      margin-bottom: 18px;
    }
    table.nilai-table thead tr {
      background: #1a1a2e;
      color: #fff;
    }
    table.nilai-table thead th {
      padding: 7px 8px;
      text-align: center;
      font-weight: 700;
      font-size: 8.5pt;
      letter-spacing: .5px;
    }
    table.nilai-table thead th:nth-child(2) { text-align: left; }
    table.nilai-table tbody tr:nth-child(even) { background: #f8f8f8; }
    table.nilai-table tbody td {
      padding: 6px 8px;
      border-bottom: 1px solid #e8e8e8;
      text-align: center;
      color: #333;
    }
    table.nilai-table tbody td:nth-child(2) { text-align: left; font-weight: 600; }
    table.nilai-table .td-no { color: #aaa; font-size: 8.5pt; }
    table.nilai-table .td-kkm { color: #888; }
    table.nilai-table .td-akhir { font-weight: 800; color: #1a1a2e; }
    table.nilai-table .td-tuntas {
      font-weight: 700;
      font-size: 8.5pt;
      padding: 2px 6px;
      border-radius: 3px;
    }
    table.nilai-table .tuntas-yes { color: #16a34a; background: #dcfce7; }
    table.nilai-table .tuntas-no  { color: #dc2626; background: #fee2e2; }

    /* ── Ringkasan ──────────────────────────────── */
    .ringkasan-row {
      display: flex;
      gap: 12px;
      margin-bottom: 18px;
    }
    .ringkasan-box {
      flex: 1;
      border: 1.5px solid #e0e0e0;
      border-radius: 6px;
      padding: 12px 10px;
      text-align: center;
    }
    .ringkasan-box .rb-label {
      font-size: 8pt;
      color: #888;
      text-transform: uppercase;
      letter-spacing: 1px;
      font-weight: 600;
      margin-bottom: 4px;
    }
    .ringkasan-box .rb-value {
      font-size: 20pt;
      font-weight: 900;
      color: #1a1a2e;
      line-height: 1;
    }
    .ringkasan-box.highlight { border-color: #f4b942; background: #fffbf0; }
    .ringkasan-box.highlight .rb-value { color: #d97706; }

    /* ── Catatan ────────────────────────────────── */
    .catatan-box {
      border: 1.5px solid #e0e0e0;
      border-radius: 6px;
      padding: 12px 14px;
      margin-bottom: 24px;
      min-height: 60px;
      font-size: 9.5pt;
      color: #444;
      line-height: 1.6;
    }

    /* ── Tanda Tangan ───────────────────────────── */
    .ttd-section {
      display: grid;
      grid-template-columns: 1fr 1fr 1fr;
      gap: 16px;
      text-align: center;
      margin-top: 8px;
    }
    .ttd-item {
      font-size: 9.5pt;
    }
    .ttd-item .ttd-label { color: #555; margin-bottom: 50px; }
    .ttd-item .ttd-line {
      border-bottom: 1.5px solid #1a1a2e;
      margin: 0 12px;
    }
    .ttd-item .ttd-name { font-weight: 700; margin-top: 4px; font-size: 9.5pt; }
    .ttd-item .ttd-nip { font-size: 8pt; color: #888; margin-top: 1px; }

    /* ── Footer ─────────────────────────────────── */
    .doc-footer {
      margin-top: 20px;
      border-top: 1px solid #e0e0e0;
      padding-top: 10px;
      text-align: center;
      font-size: 8pt;
      color: #aaa;
    }

    /* ══ PRINT STYLES ══════════════════════════════ */
    @media print {
      html, body { background: #fff; }
      .toolbar { display: none !important; }
      .page-wrap {
        max-width: 100%;
        margin: 0;
        box-shadow: none;
        border-radius: 0;
      }
      .doc { padding: 15mm 15mm 12mm 15mm; }
      .tuntas-yes, .tuntas-no { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
      table.nilai-table thead tr { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
      .ringkasan-box.highlight { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
    }

    @page {
      size: A4 portrait;
      margin: 0;
    }
  </style>
</head>
<body>

  {{-- ── Toolbar Screen-Only ── --}}
  <div class="toolbar">
    <span>🖨️ Pratinjau Cetak Raport — {{ $siswa->nama_lengkap }}</span>
    <div class="toolbar-btns">
      <a href="{{ route('dashboard.raport.show', $siswa->id) }}" class="btn-back">← Kembali</a>
      <button class="btn-print" onclick="window.print()">🖨 Cetak / Simpan PDF</button>
    </div>
  </div>

  {{-- ── Dokumen Raport ── --}}
  <div class="page-wrap">
    <div class="doc">

      {{-- KOP SEKOLAH --}}
      <div class="kop">
        <div class="kop-logo">SD</div>
        <div class="kop-text">
          <h1>SD Perguruan Buddhi</h1>
          <p>Jl. Imam Bonjol No. 41 Karawaci, Tangerang · Telp. (021) 555-888</p>
          <p>Email: admin@sdbuddhi.sch.id · Website: www.sdbuddhi.sch.id</p>
          <span class="akreditasi">Terakreditasi A — BAN-SM</span>
        </div>
      </div>

      {{-- JUDUL DOKUMEN --}}
      <div class="judul-doc">
        <h2>Laporan Hasil Belajar Siswa</h2>
        <p>Rekapitulasi Raport Semester Genap — Tahun Ajaran {{ $siswa->kelas->tahun_ajaran ?? date('Y') . '/' . (date('Y')+1) }}</p>
        <div class="underline-dec"></div>
      </div>

      {{-- IDENTITAS SISWA --}}
      <div class="identitas">
        <div class="identitas-title">Identitas Siswa</div>
        <div class="identitas-grid">
          <div class="id-row">
            <span class="label">Nama Lengkap</span>
            <span class="sep">:</span>
            <span class="val">{{ $siswa->nama_lengkap }}</span>
          </div>
          <div class="id-row">
            <span class="label">Kelas</span>
            <span class="sep">:</span>
            <span class="val">Kelas {{ $siswa->kelas->nama }}</span>
          </div>
          <div class="id-row">
            <span class="label">NIS</span>
            <span class="sep">:</span>
            <span class="val">{{ $siswa->nis }}</span>
          </div>
          <div class="id-row">
            <span class="label">Wali Kelas</span>
            <span class="sep">:</span>
            <span class="val">{{ $siswa->kelas->waliKelas->nama ?? 'Belum Ditentukan' }}</span>
          </div>
          <div class="id-row">
            <span class="label">Jenis Kelamin</span>
            <span class="sep">:</span>
            <span class="val">{{ $siswa->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}</span>
          </div>
          <div class="id-row">
            <span class="label">Tahun Ajaran</span>
            <span class="sep">:</span>
            <span class="val">{{ $siswa->kelas->tahun_ajaran ?? '-' }} / Semester Genap</span>
          </div>
        </div>
      </div>

      {{-- TABEL NILAI --}}
      <div class="section-title">Daftar Nilai Mata Pelajaran</div>
      <table class="nilai-table">
        <thead>
          <tr>
            <th style="width:28px">No</th>
            <th style="text-align:left; padding-left:10px">Mata Pelajaran</th>
            <th>KKM</th>
            <th>UH 1</th>
            <th>UTS</th>
            <th>UH 2</th>
            <th>UAS</th>
            <th>Nilai Akhir</th>
            <th>Grade</th>
            <th>Kelulusan</th>
          </tr>
        </thead>
        <tbody>
          @forelse($raports as $index => $r)
          <tr>
            <td class="td-no">{{ $index + 1 }}</td>
            <td style="padding-left:10px">{{ $r->mataPelajaran->nama }}</td>
            <td class="td-kkm">{{ $r->mataPelajaran->kkm }}</td>
            <td>{{ round($r->nilai_uh1) }}</td>
            <td>{{ round($r->nilai_uts) }}</td>
            <td>{{ round($r->nilai_uh2) }}</td>
            <td>{{ round($r->nilai_uas) }}</td>
            <td class="td-akhir">{{ $r->nilai_akhir }}</td>
            <td style="font-weight:700">{{ $r->grade }}</td>
            <td>
              <span class="td-tuntas {{ $r->tuntas ? 'tuntas-yes' : 'tuntas-no' }}">
                {{ $r->tuntas ? 'Tuntas' : 'Remedial' }}
              </span>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="10" style="text-align:center; color:#aaa; padding:16px">
              Belum ada data nilai.
            </td>
          </tr>
          @endforelse
        </tbody>
      </table>

      {{-- RINGKASAN --}}
      <div class="section-title" style="margin-bottom:10px">Ringkasan Hasil Belajar</div>
      <div class="ringkasan-row">
        <div class="ringkasan-box highlight">
          <div class="rb-label">Rata-rata Nilai</div>
          <div class="rb-value">{{ $avgScore }}</div>
        </div>
        <div class="ringkasan-box">
          <div class="rb-label">Grade Kelulusan</div>
          <div class="rb-value">{{ $gradeAkhir }}</div>
        </div>
        <div class="ringkasan-box">
          <div class="rb-label">Tingkat Tuntas KKM</div>
          <div class="rb-value">{{ $passingRate }}%</div>
        </div>
        <div class="ringkasan-box">
          <div class="rb-label">Jumlah Mata Pelajaran</div>
          <div class="rb-value">{{ $raports->count() }}</div>
        </div>
      </div>

      {{-- CATATAN WALI KELAS --}}
      <div class="section-title" style="margin-bottom:8px">Catatan Wali Kelas</div>
      <div class="catatan-box">
        Berdasarkan pemantauan akademis Semester Genap, siswa menunjukkan kesantunan budi pekerti
        yang sangat tinggi, aktif di kegiatan ekstra olahraga, serta memiliki kemampuan bahasa yang
        terus berkembang. Sangat direkomendasikan mempertahankan fokus belajarnya di bidang eksakta
        Matematika.
      </div>

      {{-- TANDA TANGAN --}}
      <div class="ttd-section">
        <div class="ttd-item">
          <div class="ttd-label">Mengetahui,<br>Orang Tua / Wali Murid</div>
          <div class="ttd-line"></div>
          <div class="ttd-name">{{ $siswa->parent->nama ?? '( __________________ )' }}</div>
          <div class="ttd-nip">Tanda Tangan</div>
        </div>
        <div class="ttd-item">
          <div class="ttd-label">Tangerang, {{ \Carbon\Carbon::now()->locale('id')->isoFormat('D MMMM Y') }}<br>Wali Kelas,</div>
          <div class="ttd-line"></div>
          <div class="ttd-name">{{ $siswa->kelas->waliKelas->nama ?? 'Wali Kelas' }}</div>
          <div class="ttd-nip">NIP. —</div>
        </div>
        <div class="ttd-item">
          <div class="ttd-label">Mengetahui,<br>Kepala Sekolah</div>
          <div class="ttd-line"></div>
          <div class="ttd-name">( __________________ )</div>
          <div class="ttd-nip">NIP. —</div>
        </div>
      </div>

      {{-- FOOTER --}}
      <div class="doc-footer">
        Dokumen ini dicetak secara otomatis oleh Sistem Monitoring SD Perguruan Buddhi &middot;
        {{ \Carbon\Carbon::now()->format('d/m/Y H:i') }}
      </div>

    </div>
  </div>

</body>
</html>
