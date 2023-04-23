<header>
    <img id="navbar-logo" src="../static/img/ontrack-logo.png" alt="logo">
    <nav>
        <ul class="navbar-links">
            <li><a href="#">Accueil</a></li>
            <li><a href="#">Mes données</a></li>
            <li><a href="#">Tickets</a></li>
            <?php
            if(isset($_SESSION['email']))
            {
                $user = User::fetchFromEmail($_SESSION['email']);
                if($user->getPermissionLevel() === ADMINISTRATOR)
                {
                    echo '
                    <li class="dropdown" data-dropdown>
                        <a href="#" data-dropdown-link>Backoffice</a>
                        <div class="dropdown-menu dropdown-links">
                            <a href="#">Gestion utilisateurs</a>
                            <a href="#">Gestion FAQ</a>
                            <a href="#">Gestion Tickets</a>
                        </div>
                    </li>
                    ';
                }
                else if($user->getPermissionLevel() === MANAGER)
                {
                    echo '
                    <li class="dropdown" data-dropdown>
                        <a href="#" data-dropdown-link>Backoffice</a>
                        <div class="dropdown-menu dropdown-links">
                            <a href="#">Gestion FAQ</a>
                            <a href="#">Gestion Tickets</a>
                        </div>
                    </li>
                    ';
                }
            }
            ?>
        </ul>
    </nav>
    <?php
    if(isset($_SESSION['email']))
    {
        $user = User::fetchFromEmail($_SESSION['email']);
        if($user->getPermissionLevel() === ADMINISTRATOR)
            $roleSpan = '<span id=role-admin>Administrateur</span>';
        else if($user->getPermissionLevel() === MANAGER)
            $roleSpan = '<span id=role-manager>Gestionnaire</span>';
        else
            $roleSpan = '<span id=role-user>Utilisateur</span>';
        echo "
        <div>
            <div id=user-profile>
                <img id=user-pfp src=../static/img/{$user->getProfilePicturePath()} alt=pfp onclick=openMenu()>
                <p>{$user->getFirstname()} {$user->getLastname()}</p>
            </div>
            <div class=submenu-wrap id=submenu-wrap>
                <div class=submenu>
                    <div class=user-info>
                        <img src=../static/img/{$user->getProfilePicturePath()} alt=pfp>
                        <div>
                            <p>{$user->getFirstname()} {$user->getLastname()}</p>
                            $roleSpan
                        </div>
                    </div>
                    <hr>
                    <a class=submenu-link href=#>
                        <img src=../static/img/profile-icon.svg alt=profile-icon>
                        <p>Mon profil</p>
                        <span>></span>
                    </a>
                    <a class=submenu-link href=logout>
                        <img src=../static/img/logout-icon.svg alt=logout-icon>
                        <p>Déconnexion</p>
                        <span>></span>
                    </a>
                </div>
            </div>
        </div>
        ";
    }
    else
        echo '<a class="btn-login" href="./login"><button>Connexion</button></a>';
    ?>
</header>