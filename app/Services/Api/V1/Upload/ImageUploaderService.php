<?php

namespace App\Services\Api\V1\Upload;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ImageUploaderService
{
    protected $disk;

    public function __construct($disk = 's3')
    {
        $this->disk = $disk;
    }

    public function upload($file, $path = 'images')
    {
        // Validação: garantir que o arquivo seja uma imagem
        $this->validateImage($file);

        // Gerar um nome único para o arquivo
        $fileName = uniqid() . '_' . $file->getClientOriginalName();

        // Upload para o sistema de arquivos configurado (S3 neste caso)
        $filePath = $file->storeAs($path, $fileName, ['disk' => $this->disk]);

        // Definir a visibilidade do arquivo como público
        Storage::disk($this->disk)->setVisibility($filePath, 'public');

        // Retorne a url do arquivo no S3
        // return Storage::disk($this->disk)->url($filePath);

        // Retorne o caminho do arquivo no S3
        return $filePath;
    }

    protected function validateImage($file)
    {
        $validator = Validator::make(['file' => $file], [
            'file' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        if ($validator->fails()) {
            abort(422, $validator->errors()->first());
        }
    }
}
