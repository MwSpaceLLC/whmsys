<?php

namespace App\Console\Commands;

use App\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserCreator extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:user {email}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate user with random password';

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

        $username = ucfirst(explode('@', $email)[0]);
        $password = Str::random(8);
        $user = new User;
        $user->name = $username;
        $user->email = $email;
        $user->password = Hash::make($password);

        if (!User::where('email', $user->email)->first()) {

            $user->save();
            $this->warn("Command succesfull => $user");
            $this->info("Username: $username");
            $this->info("Email: $email");
            $this->info("Password: $password");

        } else {
            $this->error("$username already exist in Database");
        }

    }
}
