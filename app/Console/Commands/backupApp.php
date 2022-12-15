<?php

namespace App\Console\Commands;

use File;
use Illuminate\Console\Command;

class backupApp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:backup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Crea la backup de la base de datos';

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
        $path = 'database/migrations/backup/';
        $mysqlExportPath = 'dbsmartcitystationbackup.sql';

        if (!File::isDirectory($path)) {
            File::makeDirectory($path, 0777, true, true);
        }

        $command = "mysqldump -u" . env('DB_USERNAME') . ' -p' . env('DB_PASSWORD') . ' ' . env('DB_DATABASE') . ' measures > ' . $path . $mysqlExportPath;

        $returnVar = NULL;
        $output  = NULL;

        exec($command, $output, $returnVar);
    }
}
