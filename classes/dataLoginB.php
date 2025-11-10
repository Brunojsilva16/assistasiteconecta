<?php

namespace LoginstatusBase;

require_once __DIR__ . DIRECTORY_SEPARATOR . '.' . DIRECTORY_SEPARATOR . 'dataConnectionBase.php';

use DataConnectBase\ConectionBase;

use PDO;

class LoginB extends ConectionBase
{
    public function bindExecuteLgAll($sql, $paramArray = array())
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

    public function select($query, $paramArray = array())
    {
        $result = $this->bindExecuteLgAll($query, $paramArray);
        $row = $result->fetch(PDO::FETCH_ASSOC);
        return $row;
    }

    public function selectFetchAll($query, $paramArray = array())
    {
        $result = $this->bindExecuteLgAll($query, $paramArray);
        return $result;
    }

    public function selectExists($query, $paramArray = array()) //echo $result[0]["name"];
    {
        $result = $this->bindExecuteLgAll($query, $paramArray);

        if ($result->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    // public function isUsernameExists($username)
    // {
    //     $query = 'SELECT * FROM usuarios_a where email = ?';
    //     $paramValue = array(
    //         $username
    //     );
    //     $count = $this->selectExists($query, $paramValue);
    //     return $count;
    // }

    public function getMember($username, $query)
    {
        $paramValue = array(
            $username
        );
        $result = $this->select($query, $paramValue);
        // $result = $result[0]["email"]; //inArray
        return $result;
    }

    public function authenticateMember($mail, $senha, $query)
    {
        $memberRecord = $this->getMember($mail, $query);
        $output = array('result' => false);

        if (!empty($memberRecord)) {
            if (password_verify($senha, $memberRecord["senha"])) {
                if (session_status() !== PHP_SESSION_ACTIVE) {
                    session_start();
                }
                $_SESSION['logado'] = true;
                $_SESSION["userid"] = $memberRecord["id_user"];
                $_SESSION["username"] = $memberRecord["nome"];
                $_SESSION['nivel_accesso'] = $memberRecord["user_tipo"];
                $output['result'] = true;
                $output['mensagem'] = "";
                return $output;
                die();
            } else {
                $output['mensagem'] = "Senha inválida!";
                return $output;
                die();
            }
        } else {
            $output['mensagem'] = 'Email não encontrado ou inválido!';
            return $output;
            die();
        }
    }

    public function isLoggedIn()
    {
        return isset($_SESSION['logado']) && $_SESSION['logado'] === true;
    }

    public function getUserData()
    {
        if ($this->isLoggedIn()) {
            return [
                'id' => $_SESSION['userid'],
                'nome' => $_SESSION['username']
            ];
        }
        return null;
    }

    // public function logout()
    // {
    //     session_unset();
    //     session_destroy();
    // }
}
