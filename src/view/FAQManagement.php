<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>PortAn / Gestion de la FAQ</title>
    <link rel="stylesheet" href="../../static/css/navbar.css">
    <link rel="stylesheet" href="../../static/css/footer.css">
    <link rel="icon" type="image/x-icon" href="../../static/img/infinitemeasures-logo.png">
    <script src="../../static/js/navbar.js"></script>
    <link rel="stylesheet" href="../../static/css/FAQManagement.css">
</head>

<?php include('src/view/navbar.php'); ?>

<body>
<div id="page-wrapper">
<h1>Gestion de la FAQ</h1>
<hr>

<div id="add-button-wrapper"><a href="faq/add"><button id="add-button" type="button">Ajouter une question</button></a></div>

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

<table>
    <tr id="table-header">
        <th>Question</th>
        <th>Réponse</th>
        <th>Auteur</th>
        <th>Actions</th>
    </tr>
    <?php
    $i = 1;
    foreach ($faqs as $faq)
    {
        $author = User::fetchFromEmail($faq->getAuthorEmail());
        echo"
            <tr>
                <td>{$faq->getQuestion()}</td>
                <td>{$faq->getAnswer()}</td>
                <td>{$author->getFirstname()} {$author->getLastname()}</td>
                <td>
                    <div class='actions'>
                        <a href='faq/add?id={$faq->getId()}'><button class='action-button modify' type=button>Modifier</button></a>
                        <form action=faq/delete method=POST><button class='action-button delete' type=submit name=id value={$faq->getId()}>Supprimer</button></form>
                    </div>
                </td>
            </tr>
            ";
        $i++;
    }
    ?>
</table>
</div>
<?php include('src/view/footer.php'); ?>
</body>
</html>