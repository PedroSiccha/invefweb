<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $editor = User::create([
            'name' => 'editor',
            'email' => 'editor@gmail.com',
            'password' => bcrypt('123456')
        ]);

        $editor->assignRole('Editor');

        $admin = User::create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('123456')
        ]);

        $admin->assignRole('Admin');
    }
}
