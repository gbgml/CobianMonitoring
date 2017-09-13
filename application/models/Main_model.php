<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class main_model extends CI_Model {

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

    // Создание таблицы
	public function create_table()
	{
		// Это нужно тк запись в database.php о БД еще не инициализировалась
		$this->db->query('use cobianmonitoring');

		// Названия и содержимое таблиц
		$table_name = array(
			'item' => array(
				'id' => array('type' => 'INT', 'constraint' => 9, 'unsigned' => TRUE, 'auto_increment' => TRUE),
	            'task' => array('type' => 'INT', 'constraint' => 9),
	            'date' => array('type' =>'date'),
	            'status' => array('type' => 'INT', 'constraint' => 9),
			),
			'server' => array(
				'id' => array('type' => 'INT','constraint' => 9, 'unsigned' => TRUE, 'auto_increment' => TRUE),
	            'order_id' => array('type' => 'INT', 'constraint' => 9),
	            'title' => array('type' =>'varchar', 'constraint' => 100),
			),
			'task' => array(
				'id' => array('type' => 'INT','constraint' => 9, 'unsigned' => TRUE, 'auto_increment' => TRUE),
	            'order_id' => array('type' => 'INT', 'constraint' => 9),
	            'title' => array('type' =>'varchar', 'constraint' => 100),
	            'server' => array('type' => 'INT', 'constraint' => 9),
	            'description' => array('type' =>'varchar', 'constraint' => 700),
			)
		);

		// Создание таблиц
		$this->load->dbforge();
        foreach ($table_name as $key => $value) {
        	$this->dbforge->add_key('id', TRUE);
            $this->dbforge->add_field($value);
			$this->dbforge->create_table($key, TRUE);
		}        
	}
 }