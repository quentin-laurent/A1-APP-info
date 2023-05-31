<?php

class UserProfileController
{
    // Methods

    /**
     * Renders the view corresponding to the User profile page.
     * @return void
     */
    public static function displayUserProfilePage(): void
    {
        if(!isset($_SESSION['email']))
        {
            header("HTTP/1.1 401 Unauthorized");
            require('src/view/401.html');
            exit;
        }

        $user = User::fetchFromEmail($_SESSION['email']);
        require('src/view/userProfile.php');
    }

    /**
     * Updates a {@see User} in the database.
     * @return void
     */
    public static function updateUser(): void
    {
        if(!isset($_SESSION['email']))
        {
            header("HTTP/1.1 401 Unauthorized");
            require('src/view/401.html');
            exit;
        }
        $hostname = $_SERVER['HTTP_HOST'];
        $user = User::fetchFromEmail($_SESSION['email']);
        $success = $user->update($_POST['email'], $_POST['firstname'], $_POST['lastname'], $_POST['birthday'], $_POST['phoneNumber']);

        $currentPassword = $_POST['currentPassword'];
        $newPassword = $_POST['newPassword'];
        $newPasswordConfirm = $_POST['newPasswordConfirm'];

        if($currentPassword !== '' && $newPassword !== '' && $newPasswordConfirm !== '')
        {
            if(!password_verify($currentPassword, $user->getPasswordHash()))
            {
                $_SESSION['errorMessage'] = "Le mot de passe actuel est incorrect.";
                header("Location: http://$hostname/".ROOT_URI.'index.php/profile?error');
                exit();
            }
            else if($newPassword != $newPasswordConfirm)
            {
                $_SESSION['errorMessage'] = "Les nouveaux mots de passe ne correspondent pas.";
                header("Location: http://$hostname/".ROOT_URI.'index.php/profile?error');
                exit();
            }

            $passwordUpdated = $user->updatePassword(password_hash($newPassword, PASSWORD_BCRYPT));
        }
        else
            $passwordUpdated = true;

        if($success && $passwordUpdated)
        {
            $_SESSION['email'] = $_POST['email'];
            $_SESSION['successMessage'] = "Modifications enregistrées.";
            header("Location: http://$hostname/".ROOT_URI.'index.php/profile?success');
        }
        else
        {
            if(!is_null(User::fetchFromEmail($_POST['email'])))
            {
                $_SESSION['errorMessage'] = "Cette adresse email n'est pas disponible.";
                header("Location: http://$hostname/".ROOT_URI.'index.php/profile?error');
            }
            else
            {
                $_SESSION['errorMessage'] = "Erreur lors de la mise à jour des informations.";
                header("Location: http://$hostname/".ROOT_URI.'index.php/profile?error');
            }
        }
    }
}