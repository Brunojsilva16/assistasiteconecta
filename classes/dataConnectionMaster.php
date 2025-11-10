<?php

namespace DataConnectMaster;

/**
 * Generic datasource class for handling DB operations.
 * Uses MySqli and PreparedStatements.
 *
 * @version 1.5
 */

use PDO;
use PDOException;


$connlista = array(
    '127.0.0.1',
    '::1'
);

if (!in_array($_SERVER['REMOTE_ADDR'], $connlista)) {

	/** O nome do banco de dados */
	define('DB_NAME_S', 'assistaconectaco_eventos');
	/** nome de usuário do banco de dados */
	define('DB_USER_S', 'assistaconectaco_eventos2');
	/** Senha do banco de dados */
	define('DB_PASSWORD_S', '05649Ass@eventos');
	/** nome de host */
	define('DB_HOST_S', 'localhost');
} else {
	/** O nome do banco de dados */
	define('DB_NAME_S', 'test');
	/** nome de usuário do banco de dados */
	define('DB_USER_S', 'root');
	/** Senha do banco de dados */
	define('DB_PASSWORD_S', '');
	/** nome de host */
	define('DB_HOST_S', 'localhost');	
}

class ConectionMaster
{
    private $opciones = array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');
    protected $conn;

    public function __construct()
    {
        try {
            $this->conn = new PDO('mysql:host=' . DB_HOST_S . ';dbname=' . DB_NAME_S . '', DB_USER_S, DB_PASSWORD_S, $this->opciones);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $this->conn;
        } catch (PDOException $e) {
            echo '<p>' . $e->getMessage() . '</p>';
        }
    }

    public function getConnection() {
        return $this->conn;
    }

    public function closeConection()
    {
        return $this->conn = null;
    }
}