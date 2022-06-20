<?php

namespace Database\Seeders;

use App\Models\Administrator;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        // DB::table('rooms')->insert([
        //     [
        //         'room_number'=>101,
        //         'type'=> '1 Single',
        //         'room_area'=> '15',
        //         'price'=>250000,
        //         'floor'=>'1'
        //     ],
        //     [
        //         'room_number'=>102,
        //         'type'=> '1 Queen',
        //         'room_area'=> '15',
        //         'price'=>350000,
        //         'floor'=>'1'
        //     ],
        //     [
        //         'room_number'=>103,
        //         'type'=> '2 Single',
        //         'room_area'=> '15',
        //         'price'=>300000,
        //         'floor'=>'1'
        //     ],
        // ]);

        Administrator::create(
            [
                "username" => "alfathabibi",
                "password" => bcrypt("asdasd"),
                "name" => "Muhammad Alfath Abibi",
                "numberid" => "1301218606",
                "email" => "alfath@gmail.com",
                "phone" => "+628233344455"
            ]
        );
        // DB::table('administrators')->insert();
    }
}
