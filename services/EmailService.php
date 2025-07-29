<?php
namespace Services;

use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\Address;

class EmailService{
    private static $maildns;
    private static $transport;
    private static $mailer;
    private static $senderName;

    public static function init()
    {   
        $email_protocol = $_ENV['EMAIL_PROTOCOL'] ?? 'smtp';
        $emial_username = $_ENV['Email_username'] ?? '';
        $email_password = $_ENV['EMAIL_PASSWORD'] ?? '';
        $email_host = $_ENV['EMAIL_HOST'] ?? '';
        $email_port = $_ENV['EMAIL_PORT'] ?? '587';

        self::$maildns = $email_protocol . '://' . $emial_username . ':' . $email_password . '@' . $email_host . ':' . $email_port;
        self::$transport = Transport::fromDsn(self::$maildns);
        self::$mailer = new Mailer(self::$transport);
        self::$senderName = $_ENV['APP_NAME'] ?? 'frostel';
    }

    public static function sendEmail($to, $subject, $body,$from,$fromName = null)
    {
        self::init();
        if(is_null($fromName)){
            $fromName = self::$senderName;
        }

        if(!filter_var($from, FILTER_VALIDATE_EMAIL)){
            throw new \InvalidArgumentException("Invalid email address: $from");
        }
        if(!filter_var($to, FILTER_VALIDATE_EMAIL)){
            throw new \InvalidArgumentException("Invalid email address: $to");
        }

        $email = (new Email())
            ->from(new Address($from, $fromName))
            ->to($to)
            ->subject($subject)
            ->html($body)
            ->text('Your email client does not support HTML content.');
        
        try {
            self::$mailer->send($email);
            return true;
        } catch (\Throwable $th) {
            error_log('Email sending failed: ' . $th->getMessage());
            return false;
        }
    }
}