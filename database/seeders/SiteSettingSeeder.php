<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use \App\Models\SiteSetting;

class SiteSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SiteSetting::create([
            'name'=>'address',
            'data'=>'Kızılay Mahallesi, Atatürk Bulvarı No: 123 / Çankaya, Ankara',
        ]);
        SiteSetting::create([
            'name'=>'phone',
            'data'=>'+90 212 123 4567',
        ]);
        SiteSetting::create([
            'name'=>'email',
            'data'=>'kisacasumderler@yandex.com',
        ]);
        SiteSetting::create([
            'name'=>'harita',
            'data'=>null,
        ]);
    }
}
