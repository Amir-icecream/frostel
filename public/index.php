<?php
use Core\Request;

require_once(__DIR__ . "/../vendor/autoload.php");

require_once(__DIR__ . "/../routes/web.php");

$Router->Dispatch(Request::Url(),Request::Method());
