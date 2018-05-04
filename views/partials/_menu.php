<nav class="navbar">
<!-- menu that is set at the top of the page  -->
    <a class="navbar-brand" href="/index.php"><?php echo WEBSITE_NAME;?></a>
    <div class="collapse navbar-collapse">
        <ul class="nav navbar-nav">
            <li><a href="../index.php?action=liste">Liste des utilisateurs</a>
            </li>
            <li class="dropdown-item">
                            <a href="../../index.post.php">Blog</a>
                        </li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
            <?php if (is_logged_in()) :?>
                <li class="dropdown register">
                    <a href="#" class="dropdown-toggle"  data-toggle="dropdown" role="button">
                        <img src="<?= get_avatar_url(get_session('email')) ?>"
                             alt="Image de profil de <?= get_session('pseudo') ?>" class="img-circle">
                    </a>
                    <ul class="dropdown-menu" role="menu">
                        <li class="profile dropdown-item">
                            <a href="../index.php?action=profile&amp;id=<?= get_session('user_id')?>">Votre profil </a>
                        </li>
                        <li class="edit_user dropdown-item">
                            <a href="../index.php?action=change&amp;id=<?= get_session('user_id')?>">Edition de profil </a>
                        </li>
                        <li class="divider"></li>
                        <li class="nav-item dropdown-item">
                            <a href="../index.php?action=logout">Déconnexion</a>
                        </li>
                    </ul>
                </li>
            <?php else : ?>
            <li class="login">
                <a href="../index.php?action=login">Connexion</a>
            </li>
            <li class="register">
                <a href="../index.php?action=inscription">Inscription</a>
            </li>

            <?php endif; ?>
        </ul>
        <!--<form class="form-inline my-2 my-lg-0">
            <input class="form-control mr-sm-2" type="text" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
        </form>-->
    </div>
</nav>