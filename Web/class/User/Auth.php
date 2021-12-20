<?php
namespace Foot\User;

use PDO;
use Foot\User\User;
use Foot\User\Exception\ForbiddenException;

class Auth {

    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function user() 
    {
        $id = $_SESSION['auth'] ?? null;
        if($id === null) {
            return null;
        }
        $query = $this->pdo->prepare('SELECT * FROM utilisateurs WHERE id = ?');
        $query->execute([$id]);
        $query->setFetchMode(PDO::FETCH_CLASS, User::class);
        $user = $query->fetch();
        return $user ?: null;
    }
    
    public static function check() {
        if(session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if(!isset($_SESSION['auth'])) {
            throw new ForbiddenException();
        }
    }
}
?>