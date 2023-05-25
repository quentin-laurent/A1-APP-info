<!DOCTYPE html>
<html>
<head>
    <meta charset="ISO-8859-1">
    <title>PortAn / Log In</title>
    <link rel="stylesheet" href="../static/css/login.css">
    <link rel="icon" type="image/x-icon" href="../static/img/infinitemeasures-logo.png">
    <script type="text/javascript">
        let left = false;
        function animation() {

            logo = document.getElementById('logo');
            var background = document.getElementById('background');
            background.style.zIndex = '0';
            document.getElementById('animationButton').innerText = 'Inscription';

            if (left) {
                left = false;
                document.getElementById('right').style.visibility = 'hidden';                     
                document.getElementById('hCreateAccount').style.visibility = 'hidden';
                background.style.paddingLeft= '0%'
                logo.src='../static/img/hidden.png';
                var margin = -15;
                setInterval(moveDiv, 5);

                function moveDiv() {
                    if(margin<=38) {
                        margin+=1;
                        background.style.marginLeft = margin+'%';
                    }
                }
                setTimeout(continueExecution, 200);
                function continueExecution(){
                    background.innerHTML = background.innerHTML.replace('De retour !', 'Bienvenue !');
                    document.getElementById('p').innerHTML = 'Remplissez le formulaire et<br>commencez votre aventure !';
                    document.getElementById('left').style.visibility = 'visible';
                    document.getElementById('hLogIn').style.visibility = 'visible';
                }
            }
            else {
                left = true;
                document.getElementById('left').style.visibility = 'hidden';           
                document.getElementById('hLogIn').style.visibility = 'hidden';
                background.style.paddingLeft= '3%';
                document.getElementById('animationButton').innerText = 'Connexion';

                var margin = 38;        
                setInterval(moveDiv, 5);
                function moveDiv(){ 
                    if(margin>=-15) {
                        margin-=1;
                        background.style.marginLeft = margin+'%';
                    }
                }
                setTimeout(continueExecution, 200);
                function continueExecution() {
                    background.innerHTML = background.innerHTML.replace('Bienvenue !', 'De retour !');
                    document.getElementById('p').innerHTML = 'Saisissez vos identifiants <br>pour vous connecter !';
                    document.getElementById('hCreateAccount').style.visibility = 'visible';
                    document.getElementById('right').style.visibility = 'visible'; 
                    logo.src='../static/img/hidden.png';
                }
            }
        }

        function showPassword() {
            document.getElementById('pass-field').type = 'text';
        }

        function hidePassword() {
            document.getElementById('pass-field').type = 'password';
        }
    </script>
    <link rel="stylesheet" href="../static/css/navbar.css">
    <script src="../static/js/navbar.js"></script>
</head>

<?php include('src/view/navbar.php'); ?>

<body>
<div id="page">
<?php
    $hostname = $_SERVER['HTTP_HOST'];
    $imgDirectory = $imgDirectory = "http://$hostname/" . ROOT_URI . '/static/img/';
?>
<a href=<?php echo"http://$hostname/" . ROOT_URI . 'index.php/home' ?>><img id="logo" src=<?php echo "$imgDirectory/hidden.png"; ?> alt="logo"></a>
<div id="background">
    Bienvenue !
    <p id="p">Remplissez le formulaire et
        <br> commencez votre aventure !</p>
    <button id="animationButton" class="submit signUp" onmousedown="animation()">Inscription</button>
</div>

<div class="grid-container">
    <h1 id="hLogIn">Connexion</h1>
    <form action='./login/signin' method='POST' id="left" class="grid">
        <input type="text" name="email" class="first" placeholder="Email" required/><br>
        <input type="password" name="password"  class="second login" id="pass-field" placeholder="Mot de passe" required/><br>
        <a href=" " id="forgotPassword">Mot de passe oublié ?</a>
        <?php
            if(isset($_GET['error']) && isset($_SESSION['errorMessage']))
                echo '<p id=error-message>'.$_SESSION['errorMessage'].'</p>';
        ?>
        <input class="SignIn submit" type="submit" name="submitSignIn" value="Valider"/>
    </form>

    <h1 id="hCreateAccount">Inscription</h1>
    <form action="./login/signup" method="POST" id="right" class="grid">
        <input type="text" id="firstName" name="firstName" class="first" placeholder="Prénom" required><br>

        <input type="text" id="lastName" name="lastName" class="second" placeholder="Nom" required><br>

        <input type="date" id="birthday" name="birthday" class="third" placeholder="Date de naissance" required><br>

        <input type="email" id="email" name="email" class="fourth" placeholder="Email" required><br>

        <input type="tel" id="phoneNumber" name="phoneNumber" class="fifth" placeholder="Téléphone (facultatif)"><br>

        <input type="password" id="password" name="password" class="sixth" placeholder="Mot de passse" required><br>

        <input type="password" id="passwordVerify" name="passwordVerify" class="seventh" placeholder="Mot de passe (confirmation)" required><br>

        <input class="create submit" type="submit" name="submitCreateAccount"  value="Valider">
    </form>
</div>
</div>
</body>
</html>
