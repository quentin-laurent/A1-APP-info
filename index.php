<?php
session_start();
require_once('src/controller/LoginController.php');
require_once('src/controller/HomeController.php');
require_once('src/controller/UserManagementController.php');
require_once('src/model/FAQ.php');
require_once('src/controller/FAQController.php');
require_once('src/controller/FAQManagementController.php');
require_once('src/model/Ticket.php');
require_once('src/model/Tag.php');
require_once('src/controller/TicketController.php');
require_once('src/controller/TicketManagementController.php');
require_once('src/controller/UserProfileController.php');
require_once('src/model/Product.php');
require_once('src/controller/DataController.php');
require_once('src/model/Metric.php');
require_once('src/controller/MetricController.php');
require_once('src/controller/ContactController.php');

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
// GET endpoint to create a new Ticket
else if($uri === '/'.ROOT_URI.'index.php/tickets/add' && $method === 'GET') {
    TicketController::displayTicketAddPage();
}
// POST endpoint used to add a new Ticket
else if($uri === '/'.ROOT_URI.'index.php/tickets/add' && $method === 'POST') {
    TicketController::addTicket();
}
// GET endpoint to display the detail of a Ticket
else if($uri === '/'.ROOT_URI.'index.php/tickets/detail' && $method === 'GET') {
    TicketController::displayTicketDetailPage();
}
// GET endpoint for the Ticket management
else if($uri === '/'.ROOT_URI.'index.php/backoffice/tickets' && $method === 'GET') {
    TicketManagementController::displayTicketManagementPage();
}
// POST endpoint to resolve a Ticket
else if($uri === '/'.ROOT_URI.'index.php/backoffice/tickets/resolve' && $method === 'POST') {
    TicketManagementController::resolveTicket();
}
// POST endpoint to close a Ticket
else if($uri === '/'.ROOT_URI.'index.php/backoffice/tickets/close' && $method === 'POST') {
    TicketManagementController::closeTicket();
}
// POST endpoint to reopen a Ticket
else if($uri === '/'.ROOT_URI.'index.php/backoffice/tickets/reopen' && $method === 'POST') {
    TicketManagementController::reopenTicket();
}
// GET endpoint to display the detail of a Ticket (management only)
else if($uri === '/'.ROOT_URI.'index.php/backoffice/tickets/detail' && $method === 'GET') {
    TicketManagementController::displayTicketDetailPage();
}
// GET endpoint to display the user profile page
else if($uri === '/'.ROOT_URI.'index.php/profile' && $method === 'GET') {
    UserProfileController::displayUserProfilePage();
}
// POST endpoint used to update a User
else if($uri === '/'.ROOT_URI.'index.php/profile' && $method === 'POST') {
    UserProfileController::updateUser();
}
// GET endpoint used to display the data page
else if($uri === '/'.ROOT_URI.'index.php/data' && $method === 'GET') {
    DataController::displayDataPage();
}
// POST endpoint used to fetch metrics
else if($uri === '/'.ROOT_URI.'index.php/data/fetchMetrics' && $method === 'POST') {
    MetricController::fetchMetrics();
}
// POST endpoint used to fetch the latest metrics
else if($uri === '/'.ROOT_URI.'index.php/data/fetchLatestMetrics' && $method === 'POST') {
    MetricController::fetchLatestMetrics();
}
// TEMPORARY POST endpoint used to inject metrics
else if($uri === '/'.ROOT_URI.'index.php/data/inject' && $method === 'POST') {
    MetricController::injectMetric();
}
// GET endpoint used to display the CGU page
else if($uri === '/'.ROOT_URI.'index.php/cgu' && $method === 'GET') {
    require('src/view/cgu.php');
}
// GET endpoint used to display the TOS page
else if($uri === '/'.ROOT_URI.'index.php/mentionsLegales' && $method === 'GET') {
    require('src/view/mentionsLegales.php');
}
// GET endpoint used to display the FAQ page
else if($uri === '/'.ROOT_URI.'index.php/faq' && $method === 'GET') {
    require('src/view/faq.php');
}
// GET endpoint used to display the contact page
else if($uri === '/'.ROOT_URI.'index.php/contact' && $method === 'GET') {
    ContactController::displayContactPage();
}
// POST endpoint used to send the message created using the contact form
else if($uri === '/'.ROOT_URI.'index.php/contact' && $method === 'POST') {
    ContactController::sendMessage();
}
else {
    $hostname = $_SERVER['HTTP_HOST'];
    header("Location: http://$hostname/".ROOT_URI.'index.php/home');
}
