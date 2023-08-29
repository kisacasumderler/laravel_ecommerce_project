<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $erkek = Category::create([
            'name'=>'Erkek',
            'content'=>'Erkek Giyim',
            'cat_ust'=>null,
            'status'=>'1',
        ]);
        Category::create([
            'name'=>'Kazak',
            'content'=>null,
            'cat_ust'=>$erkek->id,
            'status'=>'1',
        ]);

        Category::create([
            'name'=>'Pantolon',
            'content'=>null,
            'cat_ust'=>$erkek->id,
            'status'=>'1',
        ]);

        $kadin = Category::create([
            'name'=>'Kadın',
            'content'=>'Kadın Giyim',
            'cat_ust'=>null,
            'status'=>'1',
        ]);

        Category::create([
            'name'=>'tişört',
            'content'=>null,
            'cat_ust'=>$kadin->id,
            'status'=>'1',
        ]);

        Category::create([
            'name'=>'Çanta',
            'content'=>null,
            'cat_ust'=>$kadin->id,
            'status'=>'1',
        ]);

        $cocuk = Category::create([
            'name'=>'Çocuk',
            'content'=>'Çocuk Giyim',
            'cat_ust'=>null,
            'status'=>'1',
        ]);

        Category::create([
            'name'=>'ayakkabı',
            'content'=>null,
            'cat_ust'=>$cocuk->id,
            'status'=>'1',
        ]);

    }
}
