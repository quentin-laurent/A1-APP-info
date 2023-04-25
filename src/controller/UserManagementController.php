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
        require('src/view/userManagement.php');
    }
}