<?php

namespace App\Profiles\Repository;

use App\Users\Repository\UserRepository;
use App\Utils\Model;

class ProfileRepository extends Model
{
    //protected $table = "profile";

    function __construct()
    {
        parent::__construct("profile");
    }

    function findOneRepository (int|string $id) {
        return $this->where("user_id", "=", $id)->first();
    }

    function updateProfileRepository(int|string $id, array $data) {
        return $this->update($id, $data, "user_id");
    }

    function createProfileRepository( int|string $id) {
        return $this->create(["user_id" => $id]);
    }

    function getProfileWhithUser(string $relationTable, string $foreingKey, int|string $id) {
        return $this->withRelation($relationTable, $foreingKey, $id);
    }
}