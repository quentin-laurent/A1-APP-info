<?php
require_once('src/model/User.php');

const USER = 1;
const MANAGER = 2;
const ADMINISTRATOR = 3;

class LoginController
{
    // Methods
    /**
     * Renders the view corresponding to the login page.
     * @return void
     */
    public static function displayLoginPage(): void
    {
        if(isset($_SESSION['email']))
        {
            $hostname = $_SERVER['HTTP_HOST'];
            header("Location: http://$hostname/".ROOT_URI.'index.php/home');
            exit;
        }

        require('src/view/login.php');
    }

    /**
     * Parses the sign-up form received from the login page.
     * @return void
     */
    public static function signUp(): void
    {
        $email = $_POST['email'];
        $firstName = $_POST['firstName'];
        $lastName = $_POST['lastName'];
        $birthday = $_POST['birthday'];
        $phoneNumber = $_POST['phoneNumber'];
        $password = $_POST['password'];
        $passwordHash = password_hash($password, PASSWORD_BCRYPT);

        $success = User::add(new User($email, $firstName, $lastName, $birthday, $phoneNumber, $passwordHash));

        $hostname = $_SERVER['HTTP_HOST'];
        if($success)
            LoginController::signIn($email, $password);
        else
        {
            $_SESSION['errorMessage'] = 'Une erreur inconnue est survenue.';
            header("Location: http://$hostname/" . ROOT_URI . 'index.php/login?error');
        }
    }

    /**
     * Parses the sign-in form received from the login page.
     * <p>It is possible to supply both an email and a password to sign-in without using a POST form
     * (i.e. after signing-up a user, it is convenient to call this method instead of letting the user sign-in once again)
     * @param $email
     * @param $password
     * @return void
     */
    public static function signIn($email=null, $password=null): void
    {
        if($email == null)
            $email = htmlspecialchars($_POST['email']);
        if($password == null)
            $password = htmlspecialchars($_POST['password']);
        $user = User::fetchFromEmail($email);
        $hostname = $_SERVER['HTTP_HOST'];

        if($user != null && !$user->isBanned() && password_verify($password, $user->getPasswordHash()))
        {
            $_SESSION['email'] = $email;
            $_SESSION['firstname'] = $user->getFirstname();
            $_SESSION['lastname'] = $user->getLastname();
            $user->increaseNbConnections();
            $user->updateLastVisit();
            header("Location: http://$hostname/".ROOT_URI.'index.php/home');
            exit();
        }
        else if($user != null && $user->isBanned())
        {
            $_SESSION['errorMessage'] = 'Ce compte est banni.';
            header("Location: http://$hostname/".ROOT_URI.'index.php/login?error');
        }
        else
        {
            $_SESSION['errorMessage'] = 'Indentifiants incorrects';
            header("Location: http://$hostname/".ROOT_URI.'index.php/login?error');
        }
    }

    /**
     * Logs the user out and destroys the session with all its associated variables.
     * @return void
     */
    public static function signOut(): void
    {
        $hostname = $_SERVER['HTTP_HOST'];
        session_unset();
        session_destroy();
        header("Location: http://$hostname/".ROOT_URI.'index.php/home');
    }
}
