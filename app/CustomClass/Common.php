<?php

namespace App\CustomClass;

use Illuminate\Support\Facades\DB;

class common {


    public static function write_log($notes, $entry) {

        DB::table('common_log')->insert(
            ['notes' => $notes, 'entry' => $entry]
        );

        return true;

    }


    // Convert temperature Celsius to temperature Fahrenheit
    public static function convert_to_F($c) {

        return round(((float)$c * 1.8) + 32);

    }
 
 
}
