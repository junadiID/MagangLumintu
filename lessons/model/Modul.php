<?php

require_once "../../config/Database.php";
// require '../config/Database.php'; //error

class Modul
{
    protected $conn;

    public function closeConn()
    {
        $this->conn = null;
    }

    public function readAllModulRows()
    {
        $db = new Database();
        $this->conn = $db->connect();

        $query = "SELECT * FROM moduls";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // close connection
        $this->conn = null;
        $db->closeConn();

        return $rows;
    }

    // return modul paling atas tanpa childnya
    public function readSuperModuls()
    {
        $db = new Database();
        $this->conn = $db->connect();

        $query = "SELECT * FROM moduls WHERE parent_id IS NULL";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // close connection
        $this->conn = null;
        $db->closeConn();

        return $rows;
    }

    public function readSuperModulsbyBatch($batch)
    {
        $db = new Database();
        $this->conn = $db->connect();

        $query = "SELECT * FROM moduls WHERE parent_id IS NULL AND batch_id = :batch";
        $stmt = $this->conn->prepare($query);

        $batch = htmlspecialchars(strip_tags($batch));
        $stmt->bindParam(':batch', $batch, PDO::PARAM_INT);

        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // close connection
        $this->conn = null;
        $db->closeConn();

        return $rows;
    }

