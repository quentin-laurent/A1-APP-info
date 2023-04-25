<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>PortAn / User management</title>
    <link rel="stylesheet" href="../../static/css/navbar.css">
    <script src="../../static/js/navbar.js"></script>
    <link rel="stylesheet" href="../../static/css/userManagement.css">
</head>

<?php include('src/view/navbar.php'); ?>

<body>
    <h1>Gestion des utilisateurs</h1>
    <table>
        <tr>
            <th>Email</th>
            <th>Prénom</th>
            <th>Nom</th>
            <th>Rôle</th>
            <th>Dernière visite</th>
            <th>Connexions</th>
            <th>Actions</th>
        </tr>
        <?php
        $users = User::fetchAllUsers();

        foreach ($users as $user)
        {
            echo"
            <tr>
                <td>
                    <div class=email>
                        <img src=../../static/img/{$user->getProfilePicturePath()}>
                        <p>{$user->getEmail()}</p>
                    </div>
                </td>
                <td>{$user->getFirstname()}</td>
                <td>{$user->getLastname()}</td>
                <td>
                    <select>
            ";
            if($user->getPermissionLevel() == USER)
                echo '
                    <option value=user selected>Utilisateur</option>
                    <option value=manager>Gestionnaire</option>
                    <option value=admin>Administrateur</option>
                ';
            else if($user->getPermissionLevel() == MANAGER)
                echo '
                    <option value=user>Utilisateur</option>
                    <option value=manager selected>Gestionnaire</option>
                    <option value=admin>Administrateur</option>
                ';
            else if($user->getPermissionLevel() == ADMINISTRATOR)
                echo '
                    <option value=user>Utilisateur</option>
                    <option value=manager>Gestionnaire</option>
                    <option value=admin selected>Administrateur</option>
                ';
            echo "
                    </select>
                </td>
                <td>01/01/2000</td>
                <td>999</td>
                <td>
                    <button type=button>Bannir</button>
                    <button type=button>Supprimer</button>
                </td>
            </tr>
            ";
        }
        ?>
    </table>
</body>
</html>