<?php

namespace App\Services;

use App\Models\Collection;
use App\Models\File;
use App\Models\ImageSpec;

/**
 * Class FileService
 * @package App\Services
 */
class FileService
{
    static private $allowed_mime_types = [
        'image/jpeg',
        'image/png',
    ];

    static public function newFiles($files, $collection_id)
    {
        $collection = Collection::with('imageSpecs')->find($collection_id);

        foreach ($files as $file){
            self::newFile($file, $collection);
        }

    }

    static private function newFile($file, Collection $collection)
    {
        $path = $collection->getPath();

        $file_model = self::storeFile($file, $path, $collection);

        $contentType = mime_content_type($file_model->path());

        if (in_array($contentType, self::$allowed_mime_types)) {
            self::convertImage($file_model);
        }
    }

    static public function storeFile($file, $path, $collection) : File
    {
        $base_name = $file->getClientOriginalName();

        $final_path = $file->storeAs($path, $base_name, 'public');

        return File::updateOrCreate([
            'name' => $base_name,
            'path' => storage_path('app/public/'.$path),
        ], [
            'collection_id' => $collection->id,
        ]);
    }

    static private function convertImage(File $image)
    {
        $collection = $image->collection;
        foreach ($collection->imageSpecs as $spec){
            $path = WebpService::create($image, $spec);

            $base_name = pathinfo($path, \PATHINFO_BASENAME);
            $dir_name = pathinfo($path, \PATHINFO_DIRNAME);
            File::updateOrCreate([
                'name' => $base_name,
                'path' => $dir_name,
                'file_id' => $image->id,
            ], [
                'collection_id' => $collection->id,
            ]);
        }
    }
}
