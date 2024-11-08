<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Http;

class MeterAPI extends Controller
{
    //
    public function generateKey(String $username, String $password)
    {

        $url = env("METER_URL");
        $endpoint = env("METER_ENDPOINT");
        $apiKey = env("METER_APIKEY");

        $constructed_url = "{$url}?Method=login&api={$endpoint}&apiKey={$apiKey}";

        try {

            $response = Http::post($constructed_url, [
                "nam" => $username,
                "psw" => $password,
            ]);

            $json_decoded = json_decode($response->body(), true);

            if ($json_decoded["result"] === 200) {

                return $json_decoded["value"]["apiKey"];
            }

            return null;
        } catch (Exception $e) {

            return $e;
        }
    }

    public function getPrices(String $username, String $apiKey)
    {


        $url = env("METER_URL");
        $endpoint = env("METER_ENDPOINT");
        $apiKey = urlencode($this->encryptAndEncodeApikey($apiKey));

        $constructed_url = "{$url}?Method=getPrices&api={$endpoint}&apiKey={$apiKey}";

        try {

            $response = Http::post($constructed_url, [
                "loginid" => $username,
                "ckv" => "1",
                "ptype" => -1,
                "offset" => -1,
                "limit" => -1
            ]);

            $json_decoded = json_decode($response->body(), true);

            if ($json_decoded["result"] === 200) {

                return $json_decoded;
            }

            return null;
        } catch (Exception $e) {

            return $e;
        }
    }

    public function getDeviceDetails(String $username, String $meter_id, String $apiKey)
    {
        $url = env("METER_URL");
        $endpoint = env("METER_ENDPOINT");
        $apiKey = urlencode($this->encryptAndEncodeApikey($apiKey));

        $constructed_url = "{$url}?Method=getMetStatusByMetId&api={$endpoint}&apiKey={$apiKey}";

        try {

            $response = Http::post($constructed_url, [
                "loginid" => $username,
                "metid" => $meter_id
            ]);

            $json_decoded = json_decode($response->body(), true);

            if ($json_decoded["result"] === 200) {

                return $json_decoded;
            }

            return null;
        } catch (Exception $e) {

            return $e;
        }
    }

    public function getDevices(String $username, $apiKey)
    {
        $url = env("METER_URL");
        $endpoint = env("METER_ENDPOINT");
        $apiKey = urlencode($this->encryptAndEncodeApikey($apiKey));

        $constructed_url = "{$url}?Method=getMetList_Simple&api={$endpoint}&apiKey={$apiKey}";

        try {

            $response = Http::post($constructed_url, [
                "loginid" => $username,
                "ckv" => "1",
            ]);

            $json_decoded = json_decode($response->body(), true);

            if ($json_decoded["result"] === 200) {

                return $json_decoded;
            }

            return null;
        } catch (Exception $e) {

            return $e;
        }
    }

    public function addUser($username, $tenant_name, $tenant_username, $tenant_phone, $apiKey)
    {
        $url = env("METER_URL");
        $endpoint = env("METER_ENDPOINT");
        $apiKey = urlencode($this->encryptAndEncodeApikey($apiKey));

        $constructed_url = "{$url}?Method=addUser&api={$endpoint}&apiKey={$apiKey}";

        try {

            $response = Http::post($constructed_url, [
                "loginid" => $username,
                "uN" => $tenant_name,
                "uI" => $tenant_username,
                "tel" => $tenant_phone
            ]);

            $json_decoded = json_decode($response->body(), true);

            if ($json_decoded["result"] === 200) {

                return $json_decoded;
            }

            return null;
        } catch (Exception $e) {

            return $e;
        }
    }

