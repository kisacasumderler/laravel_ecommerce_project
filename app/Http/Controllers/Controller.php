<?php

namespace App\Http\Controllers;

use App\Models\ImageMedia;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function fileSave($modelName = null, $filename, $request, $data, $name = 'image')
    {
        $pathOriginal = 'images/' . $filename . '/';
        klasorac($pathOriginal);

        $image = $request->file($name);
        $imageArr = [];

        $imageUrl = ImageMedia::where('model_name', $modelName)->where('table_id', $data->id)->first();

        if (!empty($imageUrl->data)) {
            foreach ($imageUrl->data as $defaultImg) {
                $defaultImg['vitrin'] = 0;
                $imageArr[] = $defaultImg;
            }
        }

        $resimgelen = uploadimage($image, $pathOriginal, $pathOriginal, 850);

        $imageArr[] = [
            'image_no' => time(),
            'image' => $resimgelen['orj'],
            'thumbnail' => $resimgelen['thum'],
            'alt' => '',
            'status' => '1',
            'vitrin' => 0
        ];

        $lastIndex = count($imageArr) - 1;
        $imageArr[$lastIndex]['vitrin'] = 1;

        ImageMedia::updateOrCreate(
            [
                'table_id' => $data->id,
                'model_name' => $modelName,
            ],
            [
                'table_id' => $data->id,
                'model_name' => $modelName,
                'data' => $imageArr
            ]
        );
    }

}
