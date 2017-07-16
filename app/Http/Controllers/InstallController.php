<?php

namespace App\Http\Controllers;

use App\Http\Requests\SetupDatabaseRequest;
use App\Http\Requests\SetupGeneralRequest;
use App\Http\Requests\SetupServiceRequest;
use App\Mail\TestMail;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;

class InstallController extends Controller {

    /**
     * Create a new controller instance.
     */
    public function __construct(){}

    /**
     * Initial setup page
     *
     * @return \Illuminate\View\View
     */
    public function setup() {
        $aStep = collect([]);
        Artisan::call('key:generate');
        session(['steps' => $aStep->toArray()]);
        $is_writable_conf = true;
        $openssl = true;
        $doveadm = true;
        $private_key = null;
        $public_key = null;

        try{
            // Configuration settings for the key
            $config = array(
                "digest_alg" => "sha512",
                "private_key_bits" => 4096,
                "private_key_type" => OPENSSL_KEYTYPE_RSA,
            );

            // Create the private and public key
            $res = openssl_pkey_new($config);

            // Extract the private key into $private_key
            openssl_pkey_export($res, $private_key);

            // Extract the public key into $public_key
            $public_key = openssl_pkey_get_details($res);
            $public_key = $public_key["key"];
        }catch(\ErrorException $e){
            $openssl = false;
        }

        try{
            $password = exec('doveadm pw -s PLAIN -p POSTFIXADM 2>&1');
            if($password != '{PLAIN}POSTFIXADM') $doveadm = false;
        }catch(\ErrorException $e){
            $doveadm = false;
        }

        try{
            ob_start();
            var_export([
                'serial_number' => str_random(64),
                'encryption' => [
                    'private_key' => $private_key,
                    'public_key'  => $public_key,
                ]
            ]);
            $content = ob_get_contents();
            ob_end_clean();

            File::put(config_path().'/postfixadm.php', "<?php\nreturn ".$content.';');
        }catch(\ErrorException $e){
            $is_writable_conf = false;
        }

        return view('installer.setup', [
            'aStep' => $aStep,
            'is_writable' => File::isWritable(base_path().'/.env'),
            'is_writable_conf' => $is_writable_conf,
            'openssl' => $openssl,
            'doveadm' => $doveadm,
            'lock_writable' => File::isWritable(base_path().'/installer.lock'),
        ]);
    }

    /**
     * Get the general settings setup page
     *
     * @return \Illuminate\View\View
     */
    public function getGeneralSetup() {
        $aStep = collect(session('steps', []));
        $aStep->put('general', 'general');
        session(['steps' => $aStep->toArray()]);

        return view('installer.general', [
            'step' => 'general',
            'aStep' => $aStep
        ]);
    }

    /**
     * Save the posted general settings payload
     *
     * @param SetupGeneralRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postGeneralSetup(SetupGeneralRequest $request) {

        /*
         * Test the MySQL connection
         */
        try{
            mysqli_connect($request->get('DB_HOST'),$request->get('DB_USERNAME'),$request->get('DB_PASSWORD'),$request->get('DB_DATABASE'),$request->get('DB_PORT'));
        }catch(\ErrorException $e){

            dd($e);
        }

        $aStep = collect(session('steps', []));

        /*
         * Check the MySQL connection failed and redirect back if it failed
         */
        if (mysqli_connect_errno()) {
            $aRequest = $request->all();
            $aRequest['mysql_error'] = mysqli_connect_errno();
            $aStep = $aStep->except('database');
            session(['steps' => $aStep->toArray()]);
            return redirect()->back()->withInput($aRequest);
        }

        try{
            config(['mail.driver' => $request->get('MAIL_DRIVER')]);
            config(['mail.host' => $request->get('MAIL_HOST')]);
            config(['mail.port' => $request->get('MAIL_PORT')]);
            config(['mail.username' => $request->get('MAIL_USERNAME')]);
            config(['mail.password' => $request->get('MAIL_PASSWORD')]);
            config(['mail.encryption' => $request->get('MAIL_ENCRYPTION')]);
            config(['mail.from.address' => $request->get('MAIL_FROM_ADDRESS')]);
            config(['mail.from.name' => $request->get('MAIL_FROM_NAME')]);
            Mail::to([$request->get('MAIL_FROM_ADDRESS')])->send(new TestMail('PostfixADM mail configuration test'));
        }catch(\Exception $e){
            $aRequest = $request->all();

            $error = explode('[', $e->getMessage());
            $aRequest['mail_error'] = $error[0];

            $aStep = $aStep->except('database');
            session(['steps' => $aStep->toArray()]);
            return redirect()->back()->withInput($aRequest);
        }

