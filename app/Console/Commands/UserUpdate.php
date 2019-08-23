<?php

namespace App\Console\Commands;

use App\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class UserUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:passwd';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update Password for user';

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
        do {
            $email = $this->ask('ENTER: EMAIL FOR USER');
        } while ($email === null);

        do {
            do {
                $password = $this->secret('ENTER: NEW PASSWORD FOR USER');
            } while ($password === null);
            do {
                $confirm = $this->secret('CONFIRM: PASSWORD FOR USER');
            } while ($confirm === null);

            if (strcasecmp($confirm, $password) !== 0) {

                $this->error("ERROR: PASSWORDS NOT MATCH");
            }

        } while (strcasecmp($confirm, $password) !== 0);


        if ($user = User::where('email', $email)->first()) {
            $user->password = Hash::make($password);
            $user->save();

            $this->warn(strtoupper($user) . "'S PASSWORD UPDATE SUCCESFULL");
            $this->info("EMAIL: $email");
            $this->info("PASSWORD: *********");
        } else {

            $this->error(strtoupper($user) . " DO NOT EXIST");
        }

    }
}
