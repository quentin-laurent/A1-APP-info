<?php

class HomeController
{
    // Methods
    /**
     * Renders the view corresponding to the home page.
     * @return void
     */
    public static function displayHomePage(): void
    {
        require('src/view/home.php');
    }
}