        /*
         * Add the given parameters to the application environment
         */
        File::append(base_path().'/.env', "
APP_DEBUG=".$request->get('APP_DEBUG')."
APP_LOG_LEVEL=".$request->get('APP_LOG_LEVEL')."
APP_URL=".$request->get('APP_URL')."
DB_CONNECTION=".$request->get('DB_CONNECTION')."
DB_HOST=".$request->get('DB_HOST')."
DB_PORT=".$request->get('DB_PORT')."
DB_DATABASE=".$request->get('DB_DATABASE')."
DB_USERNAME=".$request->get('DB_USERNAME')."
DB_PASSWORD=".$request->get('DB_PASSWORD')."
MAIL_DRIVER=".$request->get('MAIL_DRIVER')."
MAIL_HOST=".$request->get('MAIL_HOST')."
MAIL_PORT=".$request->get('MAIL_PORT')."
MAIL_USERNAME=".$request->get('MAIL_USERNAME')."
MAIL_PASSWORD=".$request->get('MAIL_PASSWORD')."
MAIL_ENCRYPTION=".$request->get('MAIL_ENCRYPTION')."
");

        $config = config('postfixadm');
        $config['encryption']['method'] = $request->get('encryption');
        ob_start();
        var_export($config);
        $content = ob_get_contents();
        ob_end_clean();
        File::put(config_path().'/postfixadm.php', "<?php\nreturn ".$content.';');

        $aStep = collect(session('steps', []));
        $aStep->put('database', 'database');
        session(['steps' => $aStep->toArray()]);

        return redirect()->to('/installer/database');
    }

    /**
     * @return \Illuminate\View\View
     */
    public function getDatabaseSetup(){

        $matrix = [];
        $tables = DB::select('SHOW TABLES');
        foreach($tables as $table){
            $tmpTable = (array) $table;
            $table = current($tmpTable);
            $matrix[] = [
                'table'     => $table,
                'columns'   => Schema::getColumnListing($table)
            ];
        }

        $aStep = collect(session('steps', []));
        $aStep->put('database', 'database');
        $aStep->put('general', 'general');
        session(['steps' => $aStep->toArray()]);

        return view('installer.database', [
            'aStep'  => $aStep,
            'matrix' => $matrix,
        ]);
    }

