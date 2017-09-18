<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class task_model extends CI_Model {
	function sort_save($data)
     {
			// echo '<xmp>'; print_r($data); echo '</xmp>';
        	$data2['order_id'] = '222';
        	$data2['id'] = '2';
        	$this->db->where('id', $data['id']);
         	$this->db->update('task', $data);
     }

    
}