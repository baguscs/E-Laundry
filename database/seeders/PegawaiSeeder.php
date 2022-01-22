<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PegawaiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('pegawais')->insert([
            'role_id' => 1,
            'nama' => "Bagus Cahyo S",
            'alamat' => "Jl. Sawo Bringin Gg: 6 No:35",
            'telpon' => '085128392371',
            'img' => 'bagus.jpg',
            'ijazah' => 'ijazah.pdf',
            'sekolah' => 'SMKN 1 Surabaya',
            'kelamin' => 'Laki-laki',
            'kode' => 'BA1',
            'status' => 'aktif',
            'email' => 'bagus@gmail.com',
        ]); 
    }
}