    public function getUsers($username, $apiKey, $ckv="")
    {
        $url = env("METER_URL");
        $endpoint = env("METER_ENDPOINT");
        $apiKey = urlencode($this->encryptAndEncodeApikey($apiKey));

        $constructed_url = "{$url}?Method=getUsers&api={$endpoint}&apiKey={$apiKey}";

        try {

            $response = Http::post($constructed_url, [
                "loginid" => $username,
                "ckv" => $ckv
            ]);

            $json_decoded = json_decode($response->body(), true);

            if ($json_decoded["result"] === 200) {

                return $json_decoded;
            }

            return null;
        } catch (Exception $e) {

            return $e;
        }
    }

    public function deleteUsers(String $username, array $user_station_ids, String $apiKey)
    {
        $url = env("METER_URL");
        $endpoint = env("METER_ENDPOINT");
        $apiKey = urlencode($this->encryptAndEncodeApikey($apiKey));

        $constructed_url = "{$url}?Method=deleteUser&api={$endpoint}&apiKey={$apiKey}";

        try {

            $response = Http::post($constructed_url, [
                "loginid" => $username,
                "id" => $user_station_ids,
            ]);

            $json_decoded = json_decode($response->body(), true);

            if ($json_decoded["result"] === 200) {

                return $json_decoded;
            }

            return null;
        } catch (Exception $e) {

            return $e;
        }
    }

    public function addPrice(String $username, String $priceName, String $price, String $priceNote, int $priceType=1, $apiKey)
    {
        $url = env("METER_URL");
        $endpoint = env("METER_ENDPOINT");
        $apiKey = urlencode($this->encryptAndEncodeApikey($apiKey));

        $constructed_url = "{$url}?Method=addPrice&api={$endpoint}&apiKey={$apiKey}";

        try {

            $response = Http::post($constructed_url, [
                "loginid" => $username,
                "PriceName" => $priceName,
                "Price" => $price,
                "Pnote" => $priceNote,
                "priceType" => $priceType
            ]);

            $json_decoded = json_decode($response->body(), true);

            if ($json_decoded["result"] === 200) {

                return $json_decoded;
            }

            return null;
        } catch (Exception $e) {

            return $e;
        }
    }

    public function landlordRecharge(String $username, String $meter_id, String $simple, String $apiKey, String $sellKwh="0", String $sellMoney="0", String $isWifi="1")
    {
        $url = env("METER_URL");
        $endpoint = env("METER_ENDPOINT");
        $apiKey = urlencode($this->encryptAndEncodeApikey($apiKey));

        $constructed_url = "{$url}?Method=sellKwh&api={$endpoint}&apiKey={$apiKey}";

        try {

            $response = Http::post($constructed_url, [
                "loginid" => $username,
                "sellKwh" => $sellKwh,
                "sellMoney" => $sellMoney,
                "metid" => $meter_id,
                "simple" => $simple,
                "iswifi" => $isWifi
            ]);

            $json_decoded = json_decode($response->body(), true);

            if ($json_decoded["result"] === 200) {

                return $json_decoded;
            }
            return null;
            
        } catch (Exception $e) {
            return $e;
        }
    }

    public function sellByApi(String $username, String $meter_id, String $simple, String $apiKey, String $sellKwh="0", String $sellMoney="0")
    {
        $url = env("METER_URL");
        $endpoint = env("METER_ENDPOINT");
        $apiKey = urlencode($this->encryptAndEncodeApikey($apiKey));

        $constructed_url = "{$url}?Method=sellByApi&api={$endpoint}&apiKey={$apiKey}";

        try {

            $response = Http::post($constructed_url, [
                "loginid" => $username,
                "sellKwh" => $sellKwh,
                "sellMoney" => $sellMoney,
                "metid" => $meter_id,
                "simple" => $simple
            ]);

            $json_decoded = json_decode($response->body(), true);

            if ($json_decoded["result"] === 200) {

                return $json_decoded;
            }

            return null;
        } catch (Exception $e) {

            return $e;
        }
    }

