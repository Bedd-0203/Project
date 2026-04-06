<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Sda;
use App\Models\News;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ── 1. HAPUS DATA LAMA ──────────────────────────────────────────
        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Sda::truncate();
        News::truncate();
        Category::truncate();
        User::truncate();
        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // ── 2. USERS ────────────────────────────────────────────────────
        $admin = User::create([
            'name'     => 'Admin SDA Palembang',
            'email'    => 'admin@sda.palembang.go.id',
            'password' => Hash::make('admin123'),
            'role'     => 'admin',
        ]);

        User::create([
            'name'     => 'Petugas Dinas LH',
            'email'    => 'petugas@sda.palembang.go.id',
            'password' => Hash::make('petugas123'),
            'role'     => 'petugas',
        ]);

        User::create([
            'name'     => 'Warga Palembang',
            'email'    => 'warga@gmail.com',
            'password' => Hash::make('warga123'),
            'role'     => 'masyarakat',
        ]);

        // ── 3. KATEGORI (hanya 3) ───────────────────────────────────────
        $cat1 = Category::create([
            'name'        => 'Pertanian, Kehutanan & Perikanan',
            'description' => 'Data pertanian, perkebunan, kehutanan, sungai, dan perikanan di wilayah Kota Palembang.',
        ]);

        $cat2 = Category::create([
            'name'        => 'Pertambangan & Lingkungan Hidup',
            'description' => 'Data pertambangan, mineral, dan pengelolaan lingkungan hidup Kota Palembang.',
        ]);

        $cat3 = Category::create([
            'name'        => 'Energi & Air',
            'description' => 'Sumber daya energi terbarukan dan pengelolaan sumber daya air Kota Palembang.',
        ]);

        // ── 4. DATA SDA ─────────────────────────────────────────────────
        $sdaData = [
            // Kategori 1 - Pertanian, Kehutanan & Perikanan
            [
                'title'       => 'Sawah Produktif Seberang Ulu Palembang',
                'description' => 'Areal persawahan produktif seluas 1.250 hektar di Kecamatan Seberang Ulu dengan komoditas utama padi varietas Ciherang dan IR64. Hasil panen rata-rata mencapai 5,2 ton per hektar per musim tanam.',
                'location'    => 'Kec. Seberang Ulu I, Palembang',
                'category_id' => $cat1->id,
            ],
            [
                'title'       => 'Hutan Lindung Punti Kayu Palembang',
                'description' => 'Kawasan hutan lindung seluas 50 hektar yang menjadi paru-paru kota Palembang. Hutan ini dihuni berbagai satwa liar endemik Sumatera dan menjadi destinasi wisata alam edukasi.',
                'location'    => 'Kec. Sukarami, Palembang',
                'category_id' => $cat1->id,
            ],
            [
                'title'       => 'Potensi Perikanan Sungai Musi',
                'description' => 'Sungai Musi sebagai sumber daya perikanan utama Kota Palembang dengan hasil tangkap ikan air tawar rata-rata 45 ton per bulan. Komoditas unggulan meliputi ikan Belida, Gabus, dan Patin.',
                'location'    => 'Sungai Musi, Palembang',
                'category_id' => $cat1->id,
            ],
            [
                'title'       => 'Perkebunan Karet Rakyat Gandus',
                'description' => 'Perkebunan karet rakyat seluas 320 hektar yang dikelola oleh 215 kepala keluarga di Kecamatan Gandus. Produksi lateks mencapai 2,1 ton per hektar per tahun.',
                'location'    => 'Kec. Gandus, Palembang',
                'category_id' => $cat1->id,
            ],

            // Kategori 2 - Pertambangan & Lingkungan Hidup
            [
                'title'       => 'Deposit Pasir Sungai Musi',
                'description' => 'Deposit pasir kuarsa dan pasir sungai di sepanjang aliran Sungai Musi dengan potensi volume diperkirakan mencapai 2,5 juta meter kubik. Pengelolaan dilakukan sesuai regulasi lingkungan yang berlaku.',
                'location'    => 'Sepanjang Sungai Musi, Palembang',
                'category_id' => $cat2->id,
            ],
            [
                'title'       => 'Tempat Pembuangan Akhir Sukawinatan',
                'description' => 'Pengelolaan sampah dan limbah padat di TPA Sukawinatan seluas 32 hektar menggunakan sistem controlled landfill. Kapasitas tampung 500 ton sampah per hari dengan fasilitas pengolahan leachate.',
                'location'    => 'Kec. Sukarami, Palembang',
                'category_id' => $cat2->id,
            ],

            // Kategori 3 - Energi & Air
            [
                'title'       => 'Instalasi Pengolahan Air Bersih Karang Anyar',
                'description' => 'IPA Karang Anyar berkapasitas 200 liter per detik melayani lebih dari 120.000 jiwa warga Palembang. Sumber air baku berasal dari Sungai Musi dengan teknologi pengolahan mutakhir.',
                'location'    => 'Kec. Gandus, Palembang',
                'category_id' => $cat3->id,
            ],
            [
                'title'       => 'PLTS Atap Gedung Pemerintah Kota',
                'description' => 'Pemasangan panel surya di 12 gedung pemerintahan Kota Palembang dengan total kapasitas 250 kWp. Program ini ditargetkan menghemat konsumsi listrik sebesar 30% dan mengurangi emisi CO2 hingga 180 ton per tahun.',
                'location'    => 'Pusat Kota Palembang',
                'category_id' => $cat3->id,
            ],
        ];

        foreach ($sdaData as $data) {
            Sda::create($data);
        }

        // ── 5. BERITA ───────────────────────────────────────────────────
        $newsData = [
            [
                'title'   => 'Potensi SDA Palembang Meningkat Signifikan di 2026',
                'content' => 'Pemerintah Kota Palembang mencatat peningkatan signifikan dalam pengelolaan sumber daya alam sepanjang tahun 2025. Total produksi pertanian meningkat 18% dibandingkan tahun sebelumnya, sementara kualitas air Sungai Musi mengalami perbaikan berkat program revitalisasi yang konsisten. Wali Kota Palembang menyatakan komitmen untuk terus meningkatkan transparansi pengelolaan SDA melalui Portal SDA ini.',
                'user_id' => $admin->id,
            ],
            [
                'title'   => 'Pengelolaan Sungai Musi: Program Bersih Sungai 2026',
                'content' => 'Dinas Lingkungan Hidup Kota Palembang resmi meluncurkan Program Bersih Sungai Musi 2026 yang melibatkan lebih dari 5.000 relawan dari berbagai elemen masyarakat. Program ini mencakup pembersihan sampah, pemantauan kualitas air, dan sosialisasi kepada warga bantaran sungai. Target utama adalah menjadikan Sungai Musi sebagai ikon wisata air yang bersih dan lestari pada tahun 2027.',
                'user_id' => $admin->id,
            ],
            [
                'title'   => 'Festival Ikan Belida: Lestarikan Fauna Ikonik Palembang',
                'content' => 'Festival Ikan Belida kembali digelar di bantaran Sungai Musi sebagai upaya pelestarian ikan endemik yang menjadi simbol kuliner khas Palembang, pempek. Kegiatan ini menampilkan pameran budidaya ikan Belida, lomba memasak pempek, dan seminar konservasi. Dinas Perikanan mencatat populasi ikan Belida di Sungai Musi mulai menunjukkan tren pemulihan.',
                'user_id' => $admin->id,
            ],
            [
                'title'   => 'Palembang Raih Penghargaan Kota Hijau 2025',
                'content' => 'Kota Palembang berhasil meraih penghargaan Kota Hijau kategori Pengelolaan Ruang Terbuka Hijau Terbaik dari Kementerian LHK. Penghargaan ini diraih berkat program penanaman 50.000 pohon di sepanjang Sungai Musi dan kawasan perkotaan. Total RTH Palembang kini mencapai 28% dari luas wilayah, melampaui target nasional sebesar 20%.',
                'user_id' => $admin->id,
            ],
        ];

        foreach ($newsData as $data) {
            News::create($data);
        }

        $this->command->info('✓ Seeder berhasil! 3 kategori, ' . count($sdaData) . ' SDA, ' . count($newsData) . ' berita.');
    }
}
