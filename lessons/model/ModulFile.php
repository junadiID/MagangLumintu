<?php

require_once "../../config/Database.php";
// panggil disini atau dipanggil ketika di file untuk api


class ModulFile
{
    protected $conn;
    // table name 'modul_files'

    public function closeConn()
    {
        $this->conn = null;
    }

    public function readAllFiles()
    {
        $db = new Database();
        $this->conn = $db->connect();

        $query = "SELECT * FROM modul_files";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // close connection
        $this->conn = null;
        $db->closeConn();

        return $rows;
    }

    public function readSingleFile($id)
    {
        $db = new Database();
        $this->conn = $db->connect();

        $query = "SELECT * FROM modul_files WHERE id = :id";
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

    public function readFilesByModul($modul_id)
    {
        $db = new Database();
        $this->conn = $db->connect();

        $query = "SELECT * FROM modul_files WHERE modul_id = :modul_id";
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

    public function insertFileData($data)
    {
        $db = new Database();
        $this->conn = $db->connect();

        $query = "INSERT INTO modul_files SET modul_id = :modul_id, file_name = :file_name, file_size = :file_size, file_type = :file_type, file_url = :file_url";

        [
            "modul_id" => $modul_id,
            "file_name" => $file_name,
            "file_size" => $file_size,
            "file_type" => $file_type,
            "file_url" => $file_url
        ] = $data;

        $modul_id = htmlspecialchars(strip_tags($modul_id));
        $file_name = htmlspecialchars(strip_tags($file_name));
        $file_size = htmlspecialchars(strip_tags($file_size));
        $file_type = htmlspecialchars(strip_tags($file_type));
        $file_url = htmlspecialchars(strip_tags($file_url));

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':modul_id', $modul_id, PDO::PARAM_INT);
        $stmt->bindParam(':file_name', $file_name, PDO::PARAM_STR);
        $stmt->bindParam(':file_size', $file_size, PDO::PARAM_INT);
        $stmt->bindParam(':file_type', $file_type, PDO::PARAM_STR);
        $stmt->bindParam(':file_url', $file_url, PDO::PARAM_STR);

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

    public function updateFileData($data)
    {
        $db = new Database();
        $this->conn = $db->connect();

        $query = "UPDATE modul_files SET modul_id = :modul_id, file_name = :file_name, file_size = :file_size, file_type = :file_type, file_url = :file_url WHERE id = :id";

        [
            "id" => $id,
            "modul_id" => $modul_id,
            "file_name" => $file_name,
            "file_size" => $file_size,
            "file_type" => $file_type,
            "file_url" => $file_url
        ] = $data;

        $id = htmlspecialchars(strip_tags($id));
        $modul_id = htmlspecialchars(strip_tags($modul_id));
        $file_name = htmlspecialchars(strip_tags($file_name));
        $file_size = htmlspecialchars(strip_tags($file_size));
        $file_type = htmlspecialchars(strip_tags($file_type));
        $file_url = htmlspecialchars(strip_tags($file_url));

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':modul_id', $modul_id, PDO::PARAM_INT);
        $stmt->bindParam(':file_name', $file_name, PDO::PARAM_STR);
        $stmt->bindParam(':file_size', $file_size, PDO::PARAM_INT);
        $stmt->bindParam(':file_type', $file_type, PDO::PARAM_STR);
        $stmt->bindParam(':file_url', $file_url, PDO::PARAM_STR);

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

    public function deleteFileData($id)
    {
        $db = new Database();
        $this->conn = $db->connect();

        $query = "DELETE FROM modul_files WHERE id = :id";
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

    public function deleteFileDataByModul($modul_id)
    {
        $db = new Database();
        $this->conn = $db->connect();

        $query = "DELETE FROM modul_files WHERE modul_id = :modul_id";
        $stmt = $this->conn->prepare($query);

        $id = htmlspecialchars(strip_tags($modul_id));
        $stmt->bindParam(':modul_id', $modul_id, PDO::PARAM_INT);
        $stmt->execute();
        $num_deleted = $stmt->rowCount();

        // close connection
        $this->conn = null;
        $db->closeConn();

        return $num_deleted;
    }
}
