<?php

class FAQManagementController
{
    // Methods

    /**
     * Renders the view corresponding to the FAQ management page
     * @return void
     */
    public static function displayFAQManagementPage(): void
    {
        if(!isset($_SESSION['email']))
        {
            header("HTTP/1.1 401 Unauthorized");
            require('src/view/401.html');
            exit;
        }
        else if(User::fetchFromEmail($_SESSION['email'])->getPermissionLevel() < MANAGER)
        {
            header("HTTP/1.1 403 Forbidden");
            require('src/view/403.html');
            exit;
        }
        $faqs = FAQ::fetchAllFAQs();
        require('src/view/FAQManagement.php');
    }

    /**
     * Renders the view containing the form used to create a new FAQ
     * @return void
     */
    public static function displayFAQAddPage(): void
    {
        if(!isset($_SESSION['email']))
        {
            header("HTTP/1.1 401 Unauthorized");
            require('src/view/401.html');
            exit;
        }
        else if(User::fetchFromEmail($_SESSION['email'])->getPermissionLevel() < MANAGER)
        {
            header("HTTP/1.1 403 Forbidden");
            require('src/view/403.html');
            exit;
        }
        require('src/view/addFAQ.php');
    }

    /**
     * Adds a new FAQ to the database.
     * @return void
     */
    public static function addFAQ(): void
    {
        if(!isset($_SESSION['email']))
        {
            header("HTTP/1.1 401 Unauthorized");
            require('src/view/401.html');
            exit;
        }
        else if(User::fetchFromEmail($_SESSION['email'])->getPermissionLevel() < MANAGER)
        {
            header("HTTP/1.1 403 Forbidden");
            require('src/view/403.html');
            exit;
        }

        (isset($_POST['id'])) ? $faq = FAQ::fetchFromId($_POST['id']) : $faq = null;
        if(!is_null($faq))
        {
            FAQManagementController::updateFAQ($faq);
            return;
        }

        $success = FAQ::add(new FAQ($_POST['question'], $_POST['answer'], $_SESSION['email']));

        $hostname = $_SERVER['HTTP_HOST'];
        if($success)
        {
            $_SESSION['successMessage'] = "Nouvelle question ajoutée.";
            header("Location: http://$hostname/".ROOT_URI.'index.php/backoffice/faq?success');
        }
        else
        {
            $_SESSION['errorMessage'] = "Erreur lors de la création de la question.";
            header("Location: http://$hostname/".ROOT_URI.'index.php/backoffice/faq?error');
        }
    }

    /**
     * Updates a FAQ in the database.
     * @return void
     */
    private static function updateFAQ(FAQ $faq): void
    {
        $success = $faq->update($_POST['question'], $_POST['answer'], $_SESSION['email']);

        $hostname = $_SERVER['HTTP_HOST'];
        if($success)
        {
            $_SESSION['successMessage'] = "La question a bien été modifiée.";
            header("Location: http://$hostname/".ROOT_URI.'index.php/backoffice/faq?success');
        }
        else
        {
            $_SESSION['errorMessage'] = "Erreur lors de la modification de la question.";
            header("Location: http://$hostname/".ROOT_URI.'index.php/backoffice/faq?error');
        }
    }

    /**
     * Deletes a FAQ from the database.
     * @return void
     */
    public static function deleteFAQ(): void
    {
        if(!isset($_SESSION['email']))
        {
            header("HTTP/1.1 401 Unauthorized");
            require('src/view/401.html');
            exit;
        }
        else if(User::fetchFromEmail($_SESSION['email'])->getPermissionLevel() < MANAGER)
        {
            header("HTTP/1.1 403 Forbidden");
            require('src/view/403.html');
            exit;
        }

        $hostname = $_SERVER['HTTP_HOST'];

        if(!isset($_POST['id']))
        {
            header("Location: http://$hostname/".ROOT_URI.'index.php/backoffice/faq');
            exit();
        }

        $faq = FAQ::fetchFromId($_POST['id']);
        $success = $faq->delete();

        if($success)
        {
            $_SESSION['successMessage'] = "La question n°{$faq->getId()} a bien été supprimée.";
            header("Location: http://$hostname/".ROOT_URI.'index.php/backoffice/faq?success');
        }
        else
        {
            $_SESSION['errorMessage'] = "Erreur lors de la suppression de la question n°{$faq->getId()}.";
            header("Location: http://$hostname/".ROOT_URI.'index.php/backoffice/faq?error');
        }
    }
}