<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

use function Laravel\Prompts\error;

class MeterController extends Controller
{
    /**
     * Display a listing of the resource.
    */

    private $meterAPI;

    public function __construct()
    {
        $this->meterAPI = new MeterAPI();
    }

    public function index()
    {
        //
        $username = Cache::get("username");
        $apiKey = Cache::get("apiKey");

        $users = $this->meterAPI->getUsers($username, $apiKey);

        if($users){

            return view("meters.dashboard", ["users" => $users["value"]]);

        }

    }

    public function index_meters()
    {
        $username = Cache::get("username");
        $apiKey = Cache::get("apiKey");

        $meters = $this->meterAPI->getDevices($username, $apiKey);

        if($meters["value"] and $meters["value"]["c"]){

            return view("meters.meters", [
                "meters" => $meters["value"]["d"]
            ]);

        }

        return response("No meters for this account. You need to create one.");

    }

    public function index_prices()
    {
        $username = Cache::get("username");
        $apiKey = Cache::get("apiKey");

        $prices = $this->meterAPI->getPrices($username, $apiKey)["value"];

        return view("meters.prices", ["prices" => $prices]);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create_user()
    {
        //
        return view("meters.user");

    }

    public function create_meter()
    {
        return view("meters.meter");
    }

    public function create_price()
    {
        return view("meters.price");
    }

    public function create_bind_meter_user()
    {
        return view("meters.bind_meter_user");
    }

    public function create_charge()
    {
        return view("meters.charge");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store_user(Request $request)
    {
        //
        $username = Cache::get("username");
        $apiKey = Cache::get("apiKey");

        $validated = $request->validate([
            "name" => ['required'],
            "username" => ['required'],
            "phone" => ['required'],
        ]);

        $this->meterAPI->addUser($username, $validated["name"], $validated["username"], $validated["phone"], $apiKey);

        return redirect(route("dashboard"));

    }

    public function store_meter(Request $request)
    {
        $username = Cache::get("username");
        $apiKey = Cache::get("apiKey");

        $validated = $request->validate([
            "meter_id" => ['required'],
            "meter_name" => ['required'],
            "meter_phone" => ['nullable'],
            "meter_note" => ['nullable'],
            "price_id" => ['required'],
            "user_id" => ["required"],
            "warmkwh" => ['required'],
            "sellmin" => ['required'],
        ]);

        $validated = array_map(fn($value) => $value ?? '', $validated);

        $meterObject = $this->meterAPI->MeterObject($validated["meter_id"], $validated["meter_name"], $validated["price_id"], $validated["user_id"], $validated["meter_note"], $validated["meter_phone"], 1, $validated["warmkwh"], $validated["sellmin"]);

        $response = $this->meterAPI->addMeter($username, [$meterObject], $apiKey);

        if($response){
            return redirect(route("meters"));
        }

        return response("Failed creating meter");

    }

    public function store_price(Request $request)
    {
        $username = Cache::get("username");
        $apiKey = Cache::get("apiKey");

        $validated = $request->validate([
            "price_name" => ['required'],
            "price_amount" => ['required'],
            "price_note" => ['nullable'],
        ]);

        $validated = array_map(fn($value) => $value ?? '', $validated);

        $response = $this->meterAPI->addPrice($username, $validated["price_name"], $validated["price_amount"], $validated["price_note"], 1, $apiKey);

        if($response){
            return redirect(route("prices"));
        }

        return response("Failed creating price.");
        

    }

    public function store_bind_meter_user(Request $request)
    {
        $username = Cache::get("username");
        $apiKey = Cache::get("apiKey");

        $validated = $request->validate([
            "user_id" => ['required'],
            "meter_id" => ['required']
        ]);

        $this->meterAPI->linkUserMeter($username, $validated["user_id"], $validated["meter_id"], $apiKey);

        return redirect(route("dashboard"));

    }

    public function store_charge(Request $request)
    {
        $username = Cache::get("username");
        $apiKey = Cache::get("apiKey");

        $validated = $request->validate([
            "meter_id" => ['required'],
            "charge_amount" => ['required'],
        ]);

        $this->meterAPI->landlordRecharge($username, $validated["meter_id"], "2", $apiKey, sellMoney:$validated["charge_amount"]);

        return redirect(route("dashboard"));

    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $userId)
    {
        //
        $start = $request->get("start");
        if(!$start){
            $start = Carbon::now()->firstOfMonth()->format("Y-m-d");
        }

        $end = $request->get("end");
        if(!$end){
            $end = Carbon::now()->format("Y-m-d");
        }


        $username = Cache::get("username");
        $apiKey = Cache::get("apiKey");
        
        $user = $this->meterAPI->getUsers($username, $apiKey, $userId);

        if($user["value"]){
            $user = $user["value"][0];
            $summary = $this->meterAPI->getUsageSummary($username, $user["Station_index"], $apiKey);

            $userBill = $this->meterAPI->getMonthBill($username, $start, $end, $userId, $apiKey, 2);

            if($userBill){
                return view("meters.usage", [
                    "usages" => $userBill["value"],
                    "username" => $user["Name"],
                    "summary" => $summary["value"]
                ]);
            }

        }

        return response("Record not found");

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy_user(string $userId)
    {
        //
        $username = Cache::get("username");
        $apiKey = Cache::get("apiKey");

        $user = $this->meterAPI->getUsers($username, $apiKey, $userId);

        if($user && $user["value"]){
            $user = $user["value"][0];

            $this->meterAPI->deleteUsers($username, [$user["Station_index"]], $apiKey);
            return redirect(route("dashboard"));
        }

        return response("Failed User Deletion. User might not existed.");

    }

    public function destroy_prices(int $price_id)
    {
        $username = Cache::get("username");
        $apiKey = Cache::get("apiKey");

        $response = $this->meterAPI->deletePrices($username, [$price_id], $apiKey);

        if($response){
            return redirect(route("prices"));
        }

        return response("Failed deletion");

    }

    // Extras

    public function switch_meter(String $meter_id, String $val)
    {

        $username = Cache::get("username");
        $apiKey = Cache::get("apiKey");

        $response = $this->meterAPI->controlRelay($username, $val, $meter_id, apiKey:$apiKey);


        if($response){

            return redirect(route("meters"));

        }

        return response("Switching meter failed");
        

    }

}
