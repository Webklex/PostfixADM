<?php
/*
 * File: BaseCommand.php
 * Category: Command
 * Author: MSG
 * Created: 17.12.2015 10:56
 * Updated: -
 *
 * Description:
 *  -
 */

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class BaseCommand extends Command {
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = "command:cmd {param : description}";

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Command description";

    protected $logFile = '';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(){
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(){
        //$this->info("");
        //$this->error("");
        //$this->argument("param")
    }

    public function error($str,$verbosity = null){
        parent::error($str);
        Log::error($str);
    }

    public function info($str,$verbosity = null){
        parent::info($str);
        Log::info($str);
        /*Log::emergency($str);
        Log::alert($str);
        Log::critical($str);
        Log::error($str);
        Log::warning($str);
        Log::notice($str);
        Log::debug($str);*/
    }

    public function line($str, $style = null, $verbosity = null){
        parent::line($str);
        if(str_replace(' ', '', $str) != ''){
            Log::notice($str);
        }
    }
}