    public function sellByApiOk(String $username, String $payment_id, String $meter_id, String $apiKey)
    {
        $url = env("METER_URL");
        $endpoint = env("METER_ENDPOINT");
        $apiKey = urlencode($this->encryptAndEncodeApikey($apiKey));

        $constructed_url = "{$url}?Method=sellByApiOk&api={$endpoint}&apiKey={$apiKey}";

        try {

            $response = Http::post($constructed_url, [
                "loginid" => $username,
                "idx" => $payment_id,
                "metid" => $meter_id,
            ]);

            $json_decoded = json_decode($response->body(), true);

            if ($json_decoded["result"] === 200) {

                return $json_decoded;
            }

            return null;
        } catch (Exception $e) {

            return $e;
        }
    }

    public function deletePrices(String $username, array $price_ids, String $apiKey)
    {
        $url = env("METER_URL");
        $endpoint = env("METER_ENDPOINT");
        $apiKey = urlencode($this->encryptAndEncodeApikey($apiKey));

        $constructed_url = "{$url}?Method=deletePrice&api={$endpoint}&apiKey={$apiKey}";

        try {

            $response = Http::post($constructed_url, [
                "loginid" => $username,
                "id" => $price_ids,
            ]);

            $json_decoded = json_decode($response->body(), true);

            if ($json_decoded["result"] === 200) {

                return $json_decoded;
            }

            return null;
        } catch (Exception $e) {

            return $e;
        }

    }

    public function addMeter(String $username, array $meterObjects, $apiKey)
    {

        $url = env("METER_URL");
        $endpoint = env("METER_ENDPOINT");
        $apiKey = urlencode($this->encryptAndEncodeApikey($apiKey));

        $constructed_url = "{$url}?Method=addMeter&api={$endpoint}&apiKey={$apiKey}";

        try {

            $response = Http::post($constructed_url, [
                "loginid" => $username,
                "mts" => $meterObjects,
            ]);

            $json_decoded = json_decode($response->body(), true);

            if ($json_decoded["result"] === 200) {

                return $json_decoded;
            }

            return null;
        } catch (Exception $e) {

            return $e;
        }

    }

    public function getMonthBill(String $username, String $start, String $end, String $meter_id, String $apiKey, int $time_query=1)
    {
        $url = env("METER_URL");
        $endpoint = env("METER_ENDPOINT");
        $apiKey = urlencode($this->encryptAndEncodeApikey($apiKey));

        $constructed_url = "{$url}?Method=getMonthBill&api={$endpoint}&apiKey={$apiKey}";

        try {

            $response = Http::post($constructed_url, [
                "loginid" => $username,
                "st" => $start,
                "et" => $end,
                "metID" => $meter_id,
                "mYMD" => $time_query
            ]);

            $json_decoded = json_decode($response->body(), true);

            if ($json_decoded["result"] === 200) {

                return $json_decoded;
            }

            return null;
        } catch (Exception $e) {

            return $e;
        }
    }

    public function getPublicHisList(String $username, String $meter_id, String $start, String $end, String $apiKey)
    {
        $url = env("METER_URL");
        $endpoint = env("METER_ENDPOINT");
        $apiKey = urlencode($this->encryptAndEncodeApikey($apiKey));

        $constructed_url = "{$url}?Method=getPublicHisList&api={$endpoint}&apiKey={$apiKey}";

        try {

            $response = Http::post($constructed_url, [
                "loginid" => $username,
                "stime" => $start,
                "etime" => $end,
                "meterID" => $meter_id,
            ]);

            $json_decoded = json_decode($response->body(), true);

            if ($json_decoded["result"] === 200) {

                return $json_decoded;
            }

            return null;
        } catch (Exception $e) {

            return $e;
        }
    }

