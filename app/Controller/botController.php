<?php
namespace App\Controller;

use CURLFile;
use Exception;
use Services\TelegramEndPoints;
use Services\TelegramServices; 

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
        $telegram = new TelegramServices();
        $telegram->run(function($update) use ($telegram) {
            $update = $telegram->getUpdate();
            
            // $messageType = $telegram->detectMessageType($update);
            // $fileID = $telegram->getFileId($update, $messageType);
            // return $telegram->downloadFile($fileID, __DIR__ .'/');

            $chatId = $update["message"]["chat"]["id"] ?? null;
            $userText = $update["message"]["text"] ?? "";

            $data = [
                "chat_id" => $chatId,
                'photo' => new CURLFile(__DIR__ .'/h.png'),
                'caption' => 'This is a test message',
            ];

            $result = $telegram->send($data,TelegramEndPoints::sendPhoto());
        });


        respons('ok', 200);
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