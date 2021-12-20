<?php
namespace Foot;

use Foot\Table\Exception\NotFoundException;
use Foot\Table\Table;
use PDO;

final class IconesTable extends Table {

    protected $table = "icones";
    protected $class = Icones::class;

    public function getNoByJoueurName(string $nom) 
    {
        $query = $this->pdo->prepare('SELECT no_joueur FROM ' . $this->table . ' WHERE nom = :nom');
        $query->execute(['nom' => $nom]);
        $query->setFetchMode(PDO::FETCH_CLASS, $this->class);
        $result = $query->fetch();
        if($result === false) {
            throw new NotFoundException($this->table, $nom);
        }
        return (int)$result->getNo_joueur();
    }
}
?>