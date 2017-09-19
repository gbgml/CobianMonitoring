<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class task_model extends CI_Model {
	function sort_save($data)
	{
		$this->db->where('id', $data['id']);
		$this->db->update('task', $data);
	}
	function sort_server_save($data)
	{
		$this->db->where('id', $data['id']);
		$this->db->update('server', $data);
	}


}