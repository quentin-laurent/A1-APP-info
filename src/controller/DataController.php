<?php

class DataController
{
    // Methods

    /**
     * Renders the view corresponding to the data page.
     * @return void
     */
    public static function displayDataPage(): void
    {
        if(!isset($_SESSION['email']))
        {
            $hostname = $_SERVER['HTTP_HOST'];
            header("Location: http://$hostname/".ROOT_URI.'index.php/login');
            exit;
        }

        $user = User::fetchFromEmail($_SESSION['email']);
        $product = Product::fetchFromId($user->getProductId());

        $hostname = $_SERVER['HTTP_HOST'];
        if(is_null($user->getProductId()))
            $_SESSION['errorMessage'] = "Aucun identifiant d'appareil n'a été renseigné sur votre profil !";
        else if(is_null($product))
            $_SESSION['errorMessage'] = "Aucun appareil trouvé avec l'identifiant {$user->getProductId()}.";

        MetricController::updateMetrics();
        require('src/view/data.php');
    }
}