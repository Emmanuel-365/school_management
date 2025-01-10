<?php

namespace App\Models;

use PDO;

class Model {
    /**
     * Summary of db
     * @var PDO
     */
    protected $db;
    protected static $table;
    protected $primaryKey = 'id';
    protected $fillable = [];
    protected $created_at;
    protected $updated_at;

    public function __construct($db) {
        $this->db = $db;
        if (empty(static::$table)) {
            $className = get_class($this);
            $tableName = strtolower(str_replace('Model', '', $className)) . 's';
            static::$table = $tableName;
        }
    }

    // Méthode pour filtrer les données en fonction des champs fillable
    protected function filterFillable($data) {
        return array_intersect_key($data, array_flip($this->fillable));
    }

    // Méthode pour créer un enregistrement
    public function create($data) {
        $filteredData = $this->filterFillable($data);
        $columns = implode(", ", array_keys($filteredData));
        $placeholders = implode(", ", array_fill(0, count($filteredData), '?'));
        $sql = "INSERT INTO " . static::$table . " ($columns) VALUES ($placeholders)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(array_values($filteredData));
        return $this->db->lastInsertId();
    }

    // Méthode pour lire un enregistrement par clé primaire
    public function read($id) {
        $sql = "SELECT * FROM " . static::$table . " WHERE {$this->primaryKey} = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        $stmt->setFetchMode(PDO::FETCH_CLASS, get_class($this), [$this->db]);
        return $stmt->fetch();
    }

    // Méthode pour lire tous les enregistrements
    public function readAll() {
        $sql = "SELECT * FROM " . static::$table;
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_CLASS, get_class($this), [$this->db]);
        return $stmt->fetchAll();
    }

    // Méthode pour mettre à jour un enregistrement
    public function update($id, $data) {
        $filteredData = $this->filterFillable($data);
        $set = [];
        foreach ($filteredData as $key => $value) {
            $set[] = "$key = ?";
        }
        $set = implode(", ", $set);
        $sql = "UPDATE " . static::$table . " SET $set WHERE {$this->primaryKey} = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(array_merge(array_values($filteredData), [$id]));
        return true;
    }

    // Méthode pour supprimer un enregistrement
    public function delete($id) {
        $sql = "DELETE FROM " . static::$table . " WHERE {$this->primaryKey} = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
    }

    // Méthode pour lire un enregistrement par n'importe quel champ
    public function findBy($field, $value) {
        $sql = "SELECT * FROM " . static::$table . " WHERE $field = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$value]);
        $stmt->setFetchMode(PDO::FETCH_CLASS, get_class($this), [$this->db]);
        return $stmt->fetch();
    }

    public function findManyBy($field, $value) {
        $sql = "SELECT * FROM " . static::$table . " WHERE $field = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$value]);
        $stmt->setFetchMode(PDO::FETCH_CLASS, get_class($this), [$this->db]);
        return $stmt->fetchAll();
    }

    // Méthode pour lire un seul champ par clé primaire
    public function getField($field, $id) {
        $sql = "SELECT $field FROM " . static::$table . " WHERE {$this->primaryKey} = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetchColumn();
    }

    // Méthode magique pour obtenir un attribut
    public function __get($name) {
        return $this->$name;
    }

    // Méthode magique pour définir un attribut
    public function __set($name, $value) {
        $this->$name = $value;
    }
}
