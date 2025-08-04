<?php
namespace Config;

use Exception;

class TelegramEndPoints{
    private static $botToken;
    private static $endPoints;
    private static $baseUrl = 'https://api.telegram.org/bot';

    private static function init() {
        if(!empty(self::$endPoints)) return;
        self::$botToken = $_ENV['TELEGRAM_BOT_TOKEN'] ?? '';
        if(!self::$botToken)
        {
            throw new Exception("TELEGRAM_BOT_TOKEN is not set.");
        }

        self::$endPoints = [
            // sending endpoints
            'sendMessage',
            'sendPhoto',
            'sendAudio',
            'sendDocument',
            'sendVideo',
            'sendAnimation',
            'sendVoice',
            'sendVideoNote',
            'sendMediaGroup',
            'sendLocation',
            'sendVenue',
            'sendContact',
            'editMessageText',
            'deleteMessage',
            'setWebhook',
            'deleteWebhook',
            'kickChatMember',
            'unbanChatMember',
            'restrictChatMember',
            'promoteChatMember',
            'answerCallbackQuery',
            'answerInlineQuery',
            'sendDice',
            // receiving endpoints
            'getFile',
            'getMe',
            'getUpdates',
            'getWebhookInfo',
            'getChat',
            'getChatAdministrators',
            'getChatMembersCount',
            'getChatMember',
            
        ];
    }

    public static function all(){
        self::init();
        return self::$endPoints;
    }

    public static function __callStatic($name, $arguments)
    {
        self::init();
        if(!in_array($name,self::$endPoints))
        {
            error_log("function: {$name} not found in TelegramEndPoints");
            throw new Exception("function: {$name} not found in TelegramEndPoints");
        }
        $endPoint = self::$baseUrl . self::$botToken . "/{$name}";
        if(strpos($name,'get') === 0){
            $endPoint .= '?';
        }
        return $endPoint;
    }
    
}