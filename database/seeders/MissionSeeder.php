<?php

namespace Database\Seeders;

use App\Models\Mission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class MissionSeeder extends Seeder
{
    public function run(): void
    {
        $missions = [
            ['Bring Your Tumbler', 1, 50, 'Kebiasaan', 'Gunakan botol minum isi ulang untuk mengganti satu minuman kemasan.', 'Tunjukkan tumbler saat diisi atau digunakan.'],
            ['Trash in Its Place', 1, 75, 'Kebiasaan', 'Pilah sampah yang kamu hasilkan dan buang ke tempat yang sesuai.', 'Tunjukkan jenis sampah dan tempat pemilahannya.'],
            ['Clean Your Corner', 1, 100, 'Kebiasaan', 'Bersihkan satu sudut ruang belajar atau lingkungan rumahmu.', 'Dokumentasikan area yang sudah dibersihkan.'],
            ['Say No to Plastic', 1, 75, 'Daur ulang', 'Gunakan tas, wadah, atau alat makan pakai ulang saat berbelanja.', 'Tunjukkan alternatif plastik yang kamu gunakan.'],
            ['Plastic Hunter', 2, 100, 'Daur ulang', 'Kumpulkan sampah plastik di area sekitar dan pilah untuk disalurkan.', 'Tunjukkan hasil pemilahan plastik.'],
            ['Waste Bank Hero', 2, 150, 'Daur ulang', 'Setorkan sampah terpilah ke bank sampah.', 'Dokumentasikan sampah terpilah saat disetorkan.'],
            ['Zero Waste Lunch', 2, 125, 'Kebiasaan', 'Siapkan bekal dengan wadah dan alat makan yang dapat digunakan kembali.', 'Tunjukkan perlengkapan makan dan hasil kegiatanmu.'],
            ['Reuse Challenge', 2, 100, 'Daur ulang', 'Ubah benda bekas menjadi barang dengan fungsi baru.', 'Tunjukkan benda dan jelaskan perubahan fungsinya.'],
            ['Eco Walk', 3, 200, 'Kebiasaan', 'Ganti satu perjalanan pendek dengan berjalan kaki.', 'Dokumentasikan perjalanan dan jelaskan rutenya secara umum.'],
            ['Green Community Day', 3, 250, 'Komunitas', 'Ikut dalam kegiatan lingkungan yang diadakan komunitas.', 'Tunjukkan tugas yang kamu kerjakan selama kegiatan.'],
            ['Recycling Champion', 3, 200, 'Daur ulang', 'Olah bahan daur ulang menjadi produk yang dapat dipakai.', 'Tunjukkan proses atau hasil pengolahan.'],
            ['Eco Education', 3, 150, 'Komunitas', 'Bagikan pengetahuan lingkungan melalui sesi belajar singkat.', 'Tunjukkan materi atau kegiatan edukasi.'],
            ['Lead a Clean-Up', 4, 350, 'Komunitas', 'Koordinasikan aksi bersih-bersih bersama peserta lain.', 'Dokumentasikan kegiatan dan jelaskan tugas koordinasimu.'],
            ['Waste Audit', 4, 300, 'Proyek', 'Catat jenis dan jumlah sampah dari satu area, lalu usulkan perbaikan.', 'Tunjukkan catatan audit dan rangkum temuanmu.'],
            ['Green Action Week', 4, 400, 'Komunitas', 'Ajak kelompokmu menjalankan kebiasaan ramah lingkungan selama satu minggu.', 'Pilih dokumentasi yang mewakili pekan kegiatan dan rangkum hasilnya.'],
            ['Eco Change Maker', 5, 500, 'Proyek', 'Jalankan inisiatif lingkungan yang bisa dilanjutkan orang lain.', 'Tunjukkan hasil awal dan rencana keberlanjutan.'],
            ['Green Campus Project', 5, 750, 'Proyek', 'Kerjakan proyek yang memperbaiki pengelolaan lingkungan kampus.', 'Tunjukkan pelaksanaan dan ringkas dampaknya.'],
            ['Sustainability Hero', 5, 600, 'Proyek', 'Evaluasi satu program lingkungan berkelanjutan dan bagikan hasilnya.', 'Tunjukkan bukti pelaksanaan dan indikator perubahan.'],
        ];

        foreach ($missions as [$title, $level, $xp, $category, $description, $instructions]) {
            Mission::firstOrCreate(['seed_key' => Str::slug($title)], [
                'title' => $title,
                'required_level' => $level,
                'xp_reward' => $xp,
                'category' => $category,
                'description' => $description,
                'evidence_instructions' => $instructions,
            ]);
        }
    }
}