    public function readSingleModul($id)
    {
        $db = new Database();
        $this->conn = $db->connect();

        $query = "SELECT * FROM moduls WHERE id = :id";
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

    // return modul dengan childnya (rekursif)
    public function readModulTree($id = null)
    {
        $moduls = $this->searchByParentId($id);
        $tree = [];

        if ($moduls) {
            foreach ($moduls as $modul) {
                if ($this->isHasChild($modul["id"])) {
                    $tree[] = [
                        "id" => $modul["id"],
                        "parent_id" => $modul["parent_id"],
                        "modul_name" => $modul["modul_name"],
                        "modul_desc" => $modul["modul_description"],
                        "batch_id" => $modul["batch_id"],
                        "child" => $this->readModulTree($modul["id"])
                    ];
                } else {
                    $tree[] = [
                        "id" => $modul["id"],
                        "parent_id" => $modul["parent_id"],
                        "modul_name" => $modul["modul_name"],
                        "modul_desc" => $modul["modul_description"],
                        "batch_id" => $modul["batch_id"],
                    ];
                }
            }
        }

        return $tree;
    }

    public function readModulTreeByBatch($batch_id)
    {
        $moduls = $this->readSuperModulsbyBatch($batch_id);
        $tree = [];

        if ($moduls) {
            foreach ($moduls as $modul) {
                if ($this->isHasChild($modul["id"])) {
                    $tree[] = [
                        "id" => $modul["id"],
                        "parent_id" => $modul["parent_id"],
                        "modul_name" => $modul["modul_name"],
                        "modul_desc" => $modul["modul_description"],
                        "batch_id" => $modul["batch_id"],
                        "child" => $this->readModulTree($modul["id"])
                    ];
                } else {
                    $tree[] = [
                        "id" => $modul["id"],
                        "parent_id" => $modul["parent_id"],
                        "modul_name" => $modul["modul_name"],
                        "modul_desc" => $modul["modul_description"],
                        "batch_id" => $modul["batch_id"],
                    ];
                }
            }
        }

        return $tree;
    }

    // return single modul dengan childnya
    public function readSingleModulTree($id)
    {
        $row = $this->readSingleModul($id);

        if ($row) {
            $child = $this->readModulTree($id);

            if ($child) {
                $tree = [
                    "id" => $row["id"],
                    "parent_id" => $row["parent_id"],
                    "modul_name" => $row["modul_name"],
                    "modul_desc" => $row["modul_description"],
                    "batch_id" => $row["batch_id"],
                    "child" => $child
                ];
            } else {
                $tree = [
                    "id" => $row["id"],
                    "parent_id" => $row["parent_id"],
                    "modul_name" => $row["modul_name"],
                    "modul_desc" => $row["modul_description"],
                    "batch_id" => $row["batch_id"]
                ];
            }
            return $tree;
        } else {
            return false;
        }
    }

    public function createModul($data)
    {
        $db = new Database();
        $this->conn = $db->connect();

        $query = "INSERT INTO moduls SET modul_name = :modul_name, status = :status, parent_id = :parent_id, batch_id = :batch_id, modul_description = :description, modul_weight = :weight";

        [
            "modul_name" => $modul_name,
            "status" => $status,
            "parent_id" => $parent_id,
            "batch_id" => $batch_id,
            "modul_description" => $modul_description,
            "modul_weight" => $modul_weight
        ] = $data;

        $modul_name = htmlspecialchars(strip_tags($modul_name));
        $modul_description = htmlspecialchars(strip_tags($modul_description));
        $modul_weight = htmlspecialchars(strip_tags($modul_weight));
        $status = htmlspecialchars(strip_tags($status));
        $parent_id = htmlspecialchars(strip_tags($parent_id));
        $batch_id = htmlspecialchars(strip_tags($batch_id));

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':modul_name', $modul_name, PDO::PARAM_STR);
        $stmt->bindParam(':status', $status, PDO::PARAM_INT);
        $stmt->bindParam(':description', $modul_description, PDO::PARAM_STR);
        $stmt->bindParam(':weight', $modul_weight, is_null($modul_weight) || empty($modul_weight) ? PDO::PARAM_NULL : PDO::PARAM_STR);
        $stmt->bindParam(':parent_id', $parent_id, is_null($parent_id) || empty($parent_id) ? PDO::PARAM_NULL : PDO::PARAM_INT);
        $stmt->bindParam(':batch_id', $batch_id, is_null($batch_id) || empty($batch_id) ? PDO::PARAM_NULL : PDO::PARAM_INT);

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

    public function updateModul($data)
    {
        $db = new Database();
        $this->conn = $db->connect();

        $query = "UPDATE moduls SET modul_name = :modul_name, status = :status, parent_id = :parent_id, batch_id = :batch_id, modul_description = :description, modul_weight = :weight WHERE id = :id";

        [
            "id" => $id,
            "modul_name" => $modul_name,
            "status" => $status,
            "parent_id" => $parent_id,
            "batch_id" => $batch_id,
            "modul_description" => $modul_description,
            "modul_weight" => $modul_weight
        ] = $data;

        $id = htmlspecialchars(strip_tags($id));
        $modul_name = htmlspecialchars(strip_tags($modul_name));
        $modul_description = htmlspecialchars(strip_tags($modul_description));
        $modul_weight = htmlspecialchars(strip_tags($modul_weight));
        $status = htmlspecialchars(strip_tags($status));
        $parent_id = htmlspecialchars(strip_tags($parent_id));
        $batch_id = htmlspecialchars(strip_tags($batch_id));

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':modul_name', $modul_name, PDO::PARAM_STR);
        $stmt->bindParam(':description', $modul_description, PDO::PARAM_STR);
        $stmt->bindParam(':status', $status, PDO::PARAM_INT);
        $stmt->bindParam(':weight', $modul_weight, is_null($modul_weight) || empty($modul_weight) ? PDO::PARAM_NULL : PDO::PARAM_STR);
        $stmt->bindParam(':parent_id', $parent_id, is_null($parent_id) || empty($parent_id) ? PDO::PARAM_NULL : PDO::PARAM_INT);
        $stmt->bindParam(':batch_id', $batch_id, is_null($batch_id) || empty($batch_id) ? PDO::PARAM_NULL : PDO::PARAM_INT);

        $stmt->execute();

        if ($stmt->rowCount()) {
            $updated_id = $id;
        } else {
            $updated_id = false;
        }

        // close connection
        $this->conn = null;
        $db->closeConn();

        return $updated_id;
    }

    public function deleteModulById($id)
    {
        $db = new Database();
        $this->conn = $db->connect();

        $query = "DELETE FROM moduls WHERE id = :id";
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

    // return 0/1
    public function isHasChild($id)
    {
        $db = new Database();
        $this->conn = $db->connect();

        $query = "SELECT * FROM moduls WHERE parent_id = {$id} LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $count = $stmt->rowCount();

        // close connection
        $this->conn = null;
        $db->closeConn();

        return $count;
    }

    // return modul tanpa childnya
    public function searchByParentId($id)
    {
        $db = new Database();
        $this->conn = $db->connect();

        $where = is_null($id) ? "IS NULL" : "= {$id}";
        $query = "SELECT * FROM moduls WHERE parent_id {$where}";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // close connection
        $this->conn = null;
        $db->closeConn();

        return $rows;
    }
}
