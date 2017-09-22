<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Task extends CI_Controller {
	public function index()
	{
		$this->load->helper('form');
		$this->load->model('main_model');
		$this->load->model('task_model');
		$data['task'] = $this->main_model->get_task();
		// Получение списка серверов без заданий
		$data['empty_server'] = $this->main_model->get_empty_server();
		$this->load->view('header_view');
		$this->load->view('task_view', $data);
	}
	public function add_task()
	{
		$this->load->model('main_model');
		$data['title'] = $this->input->post('title');
		$data['description'] = $this->input->post('task_description');
		$this->main_model->add_task($data);
		redirect(base_url('task'));
	}
	public function sort_save()
	{
		$this->load->model('task_model');
		$order = $_POST['order'];
		$data['server'] = NULL;
		foreach($order as $i=>$id){
			$srv = explode('.', $id);
			if (isset($srv['1'])) {
				$data['server'] = $srv['1'];
				$server['id'] = $srv['1'];
				$server['order_id'] = $i;
				$this->task_model->sort_server_save($server);
				continue;
			}
			$data['order_id'] = $i;
			$data['id'] = str_replace("sort-", "", $id);
			$this->task_model->sort_save($data);
		}
	}
	public function get_one_task()
	{
		$this->load->model('task_model');
		$id = $_POST['tr_id'];
		$query = $this->task_model->get_one_task($id);
		echo json_encode($query);
	}	
	public function update_task()
	{
		$data['id'] = $this->input->post('task_id');
		$data['title'] = $this->input->post('task_title');
		$data['description'] = $this->input->post('task_description');
		$this->load->model('task_model');
		$this->task_model->update_task($data);
		redirect(base_url('task'));
	}
	public function delete_task($id)
	{
		$this->load->model('task_model');
		$this->task_model->delete_task($id);
		redirect(base_url('task'));
	}
	public function add_server()
	{
		$this->load->model('task_model');
		$data['title'] = $this->input->post('server_title');
		$this->task_model->add_server($data);
		redirect(base_url('task'));
	}	
	public function get_one_server()
	{
		$this->load->model('task_model');
		$id = $_POST['tr_id'];
		$query = $this->task_model->get_one_server($id);
		echo json_encode($query);
	}
	public function update_server()
	{
		$data['id'] = $this->input->post('server_id');
		$data['title'] = $this->input->post('server_title');
		$this->load->model('task_model');
		$this->task_model->update_server($data);
		redirect(base_url('task'));
	}	
	public function delete_server($id)
	{
		$this->load->model('task_model');
		$this->task_model->delete_server($id);
		redirect(base_url('task'));
	}	
}
