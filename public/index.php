<?php
use Core\Request;
use Core\Route;
use Core\Session;
use Core\Bootstrap;
use Core\Error_Handler;
use Dotenv\Dotenv;

require_once(__DIR__ . "/../vendor/autoload.php");

try {
    $dotenv = Dotenv::createImmutable(__DIR__ . '/../');
    $dotenv->load();
} catch (\Exception $e) {
    throw new Exception("Environment load error : " . $e->getMessage());
}

Bootstrap::php_configuration();
Error_Handler::exeption_handeler();

Bootstrap::initializeRequest();
