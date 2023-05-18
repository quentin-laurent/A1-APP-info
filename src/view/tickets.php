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
<div id="add-ticket"><a href="tickets/add   "><button type="button">Créer un nouveau ticket</button></a></div>

<div id="tickets">
    <?php
        foreach($tickets as $ticket)
        {
            $author = User::fetchFromEmail($ticket->getAuthorEmail());
            echo "
                <div class=ticket>
                    <p class=ticket-title>Ticket n°{$ticket->getId()}: {$ticket->getTitle()}</p>
                    <hr>
                    <div class=ticket-tags>
                        <span class='tag bug'>bug</span>
                        <span class='tag urgent'>urgent</span>
                    </div>
                    <p class=desc>Description:</p>
                    <p class=ticket-description>{$ticket->getDescription()}</p>
                    <div class=ticket-footer>
                        <p class=ticket-author>Auteur: {$author->getFirstname()} {$author->getLastname()}</p>
                        <div class=ticket-buttons>
                            <button class='ticket-button more' type=button>Détail</button>
                            <button class='ticket-button answer' type=button>Répondre</button>
                            <button class='ticket-button close' type=button>Fermer</button>
                        </div>
                    </div>
                </div>
            ";
        }
    ?>
    <!--
    <div class="ticket">
        <p class="ticket-title">Ticket n°0</p>
        <hr>
        <div class="ticket-tags">
            <span class="tag bug">bug</span>
            <span class="tag urgent">urgent</span>
        </div>
        <p class="desc">Description:</p>
        <p class="ticket-description">
            The "Login" and "Register" buttons overlap on the navigation bar of the home page.
            This makes it difficult to access the "Register" button. This is a very long text that will probably cause the ticket to increase in size.
            This is not greta because this will disrupt the overall arrangement. This should be fixed by truncating the text (aka using an ellipse) so that all the tickets have the same size
            even if someone bothers to write a novel like me.
            The "Login" and "Register" buttons overlap on the navigation bar of the home page.
            This makes it difficult to access the "Register" button. This is a very long text that will probably cause the ticket to increase in size.
            This is not greta because this will disrupt the overall arrangement. This should be fixed by truncating the text (aka using an ellipse) so that all the tickets have the same size
            even if someone bothers to write a novel like me.
        </p>
        <div class="ticket-footer">
            <p class="ticket-author">Auteur: John Doe</p>
            <div class="ticket-buttons">
                <button class="ticket-button more" type="button">Détail</button>
                <button class="ticket-button answer" type="button">Répondre</button>
                <button class="ticket-button close" type="button">Fermer</button>
            </div>
        </div>
    </div>

    <div class="ticket">
        <p class="ticket-title">Ticket n°0</p>
        <hr>
        <div class="ticket-tags">
            <span class="tag bug">bug</span>
            <span class="tag urgent">urgent</span>
        </div>
        <p class="desc">Description:</p>
        <p class="ticket-description">
            The "Login" and "Register" buttons overlap on the navigation bar of the home page.<br>
            This makes it difficult to access the "Register" button.<br>
            Please fix ASAP.
        </p>
        <div class="ticket-footer">
            <p class="ticket-author">Auteur: John Doe</p>
            <div class="ticket-buttons">
                <button class="ticket-button more type="button">Détail</button>
                <button class="ticket-button answer" type="button">Répondre</button>
                <button class="ticket-button close" type="button">Fermer</button>
            </div>
        </div>
    </div>

    <div class="ticket">
        <p class="ticket-title">Ticket n°0</p>
        <hr>
        <div class="ticket-tags">
            <span class="tag bug">bug</span>
            <span class="tag urgent">urgent</span>
        </div>
        <p class="desc">Description:</p>
        <p class="ticket-description">The "Login" and "Register" buttons overlap on the navigation bar of the home page. This makes it difficult to access the "Register" button.</p>
        <div class="ticket-footer">
            <p class="ticket-author">Auteur: John Doe</p>
            <div class="ticket-buttons">
                <button class="ticket-button more type="button">Détail</button>
                <button class="ticket-button answer" type="button">Répondre</button>
                <button class="ticket-button close" type="button">Fermer</button>
            </div>
        </div>
    </div>

    <div class="ticket">
        <p class="ticket-title">Ticket n°0</p>
        <hr>
        <div class="ticket-tags">
            <span class="tag bug">bug</span>
            <span class="tag urgent">urgent</span>
        </div>
        <p class="desc">Description:</p>
        <p class="ticket-description">The "Login" and "Register" buttons overlap on the navigation bar of the home page. This makes it difficult to access the "Register" button.</p>
        <div class="ticket-footer">
            <p class="ticket-author">Auteur: John Doe</p>
            <div class="ticket-buttons">
                <button class="ticket-button more type="button">Détail</button>
                <button class="ticket-button answer" type="button">Répondre</button>
                <button class="ticket-button close" type="button">Fermer</button>
            </div>
        </div>
    </div>
    -->
</div>
</body>
</html>