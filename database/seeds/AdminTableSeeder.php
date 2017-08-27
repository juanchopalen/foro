<?php

use Illuminate\Database\Seeder;

class AdminTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\User::class)->create([
            'first_name' =>'Juan',
            'last_name' => 'Palencia',
            'username' => 'klaustro',
            'email' => 'juanchopalen@gmail.com',      
            'role' => 'admin'  	
        ]);
    }
}
