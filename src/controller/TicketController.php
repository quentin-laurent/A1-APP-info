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

    /**
     * Adds a new Ticket to the database.
     * @return void
     */
    public static function addTicket(): void
    {
        if(!isset($_SESSION['email']))
        {
            header("HTTP/1.1 401 Unauthorized");
            require('src/view/401.html');
            exit;
        }

        (isset($_POST['id'])) ? $ticket = Ticket::fetchFromId($_POST['id']) : $ticket = null;
        if(!is_null($ticket))
        {
            TicketController::updateTicket($ticket);
            return;
        }

        $success = Ticket::add(new Ticket($_POST['title'], $_POST['description'], true, $_SESSION['email'], NULL), $_POST['tag-type'], $_POST['tag-priority']);

        $hostname = $_SERVER['HTTP_HOST'];
        if($success)
        {
            $_SESSION['successMessage'] = "Nouveau ticket créé.";
            header("Location: http://$hostname/".ROOT_URI.'index.php/tickets?success');
        }
        else
        {
            $_SESSION['errorMessage'] = "Erreur lors de la création du ticket.";
            header("Location: http://$hostname/".ROOT_URI.'index.php/tickets?error');
        }
    }

    /**
     * Updates a Ticket in the database.
     * @return void
     */
    private static function updateTicket(Ticket $ticket): void
    {
        $success = $ticket->update($_POST['title'], $_POST['description'], $_POST['tag-type'], $_POST['tag-priority']);

        $hostname = $_SERVER['HTTP_HOST'];
        if($success)
        {
            $_SESSION['successMessage'] = "Le ticket a bien été modifié.";
            header("Location: http://$hostname/".ROOT_URI.'index.php/tickets?success');
        }
        else
        {
            $_SESSION['errorMessage'] = "Erreur lors de la modification du ticket.";
            header("Location: http://$hostname/".ROOT_URI.'index.php/tickets?error');
        }
    }
}