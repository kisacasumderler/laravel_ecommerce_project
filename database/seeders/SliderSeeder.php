<?php

namespace Database\Seeders;

use App\Models\Slider;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SliderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Slider::create([
            'image'=>'images/hero_1.jpg',
            'MobileImage'=>'images/mobile_slider.jpg',
            'name'=>'Stilinizi Yansıtan Ayakkabıları Keşfedin',
            'content'=>'Ayakkabılarınızla tarzınızı yansıtın! Alışveriş sayfamızda en yeni trendleri keşfedin ve stilinizi tamamlayacak ayakkabıları bulun.',
            'link'=>'urunler',
            'status'=>'1'
        ]);
    }
}
