<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class YoneticiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        db::table('kullanicilar')->insert([
            'adSoyad'=>"admin",
            'seflink'=>"admin",
            'email'=>"admin@gmail.com",
            'password'=>bcrypt(123),
            'durum'=>1,
            'gorev'=>1
        ]);
    }
}