    public function getUsageSummary(String $username, String $meter_id, String $apiKey)
    {
        $url = env("METER_URL");
        $endpoint = env("METER_ENDPOINT");
        $apiKey = urlencode($this->encryptAndEncodeApikey($apiKey));

        $constructed_url = "{$url}?Method=getSumm&api={$endpoint}&apiKey={$apiKey}";

        try {

            $response = Http::post($constructed_url, [
                "loginid" => $username,
                "meterID" => $meter_id,
            ]);

            $json_decoded = json_decode($response->body(), true);

            if ($json_decoded["result"] === 200) {

                return $json_decoded;
            }

            return null;
        } catch (Exception $e) {

            return $e;
        }
    }

    public function getUserMeter(String $username, String $user_id, String $apiKey)
    {
        $url = env("METER_URL");
        $endpoint = env("METER_ENDPOINT");
        $apiKey = urlencode($this->encryptAndEncodeApikey($apiKey));

        $constructed_url = "{$url}?Method=link2MetersList&api={$endpoint}&apiKey={$apiKey}";

        try {

            $response = Http::post($constructed_url, [
                "loginid" => $username,
                "userid" => $user_id
            ]);

            $json_decoded = json_decode($response->body(), true);

            if ($json_decoded["result"] === 200) {

                return $json_decoded;
            }

            return null;
        } catch (Exception $e) {

            return $e;
        }
    }

    public function linkUserMeter(String $username, String $user_id, String $meter_id, String $apiKey)
    {
        $url = env("METER_URL");
        $endpoint = env("METER_ENDPOINT");
        $apiKey = urlencode($this->encryptAndEncodeApikey($apiKey));

        $constructed_url = "{$url}?Method=link2User&api={$endpoint}&apiKey={$apiKey}";

        try {

            $response = Http::post($constructed_url, [
                "loginid" => $username,
                "MeterID" => $meter_id,
                "UserID" => $user_id
            ]);

            $json_decoded = json_decode($response->body(), true);

            if ($json_decoded["result"] === 200) {

                return $json_decoded;
            }

            return null;
        } catch (Exception $e) {

            return $e;
        }
    }


    public function controlRelay(String $username, String $value, String $metId, String $isWifi="1", String $apiKey)
    {
        $url = env("METER_URL");
        $endpoint = env("METER_ENDPOINT");
        $apiKey = urlencode($this->encryptAndEncodeApikey($apiKey));

        $constructed_url = "{$url}?Method=setRelay&api={$endpoint}&apiKey={$apiKey}";

        try {

            $response = Http::post($constructed_url, [
                "loginid" => $username,
                "Val" => $value,
                "MetID" => $metId,
                "iswifi" => $isWifi
            ]);

            $json_decoded = json_decode($response->body(), true);

            if ($json_decoded["result"] === 200) {

                return $json_decoded;
            }

            return null;
        } catch (Exception $e) {

            return $e;
        }
    }

    public function MeterObject(String $meter_id, String $meter_name, String $price_id, String $user_id, String $meter_note="", String $meter_phone="", String $index="", String $warmKwh="2", String $sell_min="2", String $isAdd="1")
    {

        $meterObject = [

            "MeterID" => $meter_id,
            "Name" => $meter_name,
            "PriceID" => $price_id,
            "Tel" => $meter_phone,
            "Note" => $meter_note,
            "UserID" => $user_id,
            "index" => $index,
            "warmkwh" => $warmKwh,
            "sellmin" => $sell_min,
            "isAdd" => $isAdd
        ];

        return $meterObject;
    }

    function encryptAndEncodeApikey($apikey) {
        // Define the encryption key and cipher
        $encryptionKey = env('METER_APIKEY'); // Make sure this matches the Secret Key from your screenshot
        $cipher = "aes-256-ecb"; // AES-256-ECB
    
        // Encrypt the API key using AES-256-ECB encryption without IV (since ECB mode doesn’t use an IV)
        $encrypted = openssl_encrypt(
            $apikey,
            $cipher,
            $encryptionKey,
            OPENSSL_RAW_DATA
        );
    
        // Base64 encode the encrypted data
        return base64_encode($encrypted);
    }    

}
