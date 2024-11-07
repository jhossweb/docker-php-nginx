<?php

namespace App\Config;

use PDO;

class BaseConexion
{
    private static $instance = null;
    private $dns, $conexion, $host, $username, $password, $dbname, $port;

    function __construct()
    {
        $this->host = "localhost";
        $this->username = "jhossweb";
        $this->password = "secret";
        $this->port = 5432;
        $this->dbname = "dbpruebas";
        
        $this->dns = "pgsql:host=$this->host;dbname=$this->dbname";

        try {
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ];
            $this->conexion = new PDO($this->dns, $this->username, $this->password, $options);
        } catch(\Exception $e) {
            die ("Error de conexión. " . $e->getMessage());
        }
    }

    static function getInstace() {
        if(!self::$instance){
            self::$instance = new BaseConexion;
        }

        return self::$instance;
    }

    function getConexion(): PDO{
        return $this->conexion;
    }
}