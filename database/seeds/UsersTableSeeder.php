<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use TCG\Voyager\Models\Role;
use TCG\Voyager\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     *
     * @return void
     */
    public function run()
    {
        if (User::count() == 0) {
            $role = Role::where('name', 'admin')->firstOrFail();

            User::create([
                'mobile_number'  => '929194872',
                'email'          =>  'abdudlh1@gmail.com',
                'password'       => bcrypt('Abdu/123'),
                'last_login_ip'  => '127.0.0.1',
                'last_login_device_info' => 'ADMIN_CREATION',
                'remember_token' => Str::random(60),
                'role_id'        => $role->id,
            ]);
        }
    }
}
