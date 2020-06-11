<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;
use App\User;

class NewUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:new';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new user';

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
        $firstName = $this->ask('First Name');
        $lastName = $this->ask('Last Name');
        $email = $this->ask('Email Address');
        $password = Hash::make($this->secret('Password'));

        $user = new User();
        $user -> first_name = $firstName;
        $user -> last_name = $lastName;
        $user -> email = $email;
        $user -> password = $password;
        $user -> save();

        $token = $user -> createToken('token');

        $this->info('API Token: '.$token -> plainTextToken);
    }
}
