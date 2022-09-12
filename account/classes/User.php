<?php


class User
{
    private $_db;

    public function __construct()
    {
        $this->_db = Database::getInstance();
    }

    public function register_user($fields = array())
    {
        if ($this->_db->insert('user', $fields))
            return true;
        else
            return false;
    }

    public function verifikasi_account($fields = array())
    {
        if ($this->_db->insert('user_token', $fields))
            return true;
        else
            return false;
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

    public function update_user($fields = array(), $value)
    {
        if ($this->_db->update('user', $fields, 'user_email', $value))
            return true;
        else
            return false;
    }

    public function delete_user($table, $column, $value)
    {
        if ($this->_db->delete($table, $column, $value))
            return true;
        else
            return false;
    }


    public function is_admin($email)
    {

        $fields = array('user_email' => 'user_email', 'role_id' => 'role_id');
        $column = $fields['user_email'];
        $data = $this->_db->get_info($fields, 'user', $column, $email);

        if ($data['role_id'] == 1)
            return true;
        else
            return false;

    }

    public function is_mentor($email)
    {

        $fields = array('user_email' => 'user_email', 'role_id' => 'role_id');
        $column = $fields['user_email'];
        $data = $this->_db->get_info($fields, 'user', $column, $email);

        if ($data['role_id'] == 2)
            return true;
        else
            return false;

    }


    public function is_loggedIn()
    {
        if (Session::exists('email'))
            return true;
        else
            return false;
    }

    public function get_users()
    {
        // NEW
        $fields = array('user_email' => 'user_email', 'user_username' => 'user_username', 'user_first_name' => 'user_first_name', 'user_last_name' => 'user_last_name', 'user_status' => 'user_status', 'user_dob' => 'user_dob', 'user_phone' => 'user_phone', 'user_address' => 'user_address', 'user_profile_picture' => 'user_profile_picture', 'role_id' => 'role_id', 'batch_id' => 'batch_id', 'batch_name' => 'batch_name', 'batch_start_date' => 'batch_start_date', 'batch_end_date' => 'batch_end_date', 'role_name' => 'role_name', 'date_created' => 'date_created');
        return $this->_db->get_info($fields, '', '', '', '');
    }

    public function get_users_role($role)
    {
        // NEW
        $fields = array('user_email' => 'user_email', 'user_username' => 'user_username', 'user_first_name' => 'user_first_name', 'user_last_name' => 'user_last_name', 'user_status' => 'user_status', 'user_dob' => 'user_dob', 'user_phone' => 'user_phone', 'user_address' => 'user_address', 'user_profile_picture' => 'user_profile_picture', 'role_id' => 'role_id', 'batch_id' => 'batch_id', 'batch_name' => 'batch_name', 'batch_start_date' => 'batch_start_date', 'batch_end_date' => 'batch_end_date', 'role_name' => 'role_name', 'date_created' => 'date_created');
        return $this->_db->get_info($fields, '', '', '', $role);

    }

    public function get_roles()
    {

        return $this->_db->get_info('', 'role', '', '', '');

    }

    public function get_data($email)
    {

        $fields = array('user_email' => 'user_email', 'user_password' => 'user_password', 'user_username' => 'user_username', 'user_first_name' => 'user_first_name', 'user_last_name' => 'user_last_name', 'user_status' => 'user_status', 'user_dob' => 'user_dob', 'user_phone' => 'user_phone', 'user_address' => 'user_address', 'user_gender' => 'user_gender', 'user_profile_picture' => 'user_profile_picture', 'role_id' => 'role_id', 'batch_id' => 'batch_id');
        $column = $fields['user_email'];

        if ($this->check_email($email))
            return $this->_db->get_info($fields, 'user', $column, $email);
        else
            return "Info user tidak ditemukan";
    }


    public function get_data_token($token)
    {

        $fields = array('user_email' => 'user_email', 'user_token' => 'user_token', 'date_created' => 'date_created');
        $column = $fields['user_token'];
        return $this->_db->get_info($fields, 'user_token', $column, $token);
    }

    public function get_token($token_id)
    {

        if ($this->check_token($token_id))
            return "Info user tidak ditemukan";
        else
            $fields = array('user_email' => 'user_email');
        $column = $fields['user_email'];
        return $this->_db->get_info($fields, 'user_token', $column, $token_id);

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

    public function check_username($username)
    {
        $fields = array('user_username' => 'user_username');
        $column = $fields['user_username'];
        $data = $this->_db->get_info($fields, 'user', $column, $username);

        if (empty($data))
            return false;
        else
            return true;

    }

    // Check token from request user
    public function check_token($token_id)
    {

        $fields = array('user_email' => 'user_email', 'user_token' => 'user_token', 'date_created' => 'date_created');
        $column = $fields['user_token'];
        $data = $this->_db->get_info($fields, 'user_token', $column, $token_id);

        if (empty($data))
            return false;
        else
            return true;

    }



}