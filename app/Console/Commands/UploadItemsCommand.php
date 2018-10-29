<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\{
    Item,
    ItemType,
    RarityClass,
};

class UploadItemsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'items:upload {folder}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'uploading artworks (heroes)';

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
     * @return mixed
     */
    public function handle()
    {
        $folder = $this->argument('folder');
        
    }
    
}
