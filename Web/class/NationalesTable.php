<?php
namespace Foot;

use Foot\Table\Exception\NotFoundException;
use Foot\Table\Table;
use PDO;

final class NationalesTable extends Table {

    protected $table = "equipes_nationales";
    protected $class = Nationales::class;

    public function getNoByNationalesCountry(string $paysNation) 
    {
        $query = $this->pdo->prepare('SELECT no_equipe FROM ' . $this->table . ' WHERE pays_equipe = :pays_equipe');
        $query->execute(['pays_equipe' => $paysNation]);
        $query->setFetchMode(PDO::FETCH_CLASS, $this->class);
        $result = $query->fetch();
        if($result === false) {
            throw new NotFoundException($this->table, $paysNation);
        }
        return (int)$result->getNo_equipe();
    }

    public function getNationalesCountryByNo(int $no) 
    {
        $query = $this->pdo->prepare('SELECT pays_equipe FROM ' . $this->table . ' WHERE no_equipe = :no_equipe');
        $query->execute(['no_equipe' => $no]);
        $query->setFetchMode(PDO::FETCH_CLASS, $this->class);
        $result = $query->fetch();
        if($result === false) {
            throw new NotFoundException($this->table, $no);
        }
        return $result->getPays_equipe();
    }
}
?>