<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Common;

class weatherController extends Controller {


    public function index() {

        // GET the most recent update from DB
        $db = DB::table('meta_weather')
                    ->orderBy('updated_at', 'DESC')
                    ->limit(1)
                    ->get();
        
        // IF there is data, analyze its age
        if (isset($db[0]->data)) {

            $now = Carbon::now();
            $last = new Carbon($db[0]->updated_at);
            $seconds_since_last_update = $now->diffInSeconds($last);

            Common::write_log('weather: $seconds_since_last_update', $seconds_since_last_update);
    
            // IF the data is current (newer than 10 minutes), use it
            if ($seconds_since_last_update < 600) {

                $data = $db[0]->data;

            } else {

                // IF the data is old, GET fresh data
                $data = $this->call_api();
            }

        // GET fresh data
        } else {

            $data = $this->call_api();

        }

        return view ('dashboard', compact('data'));

    }



    private function call_api() {

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://www.metaweather.com/api/location/2444674/",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_TIMEOUT => 30000,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
            ),
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        Common::write_log('weather: full response', $response);

        $json = json_decode($response);

        // Create a new ARRAY to hold the pertinent data
        $data = array();

        foreach ($json->consolidated_weather as $day) {

            // Convetrt to get name of day
            $timestamp = strtotime($day->applicable_date);
            $day_name = date('l', $timestamp);

            // Convert from C to F
            $temp_high = Common::convert_to_f($day->max_temp);
            $temp_low = Common::convert_to_f($day->min_temp);

            $image_name = $day->weather_state_abbr;
            $weather_cond = $day->weather_state_name;

            $arr = array("dayName"=>$day_name, "tempHigh"=>$temp_high, "tempLow"=>$temp_low, "imageName"=>$image_name, "weatherCond"=>$weather_cond);

            array_push($data, $arr);

        }

        $forecast = json_encode($data);

        DB::table('meta_weather')->insert(
            ['data' => $forecast, 'updated_at' => NOW()]
        );

        return $forecast;

    }


}
