<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BerandaController extends Controller
{
    public function index()
    {
        // Mock news data corresponding to Design.md specifications
        $newsFeed = [
            [
                'id' => 1,
                'kategori' => 'Prestasi',
                'judul' => 'SD Perguruan Buddhi Meraih Juara Umum Olimpiade Matematika Kota Tangerang',
                'excerpt' => 'Tim olimpiade SD Perguruan Buddhi berhasil memboyong 3 medali emas dan 1 perak dalam ajang bergengsi O2SN tingkat kota.',
                'body' => 'Sebuah kebanggaan luar biasa datang dari tim olimpiade matematika SD Perguruan Buddhi. Dalam ajang Olimpiade Sains Nasional tingkat Kota Tangerang yang diselenggarakan pada tanggal 20 Mei lalu, siswa-siswi kami berhasil meraih Juara Umum dengan menyabet 3 medali emas dan 1 perak. Kepala Sekolah menyatakan bahwa prestasi ini merupakan hasil kerja keras pelatihan intensif selama 6 bulan terakhir bersama para guru pembimbing.',
                'thumbnail' => 'https://images.unsplash.com/photo-1546410531-bb4caa6b424d?auto=format&fit=crop&w=600&q=80',
                'created_at' => now()->subDays(4),
            ],
            [
                'id' => 2,
                'kategori' => 'Kegiatan',
                'judul' => 'Pelepasan & Wisuda Siswa Kelas VI Angkatan Ke-32 Berlangsung Khidmat',
                'excerpt' => 'Momen penuh haru menyelimuti acara wisuda kelas VI yang diadakan di Aula Serbaguna Universitas Buddhi Dharma.',
                'body' => 'Sebanyak 124 siswa-siswi kelas VI SD Perguruan Buddhi resmi dinyatakan lulus dalam wisuda Angkatan Ke-32. Acara bertema "Terbang Tinggi Meraih Mimpi, Berbekal Karakter Luhur" ini dihadiri oleh para wali murid, komite sekolah, serta jajaran rektorat Universitas Buddhi Dharma selaku yayasan penaung. Pertunjukan seni angklung dan paduan suara siswa kelas V turut memeriahkan acara.',
                'thumbnail' => 'https://images.unsplash.com/photo-1523050854058-8df90110c9f1?auto=format&fit=crop&w=600&q=80',
                'created_at' => now()->subDays(8),
            ],
            [
                'id' => 3,
                'kategori' => 'Pengumuman',
                'judul' => 'Pendaftaran Peserta Didik Baru (PPDB) Tahun Ajaran 2026/2027 Telah Dibuka',
                'excerpt' => 'Dapatkan diskon formulir pendaftaran gelombang pertama hingga akhir Juni 2026. Kuota terbatas!',
                'body' => 'SD Perguruan Buddhi secara resmi membuka penerimaan murid baru untuk Tahun Ajaran 2026/2027. Gelombang pertama dibuka mulai 1 Mei hingga 30 Juni 2026 dengan penawaran potongan biaya pembangunan sebesar 20%. Kami menyambut calon siswa untuk bergabung dalam lingkungan belajar yang berkarakter, modern, dan didukung oleh fasilitas digital terlengkap.',
                'thumbnail' => 'https://images.unsplash.com/photo-1427504494785-3a9ca7044f45?auto=format&fit=crop&w=600&q=80',
                'created_at' => now()->subDays(13),
            ],
            [
                'id' => 4,
                'kategori' => 'Prestasi',
                'judul' => 'Juara 1 Lomba Melukis Poster Lingkungan Hidup Tingkat Provinsi',
                'excerpt' => 'Alya Putri, siswi berprestasi kelas 6A, menyabet piala utama dalam kampanye Hari Bumi Jawa Barat.',
                'body' => 'Karya poster bertajuk "Hijaukan Kembali Sekolah Kita" karya Alya Putri dari kelas 6A berhasil terpilih sebagai karya terbaik pertama dalam Lomba Melukis Poster Lingkungan Hidup tingkat provinsi. Kreativitas dan paduan warna cat air yang digunakan Alya mendapat apresiasi tinggi dari dewan juri profesional.',
                'thumbnail' => 'https://images.unsplash.com/photo-1513364776144-60967b0f800f?auto=format&fit=crop&w=600&q=80',
                'created_at' => now()->subDays(18),
            ]
        ];

        $facilities = [
            ['nama' => 'Perpustakaan Digital', 'deskripsi' => 'Akses 5.000+ buku fisik, e-book, dan tablet baca interaktif.', 'ikon' => 'book-open'],
            ['nama' => 'Laboratorium Komputer', 'deskripsi' => '30 unit PC modern berkecepatan tinggi dengan AC lengkap.', 'ikon' => 'monitor'],
            ['nama' => 'Lapangan Olahraga', 'deskripsi' => 'Lapangan futsal, basket, dan badminton yang teduh dan luas.', 'ikon' => 'activity'],
            ['nama' => 'Aula Serbaguna', 'deskripsi' => 'Gedung pertemuan representatif berkapasitas 500 orang.', 'ikon' => 'home'],
            ['nama' => 'Kantin Sehat & Bersih', 'deskripsi' => 'Makanan higienis dengan sistem pembayaran non-tunai.', 'ikon' => 'coffee'],
            ['nama' => 'Unit Kesehatan Sekolah', 'deskripsi' => 'Peralatan pertolongan pertama lengkap dipandu perawat jaga.', 'ikon' => 'heart'],
            ['nama' => 'Mushola Sekolah', 'deskripsi' => 'Sarana ibadah yang bersih, tenang, dan nyaman.', 'ikon' => 'moon'],
            ['nama' => 'CCTV & Keamanan 24/7', 'deskripsi' => 'Pemantauan keamanan di seluruh penjuru sudut sekolah.', 'ikon' => 'shield']
        ];

        return view('public.beranda', compact('newsFeed', 'facilities'));
    }

    public function beritaShow($id)
    {
        // Simple mock route for detailed view of news articles
        $newsFeed = [
            1 => [
                'kategori' => 'Prestasi',
                'judul' => 'SD Perguruan Buddhi Meraih Juara Umum Olimpiade Matematika Kota Tangerang',
                'body' => 'Sebuah kebanggaan luar biasa datang dari tim olimpiade matematika SD Perguruan Buddhi. Dalam ajang Olimpiade Sains Nasional tingkat Kota Tangerang yang diselenggarakan pada tanggal 20 Mei lalu, siswa-siswi kami berhasil meraih Juara Umum dengan menyabet 3 medali emas dan 1 perak. Kepala Sekolah menyatakan bahwa prestasi ini merupakan hasil kerja keras pelatihan intensif selama 6 bulan terakhir bersama para guru pembimbing.',
                'thumbnail' => 'https://images.unsplash.com/photo-1546410531-bb4caa6b424d?auto=format&fit=crop&w=600&q=80',
                'created_at' => now()->subDays(4),
            ],
            2 => [
                'kategori' => 'Kegiatan',
                'judul' => 'Pelepasan & Wisuda Siswa Kelas VI Angkatan Ke-32 Berlangsung Khidmat',
                'body' => 'Sebanyak 124 siswa-siswi kelas VI SD Perguruan Buddhi resmi dinyatakan lulus dalam wisuda Angkatan Ke-32. Acara bertema "Terbang Tinggi Meraih Mimpi, Berbekal Karakter Luhur" ini dihadiri oleh para wali murid, komite sekolah, serta jajaran rektorat Universitas Buddhi Dharma selaku yayasan penaung. Pertunjukan seni angklung dan paduan suara siswa kelas V turut memeriahkan acara.',
                'thumbnail' => 'https://images.unsplash.com/photo-1523050854058-8df90110c9f1?auto=format&fit=crop&w=600&q=80',
                'created_at' => now()->subDays(8),
            ],
            3 => [
                'kategori' => 'Pengumuman',
                'judul' => 'Pendaftaran Peserta Didik Baru (PPDB) Tahun Ajaran 2026/2027 Telah Dibuka',
                'body' => 'SD Perguruan Buddhi secara resmi membuka penerimaan murid baru untuk Tahun Ajaran 2026/2027. Gelombang pertama dibuka mulai 1 Mei hingga 30 Juni 2026 dengan penawaran potongan biaya pembangunan sebesar 20%. Kami menyambut calon siswa untuk bergabung dalam lingkungan belajar yang berkarakter, modern, dan didukung oleh fasilitas digital terlengkap.',
                'thumbnail' => 'https://images.unsplash.com/photo-1427504494785-3a9ca7044f45?auto=format&fit=crop&w=600&q=80',
                'created_at' => now()->subDays(13),
            ],
            4 => [
                'kategori' => 'Prestasi',
                'judul' => 'Juara 1 Lomba Melukis Poster Lingkungan Hidup Tingkat Provinsi',
                'body' => 'Karya poster bertajuk "Hijaukan Kembali Sekolah Kita" karya Alya Putri dari kelas 6A berhasil terpilih sebagai karya terbaik pertama dalam Lomba Melukis Poster Lingkungan Hidup tingkat provinsi. Kreativitas dan paduan warna cat air yang digunakan Alya mendapat apresiasi tinggi dari dewan juri profesional.',
                'thumbnail' => 'https://images.unsplash.com/photo-1513364776144-60967b0f800f?auto=format&fit=crop&w=600&q=80',
                'created_at' => now()->subDays(18),
            ]
        ];

        $berita = (object) ($newsFeed[$id] ?? abort(404));
        return view('public.berita.show', compact('berita'));
    }

    public function fasilitas()
    {
        return view('public.fasilitas');
    }
}
