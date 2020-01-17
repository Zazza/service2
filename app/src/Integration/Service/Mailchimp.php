<?php
/**
 * Created by PhpStorm.
 * User: dsamotoy
 * Date: 18.11.19
 * Time: 14:29
 */

namespace Integration\Service;


class Mailchimp extends General implements Service
{
    const NAME = 'mailchimp';

    public function createGroup(array $param): bool
    {
        //....

        return true;
    }

    public function addSubscriber(string $name, string $email): bool
    {
        $data = [
            'apikey'        => $this->integration['apiKey'],
            'email_address' => $email,
            'status'        => 'subscribed',
            'merge_fields'  => [
                'FNAME' => $name
            ]
        ];

        curl_setopt_array($this->curl, [
            CURLOPT_URL => 'https://us13.api.mailchimp.com/3.0/lists/'.$this->integration['listId'].'/members/',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_POST => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'Authorization: Basic '.base64_encode('user:'.$this->integration['apiKey'])
            ]
        ]);

        return true;
    }
}
