<?php

namespace App\Profiles\Repository;

use App\Utils\Model;

class ProfileRepository extends Model
{
    protected $table = "users";

    function findWithRelationRepository (int|string $id, string $relationTable, string $foreignKey) {
        return $this->findWithRelation($id, $relationTable, $foreignKey);
    }
}