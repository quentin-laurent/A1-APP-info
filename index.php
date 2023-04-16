<?php
require_once('src/controller/LoginController.php');
require_once('src/controller/HomeController.php');

const ROOT_URI = 'portan/';

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
if("/".ROOT_URI."index.php/login" === $uri)  {
    LoginController::displayLoginPage();
}
else if("/".ROOT_URI."index.php/home" === $uri) {
    HomeController::displayHomePage();
}
else if("/".ROOT_URI."index.php/test" === $uri) {
    require('test.php');
}
