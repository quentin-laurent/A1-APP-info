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
            $hostname = $_SERVER['HTTP_HOST'];
            header("Location: http://$hostname/".ROOT_URI.'index.php/login');
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

        ((isset($_GET['id'])) && (is_numeric($_GET['id']))) ? $ticket = Ticket::fetchFromId($_GET['id']) : $ticket = null;

        if(isset($ticket) && $ticket->getAuthorEmail() != $_SESSION['email'])
        {
            header("HTTP/1.1 403 Forbidden");
            require('src/view/403.html');
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
        if($ticket->getAuthorEmail() != $_SESSION['email'])
        {
            header("HTTP/1.1 403 Forbidden");
            require('src/view/403.html');
            exit;
        }

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

    /**
     * Renders the view containing the detail of a Ticket.
     * @return void
     */
    public static function displayTicketDetailPage(): void
    {
        $hostname = $_SERVER['HTTP_HOST'];
        if(!isset($_SESSION['email']))
        {
            header("HTTP/1.1 401 Unauthorized");
            require('src/view/401.html');
            exit;
        }
        if(!isset($_GET['id']) || !is_numeric($_GET['id']))
        {
            header("Location: http://$hostname/".ROOT_URI.'index.php/home');
            exit;
        }
        $ticket = Ticket::fetchFromId($_GET['id']);

        if(is_null($ticket))
        {
            header("Location: http://$hostname/".ROOT_URI.'index.php/home');
            exit;
        }

        if($ticket->getAuthorEmail() != $_SESSION['email'])
        {
            header("HTTP/1.1 403 Forbidden");
            require('src/view/403.html');
            exit;
        }

        require('src/view/ticketDetail.php');
    }
}