    /**
     * @param SetupDatabaseRequest $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function postDatabaseSetup(SetupDatabaseRequest $request){

        $mapping = json_decode($request->get('mapping'), true);

        $config = [];
        foreach($mapping as $kind => $map){
            $config[$kind] = [
                'table' => $map['table'],
                'columns' => []
            ];
            foreach(collect($map)->except('table') as $column => $conf){

                if($conf['join']['status'] == true && (
                    isset($conf['join_key']) && isset($conf['join_value']) ?
                        $conf['join_key'] != null && $conf['join_value'] != null : false
                    )){

                    if(preg_match('/null\-.*/', $conf['column']) == false && $conf['column'] != '' && $conf['column'] != null) {
                        $config[$kind]['columns'][$column] = [
                            'column' => str_replace($map['table'].'$', '', $conf['column']),
                            'join' => [
                                'table' => $conf['join']['table'],
                                'key'   => str_replace($conf['join']['table'].'$', '', $conf['join_key']),
                                'value' => str_replace($conf['join']['table'].'$', '', $conf['join_value']),
                            ]
                        ];
                    }else{
                        $config[$kind]['columns'][$column] = false;
                    }
                }elseif(isset($conf['column'])){
                    if(preg_match('/null\-.*/', $conf['column']) == false && $conf['column'] != '' && $conf['column'] != null) {
                        $config[$kind]['columns'][$column] = [
                            'column' => str_replace($map['table'] . '$', '', $conf['column'])
                        ];
                    }else{
                        $config[$kind]['columns'][$column] = false;
                    }
                }else{
                    $config[$kind]['columns'][$column] = false;
                }
            }
        }

        $errors = collect([]);
        foreach($config as $map){
            if(isset($map['table'])){
                if($map['table'] != 'null' && $map['table'] != null){
                    $db = DB::table($map['table']);
                    foreach($map['columns'] as $column => $conf){
                        if($conf != false){
                            try{
                                $db->select($conf['column'])->first();
                                if(isset($conf['join'])){
                                    $db->join(
                                        $conf['join']['table'],
                                        $map['table'].'.'.$conf['column'],
                                        '=',
                                        $conf['join']['table'].'.'.$conf['join']['key'])
                                    ->select($conf['join']['table'].'.'.$conf['join']['value'])
                                    ->first();
                                }
                            }catch(QueryException $e){
                                $errors->push($e->getMessage());
                            }
                        }
                    }
                }
            }
        }

        if(env('DB_MAPPING', false) == false){
            File::append(base_path().'/.env', "DB_MAPPING=".json_encode($config)."\n");
        }

        $aStep = collect(session('steps', []));
        if($errors->count() == 0){
            $aStep->put('database', 'database');
            $aStep->put('general', 'general');
            session(['steps' => $aStep->toArray()]);
        }

        return view('installer.database_check', [
            'aStep'  => $aStep,
            'aError' => $errors
        ]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getServices() {

        $aStep = collect(session('steps', []));
        $aStep->put('general', 'general');
        $aStep->put('database', 'database');
        $aStep->put('completed', 'completed');
        session(['steps' => $aStep->toArray()]);

        $config = json_decode(env('DB_MAPPING'), true);

        if(env('DB_MIGRATED', false) == false){

            $tables = DB::select('SHOW TABLES');
            $aTable = collect([]);
            foreach($tables as $table) {
                $tmpTable = (array)$table;
                $table = current($tmpTable);
                $aTable->put($table, [
                    'table'     => $table,
                    'columns'   => collect(Schema::getColumnListing($table))
                ]);
            }

            if($aTable->has('pfa_users') == false):
                Schema::create('pfa_users', function (Blueprint $table) {
                    $table->increments('id');
                    $table->string('name');
                    $table->string('email')->unique();
                    $table->string('password');
                    $table->string('google2fa_secret')->nullable();
                    $table->boolean('super_user')->default(0);
                    $table->rememberToken();
                    $table->timestamps();
                });
            endif;

            if($aTable->has('pfa_domain_user') == false):
                Schema::create('pfa_domain_user', function (Blueprint $table) {
                    $table->increments('id');
                    $table->integer('domain_id')->unsigned();
                    $table->integer('user_id')->unsigned();
                    $table->timestamps();
                });
            endif;

            if($aTable->has('pfa_logs') == false):
                Schema::create('pfa_logs', function (Blueprint $table) {
                    $table->increments('id');
                    $table->integer('user_id')->nullable();
                    $table->text('message');
                    $table->timestamps();
                });
            endif;

            /*
             * MAILBOX MIGRATION
             */
            if($config['mailbox']['table'] == null || $config['mailbox']['table'] == 'null'){
                if($aTable->has('pfa_mailboxes') == false):
                    Schema::create('pfa_mailboxes', function (Blueprint $table) use($config) {
                        $table->increments('id');

                        $table->integer('domain_id');
                        $table->string('email');
                        $table->string('password');
                        $table->integer('quota_kb');
                        $table->boolean('active')->default(0);
                        $table->string('domain');

                        $table->timestamps();
                    });
                endif;
            }else{
                if($aTable->has($config['mailbox']['table']) == true):
                    Schema::table($config['mailbox']['table'], function (Blueprint $table) use($config, $aTable) {

                        $dbTable = collect($aTable->get($config['mailbox']['table']));
                        /** @var Collection $columns */
                        $columns = $dbTable != null ? $dbTable->get('columns') : collect([]);
                        if($columns->contains('id') == false) $table->increments('id');

                        if($columns->contains('domain') == false && $config['mailbox']['columns']['domain'] == false) $table->integer('domain');
                        if($columns->contains('email') == false && $config['mailbox']['columns']['email'] == false) $table->string('email');
                        if($columns->contains('password') == false && $config['mailbox']['columns']['password'] == false) $table->string('password');
                        if($columns->contains('quota_kb') == false && $config['mailbox']['columns']['quota_kb'] == false) $table->integer('quota_kb');
                        if($columns->contains('active') == false && $config['mailbox']['columns']['active'] == false) $table->boolean('active')->default(0);

                        if($columns->contains('created_at') == false) $table->timestamp('created_at')->nullable();
                        if($columns->contains('updated_at') == false) $table->timestamp('updated_at')->nullable();
                    });
                endif;
            }

            /*
             * ALIAS MIGRATION
             */
            if($config['alias']['table'] == null || $config['alias']['table'] == 'null'){
                if($aTable->has('pfa_aliases') == false):
                    Schema::create('pfa_aliases', function (Blueprint $table) use($config) {
                        $table->increments('id');

                        $table->integer('domain_id');
                        $table->string('source');
                        $table->longText('destination');
                        $table->boolean('active')->default(0);

                        $table->timestamps();
                    });
                endif;
            }else{
                if($aTable->has($config['alias']['table']) == true):
                    Schema::table($config['alias']['table'], function (Blueprint $table) use($config, $aTable) {

                        $dbTable = collect($aTable->get($config['alias']['table']));
                        /** @var Collection $columns */
                        $columns = $dbTable != null ? $dbTable->get('columns') : collect([]);
                        if($columns->contains('id') == false) $table->increments('id');

                        if($columns->contains('domain') == false && $config['alias']['columns']['domain'] == false) $table->integer('domain');
                        if($columns->contains('source') == false && $config['alias']['columns']['source'] == false) $table->string('source');
                        if($columns->contains('destination') == false && $config['alias']['columns']['destination'] == false) $table->longText('destination');
                        //if($config['alias']['columns']['active'] == false)        $table->boolean('active')->default(0);

                        if($columns->contains('created_at') == false) $table->timestamp('created_at')->nullable();
                        if($columns->contains('updated_at') == false) $table->timestamp('updated_at')->nullable();
                    });
                endif;
            }

            /*
             * DOMAIN MIGRATION
             */
            if($config['domain']['table'] == null || $config['domain']['table'] == 'null'){
                if($aTable->has('pfa_domains') == false):
                    Schema::create('pfa_domains', function (Blueprint $table) use($config) {
                        $table->increments('id');

                        $table->string('name');
                        $table->boolean('active')->default(0);

                        $table->timestamps();
                    });
                endif;
            }else{
                if($aTable->has($config['domain']['table']) == true):
                    Schema::table($config['domain']['table'], function (Blueprint $table) use($config, $aTable) {

                        $dbTable = collect($aTable->get($config['domain']['table']));
                        /** @var Collection $columns */
                        $columns = $dbTable != null ? $dbTable->get('columns') : collect([]);
                        if($columns->contains('id') == false) $table->increments('id');

                        if($columns->contains('name') == false && $config['domain']['columns']['name'] == false) $table->string('name');
                        if($columns->contains('active') == false && $config['domain']['columns']['active'] == false) $table->boolean('active')->default(0);

                        if($columns->contains('created_at') == false) $table->timestamp('created_at')->nullable();
                        if($columns->contains('updated_at') == false) $table->timestamp('updated_at')->nullable();
                    });
                endif;
            }

            File::append(base_path().'/.env', "DB_MIGRATED=true\n");
        }

        return view('installer.service', [
            'aStep'  => $aStep,
            'lock_failed'  => false
        ]);
    }

    /**
     * @param SetupServiceRequest $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function postServices(SetupServiceRequest $request) {

        if(env('QUOTA_SERVICE', null) == null){
            File::append(base_path().'/.env', "QUOTA_SERVICE=".($request->get('quota') == true?'true':'false')."\n");
        }

        $postfixadm = config('postfixadm');
        $postfixadm['quota'] = [
            'enabled' => $request->get('quota') == true,
            'url'   => $request->get('quota_url'),
            'token' => $request->get('quota_token')
        ];
        ob_start();
        var_export($postfixadm);
        $content = ob_get_contents();
        ob_end_clean();

        File::put(config_path().'/postfixadm.php', "<?php\nreturn ".$content.';');

        if(User::where('email', $request->get('email'))->first() == null){
            User::create([
                'name'   => $request->get('name'),
                'email'  => $request->get('email'),
                'password' => bcrypt($request->get('password')),
                'super_user' => true,
            ]);
        }

        return redirect()->to('/installer/finish');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function getFinish(){
        try {
            if(File::exists(base_path().'/installer.lock')) unlink(base_path().'/installer.lock');
            File::append(base_path().'/.env', "INSTALLED=true\n");
        }catch(\ErrorException $e){
            return view('installer.finish', [
                'aStep'  => collect(session('steps', [])),
                'lock_failed'  => true
            ]);
        }

        return redirect()->to('/login');
    }
}