<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

/**
 * Trait UploadAble
 * @package App\Traits
 */
trait UploadAble
{
    /**
     * @param UploadedFile $file
     * @param null $folder
     * @param string $disk
     * @param null $filename
     * @return false|string
     */
    public function uploadOne(UploadedFile $file, $folder = null, $disk = 's3', $filename = null)
    {
        $name = !is_null($filename) ? $filename : str_random(25);

        return Storage::disk($disk)->put('house-finder/'.$folder, $file);
    }

    /**
     * @param null $path
     * @param string $disk
     */
    public function deleteOne($path = null, $disk = 's3')
    {   
        $url_count = strlen(env('AWS_URL'));
        $trim_path = substr($path, $url_count);
       
        Storage::disk($disk)->delete($trim_path);
    }
}
