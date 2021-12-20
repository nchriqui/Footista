<?php
namespace Foot\User;

use PDO;
use Foot\Table\Exception\NotFoundException;
use Foot\Table\Table;
use Foot\User\User;

final class UserTable extends Table {

    protected $table = "utilisateurs";
    protected $class = User::class;

    public function findbyUsername(string $username) 
    {
        $query = $this->pdo->prepare('SELECT * FROM ' . $this->table . ' WHERE username = :username');
        $query->execute(['username' => $username]);
        $query->setFetchMode(PDO::FETCH_CLASS, $this->class);
        $result = $query->fetch();
        if($result === false) {
            throw new NotFoundException($this->table, $username);
        }
        return $result;
    }

    public function findbyMail(string $mail) 
    {
        $query = $this->pdo->prepare('SELECT * FROM ' . $this->table . ' WHERE mail = :mail');
        $query->execute(['mail' => $mail]);
        $query->setFetchMode(PDO::FETCH_CLASS, $this->class);
        $result = $query->fetch();
        if($result === false) {
            throw new NotFoundException($this->table, $mail);
        }
        return $result;
    }

    public function createUser(User $user)
    {
        $id = $this->create([
            'username' => $user->getUsername(),
            'mail' => $user->getMail(),
            'password' => $user->getPassword(),
            'inscription_date' => $user->getInscription_date()->format('Y-m-d H:i:s'),
            'code' => $user->getCode()
        ]);
        $user->setId($id);
    }

    public function updateUser(User $user)
    {
        $this->update([
            'username' => $user->getUsername(),
            'mail' => $user->getMail(),
            'password' => $user->getPassword(),
            'inscription_date' => $user->getInscription_date()->format('Y-m-d H:i:s'),
            'code' => $user->getCode(),
            'activate' => $user->getActivate(),
            'recuperation' => $user->getRecuperation(),
        ], $user->getId());
    }
}
?>