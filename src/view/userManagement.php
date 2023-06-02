<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>PortAn / User management</title>
    <link rel="stylesheet" href="../../static/css/navbar.css">
    <link rel="stylesheet" href="../../static/css/footer.css">
    <link rel="icon" type="image/x-icon" href="../../static/img/infinitemeasures-logo.png">
    <script src="../../static/js/navbar.js"></script>
    <link rel="stylesheet" href="../../static/css/userManagement.css">
    <script src="../../static/js/userManagement.js" defer></script>
</head>

<?php include('src/view/navbar.php'); ?>

<body>
<div id="page-wrapper">
    <h1>Gestion des utilisateurs</h1>
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

    <form id="search" action="users/search" method="POST">
        <h2>Recherche</h2>
        <div id="search-box">
            <div id="row1">
                <div class="input-group">
                    <label for="search-firstname">Prénom:</label>
                    <input id="search-firstname" type="text" name="firstname" placeholder="Prenom">
                </div>
                <div class="input-group">
                    <label for="search-lastname">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Nom:</label>
                    <input id="search-lastname" type="text" name="lastname" placeholder="Nom">
                </div>
            </div>
            <div id="row2">
                <div class="input-group">
                    <label for="search-email">Email:</label>
                    <input id="search-email" type="text" name="email" placeholder="Email">
                </div>
                <div class="input-group">
                    <label for="search-role">Rôle:</label>
                    <select id="search-role" name="permissionLevel">
                        <option value=0 selected>Tous</option>
                        <option value=1>Utilisateur</option>
                        <option value=2>Gestionnaire</option>
                        <option value=3>Administrateur</option>
                    </select>
                </div>
            </div>
        </div>
        <button id="search-button" type="submit">Rechercher</button>
    </form>

    <table>
        <tr id="table-header">
            <th>Email</th>
            <th>Prénom</th>
            <th>Nom</th>
            <th>Rôle</th>
            <th>Dernière visite</th>
            <th>Connexions</th>
            <th>Actions</th>
        </tr>
        <?php

        $i = 1;
        foreach ($users as $user)
        {
            echo"
            <tr>
                <td>
                    <form id=form$i method=POST><input type=hidden name=email value={$user->getEmail()} /></form>
                    <div class=email>
                        <img src=../../static/img/{$user->getProfilePicturePath()}>
                        <p>{$user->getEmail()}</p>
                    </div>
                </td>
                <td>{$user->getFirstname()}</td>
                <td>{$user->getLastname()}</td>
                <td>
                    <select form=form$i name=permissionLevel>
            ";
            if($user->getPermissionLevel() == USER)
                echo '
                    <option value=1 selected>Utilisateur</option>
                    <option value=2>Gestionnaire</option>
                    <option value=3>Administrateur</option>
                ';
            else if($user->getPermissionLevel() == MANAGER)
                echo '
                    <option value=1>Utilisateur</option>
                    <option value=2 selected>Gestionnaire</option>
                    <option value=3>Administrateur</option>
                ';
            else if($user->getPermissionLevel() == ADMINISTRATOR)
                echo '
                    <option value=1>Utilisateur</option>
                    <option value=2>Gestionnaire</option>
                    <option value=3 selected>Administrateur</option>
                ';
            $lastVisit = ($user->getLastVisit() != '') ? date_format(date_create($user->getLastVisit()), 'd/m/Y') : 'Jamais';
            $bannedValue = ($user->isBanned()) ? 'false' : 'true';
            $bannedText = ($user->isBanned()) ? 'Débannir' : 'Bannir';
            echo "
                    </select>
                </td>
                <td>$lastVisit</td>
                <td>{$user->getNbConnections()}</td>
                <td>
                    <div class='actions'>
                        <button class='action-button submit' type=submit form=form$i>Valider</button>
                        <form action=users/ban method=POST><input type=hidden name=email value={$user->getEmail()}><button class='action-button ban' type=submit name=ban value=$bannedValue>$bannedText</button></form>
                        <form action=users/delete method=POST><button class='action-button delete' type=submit name=email value={$user->getEmail()}>Supprimer</button></form>
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