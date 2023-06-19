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
        if (!isset($_SESSION['email'])) {
            $hostname = $_SERVER['HTTP_HOST'];
            header("Location: http://$hostname/" . ROOT_URI . 'index.php/login');
            exit;
        }

        $user = User::fetchFromEmail($_SESSION['email']);
        $product = Product::fetchFromId($user->getProductId());

        $hostname = $_SERVER['HTTP_HOST'];
        if (is_null($user->getProductId()))
            $_SESSION['errorMessage'] = "Aucun identifiant d'appareil n'a été renseigné sur votre profil !";
        else if (is_null($product))
            $_SESSION['errorMessage'] = "Aucun appareil trouvé avec l'identifiant {$user->getProductId()}.";

        MetricController::updateMetrics();
        require('src/view/data.php');
    }

    public static function updateLedStatus(): void
    {
        $productId = User::fetchFromEmail($_SESSION['email'])->getProductId();
        $ledStatus = $_POST['ledStatus'];

        if ($ledStatus === 'on')
            $frame = '1007B2F010001000000';
        else
            $frame = '1007B2F010000000000';

        $url = "http://projets-tomcat.isep.fr:8080/appService/?ACTION=COMMAND&TEAM=$productId&TRAME=$frame";
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($curl);

        if ($response === false)
            error_log('Error when updating LED status: ' . curl_error($curl));
        else
            error_log('Updated LED status: ' . $response);
        curl_close($curl);
    }
}