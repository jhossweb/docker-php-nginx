<?php

namespace App\Users\Repository;

use App\Config\BaseConexion;
use App\Utils\Repository;

class UserRepository implements Repository
{
    private $db;

    function __construct()
    {
        $this->db = BaseConexion::getInstace()->getConexion();    
    }

    function create(array $data)
    {
        var_dump($data);
    }
}