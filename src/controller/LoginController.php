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
        require('src/view/login.php');
    }

    public static function signUp(): void
    {
        $email = $_POST['email'];
        $firstName = $_POST['firstName'];
        $lastName = $_POST['lastName'];
        $birthday = $_POST['birthday'];
        $phoneNumber = $_POST['phoneNumber'];
        $password = $_POST['password'];
        $passwordHash = password_hash($password, PASSWORD_BCRYPT);

        $success = User::add(new User($email, $firstName, $lastName, $birthday, $phoneNumber, $passwordHash, null, USER));

        $hostname = $_SERVER['HTTP_HOST'];
        if($success)
            LoginController::signIn($email, $password);
        else
        {
            $_SESSION['errorMessage'] = 'An error occurred, please try again.';
            header("Location: http://$hostname/" . ROOT_URI . 'index.php/login?error');
        }
    }

    public static function signIn($email=null, $password=null): void
    {
        if($email == null)
            $email = htmlspecialchars($_POST['email']);
        if($password == null)
            $password = htmlspecialchars($_POST['password']);
        $user = User::fetchFromEmail($email);
        $hostname = $_SERVER['HTTP_HOST'];

        if($user != null && password_verify($password, $user->getPasswordHash()))
        {
            $_SESSION['email'] = $email;
            $_SESSION['firstname'] = $user->getFirstname();
            $_SESSION['lastname'] = $user->getLastname();
            header("Location: http://$hostname/".ROOT_URI.'index.php/home');
            exit();
        }
        else
        {
            $_SESSION['errorMessage'] = 'Invalid credentials';
            header("Location: http://$hostname/".ROOT_URI.'index.php/login?error');
        }
    }

    public static function signOut(): void
    {
        $hostname = $_SERVER['HTTP_HOST'];
        session_unset();
        session_destroy();
        header("Location: http://$hostname/".ROOT_URI.'index.php/home');
    }
}
