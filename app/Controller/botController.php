<?php
namespace App\Controller;

class botController {

    public function __construct()
    {
    }

    /**
     * Process incoming webhook requests from Telegram
     * @return void
     */
    public function process()
    {
        // retrive json data
        $update = json_decode(file_get_contents("php://input"), true);

        // اگر پیام وجود داشت
        if (isset($update["message"])) {
            $chatId = $update["message"]["chat"]["id"];
            $userText = $update["message"]["text"] ?? "";
            
            if(filter_var($userText,FILTER_VALIDATE_EMAIL))
            {
                $replyText = 'email is valid';
            }
            else{
                $replyText = 'email is not valid';
            }

            $data = [
                "chat_id" => $chatId,
                "text" => $replyText,
                "parse_mode" => 'HTML',
                "disable_web_page_preview" => false,
                "disable_notification" => false,
            ];

            $result = $this->send($data,EndPoints::sendMessage());

            // save the log of actions
            file_put_contents(__DIR__ . "/../../storage/logs/TelegramBot.log", print_r(json_decode($result),true) . PHP_EOL,);

            // response to webhook request
            http_response_code(200);
            echo "Message sent successfully";
        }
    }

    /**
     * Detect the type of message received from Telegram
     * @param array $update
     * @return string
     */
    public function detectMessageType(array $update): string{
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

    /** send message to telegram bot
     * @param array $data
     */
    public function send(array $data,string $endPoint)
    {
        // send respound to request
        $curl = curl_init();
        curl_setopt($curl,CURLOPT_URL,$endPoint);
        curl_setopt($curl,CURLOPT_POST,1);
        curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($curl,CURLOPT_POSTFIELDS,$data);
        $result = curl_exec($curl);
        curl_close($curl);
        return $result;
    }
}


class EndPoints{
    private static $botToken;

    private static function init() {
        if(!self::$botToken)
        {
            self::$botToken = $_ENV['TELEGRAM_BOT_TOKEN'] ?? '';
        }
    }
    
    public static function sendMessage()
    {
        self::init();
        return "https://api.telegram.org/bot" . self::$botToken . "/sendMessage";
    }
    public static function sendPhoto()
    {
        self::init();
        return "https://api.telegram.org/bot" . self::$botToken . "/sendPhoto";
    }


}


// $data = [
    // "chat_id" => $chatId,
    // "text" => $text,
    // "parse_mode" => "HTML",
    // "reply_to_message_id" => '',
    // "disable_web_page_preview" => false,
    // "disable_notification" => false,
    // "reply_markup" => json_encode([
        // "keyboard" => [
            // [["text" => "Button 1"]],
            // [["text" => "Button 2"], ["text" => "Button 3"]],
        // ],
        // "resize_keyboard" => true,
        // "one_time_keyboard" => true
    // ])
// ];