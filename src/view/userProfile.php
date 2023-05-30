<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>PortAn / Mon profil</title>
    <link rel="stylesheet" href="../static/css/navbar.css">
    <link rel="icon" type="image/x-icon" href="../static/img/infinitemeasures-logo.png">
    <script src="../static/js/navbar.js"></script>
    <link rel="stylesheet" href="../static/css/userProfile.css">
</head>

<?php include('src/view/navbar.php'); ?>

<body>
<h1>Mon profil</h1>
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

<div id="profile-header">
    <?php
        $hostname = $_SERVER['HTTP_HOST'];
        $imgDirectory = "http://$hostname/" . ROOT_URI . 'static/img';
        $user = User::fetchFromEmail($_SESSION['email']);
        echo "<img src=$imgDirectory/{$user->getProfilePicturePath()} alt=pfp>"
    ?>
    <p id="profile-header-infos">John Doe, 24 ans</p>
</div>
<form id="profile-infos" action="profile" method="POST">
    <h2>Informations personnelles</h2>
    <hr class="category-hr">
    <div class="input-row" id="infos1">
        <div class="input-group">
            <label for="firstname">Prénom<span class="mandatory">*</span></label>
            <input id="firstname" type="text" name="firstname" placeholder="Entrez votre prénom">
        </div>
        <div class="input-group">
            <label for="lastname">Nom<span class="mandatory">*</span></label>
            <input id="lastname" type="text" name="lastname" placeholder="Entrez votre nom">
        </div>
        <div class="input-group">
            <label for="birthday">Date de naissance<span class="mandatory">*</span></label>
            <input id="birthday" type="date" name="birthday">
        </div>
    </div>
    <div class="input-row" id="infos2">
        <div class="input-group">
            <label for="email">Adresse email<span class="mandatory">*</span></label>
            <input id="email" type="email" name="email" placeholder="Entrez votre adresse email">
        </div>
        <div class="input-group">
            <label for="phoneNumber">Numéro de téléphone</label>
            <input id="phoneNumber" type="text" name="phoneNumber" placeholder="Entrez votre numéro de téléphone    ">
        </div>
        <div class="input-group">
            <label for="portanId">Identifiant PortAn</label>
            <input id="portanId" type="text" name="portanId" placeholder="Entrez l'identifiant de votre appareil PortAn">
        </div>
    </div>
    <h2>Mot de passe</h2>
    <hr class="category-hr">
    <div class="input-row" id="infos3">
        <div class="input-group">
            <label for="currentPassword">Mot de passe actuel</label>
            <input id="currentPassword" type="password" name="currentPassword" placeholder="Entrez votre mot de passe actuel">
        </div>
        <div class="input-group">
            <label for="newPassword">Nouveau mot de passe</label>
            <input id="newPassword" type="password" name="newPassword" placeholder="Entrez votre nouveau mot de passe">
        </div>
        <div class="input-group">
            <label for="newPasswordConfirm">Nouveau mot de passe (confirmation)</label>
            <input id="newPasswordConfirm" type="password" name="newPasswordConfirm" placeholder="Entrez votre nouveau mot de passe (confirmation)">
        </div>
    </div>
    <div id="submitButton">
        <p><span class="mandatory">*</span> Champs obligatoires</p>
        <button type="submit">Enregistrer</button>
    </div>
</form>
</body>
</html>
