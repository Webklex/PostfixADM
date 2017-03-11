<?php
/*
 * File: ArtisanUpdate.php
 * Category: Command
 * Author: mgoldenbaum
 * Created: 12.12.2015 13:08
 * Updated: -
 *
 * Description:
 *  -
 */

namespace App\Console\Commands;

class ArtisanUpdate extends BaseCommand {
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = "update
                            {--init : init the required folders}
                            {--git : Update the git repository}
                            {--composer : Run composer}
                            {--migrate : Run the migration}
                            {--seed : Run the seeder}
                            ";

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Update the laravel instance";

    /**
     * Create a new command instance.
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
        $start = microtime(true);
        $this->line('');
        $this->info('Updating the System - Please wait a second or two..');

        if($this->option('git')){
            $this->line('');
            $this->info('Updating the GIT repository');
            echo exec('git pull');
            $this->info('');
        }

        if($this->option('composer')){
            $this->line('');
            $this->info('Updating all dependencies');
            echo exec('composer update');
            $this->call('optimize');
        }

        if($this->option('init')){
            $this->line('');
            $this->info('Creating required folders..');

            $this->line(exec('[ -d '.storage_path().'/fonts ] && echo "Fonts directory already exists" || (mkdir '.storage_path().'/fonts && echo "Fonts directory created")'));
            $this->line(exec('[ -d '.base_path().'/resources/lang ] && echo "Language directory already exists" || (mkdir '.base_path().'/resources/lang && echo "Language directory created")'));
            $this->line(exec('[ -d '.base_path().'/bootstrap/cache ] && echo "Cache directory already exists" || (mkdir '.base_path().'/bootstrap/cache && echo "Cache directory created")'));
            $this->line(exec('[ -d '.storage_path().'/framework/views ] && echo "Views directory already exists" || (mkdir '.storage_path().'/framework/views && echo "Views directory created")'));
            $this->line(exec('[ -d '.storage_path().'/framework/cache ] && echo "Cache directory already exists" || (mkdir '.storage_path().'/framework/cache && echo "Cache directory created")'));

            $this->line('');
            $this->info('Setting required rights..');
            $this->line(exec('chmod 777 '.storage_path().'/fonts  && echo "Fonts directory rights set"'));
            $this->line(exec('chmod 777 '.storage_path().'/logs/laravel.log  && echo "Log file rights set"'));
            $this->line(exec('chmod 777 '.storage_path().'/framework/views  && echo "Views directory rights set"'));
            $this->line(exec('chmod 777 '.storage_path().'/framework/sessions && echo "Session directory rights set"'));
            $this->line(exec('chmod 777 -R '.storage_path().'/framework/cache && echo "Cache directory rights set"'));
            $this->line(exec('chmod 777 -R '.base_path().'/resources/lang  && echo "Language direcory rights set"'));
            $this->line(exec('chmod 777 -R '.base_path().'/bootstrap/cache && echo "Cache directory rights set"'));
        }

        $this->line('');
        $this->info('Cleaning up..');
        $this->call('clear-compiled');
        try{
            exec('composer dump-autoload  2>&1', $outputAndErrors, $return_value);
            foreach($outputAndErrors as $msg){
                $this->info($msg);
            }
        }catch(\Exception $e){
            $this->error($e->getMessage());
        }

        $this->line('');
        $this->call('view:clear');
        $this->call('cache:clear');
        $this->call('route:cache');

        if($this->option('migrate')){
            $this->line('');
            $this->info('Migrating the system..');
            $this->call('migrate');
            $this->call('cache:clear');
        }

        if($this->option('seed')){
            $this->line('');
            $this->info('Seeding the system..');
            $this->call('db:seed');
        }

        $this->line('');
        $this->info('Restarting queue..');
        $this->call('queue:restart');

        $this->line('');

        $runTime = microtime(true)-$start;
        $this->info('Update process has ben completed in '.number_format(($runTime>60?$runTime/60:$runTime),2).' '.($runTime>60?'minutes':'seconds'));
    }
}
