<?php
namespace Config;

class TelegramEndPoints{
    private static $botToken;

    private static function init() {
        if(!self::$botToken)
        {
            self::$botToken = $_ENV['TELEGRAM_BOT_TOKEN'] ?? '';
        }
    }
    //sending endpoints
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
    public static function sendAudio()
    {
        self::init();
        return "https://api.telegram.org/bot" . self::$botToken . "/sendAudio";
    }
    public static function sendDocument()
    {
        self::init();
        return "https://api.telegram.org/bot" . self::$botToken . "/sendDocument";
    }
    public static function sendVideo()
    {
        self::init();
        return "https://api.telegram.org/bot" . self::$botToken . "/sendVideo";
    }
    public static function sendAnimation()
    {
        self::init();
        return "https://api.telegram.org/bot" . self::$botToken . "/sendAnimation";
    }
    public static function sendVoice()
    {
        self::init();
        return "https://api.telegram.org/bot" . self::$botToken . "/sendVoice";
    }
    public static function sendVideoNote()
    {
        self::init();
        return "https://api.telegram.org/bot" . self::$botToken . "/sendVideoNote";
    }
    public static function sendMediaGroup()
    {
        self::init();
        return "https://api.telegram.org/bot" . self::$botToken . "/sendMediaGroup";
    }
    public static function sendLocation()
    {
        self::init();
        return "https://api.telegram.org/bot" . self::$botToken . "/sendLocation";
    }
    public static function sendVenue()
    {
        self::init();
        return "https://api.telegram.org/bot" . self::$botToken . "/sendVenue";
    }
    public static function sendContact()
    {
        self::init();
        return "https://api.telegram.org/bot" . self::$botToken . "/sendContact";
    }
    public static function editMessageText()
    {
        self::init();
        return "https://api.telegram.org/bot" . self::$botToken . "/editMessageText";
    }
    public static function deleteMessage()
    {
        self::init();
        return "https://api.telegram.org/bot" . self::$botToken . "/deleteMessage";
    }
    public static function setWebhook()
    {
        self::init();
        return "https://api.telegram.org/bot" . self::$botToken . "/setWebhook";
    }
    public static function deleteWebhook()
    {
        self::init();
        return "https://api.telegram.org/bot" . self::$botToken . "/deleteWebhook";
    }
    public static function kickChatMember()
    {
        self::init();
        return "https://api.telegram.org/bot" . self::$botToken . "/kickChatMember";
    }
    public static function unbanChatMember()
    {
        self::init();
        return "https://api.telegram.org/bot" . self::$botToken . "/unbanChatMember";
    }
    public static function restrictChatMember()
    {
        self::init();
        return "https://api.telegram.org/bot" . self::$botToken . "/restrictChatMember";
    }
    public static function promoteChatMember()
    {
        self::init();
        return "https://api.telegram.org/bot" . self::$botToken . "/promoteChatMember";
    }
    public static function answerCallbackQuery()
    {
        self::init();
        return "https://api.telegram.org/bot" . self::$botToken . "/answerCallbackQuery";
    }
    public static function answerInlineQuery()
    {
        self::init();
        return "https://api.telegram.org/bot" . self::$botToken . "/answerInlineQuery";
    }
    public static function sendDice()
    {
        self::init();
        return "https://api.telegram.org/bot" . self::$botToken . "/sendDice";
    }


    //receiving endpoints
    public static function getFile(){
        self::init();
        return "https://api.telegram.org/bot" . self::$botToken . "/getFile?file_id=";
    }
    public static function getMe(){
        self::init();
        return "https://api.telegram.org/bot" . self::$botToken . "/getMe";
    }
    public static function getUpdates(){
        self::init();
        return "https://api.telegram.org/bot" . self::$botToken . "/getUpdates";
    }
    public static function getWebhookInfo(){
        self::init();
        return "https://api.telegram.org/bot" . self::$botToken . "/getWebhookInfo";
    }
    public static function getChat()
    {
        self::init();
        return "https://api.telegram.org/bot" . self::$botToken . "/getChat";
    }
    public static function getChatAdministrators()
    {
        self::init();
        return "https://api.telegram.org/bot" . self::$botToken . "/getChatAdministrators";
    }
    public static function getChatMembersCount()
    {
        self::init();
        return "https://api.telegram.org/bot" . self::$botToken . "/getChatMembersCount";
    }
    public static function getChatMember()
    {
        self::init();
        return "https://api.telegram.org/bot" . self::$botToken . "/getChatMember";
    }
}