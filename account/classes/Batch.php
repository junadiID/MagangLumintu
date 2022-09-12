<?php


class Batch
{
    private $_db;

    public function __construct()
    {
        $this->_db = Database::getInstance();
    }

    public function get_batch()
    {

        return $this->_db->get_batch();

    }

    public function get_data($batch_id)
    {

        $fields = array('batch_id' => 'batch_id', 'batch_name' => 'batch_name', 'batch_start_date' => 'batch_start_date', 'batch_end_date' => 'batch_end_date');
        $column = $fields['batch_id'];

        return $this->_db->get_info($fields, 'batch', $column, $batch_id);
        
    }

    public function add_batch($fields = array())
    {
        if ($this->_db->insert('batch', $fields))
            return true;
        else
            return false;
    }

    public function update_batch($fields = array(), $value)
    {
        if ($this->_db->update('batch', $fields, 'batch_id', $value))
            return true;
        else
            return false;
    }

    public function delete_batch($value)
    {
        if ($this->_db->delete('batch', 'batch_id', $value))
            return true;
        else
            return false;
    }



}