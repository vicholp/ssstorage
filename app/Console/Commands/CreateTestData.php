<?php

namespace App\Console\Commands;

use App\Models\Collection;
use App\Models\ImageSpec;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateTestData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:testData';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $collection = Collection::create([
            'name' => 'test',
            'slug' => 'test',
            'path' => 'test',

            'webp' => true,
        ]);

        ImageSpec::create([
            'collection_id' => $collection->id,
            'height' => '700',
            'width' => '0',
        ]);

        return 0;
    }
}
