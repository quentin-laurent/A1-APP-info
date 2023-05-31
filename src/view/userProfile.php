<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>PortAn / Mon profil</title>
    <link rel="stylesheet" href="../static/css/navbar.css">
    <link rel="icon" type="image/x-icon" href="../static/img/infinitemeasures-logo.png">
    <script src="../static/js/navbar.js"></script>
    <link rel="stylesheet" href="../static/css/userProfile.css">
    <script src="../static/js/userProfile.js" defer></script>
</head>

<?php include('src/view/navbar.php'); ?>

<body>
<h1>Mon profil</h1>
<hr>

<div id="profile-header">
    <?php
        $hostname = $_SERVER['HTTP_HOST'];
        $imgDirectory = "http://$hostname/" . ROOT_URI . 'static/img';
        echo "<img src=$imgDirectory/{$user->getProfilePicturePath()} alt=pfp>";
        echo "<p id='profile-header-infos'>{$user->getFirstname()} {$user->getLastname()}, {$user->getAge()} ans</p>"
    ?>
</div>

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

<form id="profile-infos" action="profile" method="POST">
    <h2>Informations personnelles</h2>
    <hr class="category-hr">
    <div class="input-row" id="infos1">
        <div class="input-group">
            <label for="firstname">Prénom<span class="mandatory">*</span></label>
            <input id="firstname" type="text" name="firstname" placeholder="Entrez votre prénom" <?php if(!is_null($user->getFirstname())) echo "value='{$user->getFirstname()}'"; ?> required>
        </div>
        <div class="input-group">
            <label for="lastname">Nom<span class="mandatory">*</span></label>
            <input id="lastname" type="text" name="lastname" placeholder="Entrez votre nom" <?php if(!is_null($user->getLastname())) echo "value='{$user->getLastname()}'"; ?> required>
        </div>
        <div class="input-group">
            <label for="birthday">Date de naissance<span class="mandatory">*</span></label>
            <input id="birthday" type="date" name="birthday" <?php if(!is_null($user->getBirthday())) echo "value='{$user->getBirthday()}'"; ?> required>
        </div>
    </div>
    <div class="input-row" id="infos2">
        <div class="input-group">
            <label for="email">Adresse email<span class="mandatory">*</span></label>
            <input id="email" type="email" name="email" placeholder="Entrez votre adresse email" <?php if(!is_null($user->getEmail())) echo "value='{$user->getEmail()}'"; ?> required>
        </div>
        <div class="input-group">
            <label for="phoneNumber">Numéro de téléphone</label>
            <input id="phoneNumber" type="text" name="phoneNumber" placeholder="Entrez votre numéro de téléphone" <?php if(!is_null($user->getPhoneNumber())) echo "value='{$user->getPhoneNumber()}'"; ?>>
        </div>
        <div class="input-group">
            <label for="portanId">Identifiant PortAn</label>
            <input id="portanId" type="number" name="portanId" placeholder="Entrez l'identifiant de votre appareil PortAn" <?php if(!is_null($user->getProductId())) echo "value='{$user->getProductId()}'"; ?>>
        </div>
    </div>
    <h2>Mot de passe</h2>
    <hr class="category-hr">
    <div class="input-row" id="infos3">
        <div class="input-group">
            <label for="currentPassword">Mot de passe actuel<span class="mandatory" id="currentPasswordMandatory">*</span></label>
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
    <div id="submit">
        <p><span class="mandatory">*</span> Champs obligatoires</p>
        <button id="submitButton" type="submit">Enregistrer</button>
    </div>
</form>
</body>
</html>
