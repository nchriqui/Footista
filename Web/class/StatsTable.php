<?php
namespace Foot;

use Foot\Table\Exception\NotFoundException;
use Foot\Table\Table;
use PDO;

final class StatsTable extends Table {

    protected $table = "statistiques";
    protected $class = Statistiques::class;

    public function createStat(Statistiques $stat)
    {
        $id = $this->create([
            'buts' => $stat->getButs(),
            'passes_decisives' => $stat->getPasses_decisives(),
            'cartons_jaunes' => $stat->getCartons_jaunes(),
            'cartons_rouges' => $stat->getCartons_rouges(),
            'nb_matchs' => $stat->getNb_matchs()
        ]);
    }

    public function updateStat(Statistiques $stat)
    {
        $this->updateWith2PK([
            'buts' => $stat->getButs(),
            'passes_decisives' => $stat->getPasses_decisives(),
            'cartons_jaunes' => $stat->getCartons_jaunes(),
            'cartons_rouges' => $stat->getCartons_rouges(),
            'nb_matchs' => $stat->getNb_matchs()
        ], $stat->getNo_saison(), $stat->getNo_joueur(), 'no_saison', 'no_joueur');
    }
}
?>