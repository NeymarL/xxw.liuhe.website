<?php

defined('BASEPATH') or exit('No direct script access allowed');

class MY_Model extends CI_Model
{

    protected $table_name;
    public function __construct()
    {
        parent::__construct();
    }

    public function insert_entry()
    {
        $this->db->insert($this->table_name, $this);
        return $this->check_mysql_error();
    }

    protected function check_mysql_error()
    {
        $errors = $this->db->error();
        return $errors['code'] ? false : true;
    }
    /**
     * Get the value of Table Name
     *
     * @return mixed
     */
    public function get_table_name()
    {
        return $this->table_name;
    }

    /**
     * Set the value of Table Name
     *
     * @param mixed table_name
     *
     * @return self
     */
    public function set_table_name($table_name)
    {
        $this->table_name = $table_name;

        return $this;
    }

}
