<?php
namespace Services;

class SmsServices{
    private $apikey;
    private $number;

    public function __construct() {
        $this->apikey = $_ENV['SMS_X_API_KEY'];
        $this->number = $_ENV['SMS_NUMBER'];
    }

    public function send(string  $text , $numbers){
        if(!is_array($numbers))
        {
            $numbers = [$numbers];
        }

        $curl = curl_init();
        
        $payload = [
            'lineNumber' => $this->number,
            'messageText' => $text,
            'mobiles' => $numbers,
            'sendDateTime' => null,
        ];
        
        curl_setopt_array($curl, [
            CURLOPT_URL => 'https://api.sms.ir/v1/send/bulk',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($payload),
            CURLOPT_HTTPHEADER => [
                'X-API-KEY: ' . $this->apikey,
                'Content-Type: application/json',
            ],
        ]);
        
        $response = curl_exec($curl);
        $error = curl_errno($curl);
        $error_message = curl_error($curl);
        curl_close($curl);

        if ($error) {
            return 'Curl Error: ' . $error_message;
        }
        
        return json_decode($response);
        
    }
}