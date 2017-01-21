<?php
/**
 * Created by PhpStorm.
 * User: yuyang
 * Date: 2017/1/16
 * Time: 19:41
 */
class Admin_model extends CI_Model
{
    private $table_token = "admin_user";

    public function __construct()
    {
        parent::__construct();
        $this->load->database($this->table_token);
    }

    public function getUsers($email)
    {
        return $this->db->where('email = ',$email)->get($this->table_token)->row_array();
    }
}