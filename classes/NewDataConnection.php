<?php

namespace NewDataConnect;

use PDO;
use PDOException;


   /** O nome do banco de dados */
    define('DB_NAMEN', 'assistaconectaco_eventos');
    /** nome de usuário do banco de dados */
    define('DB_USERN', 'assistaconectaco_eventos2');
    /** Senha do banco de dados */
    define('DB_PASSWORDN', '05649Ass@eventos');
    /** nome de host */
    define('DB_HOSTN', 'localhost');


class NewConection
{
    private $opciones = array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');
    protected $conn;

    public function __construct()
    {
        try {
            $this->conn = new PDO('mysql:host=' . DB_HOSTN . ';dbname=' . DB_NAMEN . '', DB_USERN, DB_PASSWORDN, $this->opciones);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $this->conn;
        } catch (PDOException $e) {
            echo '<p>' . $e->getMessage() . '</p>';
        }
    }

    /**
     * Executa uma consulta SELECT e retorna os resultados.
     * Para consultas simples sem parâmetros.
     */
    public function query($sql)
    {
        return $this->conn->query($sql);
    }

    /**
     * Prepara e executa uma declaração SQL (para UPDATE, INSERT, DELETE).
     * @param string $sql A declaração SQL para executar.
     * @param array $params Um array de parâmetros para vincular à declaração.
     * @return bool Retorna true em caso de sucesso ou false em caso de falha.
     */
    public function execute($sql, $params = [])
    {
        try {
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute($params);
        } catch (PDOException $e) {
            // Em um ambiente de produção, seria melhor logar este erro
            // em vez de exibi-lo diretamente.
            error_log('Erro de execução SQL: ' . $e->getMessage());
            return false;
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