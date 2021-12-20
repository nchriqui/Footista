<?php
use Foot\Connection;
use Foot\Icones;
use Foot\IconesTable;
use Foot\Joueurs;
use Foot\JoueursTable;
use Foot\Table\Exception\NotFoundException;

require_once "vendor/autoload.php";

$arr_cookie_options = array (
	'expires' => time() + 60*60*24*30,
	'path' => '/',
	);

if(isset($_GET['joueur']) && !empty($_GET['joueur'])) {
    $nom = htmlspecialchars($_GET['joueur']);
    $nbr = str_word_count($nom);
    if($nbr == 2) {
        $n = explode(" ", $nom);
        try {
            $pdo = Connection::getPDO();
            $table = new JoueursTable($pdo);
            $no_joueur = $table->getNoByJoueurandName($n[1], $n[0]);
            setcookie('Nom', "$nom", $arr_cookie_options);
            setcookie('No_joueur', "$no_joueur", $arr_cookie_options);
            $_COOKIE['Nom'] = $nom;
            $_COOKIE['No_joueur'] = $no_joueur;
        } catch (NotFoundException $e) {
            $e->getMessage();
            header('Location: 404.php');
            exit();
        }
    }
    else if ($nbr == 1) {
        try {
            $pdo = Connection::getPDO();
            $table = new JoueursTable($pdo);
            $no_joueur = $table->getNoByJoueurName($nom);
            setcookie('Nom', "$nom", $arr_cookie_options);
            setcookie('No_joueur', "$no_joueur", $arr_cookie_options);
            $_COOKIE['Nom'] = $nom;
            $_COOKIE['No_joueur'] = $no_joueur;
        } catch (NotFoundException $e) {
            $e->getMessage();
            header('Location: 404.php');
            exit();
        }
    }
    
}
else if(isset($_GET['no']) && !empty($_GET['no'])) {
    $no_joueur = htmlspecialchars($_GET['no']);
    try {
        $pdo = Connection::getPDO();
        $table = new JoueursTable($pdo);
        $nom = $table->getJoueurNameByNo($no_joueur);
        setcookie('Nom', "$nom", $arr_cookie_options);
        setcookie('No_joueur', "$no_joueur", $arr_cookie_options);
        $_COOKIE['Nom'] = $nom;
        $_COOKIE['No_joueur'] = $no_joueur;        
    } catch (NotFoundException $e) {
        $e->getMessage();
        header('Location: 404.php');
        exit();
    }
}
if(isset($_COOKIE['No_joueur'])) {
    $no_joueur = $_COOKIE['No_joueur'];
    $pdo = Connection::getPDO();
    $iconesTable = new IconesTable($pdo);

    $query = $pdo->prepare("SELECT * FROM joueurs NATURAL JOIN clubs NATURAL JOIN equipes_nationales WHERE no_joueur = :no_joueur");
    $query->execute(['no_joueur' => $no_joueur]);
    $query->setFetchMode(PDO::FETCH_CLASS, Joueurs::class);
    $joueur = $query->fetch();

    $query = $pdo->prepare("SELECT date_debut,date_fin,no_saison,no_club,nom_club,nb_matchs,buts,passes_decisives,cartons_jaunes,cartons_rouges FROM joueurs NATURAL JOIN clubs NATURAL JOIN statistiques NATURAL JOIN saisons WHERE no_joueur = :no_joueur ORDER BY date_debut ASC");
    $query->execute(['no_joueur' => $no_joueur]);
    $stats = $query->fetchAll();

    $query = $pdo->prepare("SELECT SUM(nb_matchs) AS nb_matchs, SUM(buts) AS nb_buts, SUM(passes_decisives) AS nb_passes_decisives, SUM(cartons_jaunes) AS nb_cartons_jaunes, SUM(cartons_rouges) AS nb_cartons_rouges FROM statistiques NATURAL JOIN saisons WHERE no_joueur = :no_joueur");
    $query->execute(['no_joueur' => $no_joueur]);
    $total = $query->fetch();

    $query = $pdo->prepare("SELECT nom_tr, description, COUNT(*) AS nb_victoires FROM trophees NATURAL JOIN saisons INNER JOIN joueurs ON trophees.no_joueur = joueurs.no_joueur WHERE trophees.no_joueur = :no_joueur GROUP BY nom_tr,description");
    $query->execute(['no_joueur' => $no_joueur]);
    $trophies = $query->fetchAll();

    $query = $pdo->prepare("SELECT date_transfert, montant FROM transferts WHERE no_joueur = :no_joueur");
    $query->execute(['no_joueur' => $no_joueur]);
    $transferts = $query->fetchAll();

    $query = $pdo->prepare("SELECT nom_blessure, date_debut_blessure, date_fin_blessure FROM joueurs NATURAL JOIN blessures WHERE no_joueur = :no_joueur");
    $query->execute(['no_joueur' => $no_joueur]);
    $blessures = $query->fetchAll();

    $query = $pdo->prepare("SELECT * FROM icones WHERE no_joueur_icone = :no_joueur");
    $query->execute(['no_joueur' => $no_joueur]);
    $query->setFetchMode(PDO::FETCH_CLASS, Icones::class);
    $icone = $query->fetch();
}
require_once "./include/header.inc.php";
?>

    <form action="index.php" method="GET">
        <div class="select page">                
            <div class="custom-select">
                <select class="home-select" name="type">
                    <option selected="selected" value="joueur">Joueur</option>
                    <option value="club">Club</option>
                    <option value="nat">Equipe Nationale</option>
                </select>
                <div class="line2"></div>
                <span class="custom-arrow"></span>
            </div>
        </div>
        <div class="search-data page">
            <input type="text" required="required" name="q" value="<?php if(isset($_GET['club'])) { echo htmlspecialchars($_GET['club']); } else if (isset($_COOKIE['Nom'])) { echo $_COOKIE['Nom']; } ?>"/>
            <div class="line"></div>
            <label>Rechercher...</label>
            <button type="submit"><span class="fas fa-search"></span></button>
        </div>
    </form>

    <?php
    if(isset($_COOKIE['No_joueur']) && !$iconesTable->exists('no_joueur_icone', $joueur->getNo_joueur())) {
        $tz  = new DateTimeZone('Europe/Paris');
        $date = new DateTime($joueur->getDate_naissance());
        $age = DateTime::createFromFormat('Y-m-d', $joueur->getDate_naissance(), $tz)->diff(new DateTime('now', $tz))->y;
        echo "<div class=\"joueur-info\">\n";
        echo "\t\t<h2>" . $joueur->getPrenom() . " <b>" . $joueur->getNom() . "</b> <span class='club-name'>(<a href=\"clubs.php?no_club={$joueur->getNo_club()}\">". $joueur->getNom_club() . "</a>)</span></h2>\n";
        echo "\t\t<div class='info'>\n";
        echo "\t\t<div>\n";
        echo "\t\t<ul>\n";
        echo "\t\t\t<li>Date de naissance/âge : <b>" .$date->format('d/m/Y'). " (". $age . ")". "</b></li>\n";
        echo "\t\t\t<li>Nationalité : <b>" . $joueur->getNationalite() . "</b></li>\n";
        if(!empty($joueur->getSurnom())) {
            echo "\t\t\t<li>Surnom : <b>" . $joueur->getSurnom() . "</b></li>\n";
        }
        echo "\t\t</ul>\n";
        echo "\t\t</div>\n";
        echo "\t\t<div>\n";
        echo "\t\t<ul>\n";
        echo "\t\t\t<li>Taille : <b>" . $joueur->getTaille() . " cm</b></li>\n";
        echo "\t\t\t<li>Poste : <b>" . $joueur->getPoste() . "</b></li>\n";
        echo "\t\t\t<li>Equipe Nationale : <a href=\"nationales.php?no_equipe={$joueur->getNo_equipe()}\"><b>" . $joueur->getPays_equipe() . "</b></a></li>\n";
        echo "\t\t</ul>\n";
        echo "\t\t</div>\n";
        echo "\t\t<div>";
        echo "\t\t<ul>\n";
        echo "\t\t\t<li>Pied : <b>" . $joueur->getPied_fort() . "</b></li>\n";
        echo "\t\t\t<li>Numéro : <b>" . $joueur->getNumero() . "</b></li>\n";
        echo "\t\t</ul>\n";  
        echo "\t\t</div>\n";
        echo "\t\t</div>\n";           
        echo "\t</div>\n";
        echo "\t<div class=\"container contain\">\n";
        echo "\t\t<div id=\"tabs\">
            <ul>
                <li><a href=\"#tabs-1\">Statistiques</a></li>
                <li><a href=\"#tabs-2\">Palmarès</a></li>
                <li><a href=\"#tabs-3\">Transferts</a></li>
                <li><a href=\"#tabs-4\">Blessures</a></li>
            </ul>
            <div id=\"tabs-1\">\n";
            if(!empty($stats)) {
                echo "\t\t".'<div class="players">
                    <table class="table table-sm table-striped">
                        <thead> 
                            <tr>
                                <th scope="col">Saison</th>
                                <th scope="col">Club</th>
                                <th scope="col">Matchs</th>
                                <th scope="col">Buts</th>
                                <th scope="col">Passes décisives</th>
                                <th scope="col">Cartons jaunes</th>
                                <th scope="col">Cartons rouges</th>
                                <th scope="col">&#x00A0;&#x00A0;&#x00A0;&#x00A0;&#x00A0;</th>
                            </tr>
                        </thead>
                        <tbody>'."\n";                    
                            foreach($stats as $stat) {
                                if(!empty($transferts)) {
                                    foreach($transferts as $transfert) {
                                        $date = new DateTime($transfert['date_transfert']);
                                        $query = $pdo->prepare("SELECT no_club, nom_club FROM clubs WHERE no_club IN (SELECT no_club_depart FROM joueurs NATURAL JOIN transferts WHERE no_joueur = :no_joueur)");
                                        $query->execute(['no_joueur' => $no_joueur]);
                                        $club = $query->fetch();
                                    }
                                }
                                $debut = explode("-", $stat['date_debut']);
                                $fin = explode("-", $stat['date_fin']);
                                $finDT = new DateTime($stat['date_fin']);
                                echo "\t<tr>\n";
                                echo "\t\t<td>" . $debut[0] . "/" . $fin[0] . "</td>\n"; 
                                if(isset($club) && ($date > $finDT) === true) {
                                    echo "\t\t<td><a href=\"clubs.php?no_club={$club['no_club']}\">" . $club['nom_club'] . "</a></td>\n";
                                } else {
                                    echo "\t\t<td><a href=\"clubs.php?no_club={$stat['no_club']}\">" . $stat['nom_club'] . "</a></td>\n";
                                }                         
                                echo "\t\t<td>".$stat['nb_matchs']."</td>\n";
                                echo "\t\t<td>".$stat['buts']."</td>\n";
                                echo "\t\t<td>".$stat['passes_decisives']."</td>\n";
                                echo "\t\t<td>".$stat['cartons_jaunes']."</td>\n";
                                echo "\t\t<td>".$stat['cartons_rouges']."</td>\n";
                                if(isset($_SESSION['auth'])) {
                                    echo "\t\t<td><a href=\"edit.php?no_saison={$stat['no_saison']}&no_joueur={$joueur->getNo_joueur()}\"><img src='./images/editbutton.svg' alt='edit'/></a></td>\n";
                                } else {
                                    echo "\t\t<td><a href=\"login.php\"><img src='./images/editbutton.svg' alt='edit'/></a></td>\n"; 
                                }
                                echo "\t</tr>\n";
                            }
                            echo "\t</tbody>\n";
                            echo "\t<tfoot>\n";
                            echo "\t<tr>\n";
                            echo "\t\t<td>Total</td>\n";
                            echo "\t\t<td></td>\n";
                            echo "\t\t<td>" . $total['nb_matchs'] . "</td>\n";
                            echo "\t\t<td>" . $total['nb_buts'] . "</td>\n";
                            echo "\t\t<td>" . $total['nb_passes_decisives'] . "</td>\n";
                            echo "\t\t<td>" . $total['nb_cartons_jaunes'] . "</td>\n";
                            echo "\t\t<td>" . $total['nb_cartons_rouges'] . "</td>\n";
                            echo "\t</tr>\n";
                            echo "\t".'</tfoot>
                    </table>
                </div>';
            } else {
                echo "\t\t<p>Pas de statistiques disponibles pour ce joueur</p>\n";
            }
        echo "</div>\n";

        echo "\t\t<div id=\"tabs-2\">";                
                if(!empty($trophies)) {
                    echo "\t\t<ul>\n";
                    foreach($trophies as $trophy) {
                        $query = $pdo->prepare("SELECT date_debut, date_fin, nom_tr FROM saisons NATURAL JOIN trophees INNER JOIN joueurs ON trophees.no_joueur = joueurs.no_joueur WHERE no_tr IN (SELECT no_tr FROM trophees NATURAL JOIN saisons INNER JOIN joueurs ON trophees.no_joueur = joueurs.no_joueur WHERE trophees.no_joueur = :no_joueur) ORDER BY nom_tr, date_debut ASC");
                        $query->execute(['no_joueur' => $no_joueur]);
                        $date_trophies = $query->fetchAll();
                        $dates_tr = [];
    
                        foreach($date_trophies as $date_trophy) {
                            $debut = explode("-", $date_trophy['date_debut']);
                            $fin = explode("-", $date_trophy['date_fin']);
                            $dates_tr[] = $debut[0] . "/" . $fin[0];
                            if($date_trophy['nom_tr'] != $trophy['nom_tr']) {
                                $dates_tr = [];
                            }                                                                 
                        } 

                        echo "\t\t<li><b>" . $trophy['nb_victoires'] ."x </b> ". $trophy['nom_tr'] . " "; foreach($dates_tr as $date_tr) { echo "(" . $date_tr . ") "; } echo "</li>\n";
                        echo "\t\t<li>" . $trophy['description'] . "</li>\n";
                        echo "\t\t<li><hr/></li>\n";
                    }
                    echo "\t\t</ul>\n";
                } else {
                    echo "\t\t<p>Pas de trophées individuels</p>\n";
                }             
            echo "\t\t</div>\n";
            echo "\t\t<div id=\"tabs-3\">\n";                
            if(!empty($transferts)) {
                echo "\t\t<table class=\"table table-sm table-striped\">
                <thead> 
                    <tr>
                        <th scope=\"col\">Date</th>
                        <th scope=\"col\">Venant de</th>
                        <th scope=\"col\">Allant à</th>
                        <th scope=\"col\">Montant du transfert</th>
                    </tr>
                </thead>";
                echo "\t<tbody>\n";
                foreach($transferts as $transfert) {
                    $query = $pdo->prepare("SELECT no_club, nom_club FROM clubs WHERE no_club IN (SELECT no_club_depart FROM transferts WHERE no_joueur = :no_joueur)");
                    $query->execute(['no_joueur' => $no_joueur]);
                    $from = $query->fetch();

                    $query = $pdo->prepare("SELECT no_club, nom_club FROM clubs WHERE no_club IN (SELECT no_club_arrivee FROM transferts WHERE no_joueur = :no_joueur)");
                    $query->execute(['no_joueur' => $no_joueur]);
                    $to = $query->fetch();

                    $date = new DateTime($transfert['date_transfert']);
                    $date_fr = $date->format("d/m/Y");

                    if($transfert['montant'] === null) {
                        $montant = "Transfert libre";
                    }
                    else {
                        $montant = $transfert['montant'] . " €";
                    }

                    echo "\t<tr>\n";
                    echo "\t\t<td>" . $date_fr . "</td>\n";
                    echo "\t\t<td><a href=\"clubs.php?no_club={$from['no_club']}\">" . $from['nom_club'] . "</a></td>\n";
                    echo "\t\t<td><a href=\"clubs.php?no_club={$to['no_club']}\">" . $to['nom_club'] . "</a></td>\n";
                    echo "\t\t<td>" . $montant . "</td>\n";
                    echo "\t</tr>\n";
                }
                echo "\t</tbody>\n";
                echo "\t</table>\n";
            } else {
                echo "\t<p>Pas de transferts effectués</p>\n";
            }           
            echo "\t\t</div>\n";
            echo "\t\t<div id=\"tabs-4\">\n";
            if(!empty($blessures)) {
                echo "\t\t<table class=\"table table-sm table-striped\">
                <thead> 
                    <tr>
                        <th scope=\"col\">Blessure</th>
                        <th scope=\"col\">De</th>
                        <th scope=\"col\">Jusqu'à</th>
                        <th scope=\"col\">Jours</th>
                    </tr>
                </thead>";
                echo "\t<tbody>\n";
                foreach($blessures as $blessure) {
                    $date_debut = new DateTime($blessure['date_debut_blessure']);
                    $date_debut_fr = $date_debut->format("d/m/Y");

                    if($blessure['date_fin_blessure'] != null) {
                        $date_fin = new DateTime($blessure['date_fin_blessure']);
                        $date_fin_fr = $date_fin->format("d/m/Y");
                        $days = $date_debut->diff($date_fin)->format("%a");
                    } else {
                        $date_fin_fr = "Encore blessé actuellement";
                        $days = '';
                    }

                    echo "\t<tr>\n";
                    echo "\t\t<td>" . $blessure['nom_blessure'] . "</td>\n";
                    echo "\t\t<td>" . $date_debut_fr . "</td>\n";
                    echo "\t\t<td>" . $date_fin_fr . "</td>\n";
                    echo "\t\t<td>" . $days . "</td>\n";
                    echo "\t</tr>\n";
                }
                echo "\t</tbody>\n";
                echo "\t</table>\n";
                if(isset($_SESSION['auth'])) {
                    echo "\t<a href=\"addblessure.php?no_joueur={$joueur->getNo_joueur()}\" class=\"add_button\">+</a>\n";
                } else {
                    echo "\t<a href=\"login.php\" class=\"add_button\">+</a>\n";
                }
                
            } else {
                echo "\t<p>Pas de blessures</p>\n";
                if(isset($_SESSION['auth'])) {
                    echo "\t<a href=\"addblessure.php?no_joueur={$joueur->getNo_joueur()}\" class=\"add_button\">+</a>\n";
                } else {
                    echo "\t<a href=\"login.php\" class=\"add_button\">+</a>\n";
                }
            }
            echo "\t\t</div>\n";
            echo "\t</div>\n";
        echo "\t</div>\n";
    } else if(isset($_COOKIE['No_joueur']) && $iconesTable->exists('no_joueur_icone', $joueur->getNo_joueur())) {
        $tz  = new DateTimeZone('Europe/Paris');
        $date = new DateTime($joueur->getDate_naissance());
        $age = DateTime::createFromFormat('Y-m-d', $joueur->getDate_naissance(), $tz)->diff(new DateTime('now', $tz))->y;
        echo "<div class=\"joueur-info\">\n";
        echo "<h2 class='icon-title'><b>Icône</b></h2>";
        echo "\t\t<h2>" . $joueur->getPrenom() . " <b>" . $joueur->getNom() . "</b> <span class='club-name'>(Icône du <a href=\"clubs.php?no_club={$joueur->getNo_club()}\">". $joueur->getNom_club() . "</a>)</span></h2>\n";
        echo "\t\t<div class='info'>\n";
        echo "\t\t<ul>\n";
        if($icone->getDecede() === true) {
            $naiss = new DateTime($joueur->getDate_naissance());
            $deces = new DateTime($icone->getDate_deces());
            $age_deces = $naiss->diff($deces)->y;
            echo "\t\t\t<li>Date de naissance : <b>" . $date->format('d/m/Y') . "</b></li>\n";
            echo "\t\t\t<li>Date du décès : <b>" . $deces->format("d/m/Y") . "</b> (" . $age_deces . " ans)</li>\n";
        } else {
            echo "\t\t\t<li>Date de naissance/âge : <b>" .$date->format('d/m/Y'). " (". $age . ")". "</b></li>\n";
        }
        echo "\t\t\t<li>Nationalité : <b>" . $joueur->getNationalite() . "</b></li>\n";
        echo "\t\t\t<li>Taille : <b>" . $joueur->getTaille() . " cm</b></li>\n";
        echo "\t\t\t<li>Surnom : <b>" . $joueur->getSurnom() . "</b></li>\n";
        echo "\t\t</ul>\n";
        echo "\t\t</div>\n";           
        echo "\t</div>\n";
        echo "\t<div class=\"container contain\">\n";
        echo "\t\t<div id=\"tabs\">
            <ul>
                <li><a href=\"#tabs-1\">Informations</a></li>
            </ul>
            <div id=\"tabs-1\">\n";
        echo "<ul class='icon list-group list-group-flush'>\n";
        echo "<li class='list-group-item'>Ancien poste : " . $joueur->getPoste() . "</li>\n";
        echo "<li class='list-group-item'>Ancien numéro : " . $joueur->getNumero() . "</li>\n";
        echo "<li class='list-group-item'>Ancienne équipe nationale : <a href=\"nationales.php?no_equipe={$joueur->getNo_equipe()}\">" . $joueur->getPays_equipe() . "</a></li>\n";
        echo "<li class='list-group-item'>Pied : " . $joueur->getPied_fort() . "</li>\n";
        $debut = new DateTime($icone->getDebut_carriere());
        $fin = new DateTime($icone->getFin_carriere());
        $years = $debut->diff($fin)->y;
        echo "<li class='list-group-item'>Début de carrière : " . $debut->format("d/m/Y") . "</li>\n";
        echo "<li class='list-group-item'>Fin de carrière : " . $fin->format("d/m/Y") . "</li>\n";
        echo "<li class='list-group-item'>Durée de la carrière : " . $years . " ans</li>";
        if(!empty($icone->getProfession_actuelle())) {
            echo "<li class='list-group-item'>Profession actuelle : " . $icone->getProfession_actuelle() . "</li>\n";
        }
        echo "<li class='list-group-item'>Moment mémorable : " . $icone->getMoment_memorable() . "</li>\n";
        echo "</ul>\n";
        echo "\t</div>\n";
        echo "\t</div>\n";
        echo "\t</div>\n";
    }
    ?>

<?php 
require_once "./include/footer.inc.php";
?>