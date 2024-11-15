<?php

namespace App\Utils;

use App\Config\BaseConexion;
use PDO;
use PDOException;

class Model
{
    private $db;
    protected $table;

    function __construct()
    {
        $this->db = BaseConexion::getInstace()->getConexion();    
    }

    function find() {
        $sql = "SELECT * FROM {$this->table}";

        $stm = $this->db->prepare($sql);
        $stm->execute();

        return $stm->fetchAll(PDO::FETCH_ASSOC);
    }

    function create(array $data)
    {
        $columns = array_keys($data);
        $columns = implode(', ', $columns);

        $values = array_values($data);
        
        $sql = "INSERT INTO {$this->table} ({$columns}) VALUES (". str_repeat('?, ', count($values) -1) . "?)";
        
        $stm = $this->db->prepare($sql);
        $stm->bindParam(1, $values[0], PDO::PARAM_STR);
        $stm->bindParam(2, $values[1], PDO::PARAM_STR);
        $stm->execute();

        $user_id = $this->db->lastInsertId();
        return $user_id;
    }

    function update (string|int $id, array $data){
        $columns = array_keys($data);
        $setPart = implode(', ', array_map(
            fn ($column) => "{$column} = ?", $columns
        ));
        $values = array_values($data);
        $values[] = $id;

        $sql = "UPDATE {$this->table} SET {$setPart} WHERE id = ?";
        $stm = $this->db->prepare($sql);

        foreach ($values as $index => $value) {
            $stm->bindValue($index + 1, $value);
        }
        $stm->execute();
        return $stm->rowCount();
    }

    function delete (int|string $id) {
        $sql = "DELETE FROM {$this->table} WHERE id = :id";
        $stm = $this->db->prepare($sql);
        $stm->bindParam(":id", $id, PDO::PARAM_INT);
        $stm->execute();

        return $stm->rowCount();
    }

    function findWithRelation( int|string $id, string $relationTable, string $foreignKey) {
        $sql = "SELECT * FROM {$this->table} 
                LEFT JOIN {$relationTable} 
                ON {$this->table}.id = {$relationTable}.{$foreignKey}
                WHERE {$this->table}.id = :id
                ";
        $stm = $this->db->prepare($sql);
        $type = is_int($id) ? PDO::PARAM_INT : PDO::PARAM_STR;
        $stm->bindParam(":id", $id, $type);
        $stm->execute();

        return $stm->fetch(PDO::FETCH_ASSOC);        
    }

    function createWithRelation (
        array $data,
        array $relationData, 
        string $relationTable,
        string $foreignKey
    ) {
        try {
            $this->db->beginTransaction();

            $mainId = $this->create($data);

            $relationData[$foreignKey] = $mainId;

            $columns = array_keys($relationData);
            $columns = implode(', ', $columns);
            $values = array_values($relationData);
            
            $sql = "INSERT INTO {$relationTable} ({$columns}) VALUES (" . str_repeat('?, ', count($values) -1) . "?)";
            
            $stm = $this->db->prepare($sql);
            foreach($values as $index => $value) {
                
                $type = is_int($value) ? PDO::PARAM_INT : PDO::PARAM_STR;
                $stm->bindValue($index + 1, $value, $type);
            }
            $stm->execute();

            $this->db->commit();
            return $mainId;
        } catch (PDOException $e) {
            $this->db->rollBack();
            throw $e;
        }
    }
}