<?php

namespace DataConnectBase;

use PDO;
use PDOException;


$connlista = array(
    '127.0.0.1',
    '::1'
);

if (!in_array($_SERVER['REMOTE_ADDR'], $connlista)) {

    /** O nome do banco de dados */
    define('DB_NAME', 'assistaconectaco_eventos');
    /** nome de usuário do banco de dados */
    define('DB_USER', 'assistaconectaco_eventos2');
    /** Senha do banco de dados */
    define('DB_PASSWORD', '05649Ass@eventos');
    /** nome de host */
    define('DB_HOST', 'localhost');

} else {
    /** O nome do banco de dados */
    define('DB_NAME', 'test');
    /** nome de usuário do banco de dados */
    define('DB_USER', 'root');
    /** Senha do banco de dados */
    define('DB_PASSWORD', '');
    /** nome de host */
    define('DB_HOST', 'localhost');
}

class ConectionBase
{
    private $opciones = array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');
    protected $conn;

    public function __construct()
    {

        try {
            $this->conn = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . '', DB_USER, DB_PASSWORD, $this->opciones);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $this->conn;
        } catch (PDOException $e) {
            echo '<p>' . $e->getMessage() . '</p>';
        }
    }

    public function getConnection()
    {
        return $this->conn;
    }

    public function closeConection()
    {
        return $this->conn = null;
    }
}
