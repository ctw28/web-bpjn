<?php

namespace Database\Seeders;

use App\Models\Grup;
use App\Models\Menu;
use App\Models\User;
use App\Models\File;
use App\Models\Konten;
use App\Models\AturGrup;
use App\Models\Komentar;
use App\Models\Publikasi;
use App\Models\JenisKonten;
use App\Models\LikeDislike;
use App\Models\PengaturanWeb;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
// use Faker\Provider\File;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //untuk admin
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@app.com', //email login
            'password' => Hash::make('00000000'), // password default login 
        ]);

        //untuk pengguna
        for ($i = 1; $i <= 9; $i++) {
            User::create([
                'name' => 'Pengguna ' . $i,
                'email' => 'pengguna' . $i . '@app.com', //email login
                'password' => Hash::make('00000000'), // password default login 
            ]);
        }

        //untuk jenis konten
        $dtdef = [
            ['user_id' => 1, 'nama' => 'Profil', 'slug' => 'profil', 'kategori' => 'ARTIKEL', 'deskripsi' => 'Profil website'],
            ['user_id' => 1, 'nama' => 'Berita', 'slug' => 'berita', 'kategori' => 'ARTIKEL', 'deskripsi' => 'Daftar berita website'],
            ['user_id' => 1, 'nama' => 'Peraturan', 'slug' => 'peraturan', 'kategori' => 'FILE', 'deskripsi' => 'Daftar peraturan pada website'],
            ['user_id' => 1, 'nama' => 'Download', 'slug' => 'download', 'kategori' => 'FILE', 'deskripsi' => 'Daftar download pada website'],
        ];

        foreach ($dtdef as $dt) {
            JenisKonten::create([
                'user_id' => $dt['user_id'],
                'nama' => $dt['nama'],
                'slug' => $dt['slug'],
                'kategori' => $dt['kategori'],
                'deskripsi' => $dt['deskripsi'],
            ]);
        }

        //untuk menu
        $dtdef = [
            ['user_id' => 1, 'urut' => 1, 'nama' => 'Halaman Depan', 'url' => '/'],
            ['user_id' => 1, 'urut' => 2, 'nama' => 'Profil', 'url' => 'javascript:;'],
            ['user_id' => 1, 'urut' => 3, 'nama' => 'Publikasi', 'url' => 'javascript:;'],
            ['user_id' => 1, 'urut' => 4, 'nama' => 'Login', 'url' => '/login'],

            ['user_id' => 1, 'urut' => 1, 'nama' => 'Visi Misi', 'url' => '/visimisi', 'menu_id' => 2],
            ['user_id' => 1, 'urut' => 2, 'nama' => 'Sejarah', 'url' => '/sejarah', 'menu_id' => 2],
            ['user_id' => 1, 'urut' => 3, 'nama' => 'Struktur Organisasi', 'url' => '/struktur-organisasi', 'menu_id' => 2],

            ['user_id' => 1, 'urut' => 1, 'nama' => 'Berita', 'url' => '/berita', 'menu_id' => 3],
            ['user_id' => 1, 'urut' => 2, 'nama' => 'Pengumuman', 'url' => '/pengumuman', 'menu_id' => 3],
            ['user_id' => 1, 'urut' => 3, 'nama' => 'Download', 'url' => '/download', 'menu_id' => 3],
            ['user_id' => 1, 'urut' => 4, 'nama' => 'Peraturan', 'url' => '/peraturan', 'menu_id' => 3],
        ];

        foreach ($dtdef as $dt) {
            $import = [
                'user_id' => $dt['user_id'],
                'nama' => $dt['nama'],
                'urut' => $dt['urut'],
                'url' => $dt['url'],
            ];
            if (isset($dt['menu_id']))
                $import['menu_id'] = $dt['menu_id'];

            Menu::create($import);
        }

        //untuk grup
        $dtdef = [
            ['user_id' => 1, 'nama' => 'Administrator'],
            ['user_id' => 1, 'nama' => 'Editor'],
            ['user_id' => 1, 'nama' => 'Pengguna'],
        ];

        foreach ($dtdef as $dt) {
            Grup::create([
                'user_id' => $dt['user_id'],
                'nama' => $dt['nama'],
            ]);
        }

        //untuk pengaturan web
        PengaturanWeb::create([
            'user_id' => 1,
            'nama' => 'Website Institut',
            'deskripsi' => 'Institut kami memiliki website resmi yang digunakan untuk mempublikasikan konten atau kegiatan pada institusi kami',
            'alamat' => 'Jalan Sultan Diponegoro No. 17 Kendari, Sulawesi Tenggara',
            'helpdesk' => '(wa call only) 0852235361763, (wa chat only) 085435263544',
            'keywords' => 'Institut Website Resmi',
            'email' => 'institut@mail.com',
        ]);

        //untuk atur grup
        $dtdef = [
            ['user_id' => 1, 'grup_id' => 1],
            ['user_id' => 1, 'grup_id' => 2],
            ['user_id' => 1, 'grup_id' => 3],
            ['user_id' => 2, 'grup_id' => 2],
            ['user_id' => 3, 'grup_id' => 3],
            ['user_id' => 4, 'grup_id' => 3],
            ['user_id' => 5, 'grup_id' => 3],
        ];

        foreach ($dtdef as $dt) {
            AturGrup::create([
                'user_id' => $dt['user_id'],
                'grup_id' => $dt['grup_id'],
            ]);
        }

        //untuk konten
        $dtdef = [
            ['user_id' => 1, 'jenis_konten_id' => 1, 'judul' => 'Visi Misi Kantor', 'waktu' => date('Y-m-d H:i:s'), 'isi' => '<p>Visi misi instansi ini adalah</p>'],
            ['user_id' => 1, 'jenis_konten_id' => 1, 'judul' => 'Sejarah', 'waktu' => date('Y-m-d H:i:s'), 'isi' => '<p>sejarah instansi ini dimulai dari</p>'],
            ['user_id' => 1, 'jenis_konten_id' => 1, 'judul' => 'Struktur Organisasi', 'waktu' => date('Y-m-d H:i:s'), 'isi' => '<p>Struktur Organisasi berdasarkan peraturan yang berlaku sebagai berikut</p>'],
            ['user_id' => 1, 'jenis_konten_id' => 2, 'judul' => 'Launching Website Resmi Instansi', 'waktu' => date('Y-m-d H:i:s'), 'isi' => '<p>Alhamdulillah pada hari  ini ' . date('w') . 'tanggal ' . date('d F Y') . ' website instansi ini telah resmi diluncurkan. semoga bermanfaat</p>'],
            ['user_id' => 1, 'jenis_konten_id' => 2, 'judul' => 'Buka Puasa Bersama', 'waktu' => date('Y-m-d H:i:s'), 'isi' => '<p>Kantor kami melaksanakan buka puasa bersama di auditorium yang diikuti oleh semua pegawai</p>'],
            ['user_id' => 1, 'jenis_konten_id' => 2, 'judul' => 'Launching Website Resmi Instansi', 'waktu' => date('Y-m-d H:i:s'), 'isi' => '<p>Pelantikan pejabat baru pada kantor ini telah dilaksanakan pada tanggal ' . date('d F Y') . ', kegiatan ini berlangsung sangat khidmat karena hampir dihadiri oleh seluruh unsur pegawai</p>'],
        ];

        foreach ($dtdef as $dt) {
            Konten::create([
                'user_id' => $dt['user_id'],
                'jenis_konten_id' => $dt['jenis_konten_id'],
                'judul' => $dt['judul'],
                'waktu' => $dt['waktu'],
                'isi' => $dt['isi'],
                'slug' => generateSlug($dt['judul'], $dt['waktu']),
            ]);
        }

        for ($i = 1; $i <= 4; $i++)
            Publikasi::create([
                'user_id' => 1,
                'konten_id' => $i,
                'is_publikasi' => 1,
            ]);

        Publikasi::create([
            'user_id' => 1,
            'konten_id' => 5,
            'is_publikasi' => 0,
            'catatan' => 'konten ini sudah terbit sebelumnya',
        ]);

        for ($i = 1; $i <= 5; $i++)
            Komentar::create([
                'user_id' => 1,
                'is_publikasi' => rand(1, 0),
                'nama' => 'pengunjung-' . $i,
                'komentar' => 'bagus, saya suka konten beritanya, terima kasih',
                'konten_id' => rand(1, 3),
            ]);

        Komentar::create([
            'user_id' => 1,
            'nama' => 'pengunjung-' . $i,
            'komentar' => 'bagus, saya suka konten beritanya, terima kasih',
            'konten_id' => rand(1, 4),
        ]);


        for ($i = 1; $i < 15; $i++)
            LikeDislike::create([
                'kategori' => 'KONTEN',
                'konten_id' => rand(1, 3),
            ]);

        //untuk file
        $dtdef = [
            ['user_id' => 1, 'jenis_konten_id' => 3, 'judul' => 'Formulir Pendaftaran', 'waktu' => date('Y-m-d H:i:s')],
            ['user_id' => 1, 'jenis_konten_id' => 3, 'judul' => 'Buku Pedoman Pegawai', 'waktu' => date('Y-m-d H:i:s')],
            ['user_id' => 1, 'jenis_konten_id' => 3, 'judul' => 'SBU Tahun 2024', 'waktu' => date('Y-m-d H:i:s')],
            ['user_id' => 1, 'jenis_konten_id' => 4, 'judul' => 'SOP Penerimaan Pegawai', 'waktu' => date('Y-m-d H:i:s')],
            ['user_id' => 1, 'jenis_konten_id' => 4, 'judul' => 'SK Pendirian Kantor', 'waktu' => date('Y-m-d H:i:s')],
            ['user_id' => 1, 'jenis_konten_id' => 4, 'judul' => 'SK Pedoman Kenaikan Pangkat', 'waktu' => date('Y-m-d H:i:s')],
        ];

        foreach ($dtdef as $i => $dt) {
            File::create([
                'user_id' => $dt['user_id'],
                'jenis_konten_id' => $dt['jenis_konten_id'],
                'judul' => $dt['judul'],
                'waktu' => $dt['waktu'],
                'path' => 'uploads/file/sampel-' . $i . ".pdf",
                'slug' => generateSlug($dt['judul'], $dt['waktu']),
            ]);
        }

        for ($i = 1; $i <= 2; $i++)
            Publikasi::create([
                'user_id' => 1,
                'file_id' => $i,
                'is_publikasi' => 1,
            ]);

        for ($i = 3; $i <= 4; $i++)
            Publikasi::create([
                'user_id' => 1,
                'file_id' => $i,
                'is_publikasi' => 0,
                'catatan' => 'ditolak, ini catatan publikasi file ke-' . $i,
            ]);

        for ($i = 1; $i <= 5; $i++) {
            Komentar::create([
                'user_id' => 1,
                'is_publikasi' => rand(1, 0),
                'nama' => 'pengunjung file ke-' . $i,
                'komentar' => 'file ke ' . $i . ' nya  bagus, terima kasih',
                'file_id' => rand(1, 4),
            ]);
        }

        Komentar::create([
            'user_id' => 1,
            'nama' => 'pengunjung-' . $i,
            'komentar' => 'bagus file downloadnya, terima kasih',
            'file_id' => rand(1, 4),
        ]);
    }
}
