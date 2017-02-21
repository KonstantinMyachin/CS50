<?php

    if (empty($_GET["latitude"]) || empty($_GET["longitude"]) || empty($_GET["APIKey"])) {
        http_response_code(400);
        exit;
    }
    
    $weather = getWeatherByCoordinates($_GET["latitude"], $_GET["longitude"], $_GET["APIKey"]);
    if ($weather !== false) {
        header("Content-type: application/json");
        print($weather);
    }
    
    function getWeatherByCoordinates($lat, $lon, $APIKey) {

        $weather = @file_get_contents("http://api.openweathermap.org/data/2.5/weather?lat=" . urlencode($lat) . "&lon=" . urlencode($lon) . "&units=metric&APPID=" . urlencode($APIKey), 
            false);
        if ($wether !== false)
            return $weather;
        
        return false;
    }

?>