<?php

class FAQController
{
    // Methods
    /**
     * Renders the view corresponding to the FAQ page.
     * @return void
     */
    public static function displayFAQPage(): void
    {
        $faqs = FAQ::fetchAllFAQs();
        require('src/view/faq.php');
    }
}
