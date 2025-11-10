<?php

namespace Dsource;

// Assume que este arquivo e newDataConnection.php estão no mesmo diretório de classes.
require_once __DIR__ . DIRECTORY_SEPARATOR . 'NewDataConnection.php';

use NewDataConnect\NewConection;
use PDO;
use PDOException;

/**
 * DataSource estende a classe NewConection para herdar a conexão com o banco de dados
 * e fornecer métodos de alto nível para manipulação de dados (CRUD).
 */
class DataSource extends NewConection
{

    /**
     * Seleciona uma única linha da tabela.
     * @param string $query A instrução SQL.
     * @param array $paramArray Parâmetros para a consulta preparada.
     * @return mixed Retorna um array associativo para o registro ou false se não encontrar.
     */
    public function select($query, $paramArray = [])
    {
        $stmt = $this->conn->prepare($query);
        $stmt->execute($paramArray);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Seleciona múltiplos registros da tabela.
     * @param string $query A instrução SQL.
     * @param array $paramArray Parâmetros para a consulta preparada.
     * @return array Retorna um array de arrays associativos.
     */
    public function selectAll($query, $paramArray = [])
    {
        $stmt = $this->conn->prepare($query);
        $stmt->execute($paramArray);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

   /**
     * Seleciona múltiplos registros do banco de dados usando uma consulta preparada.
     *
     * @param string $query A string da consulta SQL com placeholders.
     * @param array $params Um array associativo de parâmetros para a consulta.
     * @return array Retorna um array com os resultados da consulta.
     */
    public function selectQuiz($query, $params = [])
    {
        try {
            $stmt = $this->conn->prepare($query);

            // Vincula os parâmetros dinamicamente
            foreach ($params as $key => $value) {
                // O parâmetro LIMIT precisa ser tratado como inteiro
                if ($key === ':qtd') {
                    $stmt->bindValue($key, (int)$value, PDO::PARAM_INT);
                } else {
                    $stmt->bindValue($key, $value);
                }
            }

            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // Em um ambiente de produção, é melhor logar o erro
            // do que exibi-lo na tela.
            error_log('Erro na consulta: ' . $e->getMessage());
            return []; // Retorna um array vazio em caso de erro
        }
    }

    /**
     * Executa uma instrução de inserção.
     * @param string $query A instrução SQL INSERT.
     * @param array $paramArray Parâmetros para a consulta preparada.
     * @return int O número de linhas afetadas.
     */
    public function insert($query, $paramArray)
    {
        $stmt = $this->conn->prepare($query);
        $stmt->execute($paramArray);
        return $stmt->rowCount();
    }

    /**
     * Executa uma instrução de inserção e retorna o último ID inserido.
     * @param string $query A instrução SQL INSERT.
     * @param array $paramArray Parâmetros para a consulta preparada.
     * @return string O ID do último registro inserido.
     */
    public function insertLastID($query, $paramArray)
    {
        $stmt = $this->conn->prepare($query);
        $stmt->execute($paramArray);
        return $this->conn->lastInsertId();
    }

    /**
     * Executa uma instrução de atualização.
     * @param string $query A instrução SQL UPDATE.
     * @param array $paramArray Parâmetros para a consulta preparada.
     * @return int O número de linhas afetadas.
     */
    public function update($query, $paramArray = [])
    {
        $stmt = $this->conn->prepare($query);
        $stmt->execute($paramArray);
        return $stmt->rowCount();
    }

    /**
     * Executa uma instrução de exclusão.
     * @param string $query A instrução SQL DELETE.
     * @param array $paramArray Parâmetros para a consulta preparada.
     * @return int O número de linhas afetadas.
     */
    public function delete($query, $paramArray)
    {
        $stmt = $this->conn->prepare($query);
        $stmt->execute($paramArray);
        return $stmt->rowCount();
    }
}
