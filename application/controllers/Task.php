<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Task extends CI_Controller {
	public function index()
	{
		$this->load->model('main_model');
		$this->load->model('task_model');
		$data['task'] = $this->main_model->get_task();
		// echo '<xmp>'; print_r($data); echo '</xmp>';
		$this->load->view('header_view');
		$this->load->view('task_view', $data);
	}
public function add_task()
	{
		$this->load->model('main_model');
		$data['title'] = $this->input->post('title');
		$this->main_model->add_task($data);
		redirect(base_url('task'));
	}
public function sort_save()
	{
  			$this->load->model('task_model');
		    $order = $_POST['order'];
		    foreach($order as $i=>$id){
		        $data['order_id'] = $i;
		        $data['id'] = str_replace("sort-", "", $id);
          		$this->task_model->sort_save($data);
		    }
	}
}
