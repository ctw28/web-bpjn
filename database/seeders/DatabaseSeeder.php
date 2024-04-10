<?php

namespace Database\Seeders;

use App\Models\Grup;
use App\Models\Menu;
use App\Models\User;
use App\Models\AturGrup;
use App\Models\JenisKonten;
use App\Models\PengaturanWeb;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

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
            ['user_id' => 1, 'nama' => 'Berita', 'kategori' => 'ARTIKEL', 'deskripsi' => 'Daftar berita website'],
            ['user_id' => 1, 'nama' => 'Profil', 'kategori' => 'ARTIKEL', 'deskripsi' => 'Profil website'],
            ['user_id' => 1, 'nama' => 'Peraturan', 'kategori' => 'FILE', 'deskripsi' => 'Daftar peraturan pada website'],
            ['user_id' => 1, 'nama' => 'Download', 'kategori' => 'FILE', 'deskripsi' => 'Daftar download pada website'],
        ];

        foreach ($dtdef as $dt) {
            JenisKonten::create([
                'user_id' => $dt['user_id'],
                'nama' => $dt['nama'],
                'kategori' => $dt['kategori'],
                'deskripsi' => $dt['deskripsi'],
            ]);
        }

        //untuk menu
        $dtdef = [
            ['user_id' => 1, 'urut' => 1, 'nama' => 'Dashboard', 'url' => '/dashboard'],
            ['user_id' => 1, 'urut' => 2, 'nama' => 'Profil', 'url' => 'javascript:;'],
            ['user_id' => 1, 'urut' => 1, 'nama' => 'Publikasi', 'url' => 'javascript:;'],

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

        //untuk grup
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
    }
}
