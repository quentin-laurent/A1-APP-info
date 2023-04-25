<?php
session_start();
require_once('src/controller/LoginController.php');
require_once('src/controller/HomeController.php');
require_once('src/controller/UserManagementController.php');

const ROOT_URI = 'portan/';

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

if($uri === '/'.ROOT_URI.'index.php' && $method === 'GET') {
    header('Location: index.php/home');
}
// GET endpoint to display the login page
if($uri === '/'.ROOT_URI.'index.php/login' && $method === 'GET') {
    LoginController::displayLoginPage();
}
// GET endpoint to render the home page
else if($uri === '/'.ROOT_URI.'index.php/home' && $method === 'GET') {
    HomeController::displayHomePage();
}
// POST endpoint for Signing up
else if($uri === '/'.ROOT_URI.'index.php/login/signup' && $method === 'POST') {
    LoginController::signUp();
}
// POST endpoint for Signing in
else if($uri === '/'.ROOT_URI.'index.php/login/signin' && $method === 'POST') {
    LoginController::signIn();
}
// GET endpoint for Signing out
else if($uri === '/'.ROOT_URI.'index.php/logout' && $method === 'GET') {
    LoginController::signOut();
}
// GET endpoint for user management
else if($uri === '/'.ROOT_URI.'index.php/backoffice/users' && $method === 'GET') {
    UserManagementController::displayUserManagementPage();
}
// POST endpoint to receive updated user data from the user management page
else if($uri === '/'.ROOT_URI.'index.php/backoffice/users' && $method === 'POST') {
    UserManagementController::updateUser();
}
// POST endpoint used to ban or unban users from the user management page
else if($uri === '/'.ROOT_URI.'index.php/backoffice/users/ban' && $method === 'POST') {
    UserManagementController::banOrUnbanUser();
}
// POST endpoint used to delete users from the user management page
else if($uri === '/'.ROOT_URI.'index.php/backoffice/users/delete' && $method === 'POST') {
    UserManagementController::deleteUser();
}
else if($uri === '/'.ROOT_URI.'index.php/test' && $method === 'GET') {
    require('test.php');
}
