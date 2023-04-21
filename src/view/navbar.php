<header>
    <img id="navbar-logo" src="../static/img/ontrack-logo.png" alt="logo">
    <nav>
        <ul class="navbar-links">
            <li><a href="#">Accueil</a></li>
            <li><a href="#">Mes données</a></li>
            <li class="dropdown" data-dropdown>
                <a href="#" data-dropdown-link>Backoffice</a>
                <div class="dropdown-menu dropdown-links">
                    <a href="#">Gestion utilisateurs</a>
                    <a href="#">Gestion FAQ</a>
                    <a href="#">Gestion Tickets</a>
                </div>
            </li>
        </ul>
    </nav>
    <?php
    if(isset($_SESSION['email']))
    {
        $user = User::fetchFromEmail($_SESSION['email']);
        echo "<p>Bonjour {$user->getFirstname()}</p>";
    }
    else
        echo '<a class="btn-login" href="./login"><button>Connexion</button></a>';
    ?>
</header>