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

    function createRepository(array $data) {
        
        $data["pass"] = password_hash($data["pass"], PASSWORD_DEFAULT);

        $user = $this->create($data);
        return $user;
    }

    function updateRepository ($id, $data) {
        return $this->update($id, $data);
    }

    function deleteRepository(string|int $id) {
        return $this->delete($id);
    }
}