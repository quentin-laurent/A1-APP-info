<?php
session_start();
require_once('src/controller/LoginController.php');
require_once('src/controller/HomeController.php');
require_once('src/controller/UserManagementController.php');
require_once('src/model/FAQ.php');
require_once('src/controller/FAQController.php');
require_once('src/controller/FAQManagementController.php');
require_once('src/model/Ticket.php');
require_once('src/controller/TicketController.php');

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
// POST endpoint used to search users from the user management page
else if($uri === '/'.ROOT_URI.'index.php/backoffice/users/search' && $method === 'POST') {
    UserManagementController::searchUser();
}
// GET endpoint for the FAQ
else if($uri === '/'.ROOT_URI.'index.php/faq' && $method === 'GET') {
    FAQController::displayFAQPage();
}
// GET endpoint for the FAQ management
else if($uri === '/'.ROOT_URI.'index.php/backoffice/faq' && $method === 'GET') {
    FAQManagementController::displayFAQManagementPage();
}
// GET endpoint to create a new FAQ
else if($uri === '/'.ROOT_URI.'index.php/backoffice/faq/add' && $method === 'GET') {
    FAQManagementController::displayFAQAddPage();
}
// POST endpoint used to add a new FAQ
else if($uri === '/'.ROOT_URI.'index.php/backoffice/faq/add' && $method === 'POST') {
    FAQManagementController::addFAQ();
}
// POST endpoint used to delete a FAQ
else if($uri === '/'.ROOT_URI.'index.php/backoffice/faq/delete' && $method === 'POST') {
    FAQManagementController::deleteFAQ();
}
// GET endpoint for the Tickets page
else if($uri === '/'.ROOT_URI.'index.php/tickets' && $method === 'GET') {
    TicketController::displayTicketsPage();
}
else {
    $hostname = $_SERVER['HTTP_HOST'];
    header("Location: http://$hostname/".ROOT_URI.'index.php/home');
}
