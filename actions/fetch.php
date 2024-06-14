<?php
require_once 'includes/config.php';

$error = '';
$weatherData = [];
$forecastData = [];

if (isset($_POST['search'])) {
    $city = htmlspecialchars($_POST['city']);
    $selectedUnit = $_POST['unit'] ?? '';

    if (empty($city)) {
        $error = "Please Enter a City Name";
    } else {

        $units = $selectedUnit === "°C" ? "imperial" : "metric";
        $apiUrl = API_BASE_URL . "weather?q={$city}&appid=" . API_KEY . "&units=" . $units;

        $weatherData = @file_get_contents($apiUrl);

        if ($weatherData === false || $forecastData === false) {
            $error = "Failed to fetch weather data. Please try again";
        } else {
            $weatherData = json_decode($weatherData, true);

            $forecastUrl = API_BASE_URL . "forecast?q=$city&units=$units&appid=".API_KEY;
            $forecastData = @file_get_contents($forecastUrl);
            $forecastData = json_decode($forecastData, true);
            $forecastData = getForecastAtNoon($forecastData);
        }
    }
}

function getForecastAtNoon($forecastData) {
    $forecastAtNoon = [];
    $targetTime = "12:00:00";

    foreach ($forecastData['list'] as $entry) {
        if (isset($entry["dt_txt"])) {
            $dateTime = explode(" ", $entry["dt_txt"]);
            if (count($dateTime) >= 2) {
                $time = $dateTime[1];
                if ($time === $targetTime) {
                    $date = $dateTime[0];
                    $forecastAtNoon[$date] = $entry;
                }
            }
        }
    }

    return array_slice($forecastAtNoon, 0, 5);
}

function getDayAndDate($date) {
    $timestamp = strtotime($date);
    $dayOfWeek = date('l', $timestamp);
    $formattedDate = date('F j', $timestamp);
    return [$dayOfWeek, $formattedDate];
}
