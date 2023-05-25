<?php

class TicketManagementController
{
    // Methods

    /**
     * Renders the view corresponding to the Ticket management page.
     * @return void
     */
    public static function displayTicketManagementPage(): void
    {
        if(!isset($_SESSION['email']))
        {
            header("HTTP/1.1 401 Unauthorized");
            require('src/view/401.html');
            exit;
        }
        else if(User::fetchFromEmail($_SESSION['email'])->getPermissionLevel() < MANAGER)
        {
            header("HTTP/1.1 403 Forbidden");
            require('src/view/403.html');
            exit;
        }

        $tickets = Ticket::fetchAllTickets();
        require('src/view/ticketManagement.php');
    }
}