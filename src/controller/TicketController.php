<?php

class TicketController
{
    // Methods

    /**
     * Renders the view corresponding to the Tickets page.
     * @return void
     */
    public static function displayTicketsPage(): void
    {
        if(!isset($_SESSION['email']))
        {
            header("HTTP/1.1 401 Unauthorized");
            require('src/view/401.html');
            exit;
        }

        $tickets = Ticket::fetchFromAuthor($_SESSION['email']);
        require('src/view/tickets.php');
    }

    /**
     * Renders the view containing the form used to create a new Ticket.
     * @return void
     */
    public static function displayTicketAddPage(): void
    {
        if(!isset($_SESSION['email']))
        {
            header("HTTP/1.1 401 Unauthorized");
            require('src/view/401.html');
            exit;
        }
        require('src/view/addTicket.php');
    }
}