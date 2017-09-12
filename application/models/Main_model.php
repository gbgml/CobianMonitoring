<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class main_model extends CI_Model {
	public function test_db()
	{
        
    }

    // Проверка существования БД
    public function check_db($db_name)
	{
        $query = $this->db->query("SHOW DATABASES LIKE '". $db_name ."'");
        if(count($query->result_array()) == 0){
        	return FALSE;
        }
        else {
        	return TRUE;
        }
    }

    // Создание БД
    public function create_db($db_name)
	{
		$this->load->dbforge();
		if ($this->dbforge->create_database($db_name))
        {
            // return 'База данных создана!';
        }
	}
 }