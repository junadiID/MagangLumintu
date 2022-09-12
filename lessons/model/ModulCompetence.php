<?php

require_once "../../config/Database.php";
// panggil disini atau dipanggil ketika di file untuk api

class ModulCompetence
{
    protected $conn;
    // table name 'modul_competence'

    public function closeConn()
    {
        $this->conn = null;
    }

    public function readAllCriteria()
    {
        $db = new Database();
        $this->conn = $db->connect();

        $query = "SELECT * FROM modul_competence";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // close connection
        $this->conn = null;
        $db->closeConn();

        return $rows;
    }

    public function readSingleCriteria($id)
    {
        $db = new Database();
        $this->conn = $db->connect();

        $query = "SELECT * FROM modul_competence WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        $id = htmlspecialchars(strip_tags($id));
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // close connection
        $this->conn = null;
        $db->closeConn();

        return $row;
    }

    public function readCriteriaByModul($modul_id)
    {
        $db = new Database();
        $this->conn = $db->connect();

        $query = "SELECT * FROM modul_competence WHERE modul_id = :modul_id";
        $stmt = $this->conn->prepare($query);

        $modul_id = htmlspecialchars(strip_tags($modul_id));
        $stmt->bindParam(':modul_id', $modul_id, PDO::PARAM_INT);

        $stmt->execute();
        $row = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // close connection
        $this->conn = null;
        $db->closeConn();

        return $row;
    }

    public function insertCriteria($data)
    {
        $db = new Database();
        $this->conn = $db->connect();

        $query = "INSERT INTO modul_competence SET modul_id = :modul_id, competence_name = :name, competence_weight = :weight";

        [
            "modul_id" => $modul_id,
            "name" => $name,
            "weight" => $weight
        ] = $data;

        $modul_id = htmlspecialchars(strip_tags($modul_id));
        $name = htmlspecialchars(strip_tags($name));
        $weight = htmlspecialchars(strip_tags($weight));

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':modul_id', $modul_id, PDO::PARAM_INT);
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':weight', $weight, PDO::PARAM_STR);

        if ($stmt->execute()) {
            $id =  $this->conn->lastInsertId();
        } else {
            $id = false;
        }

        // close connection
        $this->conn = null;
        $db->closeConn();

        return $id;
    }

    public function updateCriteria($data)
    {
        $db = new Database();
        $this->conn = $db->connect();

        $query = "UPDATE modul_competence SET modul_id = :modul_id, competence_name = :name, competence_weight = :weight WHERE id = :id";

        [
            "id" => $id,
            "modul_id" => $modul_id,
            "name" => $name,
            "weight" => $weight
        ] = $data;

        $id = htmlspecialchars(strip_tags($id));
        $modul_id = htmlspecialchars(strip_tags($modul_id));
        $name = htmlspecialchars(strip_tags($name));
        $weight = htmlspecialchars(strip_tags($weight));

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':modul_id', $modul_id, PDO::PARAM_INT);
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':weight', $weight, PDO::PARAM_STR);

        $stmt->execute();

        if ($stmt->rowCount()) {
            $updated_id =  $id;
        } else {
            $updated_id = false;
        }

        // close connection
        $this->conn = null;
        $db->closeConn();

        return $updated_id;
    }

    public function deleteCriteria($id)
    {
        $db = new Database();
        $this->conn = $db->connect();

        $query = "DELETE FROM modul_competence WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        $id = htmlspecialchars(strip_tags($id));
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount()) {
            $deleted_id = $id;
        } else {
            $deleted_id = false;
        }

        // close connection
        $this->conn = null;
        $db->closeConn();

        return $deleted_id;
    }

    public function deleteCriteriaByModul($modul_id)
    {
        $db = new Database();
        $this->conn = $db->connect();

        $query = "DELETE FROM modul_competence WHERE modul_id = :modul_id";
        $stmt = $this->conn->prepare($query);

        $modul_id = htmlspecialchars(strip_tags($modul_id));
        $stmt->bindParam(':modul_id', $modul_id, PDO::PARAM_INT);
        $stmt->execute();
        $num_deleted = $stmt->rowCount();

        // close connection
        $this->conn = null;
        $db->closeConn();

        return $num_deleted;
    }
}
