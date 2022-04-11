<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
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
        $this->command->info('Token - '.$token->plainTextToken);

        $this->call([
            EquipmentTypesSeeder::class,
        ]);
    }
}
