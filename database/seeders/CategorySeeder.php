<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('categories')->truncate();
        Schema::enableForeignKeyConstraints();

        $categories = [
            [
                'name' => 'Accessories',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Hampers',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Mask',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Souvenir',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Others',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('categories')->insert($categories);
    }
}
