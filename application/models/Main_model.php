<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class main_model extends CI_Model {
	public function test_db()
	{
        $query = $this->db->get('test');
        return $query->result_array();
    }
 }