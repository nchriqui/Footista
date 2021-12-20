<?php

use Foot\Blessures;
use Foot\BlessuresTable;
use Foot\Connection;
use Foot\JoueursTable;
use Foot\Table\Exception\NotFoundException;
use Foot\User\Auth;
use Foot\User\Exception\ForbiddenException;
use Foot\Validator;

require_once "vendor/autoload.php";

$pdo = Connection::getPDO();
$auth = new Auth($pdo);

try {
   $auth->check();
} catch (ForbiddenException $e) {
   header('Location: login.php?forbid=1');
   exit();
}

$joueurs = new JoueursTable($pdo);
if(!isset($_GET['no_joueur'])) {
    header('Location: 404.php');
    exit();
}

$no_joueur = htmlspecialchars($_GET['no_joueur']);

try {
    $joueur = $joueurs->find($_GET['no_joueur'] ?? null, 'no_joueur');
} catch (NotFoundException $e) {
    header('Location: 404.php');
    exit();
}

$data = [
    'start' => date('Y-m-d')
];

$validator = new Validator($data);
if(!$validator->validate('start', 'date')) {
    $data['start'] = date('Y-m-d');
}

if(!empty($_POST)) {
    $data = $_POST;
    $blessure = new Blessures();
    $blessure->setNom_blessure($data['name']);
    $blessure->setDate_debut_blessure($data['start']);
    if(!empty($_POST['end'])) {
        $blessure->setDate_fin_blessure($data['end']);
    }
    $blessure->setNo_joueur($no_joueur);
    $blessures = new BlessuresTable($pdo);
    $blessures->createBlessure($blessure);
    header('Location: joueurs.php?success=1');
    exit();
}

require_once "./include/header.inc.php";
?>


    <div class="container">
        <?php echo "<div class='h2'>Ajouter une blessure à <small><b>". htmlspecialchars($joueur->getPrenom()) . " " . htmlspecialchars($joueur->getNom()) . "</b></small></div>\n"; ?>
        <form action="#" method="POST" class="form">
            <div class="row">
                <div class="col-sm-2">
                    <div class="form-group">
                        <label for="name">Nom de la blessure</label>
                        <input id="name" type="text" required="required" class="form-control" name="name" value="<?php if (isset($data['name'])) { echo htmlspecialchars($data['name']); } ?>"/>
                    </div>                
                </div>
            </div>
            <div class="row">
                <div class="col-sm-3">
                    <div class="form-group">
                        <label for="start">Date de la blessure</label>
                        <input id="start" type="date" required="required" class="form-control" name="start" value="<?php if (isset($data['start'])) { echo htmlspecialchars($data['start']); } ?>"/>
                    </div>
                </div>
                <div class="col-sm-3">                                
                    <div class="form-group">
                        <label for="end">Date de fin de blessure</label>
                        <input id="end" type="date" class="form-control" name="end" value="<?php if (isset($data['end'])) { echo htmlspecialchars($data['end']); } ?>"/>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <button type="submit" class="button-9">Ajouter la blessure</button>
            </div>
        </form>
    </div>
    
<?php
require_once "./include/footer.inc.php";
?>