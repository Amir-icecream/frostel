<?php
namespace Config;

use Exception;

class TelegramEndPoints{
    private static $botToken;
    private static $endPoints;

    private static function init() {
        if(!empty(self::$endPoints)) return;
        self::$botToken = $_ENV['TELEGRAM_BOT_TOKEN'] ?? '';
        if(!self::$botToken)
        {
            throw new Exception("TELEGRAM_BOT_TOKEN is not set.");
        }

        self::$endPoints = [
            // sending endpoints
            'sendMessage'           => "https://api.telegram.org/bot" . self::$botToken . "/sendMessage",
            'sendPhoto'             => "https://api.telegram.org/bot" . self::$botToken . "/sendPhoto",
            'sendAudio'             => "https://api.telegram.org/bot" . self::$botToken . "/sendAudio",
            'sendDocument'          => "https://api.telegram.org/bot" . self::$botToken . "/sendDocument",
            'sendVideo'             => "https://api.telegram.org/bot" . self::$botToken . "/sendVideo",
            'sendAnimation'         => "https://api.telegram.org/bot" . self::$botToken . "/sendAnimation",
            'sendVoice'             => "https://api.telegram.org/bot" . self::$botToken . "/sendVoice",
            'sendVideoNote'         => "https://api.telegram.org/bot" . self::$botToken . "/sendVideoNote",
            'sendMediaGroup'        => "https://api.telegram.org/bot" . self::$botToken . "/sendMediaGroup",
            'sendLocation'          => "https://api.telegram.org/bot" . self::$botToken . "/sendLocation",
            'sendVenue'             => "https://api.telegram.org/bot" . self::$botToken . "/sendVenue",
            'sendContact'           => "https://api.telegram.org/bot" . self::$botToken . "/sendContact",
            'editMessageText'       => "https://api.telegram.org/bot" . self::$botToken . "/editMessageText",
            'deleteMessage'         => "https://api.telegram.org/bot" . self::$botToken . "/deleteMessage",
            'setWebhook'            => "https://api.telegram.org/bot" . self::$botToken . "/setWebhook",
            'deleteWebhook'         => "https://api.telegram.org/bot" . self::$botToken . "/deleteWebhook",
            'kickChatMember'        => "https://api.telegram.org/bot" . self::$botToken . "/kickChatMember",
            'unbanChatMember'       => "https://api.telegram.org/bot" . self::$botToken . "/unbanChatMember",
            'restrictChatMember'    => "https://api.telegram.org/bot" . self::$botToken . "/restrictChatMember",
            'promoteChatMember'     => "https://api.telegram.org/bot" . self::$botToken . "/promoteChatMember",
            'answerCallbackQuery'   => "https://api.telegram.org/bot" . self::$botToken . "/answerCallbackQuery",
            'answerInlineQuery'     => "https://api.telegram.org/bot" . self::$botToken . "/answerInlineQuery",
            'sendDice'              => "https://api.telegram.org/bot" . self::$botToken . "/sendDice",
            // receiving endpoints
            'getFile'               => "https://api.telegram.org/bot" . self::$botToken . "/getFile?",
            'getMe'                 => "https://api.telegram.org/bot" . self::$botToken . "/getMe",
            'getUpdates'            => "https://api.telegram.org/bot" . self::$botToken . "/getUpdates?",
            'getWebhookInfo'        => "https://api.telegram.org/bot" . self::$botToken . "/getWebhookInfo?",
            'getChat'               => "https://api.telegram.org/bot" . self::$botToken . "/getChat?",
            'getChatAdministrators' => "https://api.telegram.org/bot" . self::$botToken . "/getChatAdministrators?",
            'getChatMembersCount'   => "https://api.telegram.org/bot" . self::$botToken . "/getChatMembersCount?",
            'getChatMember'         => "https://api.telegram.org/bot" . self::$botToken . "/getChatMember?",
            
        ];
    }

    private static function get($name){
        $endPoint = 
        return 'https://api.telegram.org/bot' . self::$botToken . '/' . $name;
    }

    public static function __callStatic($name, $arguments)
    {
        self::init();
        if(!array_key_exists($name,self::$endPoints))
        {
            error_log("function: {$name} not found in TelegramEndPoints");
            throw new Exception("function: {$name} not found in TelegramEndPoints");
        }

        $endPoint = self::$endPoints[$name];
        return $endPoint;
    }
    
}