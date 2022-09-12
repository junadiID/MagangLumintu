<?php

require_once "../classes/Database.php";

class User
{
    private $_db;

    public function __construct()
    {
        $this->_db = Database::getInstance();
    }

    public function login_user($email, $password)
    {
        $fields = array('user_email' => 'user_email', 'user_password' => 'user_password', 'role_id' => 'role_id');
        $column = $fields['user_email'];

        $data = $this->_db->get_info($fields, 'user', $column, $email);

        if (password_verify($password, $data['user_password'])) {
            return true;
        }
        else {
            return false;
        }

    }

    public function check_email($email)
    {
        $fields = array('user_email' => 'user_email');
        $column = $fields['user_email'];
        $data = $this->_db->get_info($fields, 'user', $column, $email);

        if (empty($data))
            return false;
        else
            return true;

    }

    public function get_data($email)
    {

        $fields = array('user_id' => 'user_id', 'user_email' => 'user_email', 'user_username' => 'user_username', 'user_first_name' => 'user_first_name', 'user_last_name' => 'user_last_name', 'user_status' => 'user_status', 'user_dob' => 'user_dob', 'user_phone' => 'user_phone', 'user_address' => 'user_address', 'user_profile_picture' => 'user_profile_picture', 'role_id' => 'role_id', 'batch_id' => 'batch_id');
        $column = $fields['user_email'];

        if ($this->check_email($email))
            return $this->_db->get_info($fields, 'user', $column, $email);
        else
            return "Info user tidak ditemukan";
    }

    public function get_users($role_id)
    {

        return $this->_db->get_users_batch($role_id);

    }

    public function get_batch()
    {

        return $this->_db->get_batch();

    }

    public function get_user()
    {
        $fields = array('user_id' => 'user_id', 'user_email' => 'user_email', 'user_username' => 'user_username', 'user_first_name' => 'user_first_name', 'user_last_name' => 'user_last_name', 'user_status' => 'user_status', 'user_dob' => 'user_dob', 'user_phone' => 'user_phone', 'user_address' => 'user_address', 'user_profile_picture' => 'user_profile_picture', 'role_id' => 'role_id', 'batch_id' => 'batch_id', 'batch_name' => 'batch_name', 'batch_start_date' => 'batch_start_date', 'batch_end_date' => 'batch_end_date', 'role_name' => 'role_name', 'date_created' => 'date_created');
        return $this->_db->get_info($fields, '', '', '', '');
    }

    public function get_batchs($batch_id)
    {

        $fields = array('batch_id' => 'batch_id', 'batch_name' => 'batch_name', 'batch_start_date' => 'batch_start_date', 'batch_end_date' => 'batch_end_date');
        $column = $fields['batch_id'];

        return $this->_db->get_info($fields, 'batch', $column, $batch_id);
    }



}
