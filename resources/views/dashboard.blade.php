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
	<link rel="stylesheet" href="{{ asset('css/styles.css') }}">

	<!--[if lt IE 9]>
	<script src="{{ asset('js/_lib/html5shiv.js') }}"></script>
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
                
                $count = 1;

                foreach($json as $day) {
                    
                    substr($day->dayName, 0, 1) == "S" ? $color_class = ' colored' : $color_class = '';
                    echo '<div class="col-4 col-lg-2 blox' .$color_class. '">';
                    
                    if ($count == 1) {
                        $day->dayName = 'Today';
                    } else if ($count == 2) {
                        $day->dayName = 'Tomorrow';
                    }
                    echo '<h2>' .$day->dayName. '</h2>';

                    echo '<img src="https://www.metaweather.com/static/img/weather/' .$day->imageName. '.svg" title="' .$day->weatherCond. '"><br>';
                    echo '<p><b>' .$day->tempHigh. 'º</b> / ' .$day->tempLow. 'º</p>';
                    echo '</div>';
                    
                    $count++;
                }

            @endphp

        </div>
    </div>

<script src="{{  asset('js/local.js') }}"></script>

<!-- WEYLAND-YUTANI CORPORATION - "Building Better Worlds." -->

</body>
</html>