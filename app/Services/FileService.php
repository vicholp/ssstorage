<?php

namespace App\Services;

use App\Jobs\HandleNewFile;
use App\Models\Collection;
use App\Models\File;
use App\Models\ImageSpec;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use League\Flysystem\FileExistsException;

/**
 * Class FileService
 * @package App\Services
 */
class FileService
{
    static private $webp_supported_mime_types = [
        'image/jpeg',
        'image/png',
    ];

    static public function newFiles(Array $files, Array $data) : void
    {
        foreach ($files as $file){
            self::newFile($file, $data);
        }
    }

    static private function newFile(UploadedFile $file, Array $data) : void
    {
        $data['file_name'] = pathinfo($file->getClientOriginalName(), \PATHINFO_FILENAME);
        $data['file_extension'] = $file->getClientOriginalExtension();
        $data['disk'] = "public";

        $file_path = Storage::disk('temp')->putFile('/', $file);

        $relative_path = 'temp/'.$file_path;

        HandleNewFile::dispatch($relative_path, $data);
    }

    static public function storeFile(string $old_path, Array $data) : void
    {
        $collection = Collection::find($data['collection_id']);

        $file_basename = $data['file_name'].'.'.$data['file_extension'];
        $file_dirname = $data['disk'].'/'.$collection->getPath();
        $new_path = $file_dirname.'/'.$file_basename;

        try{
            Storage::disk('local')->move($old_path, $new_path);
        }catch(FileExistsException $e){
            Storage::disk('local')->delete($old_path);
        }

        $file = File::updateOrCreate([
            'name' => $data['file_name'],
            'extension' => $data['file_extension'],
            'path' => $file_dirname,
        ], [
            'collection_id' => $collection->id,
        ]);

        self::transform($file);
    }

    static private function transform(File $file) : void
    {
        $contentType = mime_content_type($file->getAbsolutePath());

        if (in_array($contentType, self::$webp_supported_mime_types)) {
            self::convertToWebp($file);
        }
    }

    static private function convertToWebp(File $image) : void
    {
        $collection = $image->collection;
        foreach ($collection->imageSpecs as $spec){
            $path = WebpService::create($image, $spec);

            $file_filename = pathinfo($path, \PATHINFO_FILENAME);
            $file_dirname = pathinfo($path, \PATHINFO_DIRNAME);
            $file_extension = pathinfo($path, \PATHINFO_EXTENSION);

            File::updateOrCreate([
                'name' => $file_filename,
                'path' => $file_dirname,
                'extension' => $file_extension,
                'file_id' => $image->id,
            ], [
                'collection_id' => $collection->id,
            ]);
        }
    }
}
