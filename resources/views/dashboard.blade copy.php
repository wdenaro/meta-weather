<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<title>Weather Dashboard</title>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	<link rel="stylesheet" href="css/styles.css">

	<!--[if lt IE 9]>
	<script src="/js/_lib/html5shiv.js"></script>
	<![endif]-->

</head>

<!-- Created and developed by: Wes Denaro -->

<body>

    <div class="container main">
        <div class="row">
          <div class="col-12">
              <h1>Local Weather</h1>
          </div>
        </div>
        <div class="row">
            @php
                $json = json_decode($data);
                
                $flag = 1;

                foreach ($json->consolidated_weather as $day) {
                    //echo $day->applicable_date. '<br>';
                    //$timestamp = strtotime($day->applicable_date);
                    //$day = getdate($timestamp);
                    //echo $timestamp. '<br>';
                    
                    $wDay = date('l', $timestamp);

                    if ($flag == 1) {
                        $dayName = "Today";
                    } elseif ($flag == 2) {
                        $dayName = "Tomorrow";
                    } else {
                        $dayName = $wDay;
                    }
                    
                    if (preg_match("/^S/", $wDay)) {
                        $colorClass = ' colored';
                    } else {
                        $colorClass = '';
                    }

                    // $high = round(($day->max_temp * 1.8) + 32);
                    // $low = round(($day->min_temp * 1.8) + 32);
                    echo '<div class="col-4 col-lg-2 blox' .$colorClass. '">';
                    echo '<h2>' .$dayName. '</h2>';

                    //echo '<p>' .$day['weekday']. '</p>';

                    echo '<img src="https://www.metaweather.com/static/img/weather/' .$day->weather_state_abbr. '.svg" title="' .$day->weather_state_name. '"><br>';
                    echo '<p><b>' .$high. 'º</b> / ' .$low. 'º</p>';
                    echo '</div>';

                    $flag++;
                }

            @endphp
        </div>
    </div>

<script src="js/local.js"></script>

<!-- WEYLAND-YUTANI CORPORATION - "Building Better Worlds." -->

</body>
</html>