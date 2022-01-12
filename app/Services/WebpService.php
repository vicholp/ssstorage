<?php

namespace App\Services;

use Symfony\Component\Process\Process;

/**
 * Class WebpService
 * @package App\Services
 */
class WebpService
{
    static public function create($file, $spec)
    {
        $base_name = $file->name;

        $file_name = pathinfo($base_name, \PATHINFO_FILENAME);
        $file_extesion = pathinfo($base_name, \PATHINFO_EXTENSION);

        $old_path = "{$file->path}/{$base_name}";
        $new_path = "{$file->path}/{$file_name}_{$spec->width}_{$spec->height}.webp";

        $process = new Process([base_path('cwebp'), "-resize", $spec->width, $spec->height, $old_path, "-o", $new_path, "-quiet"]);
        $process->run();

        if (!$process->isSuccessful()) {
            dd($process->getErrorOutput());
        }

        return $new_path;
    }
}
