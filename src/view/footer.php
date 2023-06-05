<?php
$hostname = $_SERVER['HTTP_HOST'];
$imgDirectory = "http://$hostname/" . ROOT_URI . '/static/img/';
$rootURL = "http://$hostname/" . ROOT_URI . 'index.php';
?>
<footer>
    <div class="socials">
        <a href="https://twitter.com"><img src=<?php echo "$imgDirectory/twitter.png" ?>></a>
        <a href="https://youtube.com"><img src=<?php echo "$imgDirectory/youtube.png" ?>></a>
        <a href="https://instagram.com"><img src=<?php echo "$imgDirectory/instagram.png" ?>></a>
    </div>
    <div id="footer-links">
        <a class="link" href=<?php echo"http://$hostname/" . ROOT_URI . 'index.php/mentionsLegales' ?>>Mentions légales</a>
        <a class="link" href=<?php echo"http://$hostname/" . ROOT_URI . 'index.php/cgu' ?>>CGU</a>
        <a class="link" href="#">FAQ</a>
        <a class="link" href="#">Contact</a>
    </div>
    <div></div>
</footer>
