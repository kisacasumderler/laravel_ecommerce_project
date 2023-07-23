<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Product::create([
            'image' => 'images/cloth_1.jpg',
            'name' => 'Tank Top Tişört',
            'category_id' => 4,
            'price' => 80,
            'size' => 'L',
            'color' => 'beyaz',
            'short_text' => 'Zamansız Şıklık ve Üstün Konfor: Beyaz Sıfırkol Tişört!',
            'content' => '<p>Beyaz sıfırkol tişörtümüz, zamansız bir klasik olan tişörtler arasında öne çıkıyor. Yumuşak ve nefes alabilen pamuklu kumaşıyla gün boyu konfor sağlarken, sade tasarımıyla şıklığı da beraberinde getiriyor. Hem günlük kullanıma hem de özel etkinliklere uygun olan tişörtümüz, her tarza kolayca uyum sağlıyor. Gardırobunuzun vazgeçilmez parçası olacak beyaz sıfırkol tişörtümüzü hemen keşfedin! </p>',
            'qty' => 100,
            'status' => '1',
        ]);
        Product::create([
            'image' => 'images/cloth_2.jpg',
            'name' => 'Beyaz Erkek Tişört',
            'category_id' => 1,
            'price' => 105,
            'size' => 'L',
            'color' => 'Beyaz',
            'short_text' => 'Beyaz Erkek Tişörtü: Şıklığı ve Tarzı Birleştirin!',
            'content' => '<p>Beuaz erkek tişörtümüz, modern erkeğin gardırobunun vazgeçilmez parçası olacak. Canlı beyaz tonu ve özenle seçilmiş kumaşıyla dikkat çeken bu tişört, hem şıklığı hem de rahatlığı bir arada sunuyor. İster spor bir görünüm isteyin, ister daha şık bir tarz yaratmak isteyin, beyaz erkek tişörtümüz size her durumda eşlik ediyor. Özgün tasarımı ve mükemmel kalitesiyle öne çıkan tişörtümüzü hemen keşfedin ve tarzınıza yeni bir soluk katın!</p>',
            'qty' => 55,
            'status' => '1',
        ]);
        Product::create([
            'image' => 'images/cloth_3.jpg',
            'name' => 'Mavi Erkek Tişört',
            'category_id' => 1,
            'price' => 95,
            'size' => 'XL',
            'color' => 'Mavi',
            'short_text' => 'Mavi Erkek Tişörtü: Şıklığı ve Tarzı Birleştirin!',
            'content' => '<p>Mavi erkek tişörtümüz, modern erkeğin gardırobunun vazgeçilmez parçası olacak. Canlı mavi tonu ve özenle seçilmiş kumaşıyla dikkat çeken bu tişört, hem şıklığı hem de rahatlığı bir arada sunuyor. İster spor bir görünüm isteyin, ister daha şık bir tarz yaratmak isteyin, mavi erkek tişörtümüz size her durumda eşlik ediyor. Özgün tasarımı ve mükemmel kalitesiyle öne çıkan tişörtümüzü hemen keşfedin ve tarzınıza yeni bir soluk katın!</p>',
            'qty' => 55,
            'status' => '1',
        ]);
    }
}
