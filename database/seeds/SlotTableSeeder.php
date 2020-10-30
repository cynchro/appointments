<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SlotTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $slot = array(array(
            "slot" => "10:00"
        ),
            array(
                "slot" => "10:30"
            ),
            array(
                "slot" => "11:00"
            ),
            array(
                "slot" => "11:30"
            ),
            array(
                "slot" => "12:00"
            ));
        
        DB::table('slot')->insert($slot);
    }
}

