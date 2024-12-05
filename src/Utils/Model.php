<?php

namespace App\Utils;

use App\Config\BaseConexion;
use PDO;
use PDOException;

class Model
{
    protected $db, $query ;

    function __construct(protected $table)
    {
        $this->db = BaseConexion::getInstace()->getConexion();    
    }

    function query ($sql, $data = [], $params = null) 
    {
        if($data){

            /* substr_count = cuenta cuando ? hay en la consulta */
            $numSignos = substr_count($sql, "?");
            
            $this->query = $this->db->prepare($sql);
            
            foreach($data as $key => $value) {
                $type = is_int($value) ? PDO::PARAM_INT : PDO::PARAM_STR;
                $this->query->bindParam($key + 1, $data[$key], $type);
            }

            $this->query->bindParam(1, $data[0], PDO::PARAM_STR);
            $this->query->execute();

        } else {
            $this->query = $this->db->prepare($sql);
            $this->query->execute();
        }

        return $this;
    }

    function first ()
    {
        return $this->query->fetch(PDO::FETCH_ASSOC);
    }

    function get()
    {
        return $this->query->fetchAll(PDO::FETCH_ASSOC);
    }

    
    /** Consultas  */
    function all ()
    {
        $sql = "SELECT * FROM {$this->table}";
        return $this->query($sql)->get();
    }

    function findOne (int|string $id)
    {
        $sql = "SELECT * FROM {$this->table} WHERE id = ?";
        return $this->query($sql, [$id])->first();
    }

    function create(array $data) {
        $columns = array_keys($data);
        $columns = implode(', ', $columns);

        $values = array_values($data);

        $sql = "INSERT INTO {$this->table} ({$columns}) VALUES (" . str_repeat('?, ', count($values) - 1) . "?)";
        
        $this->query($sql, $values);

        $user_id = $this->db->lastInsertId();
        return $this->findOne($user_id);
    }

    function update( int|string $id, array $data, string $foreignKey) 
    {
        $columns = array_keys($data);
        $setClause = implode(' = ?, ', $columns) . ' = ?';
        $values = array_values($data);
        $values[] = $id;

        $sql = "UPDATE {$this->table} SET {$setClause} WHERE {$foreignKey} = ?";
        $this->query($sql, $values);

        return $this->query->rowCount();
    }

    function where ($colum, $operator, $value = null) {
        if($value == null) {
            $value = $operator;
            $operator = "=";
        }

        $sql = "SELECT * FROM {$this->table} WHERE {$colum} {$operator} ?";
        $this->query($sql, [$value]);

        return $this;
    }

    function withRelation ($relationTable, $foreignKey, $localKey, array $columns = ['*']) 
    {
        $columns = implode(', ', $columns);
        
        $sql = "SELECT {$columns} FROM {$this->table}
        LEFT JOIN {$relationTable} ON {$this->table}.{$foreignKey} = {$relationTable}.id
        WHERE {$foreignKey} = ?";
        
        return $this->query($sql, [$localKey])->first();
    }

    
}