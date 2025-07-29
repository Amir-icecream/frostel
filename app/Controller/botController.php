<?php
namespace App\Controller;

use CURLFile;
use Exception;
use Config\TelegramEndPoints;
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
        $telegram->run(function() use ($telegram) {
            // $telegram->handleUpdate();
            // $update = $telegram->getUpdate();
            
            // $messageType = $telegram->detectMessageType($update);
            // $fileID = $telegram->getFileId($update, $messageType);
            // return $telegram->downloadFile($fileID, __DIR__ .'/');

            $chatId = $update["message"]["chat"]["id"] ?? null;
            $userText = $update["message"]["text"] ?? "";
            $chatId = -1002268939731;
            $userId = 7166464236; 
            $data = [
                "chat_id" => $chatId,
                'photo' => new CURLFile(__DIR__ . '/../../storage/file/img/h.png'),
            ];

            $result = $telegram->send($data,TelegramEndPoints::sendPhoto());
            file_put_contents(__DIR__ . '/../../storage/logs/TelegramBot.log', print_r(json_decode($result), true));
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