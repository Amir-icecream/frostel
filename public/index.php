<?php
use Core\Request;
use Core\Route;
use Core\Session;
use Core\Bootstrap;
use Dotenv\Dotenv;

require_once(__DIR__ . "/../vendor/autoload.php");

try {
    $dotenv = Dotenv::createImmutable(__DIR__ . '/../');
    $dotenv->load();
} catch (\Exception $e) {
    throw new Exception("Environment load error : " . $e->getMessage());
}

Bootstrap::php_configuration();
Bootstrap::exeption_handeler();
if(Bootstrap::ApiCheck(Request::Url()))
{
    require_once(__DIR__ . "/../routes/api.php");
}
else
{
    Session::Start();
    require_once(__DIR__ . "/../routes/web.php");
}
Route::Dispatch(Request::Url(),Request::Method());
