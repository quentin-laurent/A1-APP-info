<?php
$hostname = $_SERVER['HTTP_HOST'];
$imgDirectory = "http://$hostname/" . ROOT_URI . '/static/img/';
?>
<footer>
    <div class="socials">
        <a href="https://twitter.com"><img src=<?php echo "$imgDirectory/twitter.png" ?>></a>
        <a href="https://youtube.com"><img src=<?php echo "$imgDirectory/youtube.png" ?>></a>
        <a href="https://instagram.com"><img src=<?php echo "$imgDirectory/instagram.png" ?>></a>
    </div>
    <div id="footer-links">
        <a class="link" href="#">Mentions légales</a>
        <a class="link" href="#">CGU</a>
        <a class="link" href="#">Contact</a>
    </div>
    <div></div>
</footer>
