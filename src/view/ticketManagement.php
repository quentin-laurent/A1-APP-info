<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>PortAn / Gestion des tickets</title>
    <link rel="stylesheet" href="../../static/css/navbar.css">
    <link rel="icon" type="image/x-icon" href="../../static/img/infinitemeasures-logo.png">
    <script src="../../static/js/navbar.js"></script>
    <link rel="stylesheet" href="../../static/css/ticketManagement.css">
</head>

<?php include('src/view/navbar.php'); ?>

<body>
<h1>Gestion des tickets</h1>
<hr>

<?php
if(isset($_GET['success']) && isset($_SESSION['successMessage']))
{
    echo "<p id=success-message>{$_SESSION['successMessage']}</p>";
    unset($_SESSION['successMessage']);
}
if(isset($_GET['error']) && isset($_SESSION['errorMessage'])) {
    echo "<p id=error-message>{$_SESSION['errorMessage']}</p>";
    unset($_SESSION['errorMessage']);
}
?>

<div id="tickets">
    <?php
    foreach($tickets as $ticket)
    {
        $author = User::fetchFromEmail($ticket->getAuthorEmail());
        echo "
                <div class=ticket>
                    <form id=resolve{$ticket->getId()} action=tickets/resolve method=POST><input type=hidden name=id value={$ticket->getId()}></form>
                    <form id=close{$ticket->getId()} action=tickets/close method=POST><input type=hidden name=id value={$ticket->getId()}></form>
                    <form id=reopen{$ticket->getId()} action=tickets/reopen method=POST><input type=hidden name=id value={$ticket->getId()}></form>
                    <div id=ticket-intro>
                        <p class=ticket-title>Ticket n°{$ticket->getId()}: {$ticket->getTitle(ENT_NOQUOTES)}</p>
                ";
        if($ticket->isOpen())
            echo "<p class='ticket-status open'>[Ouvert]</p>";
        else if($ticket->isResolved())
            echo "<p class='ticket-status resolved'>[Résolu]</p>";
        else
            echo "<p class='ticket-status closed'>[Fermé]</p>";
        echo "
                    </div>
                    <hr>
                    <div class=ticket-tags>
                    ";

        $tags = $ticket->getTags();
        foreach ($tags as $tag)
            echo "<span class='tag {$tag->getName()}'>{$tag->getName()}</span>";

        echo "
                </div>
                    <p class=desc>Description:</p>
                    <p class=ticket-description>{$ticket->getDescription(true)}</p>
                    <div class=ticket-footer>
                        <p class=ticket-author>Auteur: {$author->getFirstname()} {$author->getLastname()}</p>
                        <div class=ticket-buttons>
                            <a class='ticket-button more' href='tickets/detail?id={$ticket->getId()}'>Détail</a>
             ";
        if($ticket->isResolved() || !$ticket->isOpen())
            echo "<button class='ticket-button reopen' type=submit form=reopen{$ticket->getId()}>Rouvrir</button>";
        if($ticket->isOpen())
        {
            echo "<button class='ticket-button resolve' type=submit form=resolve{$ticket->getId()}>Résoudre</button>";
            echo "<button class='ticket-button close' type=submit form=close{$ticket->getId()}>Fermer</button>";
        }

        echo "
                        </div>
                    </div>
                </div>
            ";
    }
    ?>
</div>
</body>
</html>