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
            document.getElementById('animationButton').innerText = 'SIGN UP';

            if (left) {
                left = false;
                document.getElementById('right').style.visibility = 'hidden';                     
                document.getElementById('hCreateAccount').style.visibility = 'hidden';
                background.style.paddingLeft= '0%'
                logo.src='../static/img/infinitemeasures-logo.png';
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
                    background.innerHTML = background.innerHTML.replace('Welcome Back!', 'Hello, Friend!');
                    document.getElementById('p').innerHTML = 'Enter your personal details and start<br>your journey with us';
                    document.getElementById('left').style.visibility = 'visible';
                    document.getElementById('hLogIn').style.visibility = 'visible';
                }
            }
            else {
                left = true;
                document.getElementById('left').style.visibility = 'hidden';           
                document.getElementById('hLogIn').style.visibility = 'hidden';
                background.style.paddingLeft= '3%';
                document.getElementById('animationButton').innerText = 'SIGN IN';

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
                    background.innerHTML = background.innerHTML.replace('Hello, Friend!', 'Welcome Back!');
                    document.getElementById('p').innerHTML = 'To stay connected with us please <br>fill in your credentials';
                    document.getElementById('hCreateAccount').style.visibility = 'visible';
                    document.getElementById('right').style.visibility = 'visible'; 
                    logo.src='../static/img/infinitemeasures-logo.png';
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
</head>
<body>
<?php
    $hostname = $_SERVER['HTTP_HOST'];
    $imgDirectory = $imgDirectory = "http://$hostname/" . ROOT_URI . '/static/img/';
?>
<a href=<?php echo"http://$hostname/" . ROOT_URI . 'index.php/home' ?>><img id="logo" src=<?php echo "$imgDirectory/infinitemeasures-logo.png"; ?> alt="logo"></a>
<div id="background">
    Hello, Friend!
    <p id="p">Enter your personal details and start
        <br> your journey with us</p>
    <button id="animationButton" class="submit signUp" onmousedown="animation()">SIGN UP</button>
</div>

<div class="grid-container">
    <h1 id="hLogIn">Log in</h1>
    <form action='./login/signin' method='POST' id="left" class="grid">
        <input type="text" name="email" class="first" placeholder="Email" required/><br>
        <input type="password" name="password"  class="second login" id="pass-field" placeholder="Password" required/><br>
        <a href=" " id="forgotPassword">Forgot my password</a>
        <?php
            if(isset($_GET['error']) && isset($_SESSION['errorMessage']))
                echo '<p id=error-message>'.$_SESSION['errorMessage'].'</p>';
        ?>
        <input class="SignIn submit" type="submit" name="submitSignIn" value="Sign In"/>
    </form>

    <h1 id="hCreateAccount">Create Account</h1>
    <form action="./login/signup" method="POST" id="right" class="grid">
        <input type="text" id="firstName" name="firstName" class="first" placeholder="First Name" required><br>

        <input type="text" id="lastName" name="lastName" class="second" placeholder="Second Name" required><br>

        <input type="date" id="birthday" name="birthday" class="third" placeholder="Birthday" required><br>

        <input type="email" id="email" name="email" class="fourth" placeholder="Email" required><br>

        <input type="tel" id="phoneNumber" name="phoneNumber" class="fifth" placeholder="Phone number (optional)"><br>

        <input type="password" id="password" name="password" class="sixth" placeholder="Password" required><br>

        <input type="password" id="passwordVerify" name="passwordVerify" class="seventh" placeholder="Verify password" required><br>

        <input class="create submit" type="submit" name="submitCreateAccount"  value="Sign Up">
    </form>
</div>

</body>
</html>
