<?php

namespace App\Utils\Concerns\Models;


use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

trait ServiceImageConcern
{

    /**
     * @param $image
     * @param string $imageTitle
     * @param string $folderPath
     * @param $oldImagePath
     * @param null $moduleName
     * @return mixed|string
     */
    private function uploadThumbImage($image, string $imageTitle, string $folderPath, $oldImagePath, $moduleName = null)
    {

        if (!$image) return $oldImagePath;

        request()->validate([
            'image' => 'mimes:jpg,png,jpeg,gif|max:' . config('admin.max_upload_size')
        ]);

        $imageQuality = config('admin.image_quality.' . $moduleName) ?? null;
        $extension = $imageQuality ? 'jpg' : $image->extension();
        $imageName = str_replace(['.jpg', '.jpeg', '.png', '.JPEG'], '', $imageTitle) . '.' . $extension;
        if ($imageQuality) {
            $fileFullPath = $folderPath . '/' . $imageName;
            $resizedImage = Image::make($image);
            $resizedImage->resize(255, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            Storage::put($fileFullPath, (string)$resizedImage->encode('jpg', $imageQuality));
            return $imageName;
        }
        Storage::putFileAs($folderPath, $image, $imageName);
        dd('aa');
        return $imageName;
    }


}
