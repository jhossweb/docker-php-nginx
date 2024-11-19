<?php

namespace App\Users\Repository;

use App\Utils\Model;
use App\Utils\Repository;

class UserRepository extends Model implements Repository
{
    protected $table = "users";

    function findRepository () {
        return $this->find();
    }

    function findByRepository(int|string|array $id)
    {
        return $this->findBy($id);
    }

    function findByUsernameRepository(string $username)
    {
        return $this->findByUsername($username);
    }

    function findWithRelationRepository (int|string $id, string $relationTable, string $foreignKey) {
        return $this->findWithRelation($id, $relationTable, $foreignKey);
    }

    function createRepository(array $data) {
        
        $data["pass"] = password_hash($data["pass"], PASSWORD_DEFAULT);
        $user = $this->create($data);
        //$user = $this->createWithRelation($data, ["biography" => "hola mundo"], 'profile', 'user_id');
        return $user;
    }

    function updateRepository ($id, $data) {
        return $this->update($id, $data);
    }

    function deleteRepository(string|int $id) {
        return $this->delete($id);
    }     
}