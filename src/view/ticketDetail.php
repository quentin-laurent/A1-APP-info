<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>PortAn / Ticket n° <?php echo $ticket->getId() ?></title>
    <link rel="stylesheet" href="../../static/css/navbar.css">
    <link rel="icon" type="image/x-icon" href="../../static/img/infinitemeasures-logo.png">
    <script src="../../static/js/navbar.js"></script>
    <link rel="stylesheet" href="../../static/css/ticketDetail.css">
</head>

<?php include('src/view/navbar.php'); ?>

<body>
    <h1>Détail du ticket n°<?php echo $ticket->getId(); ?></h1>
    <hr>
    <?php $author = User::fetchFromEmail($ticket->getAuthorEmail()); ?>
    <div class=ticket>
        <div id="ticket-intro">
            <p class=ticket-title>Ticket n°<?php echo $ticket->getId() ?>: <?php echo $ticket->getTitle(ENT_NOQUOTES) ?></p>
            <?php
                if($ticket->isOpen())
                    echo "<p class='ticket-status open'>[Ouvert]</p>";
                else if($ticket->isResolved())
                    echo "<p class='ticket-status resolved'>[Résolu]</p>";
                else
                    echo "<p class='ticket-status closed'>[Fermé]</p>";
            ?>
        </div>
        <hr>
        <div class=ticket-tags>
            <?php
                $tags = $ticket->getTags();
                foreach($tags as $tag)
                    echo "<span class='tag {$tag->getName()}'>{$tag->getName()}</span>"
            ?>
        </div>
        <p class=desc>Description:</p>
        <p class=ticket-description><?php echo $ticket->getDescription(true) ?></p>
        <div class=ticket-footer>
            <p class=ticket-author>Auteur: <?php echo "{$author->getFirstname()} {$author->getLastname()}";?></p>
            <div class=ticket-buttons>
                <?php
                    if($ticket->isOpen())
                        echo "<a class='ticket-button modify' href='add?id={$ticket->getId()}'>Modifier</a>";
                    else
                        echo "<button class='ticket-button modify disabled' disabled>Modifier</button>"
                ?>

            </div>
        </div>
    </div>
</body>
</html>