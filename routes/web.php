<?php

use App\Http\Controllers\MeterAPI;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get("/test", function() {

    $meterController = new MeterAPI();


    $apiKey = $meterController->generateKey("0003107495", "77889966");

    //dd($meterController->getPrices("0003107495", $apiKey));

    //$response = dd($meterController->getUsers("0003107495", $apiKey));

    //$response = dd($meterController->addPrice("0003107495", "Testing Price", "12.67", "This is for testing", 0, $apiKey));

    $response = dd($meterController->getPrices("0003107495", $apiKey));

    //$response = $meterController->addUser("0003107495", "Syamsul", "smi5278", "18143215190", $apiKey);

    

    //$response = $meterController->deleteUsers("0003107495", [2041759], $apiKey);


    dd($response);

}

);