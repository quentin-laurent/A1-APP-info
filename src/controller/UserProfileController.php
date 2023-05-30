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

        require('src/view/userProfile.php');
    }
}