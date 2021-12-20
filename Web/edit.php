<?php

use Foot\Connection;
use Foot\JoueursTable;
use Foot\StatsTable;
use Foot\Table\Exception\NotFoundException;
use Foot\User\Auth;
use Foot\User\Exception\ForbiddenException;

require_once "vendor/autoload.php";

$pdo = Connection::getPDO();
$auth = new Auth($pdo);

try {
   $auth->check();
} catch (ForbiddenException $e) {
   header('Location: login.php?forbid=1');
   exit();
}

$stats = new StatsTable($pdo);
$joueurs = new JoueursTable($pdo);
if(!isset($_GET['no_saison']) && !isset($_GET['no_joueur'])) {
    header('Location: 404.php');
    exit();
}

try {
    $stat = $stats->findWith2PK($_GET['no_saison'] ?? null, $_GET['no_joueur'] ?? null, 'no_saison', 'no_joueur');
    $joueur = $joueurs->find($_GET['no_joueur'] ?? null, 'no_joueur');
} catch (NotFoundException $e) {
    header('Location: 404.php');
    exit();
} catch (\Error $e) {
    header('Location: 404.php');
    exit();
}

$saison = $stat->getNo_saison();
$query = $pdo->prepare("SELECT date_debut,date_fin FROM saisons WHERE no_saison = :saison");
$query->execute(['saison' => $saison]);
$date = $query->fetch();

$debut = explode("-", $date['date_debut']);
$fin = explode("-", $date['date_fin']);

$data = [
    'buts' => $stat->getButs(),
    'decisives' => $stat->getPasses_decisives(),
    'jaunes' => $stat->getCartons_jaunes(),
    'rouges' => $stat->getCartons_rouges(),
    'matchs' => $stat->getNb_matchs()
];

$errors = [];
if(!empty($_POST)) {
    $data = $_POST;
    $stat->setButs($data['buts']);
    $stat->setPasses_decisives($data['decisives']);
    $stat->setCartons_rouges($data['jaunes']);
    $stat->setCartons_rouges($data['rouges']);
    $stat->setNb_matchs($data['matchs']);
    $stats->updateStat($stat);
    header('Location: joueurs.php?success=1');
    exit();
}

require_once "./include/header.inc.php";
?>
    <div class="container">
        <?php echo "<div class='h2'>Editer les statistiques de <small><b>". htmlspecialchars($joueur->getPrenom()) . " " . htmlspecialchars($joueur->getNom()) . "</b> (<i>saison: " . $debut[0] . "/" . $fin[0] . "</i>)" . "</small></div>\n"; ?>
        <form action="#" method="POST" class="form">
            <div class="row">
                <div class="col-sm-3">
                    <div class="form-group">
                        <label for="matchs">Nombre de matchs joués</label>
                        <input id="matchs" type="number" required="required" class="form-control" name="matchs" value="<?php if (isset($data['matchs'])) { echo htmlspecialchars($data['matchs']); } ?>"/>
                    </div>
                </div>
                <div class="col-sm-3">                                
                    <div class="form-group">
                        <label for="buts">Nombre de buts marqués</label>
                        <input id="buts" type="number" required="required" class="form-control" name="buts" value="<?php if (isset($data['buts'])) { echo htmlspecialchars($data['buts']); } ?>"/>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <label for="decisives">Passes décisives</label>
                        <input id="decisives" type="number" required="required" class="form-control" name="decisives" value="<?php if (isset($data['decisives'])) { echo htmlspecialchars($data['decisives']); } ?>"/>
                    </div>                                        
                </div>
            </div>
            <div class="row">
                <div class="col-sm-2">                                
                    <div class="form-group">
                        <label for="jaunes">Cartons jaunes</label>
                        <input id="jaunes" type="number" required="required" class="form-control" name="jaunes" value="<?php if (isset($data['jaunes'])) { echo htmlspecialchars($data['jaunes']); } ?>"/>
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="form-group">
                        <label for="rouges">Cartons rouges</label>
                        <input id="rouge" type="number" required="required" class="form-control" name="rouges" value="<?php if (isset($data['rouges'])) { echo htmlspecialchars($data['rouges']); } ?>"/>
                    </div>                                        
                </div>
            </div>
            <div class="form-group">
                <button type="submit" class="button-9">Modifier les statistiques</button>
            </div>
        </form>
    </div>
<?php
require_once "./include/footer.inc.php";
?>