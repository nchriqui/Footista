<?php
namespace Foot;

require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'FootConf.conf.php';

use \PDO;

class Connection {

    public static function getPDO() : PDO 
    {
        /*return new PDO('pgsql:dbname=dbfoot;host=localhost', 'etu', 'A123456*', [
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);*/

        return new PDO('pgsql:dbname='.FootConf::$pdoDB.';host='.FootConf::$pdoHost.'', FootConf::$pdoUser, FootConf::$pdoPassword, [
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);
    }
}
?>