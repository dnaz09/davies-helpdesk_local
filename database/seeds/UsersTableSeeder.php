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
        // DB::table('users')->truncate();
       	$user1 = [
        	'first_name' => 'Chase',
        	'middle_initial' => 'T',
        	'last_name' => 'Admin',
        	'username' => 'chaseadmin',
        	'position' => 'GOVERNANCE',
        	'employee_number' => 'chase2017',
        	'email' => 'chaseadmin@gmail.com',
        	'password' => bcrypt('password'),
            'dept_id' => 7,
            'image' => '',
            'mystatus' => 'active',
            'role_id' => 4,
        	'email_pass' => 'password',
        	'cellno' => '09269814196',
        	'localno' => '1231231',
            'company' => 'DAVIES PAINT',
            'location_id' => 14,
            'active' => 1,
            'super_admin' => 1,
            'online'=> 0,
            'superior'=>0
        ];

        User::create($user1);
    }
}

