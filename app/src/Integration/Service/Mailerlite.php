<?php
/**
 * Created by PhpStorm.
 * User: dsamotoy
 * Date: 18.11.19
 * Time: 14:29
 */

namespace Integration\Service;


use GuzzleHttp\Client;

class Mailerlite extends General implements Service
{
    const NAME = 'mailerlite';

    public function createGroup(array $param): bool
    {
        curl_setopt_array($this->curl, [
            CURLOPT_URL => "http://api.mailerlite.com/api/v2/groups",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode($param),
            CURLOPT_HTTPHEADER => [
                "content-type: application/json",
                "x-mailerlite-apikey: " . $this->integration['apiKey']
            ],
        ]);

        return true;
    }

    public function addSubscriber(string $name, string $email): bool
    {
        curl_setopt_array($this->curl, [
            CURLOPT_URL => "https://api.mailerlite.com/api/v2/groups/".$this->integration['groupId']."/subscribers",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode(['name' => $name, 'email' => $email]),
            CURLOPT_HTTPHEADER => [
                "content-type: application/json",
                "x-mailerlite-apikey: " . $this->integration['apiKey']
            ],
        ]);

        return true;
    }
}
