<?php

namespace App\Config;

use PDO;

class BaseConexion
{
    private static $instance = null;
    private $dns, $conexion, $host, $username, $password, $dbname, $port;

    function __construct()
    {
        $this->host = constant('DB_HOST');
        $this->username = constant('DB_USER');
        $this->password = constant('DB_PASS');
        $this->port = constant('DB_PORT');
        $this->dbname = constant('DB_DBNAME');
        
        $this->dns = "pgsql:host=$this->host;dbname=$this->dbname";

        try {
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ];
            $this->conexion = new PDO($this->dns, $this->username, $this->password, $options);
            echo "conexión correcta";
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