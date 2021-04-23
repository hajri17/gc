<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('users')->truncate();
        Schema::enableForeignKeyConstraints();

        $users = [
            [
                'name' => 'Administrator',
                'email' => 'admin@admin.com',
                'email_verified_at' => now(),
                'password' => bcrypt('password'),
                'remember_token' => 'ABCdefg1234',
                'is_admin' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Lu\'luil Maghfiroh',
                'email' => 'luluil@gmail.com',
                'email_verified_at' => now(),
                'password' => bcrypt('password'),
                'remember_token' => 'ABCdefgh1234',
                'is_admin' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Lulu Ilma Firoh',
                'email' => 'ilulu2247@gmail.com',
                'email_verified_at' => null,
                'password' => bcrypt('password'),
                'remember_token' => 'ABCdefgh1234',
                'is_admin' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('users')->insert($users);
    }
}
