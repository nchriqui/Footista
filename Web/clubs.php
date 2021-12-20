<?php
use Foot\Clubs;
use Foot\ClubsTable;
use Foot\Connection;
use Foot\IconesTable;
use Foot\Joueurs;
use Foot\Table\Exception\NotFoundException;

require_once "vendor/autoload.php";

$arr_cookie_options = array (
	'expires' => time() + 60*60*24*30,
	'path' => '/',
	);

if(isset($_GET['club'])) {
    $nomclub = htmlspecialchars($_GET['club']);
    try {
        $pdo = Connection::getPDO();
        $table = new ClubsTable($pdo);
        $no_club = $table->getNoByClubName($nomclub);
        setcookie('Club', "$nomclub", $arr_cookie_options);
        setcookie('No_club', "$no_club", $arr_cookie_options);
        $_COOKIE['Club'] = $nomclub;
        $_COOKIE['No_club'] = $no_club;
    } catch (NotFoundException $e) {
        $e->getMessage();
        header('Location: 404.php');
        exit();
    }
}
else if(isset($_GET['no_club'])) {
    $no_club = htmlspecialchars($_GET['no_club']);
    try {
        $pdo = Connection::getPDO();
        $table = new ClubsTable($pdo);
        $nomclub = $table->getClubNameByNo($no_club);
        setcookie('Club', "$nomclub", $arr_cookie_options);
        setcookie('No_club', "$no_club", $arr_cookie_options);
        $_COOKIE['Club'] = $nomclub;
        $_COOKIE['No_club'] = $no_club;
    } catch (NotFoundException $e) {
        $e->getMessage();
        header('Location: 404.php');
        exit();
    }
}
if(isset($_COOKIE['No_club'])) {
    $no_club = $_COOKIE['No_club'];
    $pdo = Connection::getPDO();
    $iconesTable = new IconesTable($pdo);

    $query = $pdo->prepare("SELECT * FROM joueurs NATURAL JOIN clubs NATURAL JOIN equipes_nationales WHERE no_club = :no_club ORDER BY poste='Attaquant', poste='Milieu', poste='Défenseur', poste='Gardien de But'");
    $query->execute(['no_club' => $no_club]);
    $query->setFetchMode(PDO::FETCH_CLASS, Joueurs::class);
    $joueurs = $query->fetchAll();

    $query = $pdo->prepare("SELECT * FROM clubs WHERE no_club = :no_club");
    $query->execute(['no_club' => $no_club]);
    $query->setFetchMode(PDO::FETCH_CLASS, Clubs::class);
    $club = $query->fetch();

    $query = $pdo->prepare("SELECT nom_compet, nom_tr, description, organisateur, pays_compet, COUNT(*) AS nb_victoires FROM trophees NATURAL JOIN competitions WHERE no_club = :no_club GROUP BY nom_compet, nom_tr, description, organisateur, pays_compet");
    $query->execute(['no_club' => $no_club]);
    $nb_trophies = $query->fetchAll();
}

