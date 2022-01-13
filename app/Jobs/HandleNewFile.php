<?php

namespace App\Jobs;

use App\Models\Collection;
use App\Services\FileService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\UploadedFile;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class HandleNewFile implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private string $file_path;
    private Array $data;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(string $file_path, Array $data)
    {
        $this->file_path = $file_path;
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        FileService::storeFile($this->file_path, $this->data);
    }
}
