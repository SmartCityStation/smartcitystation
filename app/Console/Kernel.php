<?php

namespace App\Console;

use App\Models\Backend\DataVariable;
use App\Models\Frontend\Measure;
use Carbon\Carbon;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

/**
 * Class Kernel.
 */
class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('activitylog:clean')->everyMinute();

        // $schedule->command('backup:clean')->daily()->at('01:00');
        // $schedule->command('backup:run')->daily()->at('02:00');  

        $schedule->command('backup:clean')->monthlyOn(1, '01:00');;
        $schedule->command('backup:run')->monthlyOn(1, '02:00');; 
        
        // $schedule->command('db:backup')->daily()->at('01:00');
        // $schedule->command('db:restore')->daily()->at('02:00');

        // $schedule->command('db:backup')->everyMinute();
        // $schedule->command('db:backup')->monthly();


        // This function send the umbral threshold to owner project
        $schedule->call('App\Http\Controllers\Frontend\MeasureController@lookinForAlertEachMinute')->everyMinute();

    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');  

        require base_path('routes/console.php');
    }
}
