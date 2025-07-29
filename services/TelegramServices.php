<?php
namespace Services;

use Exception;
use Config\TelegramEndPoints;

class TelegramServices{
    public $botToken;
    public $update;
    public $result;

    public function __construct()
    {
        if(!isset($_ENV['TELEGRAM_BOT_TOKEN']) || empty($_ENV['TELEGRAM_BOT_TOKEN'])){
            throw new \Exception("Telegram Bot Token is not set in the environment variables.");
        }
        $this->botToken = $_ENV['TELEGRAM_BOT_TOKEN'];
    }

    public function run(callable $func){
        try {
            return $func();
        } catch (\Exception $e) {
            error_log($e->getMessage());
            respons($e->getMessage(),500);
        }
           
    }

    public function handleUpdate()
    {
        $update = json_decode(file_get_contents("php://input"),true);
        if(isset($update['message']) && is_array($update['message'])){
            $this->update = $update;
            return true;
        } else {
            $this->update = [];
            error_log("Invalid update format received from Telegram.");
            throw new \Exception("Invalid update format received from Telegram.");
        }
    }

    public function getUpdate(): array
    {
        if(isset($this->update) && !empty($this->update)){
            return $this->update;
        }else{
            error_log("No update available. Please call handleUpdate() first.");
            throw new \Exception("No update available. Please call handleUpdate() first.");
        }
    }

    /**
     * Detect the type of message received from Telegram
     * @param array $update
     * @return string
     */
    public function detectMessageType(array $update): string{
        $update = $this->getUpdate();
        if (isset($update['message']['text'])) {
            return 'text';
        } elseif (isset($update['message']['photo'])) {
            return 'photo';
        } elseif (isset($update['message']['document'])) {
            return 'document';
        } elseif (isset($update['message']['video'])) {
            return 'video';
        }elseif (isset($update['message']['video_note'])){
            return 'video_note';
        }elseif (isset($message['message']['audio'])){
            return 'audio';
        } elseif (isset($update['message']['voice'])) {
            return 'voice';
        } elseif (isset($update['message']['sticker'])) {
            return 'sticker';
        } elseif (isset($update['message']['location'])) {
            return 'location';
        } elseif (isset($update['message']['contact'])) {
            return 'contact';
        }
        return 'unknown';
    }

    public function getFileId(array $update, string $messageType){
        switch (strtolower($messageType)) {
            case 'photo':
                return(end($update["message"]["photo"])["file_id"] ?? null);
            case 'document':
                return($update["message"]["document"]["file_id"] ?? null);
            case 'video':
                return($update["message"]["video"]["file_id"] ?? null);
            case 'video_note':
                return($update["message"]["video_note"]["file_id"] ?? null);
            case 'audio':
                return($update["message"]["audio"]["file_id"] ?? null);
            case 'voice':
                return($update["message"]["voice"]["file_id"] ?? null);
            case 'sticker':
                return($update["message"]["sticker"]["file_id"] ?? null);
            default:
                return null;
        }
    }

    /** send message to telegram bot
     * @param array $data
     */
    public function send(array $data,string $endPoint)
    {
        $curl = curl_init();
        curl_setopt($curl,CURLOPT_URL,$endPoint);
        curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

        $result = curl_exec($curl);

        if ($result === false) {
            error_log(curl_error($curl));
            throw new \Exception("cURL Error: " . curl_error($curl));
        }
        
        curl_close($curl);

        $this->result = $result;
        return $result;
    }
    
    /**
     * get data from telegram
     */
    public function get(array $data,string $endPoint){
        $endPoint = $endPoint . '?' . http_build_query($data);
        $curl = curl_init();
        curl_setopt($curl,CURLOPT_URL,$endPoint);
        curl_setopt($curl,CURLOPT_HTTPGET,true);
        curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);

        $result = curl_exec($curl);

        if ($result === false) {            
            error_log(curl_error($curl));
            throw new \Exception("cURL Error: " . curl_error($curl));
        }
        
        curl_close($curl);

        $this->result = $result;
        return $result;

    }
    /**
     * Download file from Telegram
     * @param string $fileId
     * @param string $filePath
     * @return bool
     */
    public function downloadFile(string $fileId, string $filePath)
    {
        
        $endPoint = TelegramEndPoints::getFile() . $fileId;
        $response = json_decode($this->get([], $endPoint), true);

        if (!isset($response['ok']) || !$response['ok']) {
            return false;
        }
        $telegramFilePath = $response['result']['file_path'] ?? '';
        $extension = pathinfo($telegramFilePath, PATHINFO_EXTENSION);
        $fileName = bin2hex(random_bytes(16)) . '.' . $extension;
        $filePath = rtrim($filePath, '/') . '/' . $fileName;

        $fileUrl = "https://api.telegram.org/file/bot" . $this->botToken . "/" . $response['result']['file_path'];
        $result = file_put_contents($filePath, file_get_contents($fileUrl));
        if($result !== false){
            return($fileName);
        }
        return false;
    }
}
