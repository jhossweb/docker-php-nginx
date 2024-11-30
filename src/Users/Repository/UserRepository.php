<?php

namespace App\Users\Repository;

use App\Profiles\Repository\ProfileRepository;
use App\Utils\Model;
use App\Utils\Repository;

class UserRepository extends Model implements Repository
{
    //protected $table = "users";

    function __construct(private ProfileRepository $profileRepository = new ProfileRepository)
    {
        parent::__construct("users");
    }

    function findAll() {
        return $this->all();
    }

    function findByRepository(int|string|array $id)
    {
        return $this->findOne($id);
    }

    function findByUsernameRepository(string $username)
    {
        return $this->where('username', '=', $username)->first();
    }

    // function findWithRelationRepository (int|string $id, string $relationTable, string $foreignKey) {
    //     return $this->findWithRelation($id, $relationTable, $foreignKey);
    // }

     function createRepository(array $data) {
        
         $data["pass"] = password_hash($data["pass"], PASSWORD_DEFAULT);
         $user = $this->create($data);
         
         $this->profileRepository->createProfileRepository($user["id"]);
         return $user;
     }

    // function updateRepository ($id, $data) {
    //     return $this->update($id, $data);
    // }

    // function deleteRepository(string|int $id) {
    //     return $this->delete($id);
    // }     
}