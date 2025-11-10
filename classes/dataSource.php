<?php

namespace Dsource;

require_once __DIR__  . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR . 'dataConnectionBase.php';

use DataConnectBase\ConectionBase;

use PDO;

class DataSource extends ConectionBase
{

    public function bindExecuteAll($sql, $paramArray = array())
    {
        $conn = $this->getConnection();
        $result = $conn->prepare($sql);

        if ($paramArray) {
            foreach ($paramArray as $key => $val) {
                $type = (is_numeric($val) ? \PDO::PARAM_INT : \PDO::PARAM_STR);
                $result->bindValue($key + 1, $val, $type);
            }
        }

        $result->execute();
        return $result;
    }

    public function bindExecuteLastId($sql, $paramArray = array())
    {
        $conn = $this->getConnection();
        $result = $conn->prepare($sql);

        if ($paramArray) {
            foreach ($paramArray as $key => $val) {
                $type = (is_numeric($val) ? \PDO::PARAM_INT : \PDO::PARAM_STR);
                $result->bindValue($key + 1, $val, $type);
            }
        }

        $result->execute();
        $last_id = $conn->lastInsertId();
        return $last_id;
    }

    public function select($query, $paramArray = array())
    {
        $result = $this->bindExecuteAll($query, $paramArray);
        $row = $result->fetch(PDO::FETCH_ASSOC);
        return $row;
    }

    public function selectArray($query, $paramArray = array()) //echo $result[0]["name"];
    {
        $result = $this->bindExecuteAll($query, $paramArray);

        if ($result->rowCount() > 0) {
            $resultset = null;
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                $resultset[] = $row;
            }
            return $resultset;
        }
    }


    public function selectCount($query, $paramArray = array())
    {
        $result = $this->bindExecuteAll($query, $paramArray);
        // fetchAll() é mais direto e eficiente do que um loop while para obter todos os resultados.
        // Ele já retorna um array vazio se não houver linhas, o que simplifica o código que chama a função.
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

    public function selectFetchAll($query, $paramArray = array())
    {
        $result = $this->bindExecuteAll($query, $paramArray);
        return $result;
    }

    public function insert($query, $paramArray)
    {
        $result = $this->bindExecuteAll($query, $paramArray);
        $row_count = $result->rowCount();
        return $row_count;
    }

    public function insertLastID($query, $paramArray)
    {
        $result = $this->bindExecuteLastId($query, $paramArray);
        return $result;
    }

    public function update($query, $paramArray)
    {
        $result = $this->bindExecuteAll($query, $paramArray);
        $row_count = $result->rowCount();
        return $row_count;
    }

    public function delete($query, $paramArray)
    {
        $result = $this->bindExecuteAll($query, $paramArray);
        $row_count = $result->rowCount();
        return $row_count;
    }

    public function getRecordCount($query, $paramArray = array())
    {
        $result = $this->bindExecuteAll($query, $paramArray);
        // $result->execute();
        $row_count = $result->rowCount();
        return $row_count;
    }
}
