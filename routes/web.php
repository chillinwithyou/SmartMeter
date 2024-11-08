<?php

use App\Http\Controllers\MeterAPI;
use App\Http\Controllers\MeterController;
use App\Http\Controllers\UserController;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

Route::prefix("/smartmeter")->group(function (){

    Route::middleware(['auth'])->group(function (){
        Route::get("/test", function() {

            $meterController = new MeterAPI();
        
        
            $apiKey = $meterController->generateKey("0003107495", "77889966");
        
            //dd($meterController->getPrices("0003107495", $apiKey));
        
            //$response = dd($meterController->getUsers("0003107495", $apiKey, "19104631262"));
        
            //$response = dd($meterController->getUserMeter("0003107495", "2039670", $apiKey));

            $response = dd($meterController->getDeviceDetails("0003107495", "19104631262", $apiKey));
        
            //$response = dd($meterController->getBalance("0003107495", "2039670", $apiKey));
        
            //$response = $meterController->getPublicHisList("0003107495", "19104631262", "2024-11-05", "2024-11-07", $apiKey);
        
            //$response = $meterController->getDevices("0003107495", $apiKey);
        
            dd($response);
        
            //$response = dd($meterController->addPrice("0003107495", "Testing Price", "12.67", "This is for testing", 0, $apiKey));
        
            //$response = dd($meterController->getPrices("0003107495", $apiKey));
        
            //$response = $meterController->addUser("0003107495", "Syamsul", "smi5278", "18143215190", $apiKey);
        
            
        
            //$response = $meterController->deleteUsers("0003107495", [2041759], $apiKey);
        
            //$response = $meterController->getDevices("0003107495", $apiKey);
            
            //$response = $meterController->getMonthBill("0003107495", "2024-11-05", "2024-11-07", "19104631262", $apiKey, 2);
            //$response = $meterController->getMonthBill()
        
        });
        
        Route::get("/", [MeterController::class, "index"])->name("dashboard");
        Route::get("/meters", [MeterController::class, "index_meters"])->name("meters");
        Route::get("/prices", [MeterController::class, "index_prices"])->name("prices");
        
        Route::get("/new_user", [MeterController::class, "create_user"])->name("new_user");
        Route::post("/new_user", [MeterController::class, "store_user"]);
        Route::delete("/delete/{userId}", [MeterController::class, "destroy_user"])->name("delete_user");
        
        Route::get("/new_meter", [MeterController::class, "create_meter"])->name("new_meter");
        Route::post("/new_meter", [MeterController::class, "store_meter"]);
        
        Route::get("/new_price", [MeterController::class, "create_price"])->name("new_price");
        Route::post("/new_price", [MeterController::class, "store_price"]);
        Route::delete("/delete_prices/{priceID}", [MeterController::class, "destroy_prices"])->name("delete_price");
        
        Route::get("/link_to_user", [MeterController::class, "create_bind_meter_user"])->name("bind_meter_user");
        Route::post("/link_to_user", [MeterController::class, "store_bind_meter_user"]);
        
        Route::get("/create_charge", [MeterController::class, "create_charge"])->name("new_charge");
        Route::post("/create_charge", [MeterController::class, "store_charge"]);
        
        Route::get("/{userId}/usage", [MeterController::class, "show"])->name("userUsage");


        Route::post("/meters/{meterId}/{value}", [MeterController::class, "switch_meter"])->name("switch_meter");
    });

    Route::get("/ei/hello", function() {
        dd("Hello");
    });

    Route::get("/login", [UserController::class, "login"])->name("login");
    Route::post("/login", [UserController::class, "loginUser"]);
});