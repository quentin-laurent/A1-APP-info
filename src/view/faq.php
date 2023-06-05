<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>PortAn / FAQ</title>
    <link rel="stylesheet" href="../static/css/navbar.css">
    <link rel="stylesheet" href="../static/css/footer.css">
    <link rel="icon" type="image/x-icon" href="../static/img/infinitemeasures-logo.png">
    <script src="../static/js/navbar.js"></script>
    <link rel="stylesheet" href="../static/css/faq.css">
</head>

<?php include('src/view/navbar.php'); ?>

<body>
<div id="page-wrapper">
    <h1>Foire aux questions (FAQ)</h1>
    <hr>

    <?php
        foreach($faqs as $faq)
        {
            echo "
            <div id=faq-wrapper>
                <div class=faq>
                    <div class=question-wrapper>
                        <p class=question>{$faq->getQuestion(ENT_QUOTES)}</p>
                    </div>
                    <div class=answer-wrapper>
                        <p class=answer>{$faq->getAnswer(ENT_QUOTES)}</p>
                    </div>
                </div>
            </div>
            ";
        }
    ?>
</div>
<?php include('src/view/footer.php'); ?>
</body>
</html>