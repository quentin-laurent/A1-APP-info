<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <?php
    (isset($_GET['id'])) ? $ticket = Ticket::fetchFromId($_GET['id']) : $ticket = null;
    if(!is_null($ticket))
        echo '<title>PortAn / Modifier un ticket</title>';
    else
        echo '<title>PortAn / Nouveau ticket</title>';
    ?>
    <link rel="stylesheet" href="../../static/css/navbar.css">
    <link rel="icon" type="image/x-icon" href="../../static/img/infinitemeasures-logo.png">
    <script src="../../static/js/navbar.js"></script>
    <link rel="stylesheet" href="../../static/css/addTicket.css">
</head>

<?php include('src/view/navbar.php'); ?>

<body>
<?php
if(!is_null($ticket))
    echo '<h1>Modifier un ticket</h1>';
else
    echo '<h1>Nouveau ticket</h1>';
?>

<form action="add" method="POST">
    <?php
    (isset($_GET['id'])) ? $ticket = Ticker::fetchFromId($_GET['id']) : $ticket = null;
    if(!is_null($ticket))
        echo "<input type=hidden name=id value={$ticket->getId()}>";
    ?>

    <form action="add" method="POST">
        <div class="ticket">
            <p class="ticket-title">
                <?php $nextId = Ticket::getHighestId() + 1; ?>
                <label for="ticket-title-input">Ticket n°<?php echo $nextId; ?>:</label>
                <input id="ticket-title-input" type="text" name="title" maxlength="256" placeholder="Titre" required>
            </p>
            <hr>
            <div id="tag-selectors">
                <div class="tag-selector">
                    <label for="tag-type-input">Type: </label>
                    <select id="tag-type-input" name="tag-type" required>
                        <option value="bug">Bug</option>
                        <option value="suggestion">Suggestion</option>
                        <option value="other">Autre</option>
                    </select>
                </div>
                <div class="tag-selector">
                    <label for="tag-priority-input">Priorité: </label>
                    <select id="tag-priority-input" name="tag-priority" required>
                        <option value="urgent">Urgent</option>
                        <option value="not-urgent">Pas urgent</option>
                    </select>
                </div>
            </div>
            <label for="ticket-description-input" class="desc">Description:</label>
            <textarea id="ticket-description-input" name="description" rows="10" placeholder="Description" required></textarea>
            <div class="ticket-footer">
                <?php $author = User::fetchFromEmail($_SESSION['email']) ?>
                <p class="ticket-author">Auteur: <?php echo "{$author->getFirstname()} {$author->getLastname()}" ?></p>
                <button class="ticket-button create" type="submit">Créer</button>
            </div>
        </div>
    </form>

</form>
</body>
</html>