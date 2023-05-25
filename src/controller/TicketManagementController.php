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

    /**
     * Marks a {@see Ticket} as resolved.
     * @return void
     */
    public static function resolveTicket(): void
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

        $hostname = $_SERVER['HTTP_HOST'];
        if(!isset($_POST['id']) || !is_numeric($_POST['id']))
        {
            header("Location: http://$hostname/".ROOT_URI.'index.php/backoffice/tickets');
            exit();
        }

        $ticket = Ticket::fetchFromId($_POST['id']);
        $success = $ticket->resolve();

        if($success)
        {
            $_SESSION['successMessage'] = "Le ticket n°{$ticket->getId()} a bien été marqué comme résolu.";
            header("Location: http://$hostname/".ROOT_URI.'index.php/backoffice/tickets?success');
        }
        else
        {
            $_SESSION['errorMessage'] = "Erreur lors de la résolution du ticket n°{$ticket->getId()}.";
            header("Location: http://$hostname/".ROOT_URI.'index.php/backoffice/tickets?error');
        }
    }

    /**
     * Marks a {@see Ticket} as closed.
     * @return void
     */
    public static function closeTicket(): void
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

        $hostname = $_SERVER['HTTP_HOST'];
        if(!isset($_POST['id']) || !is_numeric($_POST['id']))
        {
            header("Location: http://$hostname/".ROOT_URI.'index.php/backoffice/tickets');
            exit();
        }

        $ticket = Ticket::fetchFromId($_POST['id']);
        $success = $ticket->close();

        if($success)
        {
            $_SESSION['successMessage'] = "Le ticket n°{$ticket->getId()} a bien été fermé.";
            header("Location: http://$hostname/".ROOT_URI.'index.php/backoffice/tickets?success');
        }
        else
        {
            $_SESSION['errorMessage'] = "Erreur lors de la fermeture du ticket n°{$ticket->getId()}.";
            header("Location: http://$hostname/".ROOT_URI.'index.php/backoffice/tickets?error');
        }
    }

    /**
     * Reopens a closed or resolved {@see Ticket}.
     * @return void
     */
    public static function reopenTicket(): void
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

        $hostname = $_SERVER['HTTP_HOST'];
        if(!isset($_POST['id']) || !is_numeric($_POST['id']))
        {
            header("Location: http://$hostname/".ROOT_URI.'index.php/backoffice/tickets');
            exit();
        }

        $ticket = Ticket::fetchFromId($_POST['id']);
        $success = $ticket->reopen();

        if($success)
        {
            $_SESSION['successMessage'] = "Le ticket n°{$ticket->getId()} a bien été rouvert.";
            header("Location: http://$hostname/".ROOT_URI.'index.php/backoffice/tickets?success');
        }
        else
        {
            $_SESSION['errorMessage'] = "Erreur lors de la réouverture du ticket n°{$ticket->getId()}.";
            header("Location: http://$hostname/".ROOT_URI.'index.php/backoffice/tickets?error');
        }
    }

    /**
     * Renders the view containing the detail of a Ticket (management only).
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
        else if(User::fetchFromEmail($_SESSION['email'])->getPermissionLevel() < MANAGER)
        {
            header("HTTP/1.1 403 Forbidden");
            require('src/view/403.html');
            exit;
        }

        if(!isset($_GET['id']) || !is_numeric($_GET['id']))
        {
            header("Location: http://$hostname/".ROOT_URI.'index.php/backoffice/tickets');
            exit;
        }
        $ticket = Ticket::fetchFromId($_GET['id']);

        if(is_null($ticket))
        {
            header("Location: http://$hostname/".ROOT_URI.'index.php/backoffice/tickets');
            exit;
        }

        require('src/view/ticketManagementDetail.php');
    }
}