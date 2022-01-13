<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Symfony\Component\Process\Process;

/**
 * Class WebpService
 * @package App\Services
 */
class WebpService
{
    static public function create($file, $spec)
    {
        $file_name = $file->name;

        $old_path = Storage::path($file->getRelativePath());
        $relative_new_path = $file->path.'/'.$file_name."_{$spec->width}_{$spec->height}.webp";
        $new_path = Storage::path($relative_new_path);

        $process = new Process([base_path('cwebp'), "-resize", $spec->width, $spec->height, $old_path, "-o", $new_path, "-quiet"]);
        $process->run();

        if (! $process->isSuccessful()) {
            dd($process->getErrorOutput());
        }

        return $relative_new_path;
    }

}
