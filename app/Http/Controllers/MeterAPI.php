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

            dd($json_decoded);

            if ($json_decoded["result"] === 200) {

                return $json_decoded;
            }

            return null;
        } catch (Exception $e) {

            return $e;
        }
    }

    public function getUsers($username, $apiKey)
    {
        $url = env("METER_URL");
        $endpoint = env("METER_ENDPOINT");
        $apiKey = urlencode($this->encryptAndEncodeApikey($apiKey));

        $constructed_url = "{$url}?Method=getUsers&api={$endpoint}&apiKey={$apiKey}";

        try {

            $response = Http::post($constructed_url, [
                "loginid" => $username,
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

    public function addPrice(String $username, String $priceName, String $price, String $priceNote, int $priceType=0, $apiKey)
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
