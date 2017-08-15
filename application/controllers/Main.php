<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {
	public function index()
	{
		//$this->load->model('main_model');
        // Reciving emails
        /*
        $counter_arr = $this->get_mail();
        $data['new_mail_count'] = $counter_arr[1];
        if (isset($counter_arr[2])) {
            $data['del_item_count'] = $counter_arr[2];
        } else {
            $data['del_item_count'] = 0;
        }
        */
        // Reading Task list
        //$data['task'] = $this->main_model->get_task();
        // Reading Status list
        //$data['item'] = $this->main_model->get_item();
        // Loadin view
        //$this->load->view('main_view', $data);
        $this->load->view('main_view');
	}
}
