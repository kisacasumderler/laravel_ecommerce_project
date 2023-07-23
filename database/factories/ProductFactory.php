<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $categoryId = [1,2,3,4,5,6,7,8,9];
        $sizeList = ['XXXL','XXL','XL','L','S','M'];
        $color = ['Beyaz','Siyah','Kırmızı','Kahverengi','Yeşil','Mor'];

        return [
            'image'=>'images/cloth_'.fake()->numberBetween(1,10).'.jpg',
            'name'=>fake()->text(20),
            'category_id'=>$categoryId[random_int(0,8)],
            'price'=>fake()->numberBetween(95,999),
            'size'=>$sizeList[random_int(0,5)],
            'color'=>$color[random_int(0,5)],
            'short_text'=>fake()->text(50),
            'content'=>fake()->text(250),
            'qty'=>fake()->numberBetween(5,150),
            'status'=>'1'
        ];
    }
}
