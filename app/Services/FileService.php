<?php

namespace App\Services;

use App\Jobs\HandleNewFile;
use App\Models\Collection;
use App\Models\File;
use App\Models\ImageSpec;
use App\Models\Upload;
use App\Models\UploadFile;
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

    static public function newFiles(Array $files, Array $data) : Upload
    {
        $upload = Upload::create();

        foreach ($files as $file){
            $upload_file_mode = $upload->uploadFiles()->create([
                'result' => 'pending',
                'filename' => $file->getClientOriginalName(),
            ]);

            self::newFile($file, $upload_file_mode, $data);
        }

        return $upload->load('uploadFiles');
    }

    static private function newFile(UploadedFile $file, UploadFile $model, Array $data) : void
    {
        $data['file_name'] = pathinfo($file->getClientOriginalName(), \PATHINFO_FILENAME);
        $data['file_extension'] = $file->getClientOriginalExtension();
        $data['disk'] = "public";
        $data['upload_file_id'] = $model->id;

        $file_path = Storage::disk('temp')->putFile('/', $file);

        $relative_path = 'temp/'.$file_path;

        HandleNewFile::dispatch($relative_path, $data);

        $model->result = 'waiting';
        $model->save();
    }

    static public function storeFile(string $old_path, Array $data) : void
    {
        $collection = Collection::find($data['collection_id']);

        $file_basename = $data['file_name'].'.'.$data['file_extension'];
        $file_dirname = $data['disk'].'/'.$collection->getPath();
        $new_path = $file_dirname.'/'.$file_basename;

        $model = UploadFile::find($data['upload_file_id']);

        if (Storage::disk('local')->exists($new_path)){
            Storage::disk('local')->delete($new_path);
            Storage::disk('local')->move($old_path, $new_path);

            $model->result = 'replaced';
        }else{
            Storage::disk('local')->move($old_path, $new_path);

            $model->result = 'stored';
        }

        $model->save();

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
