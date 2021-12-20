<?php
use Foot\Connection;
use Foot\User\Auth;

if(session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once "vendor/autoload.php";
?>
<!DOCTYPE html>
<html lang="fr">
    <head>
        <!-- méta-données -->
        <title>Footista</title>
        <meta name="author" content="nathan"/>
        <meta name="keywords" content="foot joueurs clubs"/>
		<meta name="description" content="Besoins d'informatons sur le football."/>
        <meta charset="utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1"/>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-uWxY/CJNBR+1zjPWmfnSnVxwRheevXITnMqoEIeG1LJrdI0GlVs/9cVSyPYXdcSF" crossorigin="anonymous"/>
        <link type="text/css" rel="stylesheet" title="standard" href="styles.css"/>
        <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.0/themes/base/jquery-ui.css"/>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
        <link rel="icon" href="./images/favicon.ico"/>  
    </head>
    <?php
    $page = basename($_SERVER["PHP_SELF"]);
    if($page == "joueurs.php") {
        echo "<body class=\"body-player\">\n";
    }
    else if($page == "clubs.php") {
        echo "<body class=\"body-club\">\n";
    }
    else if($page == "nationales.php") {
        echo "<body class=\"body-nation\">\n";
    }
    else {
        echo "<body>\n";
    }
    ?>
        <header>
        <?php
        if(isset($_SESSION['auth'])) {
            $pdo = Connection::getPDO();
            $auth = new Auth($pdo);
            $user = $auth->user();
        }
        ?>
            <div class="navbar">
                <a href="index.php">
                    <img src="./images/logo.svg" alt="logo"/>
                </a>
                <ul>
                    <li <?php if($page == 'index.php') { echo "class=\"active-li\"";} ?>>
                        <a href="index.php">Accueil</a>
                    </li>
                    <li <?php if($page == 'joueurs.php') { echo "class=\"active-li\"";} ?>>
                        <a href="joueurs.php">Joueurs</a>
                    </li>
                    <li <?php if($page == 'clubs.php') { echo "class=\"active-li\"";} ?>>
                        <a href="clubs.php">Clubs</a>
                    </li>
                    <li <?php if($page == 'nationales.php') { echo "class=\"active-li\"";} ?>>
                        <a href="nationales.php">Nationales</a>
                    </li>
                    <?php
                    if(isset($_SESSION['auth'])) {
                        echo "<li>
                        <div class=\"dropdown\">
                            <button class=\"btn btn-secondary dropdown-toggle\" type=\"button\" id=\"dropdownMenu2\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\">\n";
                            if($user) {
                                $utilisateur = $user->getUsername();
                            }
                            echo str_repeat("\t", 8) . $utilisateur . "\n";
                            echo str_repeat("\t", 7) . "</button>
                            <div class=\"dropdown-menu\" aria-labelledby=\"dropdownMenu2\">
                                <a class=\"dropdown-item\" href=\"logout.php\">Déconnexion</a>
                            </div>
                        </div>
                    </li>\n";
                    }
                    else {
                        echo "<li "; if($page == 'login.php') { echo "class=\"active-li\"";} echo ">
                        <a href=\"login.php\">Se connecter</a>
                    </li>\n";
                    }
                    ?>
                </ul>
            </div>
        </header>
        