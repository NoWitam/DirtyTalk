<?php

namespace App\Console\Commands;

use App\Enums\UserRoleEnum;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:user {name} {password=123}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create user';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        
        User::create([
            'name' => $this->argument('name'),
            'email' => $this->argument('name') . "@user.com",
            'password' => Hash::make($this->argument('password')),
            'role' => UserRoleEnum::USER
        ]);
    }
}
