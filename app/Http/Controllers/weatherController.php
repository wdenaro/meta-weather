<?php

namespace App\Http\Controllers;

use DateTime;
use DateTimeZone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class weatherController extends Controller
{


    public function main()
    {
        // GET the most recent update from DB
        $db = DB::table('meta_weather')
                    ->orderBy('updated_at', 'DESC')
                    ->limit(1)
                    ->get();
        
        // IF there is data, analyze it's age
        if (isset($db[0]->data)) {

            $now = new DateTime('now', new DateTimeZone('Zulu'));
            $last = new DateTime($db[0]->updated_at);
            $minutesSinceLastUpdate = $now->diff($last)->format('%I');

            // IF the data is current, use it
            if ($minutesSinceLastUpdate < 10) {

                $data = $db[0]->data;

            } else {

                // IF the data is old, GET fresh data
                $data = $this->callAPI();
            }

        // GET fresh data
        } else {

            $data = $this->callAPI();

        }

        return view ('dashboard', compact('data'));

    }


    private function callAPI()
    {
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

        $json = json_decode($response);

        // Create a new ARRAY to hold the pertinent data
        $data = array();

        foreach ($json->consolidated_weather as $day) {

            // Convetrt to get name of day
            $timestamp = strtotime($day->applicable_date);
            $dayName = date('l', $timestamp);

            // Convert from C to F
            $tempHigh = round(($day->max_temp * 1.8) + 32);
            $tempLow = round(($day->min_temp * 1.8) + 32);

            $imageName = $day->weather_state_abbr;
            $weatherCond = $day->weather_state_name;

            $arr = array("dayName"=>$dayName, "tempHigh"=>$tempHigh, "tempLow"=>$tempLow, "imageName"=>$imageName, "weatherCond"=>$weatherCond);

            array_push($data, $arr);

        }

        $forecast = json_encode($data);

        DB::table('meta_weather')->insert(
            ['data' => $forecast, 'updated_at' => NOW()]
        );

        return $forecast;
    }



}
