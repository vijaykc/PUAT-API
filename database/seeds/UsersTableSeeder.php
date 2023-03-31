<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Model::unguard();
        DB::table('users')->delete();

        factory(App\User::class)->create([
            'name' => 'deniro',
            'email' => 'emaduro@denirostaff.com',
            'password' => password_hash('xpOULe8y4q', PASSWORD_BCRYPT)
        ]);

        Model::reguard();
    }
}
