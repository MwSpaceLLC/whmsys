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
            $email = $this->ask('What is the email');

        } while ($email === null);

        do {
            $password = $this->secret('What is the new password?');

        } while ($password === null);

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
