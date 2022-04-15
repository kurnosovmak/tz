<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class UserCreateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create new user and auth ';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        if(User::count()<1){
            User::create([
                'name'=>'admin',
                'email'=>'admin',
                'email_verified_at'=>now(),
                'password'=>Hash::make('admin'),
            ]);

        }
        $token = User::first()->createToken('api', ['*']);
        $this->info('Token - '.$token->plainTextToken);

        return 0;
    }
}
