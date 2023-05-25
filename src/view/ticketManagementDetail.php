<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>PortAn / Ticket n° <?php echo $ticket->getId() ?></title>
    <link rel="stylesheet" href="../../../static/css/navbar.css">
    <link rel="icon" type="image/x-icon" href="../../../static/img/infinitemeasures-logo.png">
    <script src="../../../static/js/navbar.js"></script>
    <link rel="stylesheet" href="../../../static/css/ticketManagementDetail.css">
</head>

<?php include('src/view/navbar.php'); ?>

<body>
<h1>Détail du ticket n°<?php echo $ticket->getId(); ?></h1>
<hr>
<?php $author = User::fetchFromEmail($ticket->getAuthorEmail()); ?>
<div class=ticket>
    <?php
        echo "<form id=resolve{$ticket->getId()} action=resolve method=POST><input type=hidden name=id value={$ticket->getId()}></form>";
        echo "<form id=close{$ticket->getId()} action=close method=POST><input type=hidden name=id value={$ticket->getId()}></form>";
        echo "<form id=reopen{$ticket->getId()} action=reopen method=POST><input type=hidden name=id value={$ticket->getId()}></form>";
    ?>
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
                if($ticket->isResolved() || !$ticket->isOpen())
                    echo "<button class='ticket-button reopen' type=submit form=reopen{$ticket->getId()}>Rouvrir</button>";
                if($ticket->isOpen())
                {
                    echo "<button class='ticket-button resolve' type=submit form=resolve{$ticket->getId()}>Résoudre</button>";
                    echo "<button class='ticket-button close' type=submit form=close{$ticket->getId()}>Fermer</button>";
                }
            ?>

        </div>
    </div>
</div>
</body>
</html>