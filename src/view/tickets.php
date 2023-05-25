<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>PortAn / Tickets</title>
    <link rel="stylesheet" href="../static/css/navbar.css">
    <link rel="icon" type="image/x-icon" href="../static/img/infinitemeasures-logo.png">
    <script src="../static/js/navbar.js"></script>
    <link rel="stylesheet" href="../static/css/tickets.css">
</head>

<?php include('src/view/navbar.php'); ?>

<body>
<h1>Mes tickets</h1>
<hr>
<div id="add-ticket"><a href="tickets/add   "><button type="button">Créer un nouveau ticket</button></a></div>

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
                    <p class=ticket-title>Ticket n°{$ticket->getId()}: {$ticket->getTitle(ENT_NOQUOTES)}</p>
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
                            <a class='ticket-button modify' href='tickets/add?id={$ticket->getId()}'>Modifier</a>
                        </div>
                    </div>
                </div>
            ";
        }
    ?>
</div>
</body>
</html>