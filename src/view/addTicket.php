<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <?php
    ((isset($_GET['id'])) && (is_numeric($_GET['id']))) ? $ticket = Ticket::fetchFromId($_GET['id']) : $ticket = null;
    if(!is_null($ticket))
        echo '<title>PortAn / Modifier un ticket</title>';
    else
        echo '<title>PortAn / Nouveau ticket</title>';
    ?>
    <link rel="stylesheet" href="../../static/css/navbar.css">
    <link rel="stylesheet" href="../../static/css/footer.css">
    <link rel="icon" type="image/x-icon" href="../../static/img/infinitemeasures-logo.png">
    <script src="../../static/js/navbar.js"></script>
    <link rel="stylesheet" href="../../static/css/addTicket.css">
</head>

<?php include('src/view/navbar.php'); ?>

<body>
<div id="page-wrapper">
    <?php
    if(!is_null($ticket))
        echo '<h1>Modifier un ticket</h1><hr>';
    else
        echo '<h1>Nouveau ticket</h1><hr>';
    ?>
    <form action="add" method="POST">
        <?php
        ((isset($_GET['id'])) && (is_numeric($_GET['id']))) ? $ticket = Ticket::fetchFromId($_GET['id']) : $ticket = null;
        if(!is_null($ticket))
            echo "<input type=hidden name=id value={$ticket->getId()}>";
        ?>

        <div class="ticket">
            <p class="ticket-title">
                <?php $nextId = Ticket::getHighestId() + 1; ?>
                <label for="ticket-title-input">Ticket n°<?php if(isset($ticket)) echo $ticket->getId(); else echo $nextId; ?>:</label>
                <input id="ticket-title-input" type="text" name="title" maxlength="256" placeholder="Titre" <?php if(isset($ticket)) echo "value='{$ticket->getTitle(ENT_QUOTES)}'"; ?> required>
            </p>
            <hr>
            <div id="tag-selectors">
                <div class="tag-selector">
                    <label for="tag-type-input">Type: </label>
                    <select id="tag-type-input" name="tag-type" required>
                        <?php
                            if(!is_null($ticket))
                            {
                                $tags = $ticket->getTags();
                                $tagNames = [];
                                foreach($tags as $tag)
                                    array_push($tagNames, $tag->getName());
                            }
                        ?>
                        <option value="bug" <?php if(isset($ticket) && in_array('bug', $tagNames)) echo 'selected'; ?>>Bug</option>
                        <option value="suggestion" <?php if(isset($ticket) && in_array('suggestion', $tagNames)) echo 'selected'; ?>>Suggestion</option>
                        <option value="autre" <?php if(isset($ticket) && in_array('autre', $tagNames)) echo 'selected'; ?>>Autre</option>
                    </select>
                </div>
                <div class="tag-selector">
                    <label for="tag-priority-input">Priorité: </label>
                    <select id="tag-priority-input" name="tag-priority" required>
                        <option value="urgent" <?php if(isset($ticket) && in_array('urgent', $tagNames)) echo 'selected'; ?>>Urgent</option>
                        <option value="not-urgent" <?php if(isset($ticket) && !in_array('urgent', $tagNames)) echo 'selected'; ?>>Pas urgent</option>
                    </select>
                </div>
            </div>
            <label for="ticket-description-input" class="desc">Description:</label>
            <textarea id="ticket-description-input" name="description" rows="10" placeholder="Description" required><?php if(isset($ticket)) echo $ticket->getDescription(); ?></textarea>
            <div class="ticket-footer">
                <?php
                    if(isset($ticket))
                        $author = User::fetchFromEmail($ticket->getAuthorEmail());
                    else
                        $author = User::fetchFromEmail($_SESSION['email'])
                ?>
                <p class="ticket-author">Auteur: <?php echo "{$author->getFirstname()} {$author->getLastname()}" ?></p>
                <button class="ticket-button create" type="submit"><?php if(isset($ticket)) echo "Valider"; else echo "Créer"; ?></button>
            </div>
        </div>
    </form>
</div>
<?php include('src/view/footer.php'); ?>
</body>
</html>