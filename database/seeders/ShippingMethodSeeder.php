<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ShippingMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('shipping_methods')->truncate();
        Schema::enableForeignKeyConstraints();

        $shippingMethods = [
            [
                'name' => 'Free',
                'price_per_kg' => 0,
            ],
            [
                'name' => 'Express',
                'price_per_kg' => 34000,
            ],
            [
                'name' => 'Standard',
                'price_per_kg' => 12000,
            ],
        ];

        DB::table('shipping_methods')->insert($shippingMethods);
    }
}
