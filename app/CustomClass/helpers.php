<?php

namespace App\CustomClass;

use Illuminate\Support\Facades\DB;

class helpers
{


    public static function write_log($notes, $entry)
    {

        DB::table('common_log')->insert(
            ['notes' => $notes, 'entry' => $entry]
        );

    }


    public static function convert_to_F($c)
    {

        return round(($c * 1.8) + 32);

    }
 
 
}
