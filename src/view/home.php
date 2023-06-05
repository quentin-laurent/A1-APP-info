<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>PortAn / Home</title>
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
                        <h1 id="BLOC-ABOUT">About us</h1>
                    </div>

                    <div class="ZONE2-REC2">
                       <img class="ZONE2-REC2"src="../static/img\athletes-running-cheetahs-wallpaper-preview.jpg" alt="">
                    </div>
                </div>

                <div class="ZONE2-BOTTOM-HALF">
                    <div class="ZONE2-REC3"></div>
                    <div class="ZONE2-REC4">
                        <p id="BLOC-ZONE2-TEXT">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam mi felis, blandit sit amet hendrerit quis, condimentum et erat. 
                            Nunc nec consectetur ex. Proin in semper tellus. Donec pretium est diam, a sagittis lectus ullamcorper eget. Ut faucibus in felis vitae 
                            varius. Sed efficitur metus ac mi ultrices, in vestibulum nibh pellentesque. Interdum et malesuada fames ac ante ipsum primis in faucibus. 
                            Proin fermentum libero velit, ornare hendrerit nunc blandit id. Sed arcu justo, vestibulum sit amet erat nec, 
                            tincidunt ornare purus. Mauris lobortis nisl vel tellus ultricies, a suscipit orci dignissim.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam mi felis, blandit sit amet hendrerit quis, condimentum et erat. 
                            Nunc nec consectetur ex. Proin in semper tellus. Donec pretium est diam, a sagittis lectus ullamcorper eget. 
                        </p>
                    </div>

                    <div class="ZONE2-REC5">
                         <h1 id="BLOC-TEAM">Team</h1>
                    </div>
                </div>
            </div>

            <div class="ZONE3">
                <div class="ZONE3-RIGHT-HALF">
                    <div class="ZONE3-RIGHT-TOP-HALF">
                        <h1 id="BLOC-PRODUCT">Product</h1>
                    </div>

                    <div class="ZONE3-RIGHT-BOTTOM-HALF">
                        <div class="ZONE3-RIGHT-BOTTOM-HALF-REC1">
                            <img class="ZONE3-REC2" src="../static/img/ontrack-watch.png" alt="">
                        </div>

                        <div class="ZONE3-BOTTOM-HALF-REC2">
                            <p id="BLOC-ZONE3-TEXT">
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam mi felis, blandit sit amet hendrerit quis, condimentum et erat. 
                                Nunc nec consectetur ex. Proin in semper tellus. Donec pretium est diam, a sagittis lectus ullamcorper eget. Ut faucibus in felis vitae 
                                varius. Sed efficitur metus ac mi ultrices, in vestibulum nibh pellentesque. Interdum et malesuada fames ac ante ipsum primis in faucibus. 
                                Proin fermentum libero velit, ornare hendrerit nunc blandit id. Sed arcu justo, vestibulum sit amet erat nec, 
                                tincidunt ornare purus. 
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
                        <h1 id="BLOC-Technology">Technology</h1>
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
