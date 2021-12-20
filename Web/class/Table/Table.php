<?php
namespace Foot\Table;

use \PDO;
use Foot\Table\Exception\NotFoundException;

abstract class Table {

    protected $pdo;
    protected $table = null;
    protected $class = null;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function find (int $id, string $primaryName="id")
    {
        $query = $this->pdo->prepare("SELECT * FROM {$this->table} WHERE $primaryName = :id");
        $query->execute(['id' => $id]);
        $query->setFetchMode(PDO::FETCH_CLASS, $this->class);
        $result = $query->fetch();
        if($result === false) {
            throw new NotFoundException($this->table, $id);
        }
        return $result;
    }

    public function findWith2PK (int $id, int $id2, string $primaryName, string $primaryName2)
    {
        $query = $this->pdo->prepare("SELECT * FROM {$this->table} WHERE $primaryName = :id AND $primaryName2 = :id2");
        $query->execute(['id' => $id, 'id2' => $id2]);
        $query->setFetchMode(PDO::FETCH_CLASS, $this->class);
        $result = $query->fetch();
        if($result === false) {
            throw new NotFoundException($this->table, $id);
        }
        return $result;
    }

    public function exists (string $field, $value, ?int $except = null) : bool
    {
        $sql = "SELECT COUNT(*) FROM {$this->table} WHERE $field = ?";
        $params = [$value];
        if ($except !== null) {
            $sql .= " AND id != ?";
            $params[] = $except;
        }
        $query = $this->pdo->prepare($sql);
        $query->execute($params);
        return (int)$query->fetch(PDO::FETCH_NUM)[0] > 0;
    }

    public function all () : array 
    {
        $sql = "SELECT * FROM {$this->table}";
        return $this->pdo->query($sql, PDO::FETCH_CLASS, $this->class)->fetchAll();
    }

    public function delete (int $id, string $primaryName="id")
    {
        $query = $this->pdo->prepare("DELETE FROM {$this->table} WHERE $primaryName = ?");
        $ok = $query->execute([$id]);
        if ($ok === false) {
            throw new \Exception("Impossible de supprimer l'enregistrement #$id dans la table {$this->table}");
        }
    }
    
    public function create (array $data) : int
    {
        $sqlInsert = [];
        $sqlFields = [];
        foreach($data as $key => $value) {
            $sqlInsert[] = $key;
            $sqlFields[] = ":$key";
        }
        $fields = implode(', ', $sqlInsert);
        $preparedFields = implode(', ', $sqlFields);       

        //$query = $this->pdo->prepare("INSERT INTO {$this->table} ($fields) VALUES ($preparedFields)");
        $query = $this->pdo->prepare("INSERT INTO {$this->table} (" . implode(', ', $sqlInsert) . ") VALUES (" . implode(', ', $sqlFields) . ")");
        $ok = $query->execute($data);
        if ($ok === false) {
            throw new \Exception("Impossible de créer l'enregistrement dans la table {$this->table}");
        }
        return (int)$this->pdo->lastInsertId();
    }

    public function createWith2PK (array $data) : int
    {
        $sqlInsert = [];
        $sqlFields = [];
        foreach($data as $key => $value) {
            $sqlInsert[] = $key;
            $sqlFields[] = ":$key";
        }
        $fields = implode(', ', $sqlInsert);
        $preparedFields = implode(', ', $sqlFields);       

        //$query = $this->pdo->prepare("INSERT INTO {$this->table} ($fields) VALUES ($preparedFields)");
        $query = $this->pdo->prepare("INSERT INTO {$this->table} (" . implode(', ', $sqlInsert) . ") VALUES (" . implode(', ', $sqlFields) . ")");
        $ok = $query->execute($data);
        if ($ok === false) {
            throw new \Exception("Impossible de créer l'enregistrement dans la table {$this->table}");
        }
        return (int)$this->pdo->lastInsertId();
    }

    public function update (array $data, int $id, string $primaryName="id")
    {
        $sqlFields = [];
        foreach($data as $key => $value) {
            $sqlFields[] = "$key = :$key";
        }
        $query = $this->pdo->prepare("UPDATE {$this->table} SET " . implode(', ', $sqlFields) . " WHERE $primaryName = :id");
        $ok = $query->execute(array_merge($data, ['id' => $id]));
        if ($ok === false) {
            throw new \Exception("Impossible de modifier l'enregistrement dans la table {$this->table}");
        }
    }

    public function updateWith2PK (array $data, int $id, int $id2, string $primaryName, string $primaryName2)
    {
        $sqlFields = [];
        foreach($data as $key => $value) {
            $sqlFields[] = "$key = :$key";
        }
        $query = $this->pdo->prepare("UPDATE {$this->table} SET " . implode(', ', $sqlFields) . " WHERE $primaryName = :id AND $primaryName2 = :id2");
        $ok = $query->execute(array_merge($data, ['id' => $id, 'id2' => $id2]));
        if ($ok === false) {
            throw new \Exception("Impossible de modifier l'enregistrement dans la table {$this->table}");
        }
    }
}
?>