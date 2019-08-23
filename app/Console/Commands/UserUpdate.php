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
                $password = $this->ask('ENTER: NEW PASSWORD FOR USER');
            } while ($password === null);
            do {
                $confirm = $this->ask('CONFIRM: PASSWORD FOR USER');
            } while ($confirm === null);
        } while (strcasecmp($confirm, $password) === 0);


        if ($user = User::where('email', $email)->first()) {
            $user->password = Hash::make($password);
            $user->save();

            $this->warn("Command succesfull => $user");
            $this->info("Email: $email");
            $this->info("Password: $password");
        } else {

            $this->error("$email not found in database");
        }

    }
}
