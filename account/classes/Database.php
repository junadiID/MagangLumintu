<?php

class Database
{

    private static $INSTANCE = null;
    private $mysqli,
    $HOST = "localhost",
    $USER = "u7693729_account",
    $PASS = "u7693729_lms_account",
    $DATABASE = "u7693729_lms_account";

    public function __construct()
    {

        // Set connection to Database
        $this->mysqli = new mysqli($this->HOST, $this->USER, $this->PASS, $this->DATABASE);

        if (mysqli_connect_error()) {
            Redirect::to("500");
        }

    }

    // Singleton pattern, Connection Database
    public static function getInstance()
    {
        if (!isset(self::$INSTANCE)) {
            self::$INSTANCE = new Database();
        }

        return self::$INSTANCE;
    }

    // Insert data to Database
    public function insert($table, $fields = array())
    {

        // Get Colum from $field and separate with comma
        $column = implode(", ", array_keys($fields));

        // Get Value
        $valueArrays = array();
        $i = 0;
        foreach ($fields as $key => $values) {

            // If type from $values = int, then remove '' from this.
            if (is_int($values)) {
                $valueArrays[$i] = $this->escape($values);
            }

            else {
                $valueArrays[$i] = "'" . $this->escape($values) . "'";
            }

            $i++;
        }

        // Add comma to the Value
        $values = implode(", ", $valueArrays);

        // Insert data into database
        $query = "INSERT INTO $table ($column) VALUES ($values)";

        return $this->run_query($query, "Masalah saat memasukan data");
    }

    // Update data in database
    public function update($table, $fields, $column, $value)
    {

        $valueArrays = array();
        $i = 0;

        foreach ($fields as $key => $values) {
            // Add equals to value with integer type 
            if (is_int($values)) {
                $valueArrays[$i] = $key . "=" . $this->escape($values);
            }
            else {
                $valueArrays[$i] = $key . "='" . $this->escape($values) . "'";
            }

            $i++;
        }

        $values = implode(", ", $valueArrays);

        // If type from value is integer, then update the data without '' 
        if (is_int($value)) {
            $query = "UPDATE $table SET $values WHERE $column = $value";
        }
        else {
            $query = "UPDATE $table SET $values WHERE $column = '$value'";
        }

        return $this->run_query($query, "Masalah saat mengupdate data");
    }

    // Delete data in Database
    public function delete($table, $column, $value)
    {

        // If type from value is integer, then update the data without ''
        if (is_int($value)) {
            $query = "DELETE FROM $table WHERE $column = $value";
        }
        else {
            $query = "DELETE FROM $table WHERE $column = '$value'";
        }

        return $this->run_query($query, "Masalah saat mengupdate data");
    }

    // Function for send query to Database
    public function run_query($query, $message)
    {
        if ($this->mysqli->query($query))
            return true;
        else
            echo($message);
    }

    //Separate character sql, for secure sql query.
    public function escape($name)
    {
        return $this->mysqli->real_escape_string(stripslashes(htmlspecialchars($name)));
    }



    // Get info from database with specific paramater
    public function get_info($fields, $table = ' ', $column = ' ', $value = ' ', $role = ' ')
    {

        if (!is_int($value)) {
            $value = "'" . $value . "'";
        }

        if ($column != '') {

            $valueArrays = array();
            $i = 0;
            foreach ($fields as $key => $values) {
                $valueArrays[$i] = $key;
                $i++;
            }
            $row = implode(", ", $valueArrays);

            $query = "SELECT $row FROM $table WHERE $column = $value";

            $result = $this->mysqli->query($query);

            while ($row = $result->fetch_assoc()) {
                return $row;
            }


        }

        else if ($table != '') {

            $query = "SELECT * FROM $table";

            $result = $this->mysqli->query($query);

            while ($row = $result->fetch_assoc()) {
                $results[] = $row;
            }

            return $results;
        }

        else if ($role != '') {

            $valueArrays = array();
            $i = 0;
            foreach ($fields as $key => $values) {
                $valueArrays[$i] = $key;
                $i++;
            }
            $row = implode(", ", $valueArrays);

            $query = "SELECT $row FROM user LEFT JOIN batch USING(batch_id) JOIN role USING(role_id) WHERE role.role_name = '$role' GROUP BY user.date_created DESC";

            $result = $this->mysqli->query($query);

            while ($row = $result->fetch_assoc()) {
                $results[] = $row;
            }

            return $results;

        }

        else {

            $valueArrays = array();
            $i = 0;
            foreach ($fields as $key => $values) {
                $valueArrays[$i] = $key;
                $i++;
            }
            $row = implode(", ", $valueArrays);

            $query = "SELECT $row FROM user LEFT JOIN batch USING(batch_id) JOIN role USING(role_id) GROUP BY user.date_created DESC";

            $result = $this->mysqli->query($query);

            while ($row = $result->fetch_assoc()) {
                $results[] = $row;
            }

            return $results;

        }

    }

    public function get_users_batch($role_id)
    {
        $query = "SELECT user_id, role_id, user.batch_id, user_email, user_username, user_first_name, user_last_name, user_dob, user_address, user_gender, user_phone, user_status, batch_name, batch_start_date, batch_end_date FROM user JOIN batch ON user.batch_id = batch.batch_id WHERE batch.batch_id = $role_id";
        $result = $this->mysqli->query($query);

        while ($row = $result->fetch_assoc()) {
            $results[] = $row;
        }

        return $results;
    }

    public function get_batch()
    {
        $query = "SELECT * FROM batch";
        $result = $this->mysqli->query($query);

        while ($row = $result->fetch_assoc()) {
            $results[] = $row;
        }

        return $results;
    }

}