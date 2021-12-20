<?php
namespace Foot;

use Foot\Table\Exception\NotFoundException;
use Foot\Table\Table;
use PDO;

final class JoueursTable extends Table {

    protected $table = "joueurs";
    protected $class = Joueurs::class;

    public function getNoByJoueurandName(string $nom, string $prenom) 
    {
        $query = $this->pdo->prepare('SELECT no_joueur FROM ' . $this->table . ' WHERE nom = :nom AND prenom = :prenom');
        $query->execute(['nom' => $nom, 'prenom' => $prenom]);
        $query->setFetchMode(PDO::FETCH_CLASS, $this->class);
        $result = $query->fetch();
        if($result === false) {
            throw new NotFoundException($this->table, $nom);
        }
        return (int)$result->getNo_joueur();
    }

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

    public function getJoueurNameByNo(int $no)
    {
        $query = $this->pdo->prepare('SELECT nom, prenom FROM ' . $this->table . ' WHERE no_joueur = :no_joueur');
        $query->execute(['no_joueur' => $no]);
        $query->setFetchMode(PDO::FETCH_CLASS, $this->class);
        $result = $query->fetch();
        if($result === false) {
            throw new NotFoundException($this->table, $no);
        }
        return $result->getPrenom() . " " . $result->getNom();
    }
}
?>