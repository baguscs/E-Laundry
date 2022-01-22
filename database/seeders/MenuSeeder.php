<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('menus')->insert([
            'nama' => 'Cuci Setrika',
            'harga' => '10000',
            'status' => 'Aktif',
        ]); 

        DB::table('menus')->insert([
            'nama' => 'Cuci Kering',
            'harga' => '6000',
            'status' => 'Aktif',
        ]);
        DB::table('menus')->insert([
            'nama' => 'Setrika',
            'harga' => '5000',
            'status' => 'Aktif',
        ]);
    }
}