require_once "./include/header.inc.php";
?> 

    <form action="index.php" method="GET">
        <div class="select page">                
            <div class="custom-select">
                <select class="home-select" name="type">
                    <option value="joueur">Joueur</option>
                    <option selected="selected" value="club">Club</option>
                    <option value="nat">Equipe Nationale</option>
                </select>
                <div class="line2"></div>
                <span class="custom-arrow"></span>
            </div>
        </div>
        <div class="search-data page">
            <input type="text" required="required" name="q" value="<?php if(isset($_GET['club'])) { echo htmlspecialchars($_GET['club']); } else if(isset($_COOKIE['Club'])) { echo $_COOKIE['Club']; } ?>"/>
            <div class="line"></div>
            <label>Rechercher...</label>
            <button type="submit"><span class="fas fa-search"></span></button>
        </div>
    </form>
    
    <?php
    if(isset($_COOKIE['No_club'])) {
        echo "<div class=\"club-info\">\n";
        echo "\t\t<h2>" . $club->getNom_club() . "</h2>\n";
        echo "\t\t<ul>\n";
        echo "\t\t\t<li>Pays : <b>" . $club->getPays_club() . "</b></li>\n";
        echo "\t\t\t<li>Stade : <b>" . $club->getStade_club() . "</b></li>\n";
        echo "\t\t\t<li>Surnom : <b>" . $club->getSurnom_club() . "</b></li>\n";
        echo "\t\t</ul>\n";             
        echo "\t</div>\n";
        echo "\t<div class=\"container contain\">\n";

        echo "\t\t<div id=\"tabs\">
            <ul>
                <li><a href=\"#tabs-1\">Effectif</a></li>
                <li><a href=\"#tabs-2\">Palmarès</a></li>
            </ul>
            <div id=\"tabs-1\">\n";
            $tz  = new DateTimeZone('Europe/Paris');
            echo "\t\t".'<div class="players">
                <table class="table table-sm table-striped">
                    <thead> 
                        <tr>
                            <th scope="col">Numéro</th>
                            <th scope="col">Joueur</th>
                            <th scope="col">Poste</th>
                            <th scope="col">Né/âge</th>
                            <th scope="col">Equipe Nationale</th>
                        </tr>
                    </thead>
                    <tbody>'."\n";                    
                        foreach($joueurs as $joueur) {
                            $date = new DateTime($joueur->getDate_naissance());
                            $age = DateTime::createFromFormat('Y-m-d', $joueur->getDate_naissance(), $tz)->diff(new DateTime('now', $tz))->y;
                            echo "\t<tr>\n";
                            echo "\t\t<td>".$joueur->getNumero()."</td>\n";
                            echo "\t\t<td><a href=\"joueurs.php?no={$joueur->getNo_joueur()}\">".$joueur->getPrenom(). " ". $joueur->getNom() . "</a>";
                            if($iconesTable->exists('no_joueur_icone', $joueur->getNo_joueur())) { echo " <small class='icones'>icône</small>"; };
                            echo  "</td>\n";
                            echo "\t\t<td>".$joueur->getPoste()."</td>\n";
                            echo "\t\t<td>".$date->format('d/m/Y'). " (". $age . ")"."</td>\n";
                            echo "\t\t<td><a href=\"nationales.php?no_equipe={$joueur->getNo_equipe()}\">".$joueur->getPays_equipe()."</a></td>\n";
                            echo "\t</tr>\n";
                        }
                echo "\t".'</tbody>
                </table>
            </div>
        </div>'."\n";

            echo "\t\t<div id=\"tabs-2\">\n";
                if(!empty($nb_trophies)) {
                    echo "\t\t<ul>\n";
                    foreach($nb_trophies as $nb_trophy) {
                        $query = $pdo->prepare("SELECT date_debut, date_fin, nom_tr FROM saisons NATURAL JOIN trophees WHERE no_tr IN (SELECT no_tr FROM trophees WHERE no_club = :no_club) ORDER BY nom_tr, date_debut ASC");
                        $query->execute(['no_club' => $no_club]);
                        $date_trophies = $query->fetchAll();
                        $dates_tr = [];

                        foreach($date_trophies as $date_trophy) {
                            $debut = explode("-", $date_trophy['date_debut']);
                            $fin = explode("-", $date_trophy['date_fin']);
                            $dates_tr[] = $debut[0] . "/" . $fin[0];
                            if($date_trophy['nom_tr'] != $nb_trophy['nom_tr']) {
                                $dates_tr = [];
                            }                                                                 
                        }                   

                        echo "\t\t<li><b>" . $nb_trophy['nom_compet'] . "</b> (" . $nb_trophy['organisateur'] . ")</li>\n";
                        if(!empty($nb_trophy['pays_compet'])) {
                            echo "\t\t<li>Pays/Ligue : <b>" . $nb_trophy['pays_compet'] . "</b></li>\n";
                        }
                        echo "\t\t<li><b>" . $nb_trophy['nb_victoires'] ."x </b>". $nb_trophy['nom_tr'] . " "; foreach($dates_tr as $date_tr) { echo "(" . $date_tr . ") "; } echo "</li>\n";
                        echo "\t\t<li>" . $nb_trophy['description'] . "</li>\n";
                        echo "\t\t<li><hr/></li>\n";
                    }
                    echo "\t\t</ul>\n";
                } else {
                    echo "\t\t<p>Pas de trophées</p>\n";
                }
            echo "\t\t</div>
        </div>
    </div>\n";
    }
    ?>
<?php
require_once "./include/footer.inc.php";
?>