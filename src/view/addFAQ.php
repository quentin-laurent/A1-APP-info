<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <?php
        (isset($_GET['id'])) ? $faq = FAQ::fetchFromId($_GET['id']) : $faq = null;
        if(!is_null($faq))
            echo '<title>PortAn / Modifier une question</title>';
        else
            echo '<title>PortAn / Ajouter une question</title>';
    ?>
    <link rel="stylesheet" href="../../../static/css/navbar.css">
    <link rel="stylesheet" href="../../../static/css/footer.css">
    <link rel="icon" type="image/x-icon" href="../../../static/img/infinitemeasures-logo.png">
    <script src="../../../static/js/navbar.js"></script>
    <link rel="stylesheet" href="../../../static/css/addFAQ.css">
</head>

<?php include('src/view/navbar.php'); ?>

<body>
<div id="page-wrapper">
<?php
    if(!is_null($faq))
        echo '<h1>Modifier une question</h1>';
    else
        echo '<h1>Ajouter une nouvelle question</h1>';
?>
<hr>

<form action="add" method="POST">
    <?php
        (isset($_GET['id'])) ? $faq = FAQ::fetchFromId($_GET['id']) : $faq = null;
        if(!is_null($faq))
            echo "<input type=hidden name=id value={$faq->getId()}>";
    ?>
    <input type="text" name="question" placeholder="Question" <?php if (!is_null($faq)) echo "value='{$faq->getQuestion(ENT_QUOTES)}'"; ?> required>
    <textarea name="answer" placeholder="Réponse" rows="5" required><?php if (!is_null($faq)) echo "{$faq->getAnswer(ENT_QUOTES)}"; ?></textarea>
    <div id="submit-button">
        <button type="submit">Valider</button>
    </div>

</form>
</div>
<?php include('src/view/footer.php'); ?>
</body>
</html>