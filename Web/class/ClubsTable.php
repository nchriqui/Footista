<?php
namespace Foot;

use Foot\Table\Exception\NotFoundException;
use Foot\Table\Table;
use PDO;

final class ClubsTable extends Table {

    protected $table = "clubs";
    protected $class = Clubs::class;

    public function getNoByClubName(string $nomclub) 
    {
        $query = $this->pdo->prepare('SELECT no_club FROM ' . $this->table . ' WHERE nom_club = :nom_club');
        $query->execute(['nom_club' => $nomclub]);
        $query->setFetchMode(PDO::FETCH_CLASS, $this->class);
        $result = $query->fetch();
        if($result === false) {
            throw new NotFoundException($this->table, $nomclub);
        }
        return (int)$result->getNo_club();
    }

    public function getClubNameByNo(int $no) 
    {
        $query = $this->pdo->prepare('SELECT nom_club FROM ' . $this->table . ' WHERE no_club = :no_club');
        $query->execute(['no_club' => $no]);
        $query->setFetchMode(PDO::FETCH_CLASS, $this->class);
        $result = $query->fetch();
        if($result === false) {
            throw new NotFoundException($this->table, $no);
        }
        return $result->getNom_club();
    }
}
?>