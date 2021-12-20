<?php
if(isset($_GET['q']) && isset($_GET['type'])) {
    $q = htmlspecialchars(ucwords(strtolower($_GET['q'])));
    $type = htmlspecialchars($_GET['type']);
    if($type === 'joueur') {
        header('Location: joueurs.php?joueur='.urlencode($q));
    } else if ($type === 'club') {
        header('Location: clubs.php?club='.urlencode($q));
    } else {
        header('Location: nationales.php?nat='.urlencode($q));
    }
}

require_once "./include/header.inc.php";
?>
            <form action="#" method="GET">
                <div class="select">                
                    <div class="custom-select">
                        <select class="home-select" name="type">
                            <option value="joueur">Joueur</option>
                            <option value="club">Club</option>
                            <option value="nat">Equipe Nationale</option>
                        </select>
                        <div class="line2"></div>
                        <span class="custom-arrow"></span>
                    </div>
                </div>
                <div class="search-data">
                    <input type="text" required="required" name="q"/>
                    <div class="line"></div>
                    <label>Rechercher...</label>
                    <button type="submit"><span class="fas fa-search"></span></button>
                </div>
            </form>

            <div class="content">
                <h1>Footista</h1>
                <p>Découvrez l'univers du football comme vous ne l'avez jamais vu.</p>
                <?php if(!isset($_SESSION['auth'])) {
                    echo "\t\t\t<div>
                        <button id=\"btn-index\" class=\"button-home\"><span class=\"more\"></span>Créer un compte/Connexion</button>
                    </div>\n";
                }
                ?>
            </div>

<?php
require_once "./include/footer.inc.php";
?>