<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>PortAn / Ajouter une question</title>
    <link rel="stylesheet" href="../../../static/css/navbar.css">
    <link rel="icon" type="image/x-icon" href="../../../static/img/infinitemeasures-logo.png">
    <script src="../../../static/js/navbar.js"></script>
    <link rel="stylesheet" href="../../../static/css/addFAQ.css">
</head>

<?php include('src/view/navbar.php'); ?>

<body>
<h1>Ajouter une nouvelle question</h1>

<form action="add" method="POST">
    <input type="text" name="question" placeholder="Question" required>
    <textarea name="answer" placeholder="Réponse" rows="5" required></textarea>
    <button type="submit">Valider</button>
</form>
</body>
</html>