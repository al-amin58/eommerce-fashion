<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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



        $this->call([UserSeeder::class]);
        // $cities = public_path('sql/countries.sql');
        // $sql = file_get_contents($cities);
        // DB::unprepared($sql);

        // $cities = public_path('sql/states.sql');
        // $sql = file_get_contents($cities);
        // DB::unprepared($sql);

        // $cities = public_path('sql/active_colors.sql');
        // $sql = file_get_contents($cities);
        // DB::unprepared($sql);

//        $cities = public_path('sql/cities.sql');
//        $sql = file_get_contents($cities);
//        DB::unprepared($sql);


    }
}
