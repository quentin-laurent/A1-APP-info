<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>PortAn / Accueil</title>
  <link rel="icon" type="image/x-icon" href="../static/img/infinitemeasures-logo.png">
  <link rel="stylesheet" href="../static/css/navbar.css">
  <link rel="stylesheet" href="../static/css/footer.css">
  <script src="../static/js/navbar.js"></script>
  <link rel="stylesheet" href="../static/css/home.css">
</head>

<?php include('src/view/navbar.php'); ?>

<body>
    <div id="parent">
        <div id="enfant">

<!--Carrousel Accueil-->    
            <div class="Vitrine" id="Debut">
                <div class="Carrousel">
                    <div class="slider-container slider-1">
                        <div class="slider">
                            <img src="../static/img/athlete-1920x689.jpg" alt="" class="imgCarrousel">
                            <img src="../static/img/1920x1080-athlete-running-mountains-bw-4k_1540062198.jpg" alt="" class="imgCarrousel">
                            <img src="../static/img/athlete-1920x689.jpg" alt="" class="imgCarrousel">
                            <img src="../static/img/10839843.jpg" alt="" class="imgCarrousel">
                            <img src="../static/img/athlete-1920x689.jpg" alt="" class="imgCarrousel">
                        </div>
                    </div>
                </div>
        <!-- Fin Carrousel Accueil-->  

        <!--Logo Central-->
                <div class="LogoCentral">
                    <img src="../static/img/portan-logo.png" alt="" id="imgLogoNom">

                    <div class="cadre">
                        <div class="center">
                            <div class="carousel">
                                <div class="preTxt">Une solution</div>
                                <div class="changeHidden">
                                    <div class="contenant">
                                        <div class="element">accessible</div>
                                        <div class="element">portative</div>
                                        <div class="element">en temps réel</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        <!--Fin Logo Central-->
            </div>

            <div class="button-top-return">
                <a href="#Debut" ><img id="button-top-return" src="../static/img/icons8-flèche-réduire-32.png" alt="Haut de la Page"></a>
            </div>
<!--Fin Carrousel Accueil-->

            <div class="ZONE2">
                <div class="ZONE2-TOP-HALF">
                    <div class="ZONE2-REC1">
                        <h1 id="BLOC-ABOUT">A propos de nous</h1>
                    </div>

                    <div class="ZONE2-REC2">
                       <img class="ZONE2-REC2"src="../static/img\athletes-running-cheetahs-wallpaper-preview.jpg" alt="">
                    </div>
                </div>

                <div class="ZONE2-BOTTOM-HALF">
                    <div class="ZONE2-REC3"></div>
                    <div class="ZONE2-REC4">
                        <p id="BLOC-ZONE2-TEXT">
                            Spécialisée dans l'équipement sportif, l'entreprise OnTrack a développé l'appareil PortAn ainsi que ce site web pour le compte de la société Infinite Measures.
                        </p>
                    </div>

                    <div class="ZONE2-REC5">
                         <h1 id="BLOC-TEAM">Notre équipe</h1>
                    </div>
                </div>
            </div>

            <div class="ZONE3">
                <div class="ZONE3-RIGHT-HALF">
                    <div class="ZONE3-RIGHT-TOP-HALF">
                        <h1 id="BLOC-PRODUCT">Notre produit</h1>
                    </div>

                    <div class="ZONE3-RIGHT-BOTTOM-HALF">
                        <div class="ZONE3-RIGHT-BOTTOM-HALF-REC1">
                            <img class="ZONE3-REC2" src="../static/img/ontrack-watch.png" alt="">
                        </div>

                        <div class="ZONE3-BOTTOM-HALF-REC2">
                            <p id="BLOC-ZONE3-TEXT">
                                Le dispositif PortAn est un boîtier qui collecte des données environnementales et physiologiques afin de fournir des renseignements sur la santé et l'environnement de la personne qui en est équipée. Il s'agit d'un dispositif dont l'usage est à destination des sportifs.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="ZONE3-LEFT-HALF">
                        <img class="ZONE3-REC4" src="../static/img/portan-logo.png" alt="">
                </div>
            </div>

            <div class="ZONE4">
            <!--
                Carrousel à contruire
                <div class="ZONE4-Carrousel">
                </div>
            -->
                <div class="ZONE4-TOP-HALF">
                    <div class="ZONE4-REC1">
                        <h1 id="BLOC-Technology">Technologie</h1>
                    </div>

                    <div class="ZONE4-REC2">
                       <img class="ZONE4-REC2" src="../static/img/athlete-stretching-fitness.jpg" alt="">
                    </div>
                </div>
                <div class="ZONE4-BOTTOM-HALF">
                    <div class="ZONE4-REC3"></div>
                    <div class="ZONE4-REC4"></div>
                </div>
            </div>
        </div>
    </div>
    <?php include('src/view/footer.php'); ?>
</body>
</html>
