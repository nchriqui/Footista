<?php
namespace Foot;

use Foot\Table\Table;
use PDO;

final class BlessuresTable extends Table {

    protected $table = "blessures";
    protected $class = Blessures::class;

    public function createBlessure(Blessures $blessure)
    {
        $id = $this->create([
            'nom_blessure' => $blessure->getNom_blessure(),
            'date_debut_blessure' => $blessure->getDate_debut_blessure(),
            'date_fin_blessure' => $blessure->getDate_fin_blessure(),
            'no_joueur' => $blessure->getNo_joueur()
        ]);
        $blessure->setNo_blessure($id);
    }
}
?>