<?php

class UserManagementController
{
    // Methods

    /**
     * Renders the view corresponding to the user management page
     * @return void
     */
    public static function displayUserManagementPage(): void
    {
        if(!isset($_SESSION['email']))
        {
            header("HTTP/1.1 401 Unauthorized");
            require('src/view/401.html');
            exit;
        }
        else if(User::fetchFromEmail($_SESSION['email'])->getPermissionLevel() < ADMINISTRATOR)
        {
            header("HTTP/1.1 403 Forbidden");
            require('src/view/403.html');
            exit;
        }
        if(!isset($_SESSION['users_search']))
            $users = User::fetchAllUsers();
        else
            $users = unserialize($_SESSION['users_search']);
        unset($_SESSION['users_search']);
        require('src/view/userManagement.php');
    }

    public static function updateUser(): void
    {
        if(!isset($_SESSION['email']))
        {
            header("HTTP/1.1 401 Unauthorized");
            require('src/view/401.html');
            exit;
        }
        else if(User::fetchFromEmail($_SESSION['email'])->getPermissionLevel() < ADMINISTRATOR)
        {
            header("HTTP/1.1 403 Forbidden");
            require('src/view/403.html');
            exit;
        }

        $user = User::fetchFromEmail($_POST['email']);
        $success = $user->updatePermissionLevel($_POST['permissionLevel']);
        $hostname = $_SERVER['HTTP_HOST'];

        if($success)
        {
            $_SESSION['successMessage'] = 'Modifications enregistrées.';
            header("Location: http://$hostname/".ROOT_URI.'index.php/backoffice/users?success');
        }
        else
        {
            $_SESSION['errorMessage'] = 'Erreur lors de l\'enregistrement des modifications.';
            header("Location: http://$hostname/".ROOT_URI.'index.php/backoffice/users?error');
        }
    }

    /**
     * Parses the ban form received from the user management page.
     * <p>If the 'ban' parameter is set to **true**, the specified user will be banned.
     * <p>If the 'ban' parameter is set to **false**, the specified user will be unbanned.
     * @return void
     */
    public static function banOrUnbanUser(): void
    {
        if(!isset($_SESSION['email']))
        {
            header("HTTP/1.1 401 Unauthorized");
            require('src/view/401.html');
            exit;
        }
        else if(User::fetchFromEmail($_SESSION['email'])->getPermissionLevel() < ADMINISTRATOR)
        {
            header("HTTP/1.1 403 Forbidden");
            require('src/view/403.html');
            exit;
        }

        $hostname = $_SERVER['HTTP_HOST'];

        if(!isset($_POST['ban']) || !isset($_POST['email']))
        {
            header("Location: http://$hostname/".ROOT_URI.'index.php/backoffice/users');
            exit();
        }

        $ban = filter_var($_POST['ban'], FILTER_VALIDATE_BOOLEAN);
        $user = User::fetchFromEmail($_POST['email']);
        $unbanText = (!$ban) ? 'dé' : '';

        if($ban)
            $success = $user->ban();
        else
            $success = $user->unban();

        if($success)
        {
            $_SESSION['successMessage'] = "L'utilisateur {$user->getEmail()} a bien été {$unbanText}banni.";
            header("Location: http://$hostname/".ROOT_URI.'index.php/backoffice/users?success');
        }
        else
        {
            $_SESSION['errorMessage'] = "Erreur lors du {$unbanText}bannissement de l'utilisateur {$user->getEmail()}.";
            header("Location: http://$hostname/".ROOT_URI.'index.php/backoffice/users?error');
        }
    }

    /**
     * Parses the delete form received from the user management page.
     * @return void
     */
    public static function deleteUser(): void
    {
        if(!isset($_SESSION['email']))
        {
            header("HTTP/1.1 401 Unauthorized");
            require('src/view/401.html');
            exit;
        }
        else if(User::fetchFromEmail($_SESSION['email'])->getPermissionLevel() < ADMINISTRATOR)
        {
            header("HTTP/1.1 403 Forbidden");
            require('src/view/403.html');
            exit;
        }
        
        $hostname = $_SERVER['HTTP_HOST'];

        if(!isset($_POST['email']))
        {
            header("Location: http://$hostname/".ROOT_URI.'index.php/backoffice/users');
            exit();
        }

        $user = User::fetchFromEmail($_POST['email']);
        $success = $user->delete();

        if($success)
        {
            $_SESSION['successMessage'] = "L'utilisateur {$user->getEmail()} a bien été supprimé.";
            header("Location: http://$hostname/".ROOT_URI.'index.php/backoffice/users?success');
        }
        else
        {
            $_SESSION['errorMessage'] = "Erreur lors de la suppression de l'utilisateur {$user->getEmail()}.";
            header("Location: http://$hostname/".ROOT_URI.'index.php/backoffice/users?error');
        }
    }

    public static function searchUser(): void
    {
        if(!isset($_SESSION['email']))
        {
            header("HTTP/1.1 401 Unauthorized");
            require('src/view/401.html');
            exit;
        }
        else if(User::fetchFromEmail($_SESSION['email'])->getPermissionLevel() < ADMINISTRATOR)
        {
            header("HTTP/1.1 403 Forbidden");
            require('src/view/403.html');
            exit;
        }

        $_SESSION['users_search'] = serialize(User::search($_POST));
        error_log(print_r($_SESSION['users_search']));
        $hostname = $_SERVER['HTTP_HOST'];
        header("Location: http://$hostname/".ROOT_URI.'index.php/backoffice/users');
    }
}