<?php

class ContactController
{
    // Methods
    /**
     * Renders the view corresponding to the contact page.
     * @return void
     */
    public static function displayContactPage(): void
    {
        $admins = User::fetchFromPermissionLevel(ADMINISTRATOR);
        require('src/view/contact.php');
    }

    /**
     * Sends a message created using the contact form.
     * @return void
     */
    public static function sendMessage(): void
    {
        $recipient = $_POST['recipient'];
        $subject = $_POST['subject'];
        $message = $_POST['message'];
        $senderEmail = $_POST['sender'];
        $senderName = $_POST['name'];

        $success = self::sendEmail($recipient, $subject, $message);

        $hostname = $_SERVER['HTTP_HOST'];
        if($success)
        {
            $_SESSION['successMessage'] = "Votre message a bien été envoyé.";
            header("Location: http://$hostname/".ROOT_URI.'index.php/contact?success');
        }
        else
        {
            $_SESSION['errorMessage'] = "Erreur: le message n'a pas pu être envoyé.";
            header("Location: http://$hostname/".ROOT_URI.'index.php/contact?error');
        }
    }

    private static function sendEmail(string $recipient, string $subject, string $message): bool
    {
        $headers = "From: contact@portan.fr";

        return mail($recipient, $subject, $message, $headers);
    }
}
