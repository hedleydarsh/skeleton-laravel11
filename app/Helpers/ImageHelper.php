<?php

use App\Services\Api\V1\Upload\ImageUploaderService;

if (!function_exists('uploadImage')) {
    /**
     * Faz upload de uma imagem usando a classe ImageUploader.
     *
     * @param \Illuminate\Http\UploadedFile $file
     * @param string $path
     * @param string $disk
     * @return string
     */
    function uploadImage($file, $path = 'images', $disk = 's3')
    {
        $uploader = new ImageUploaderService($disk);
        return $uploader->upload($file, $path);
    }
}
