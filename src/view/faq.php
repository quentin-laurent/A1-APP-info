<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>PortAn / FAQ</title>
    <link rel="stylesheet" href="../static/css/navbar.css">
    <link rel="icon" type="image/x-icon" href="../static/img/infinitemeasures-logo.png">
    <script src="../static/js/navbar.js"></script>
    <link rel="stylesheet" href="../static/css/faq.css">
</head>

<?php include('src/view/navbar.php'); ?>

<body>
<h1>FAQ</h1>

<table>
    <tr>
        <th>Question</th>
        <th>Réponse</th>
    </tr>
    <?php
    foreach ($faqs as $faq)
    {
        echo"
            <tr>
                <td>{$faq->getQuestion()}</td>
                <td>{$faq->getAnswer()}</td>
            </tr>
            ";
    }
    ?>
</table>
</body>
</html>