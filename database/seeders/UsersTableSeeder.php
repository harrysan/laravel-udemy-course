<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $usersCount = max((int)$this->command->ask('How many users would you like?', 20), 1);

        //$doe = 
        User::factory()->johndoe()->create();
        //$else = 
        User::factory()->count($usersCount)->create();

        //$users = $else->concat([$doe]);
    }
}
