<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>PortAn / Contact</title>
    <link rel="stylesheet" href="../static/css/navbar.css">
    <link rel="stylesheet" href="../static/css/footer.css">
    <link rel="icon" type="image/x-icon" href="../static/img/infinitemeasures-logo.png">
    <script src="../static/js/navbar.js"></script>
    <link rel="stylesheet" href="../static/css/contact.css">
</head>

<?php include('src/view/navbar.php'); ?>

<body>
<div id="page-wrapper">
    <h1>Contacter un administrateur</h1>
    <hr>

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

    <form action="contact" method="POST">
        <div class="input-group">
            <label for="recipient">Destinataire</label>
            <select id="recipient" name="recipient" required>
                <?php
                foreach($admins as $admin)
                    echo "<option value='{$admin->getEmail()}'>{$admin->getFirstname()} {$admin->getLastname()} ({$admin->getEmail()})</option>";
                ?>
                <option value="pawaso2070@ratedane.com">pawaso2070@ratedane.com</option>
            </select>
        </div>
        <div class="input-group">
            <label for="subject">Objet</label>
            <input id="subject" type="text" name="subject" placeholder="Objet de votre message" required>
        </div>
        <div class="input-group">
            <label for="content">Message</label>
            <textarea id="content" name="message" rows="5" placeholder="Contenu de votre message" required></textarea>
        </div>
        <div class="input-group">
            <label for="sender">Votre adresse email</label>
            <input id="sender" type="email" name="sender" placeholder="Entrez votre adresse email" required>
        </div>
        <div class="input-group">
            <label for="name">Votre prénom et nom</label>
            <input id="name" type="text" name="name" placeholder="Entrez votre prénom et votre nom" required>
        </div>
        <div id="submit-button">
            <button type="submit">Envoyer</button>
        </div>

    </form>
</div>
<?php include('src/view/footer.php'); ?>
</body>
</html>