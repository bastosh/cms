<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\Role;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		$user = new User;
		$user->name = 'Jacques Tati';
		$user->email = 'jacques@tati.com';
		$user->password = bcrypt('jactati');
		$user->save();
		$user->roles()->attach(Role::where('name', 'user')->first());

		$admin = new User;
		$admin->name = 'Tim Berners-Lee';
		$admin->email = 'tim@inter.net';
		$admin->password = bcrypt('internet');
		$admin->save();
		$admin->roles()->attach(Role::where('name', 'admin')->first());
    }
}
