<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use stdClass;

class Install extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install script in webserver';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    private $e;

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        $this->info("WELCOME TO WHMSYS INSTALLATION:");

        Artisan::call('optimize');
        sleep(2);

        if (!file_exists(base_path('.env'))) {

            $this->e = new stdClass();
            $this->install();
        } else {

            return $this->error("SYSTEM ALREADY INSTALLED");
        }

        Artisan::call('key:generate');
        Artisan::call('optimize');
        sleep(1);

        $this->info("");
        $this->info("PLEASE WAIT...");
        sleep(2);

        $this->info("");
        $this->info("!! SYSTEM WAS INSTALLED SUCCESSFULLY !!");

        $this->info("");
        $this->info("PLEASE CHECK LOGIN PATH:");

        $this->info($this->e->login);

    }

    private function setDatabase()
    {
        do {
            $this->e->dataset = $this->choice('ENTER: DATABASE DRIVER', ['mysql', 'pgsql'], 'mysql');
        } while ($this->e->dataset === null);
        do {
            $this->e->database = $this->ask('ENTER: DATABASE HOST');
        } while ($this->e->database === null);
        do {
            $this->e->port = $this->ask('ENTER: DATABASE PORT');
        } while ($this->e->port === null);
        do {
            $this->e->name = $this->ask('ENTER: DATABASE NAME');
        } while ($this->e->name === null);

        do {
            $this->e->username = $this->ask('ENTER: DATABASE USERNAME');
        } while ($this->e->username === null);

        do {
            $this->e->password = $this->secret('ENTER: DATABASE PASSWORD');
        } while ($this->e->password === null);
    }

    private function setMailDriver()
    {
        do {
            $this->e->mail = $this->choice('ENTER: MAIL DRIVER', ['mail', 'smtp'], 'mail');
        } while ($this->e->mail === null);

        if ($this->e->mail !== 'mail') {
            do {
                $this->e->mailhost = $this->ask('ENTER: MAIL HOST');
            } while ($this->e->mailhost === null);
            do {
                $this->e->mailport = $this->ask('ENTER: MAIL PORT');
            } while ($this->e->mailport === null);
            do {
                $this->e->mailuser = $this->ask('ENTER: MAIL NAME');
            } while ($this->e->mailuser === null);
            do {
                $this->e->mailpass = $this->secret('ENTER: MAIL PASSWORD');
            } while ($this->e->mailpass === null);
            do {
                $this->e->enctype = $this->choice('ENTER: MAIL ENCTYPE', ['tls', 'ssl'], 'tls');
            } while ($this->e->enctype === null);
        }

    }

    private function setEnv()
    {
        $env = <<<EOF
APP_VERSION=1.0
APP_NAME=Whmsys
APP_ENV=local
APP_LOGIN={$this->e->path}
APP_KEY=
APP_DEBUG=true
APP_SSL=true
APP_URL={$this->e->domain}

LOG_CHANNEL=stack

DB_CONNECTION={$this->e->dataset}
DB_HOST={$this->e->database}
DB_PORT={$this->e->port}
DB_DATABASE={$this->e->name}
DB_USERNAME={$this->e->username}
DB_PASSWORD="{$this->e->password}"

BROADCAST_DRIVER=log
CACHE_DRIVER=file
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
SESSION_LIFETIME=120
EOF;
        if (isset($this->e->mail)) {
            $env .= <<<EOF
MAIL_DRIVER={$this->e->mail}
MAIL_HOST={$this->e->mailhost}
MAIL_PORT={$this->e->mailport}
MAIL_USERNAME={$this->e->mailuser}
MAIL_PASSWORD={$this->e->mailpass}
MAIL_ENCRYPTION={$this->e->enctype}
EOF;

        }

        Storage::disk('base')->put('.env', $env);
    }

    private function install()
    {
        do {
            $this->e->domain = $this->ask('ENTER: DOMAIN NAME (http://)');
        } while ($this->e->domain === null);

        $this->setDatabase();

        if ($this->confirm('DO YOU WANT TO SET MAIL DRIVER?')) {
            $this->setMailDriver();
        }

        $this->e->path = md5(Str::random(8));
        $this->e->login = rtrim($this->e->domain, '/') . '/' . $this->e->path;

        $this->setEnv();
    }
}
