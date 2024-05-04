<?php
function getWeatherTemperature() {
    $city = "Kitchener";
    $countryCode = "CA";
    $apiKey = "f5298207ac95b7f307a34ad265ffd544"; 

    $url = "http://api.openweathermap.org/data/2.5/weather?q={$city},{$countryCode}&units=metric&appid={$apiKey}";
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($curl);

    if ($response === false) {
        return "Curl error: " . curl_error($curl);
    }

    $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    if ($httpCode !== 200) {
        return "HTTP error: " . $httpCode;
    }

    curl_close($curl);

    $weatherData = json_decode($response);
    if ($weatherData && property_exists($weatherData, "main") && property_exists($weatherData->main, "temp")) {
        $temperature = round($weatherData->main->temp);
        return $temperature . "°C";
    } else {
        return "N/A";
    }
}

?>
