<?php
namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Admin Admin',
            'email' => 'admin@admin.com',
            'id_rol' => 2,
            'id_type_identification' => 1,
            'email_verified_at' => now(),
            'password' => Hash::make('1234'),
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
