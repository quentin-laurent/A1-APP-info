<?php

class LoginController
{
    // Methods
    /**
     * Renders the view corresponding to the login page.
     * @return void
     */
    public static function displayLoginPage(): void
    {
        require('src/view/login.html');
    }
}
