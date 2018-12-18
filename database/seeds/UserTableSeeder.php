<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::updateOrCreate(
            ['email' => 'jill@harvard.edu', 'name' => 'Jill Harvard'],
            ['password' => Hash::make('helloworld')
            ]);

        $user = User::updateOrCreate(
            ['email' => 'jamal@harvard.edu', 'name' => 'Jamal Harvard'],
            ['password' => Hash::make('helloworld')
            ]);
    }
}
