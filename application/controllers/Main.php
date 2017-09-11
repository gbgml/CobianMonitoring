<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {
	public function index()
	{
        if (!file_exists('application/config/config-local.php')) {
            redirect('/main/install');
        }
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

    // public function create_db()
    // {
    //     $data = array();
    //     $data['task'] =  array('id' => '0', 'title' => 'Название задания');
    //     $data['server'] = array();
    //     $data['item'] = array();
    //     echo '<xmp>'; print_r($data); echo '</xmp>';
    // }
    public function install()
        {
            if(count($this->input->post()) > 0){

                // echo $this->input->post('inputBaseUrl');
                // echo '<br>';
                // echo $this->input->post('inputDBServer');
                // echo '<br>';
                // echo $this->input->post('inputDBLogin');
                // echo '<br>';
                // echo $this->input->post('inputDBPassword');
                // echo '<br>';
                // echo $this->input->post('inputEmail');
                // echo '<br>';
                // echo $this->input->post('ininputEmailPasswordputBaseUrl');
                // echo '<br>';
                
                // $data = '$config[\'base_url\'] = \'' . $this->input->post('inputBaseUrl') . '\'';
                $string = read_file('application/config/config.php');
                $string_edit = str_replace("base_url'] = ''", "base_url'] = '" . $this->input->post('inputBaseUrl') . "'", $string);
                write_file('application/config/config-local.php', $string_edit);
                redirect('../');
            }
            else {
                $this->load->view('install_view');
            }
        }

    public function test()
        {
          $this->load->model('main_model');
          $data['test'] = $this->main_model->test_db();
          // $this->load->view('articles_view',$data);
          echo '<xmp>'; print_r($data); echo '</xmp>';

        }    
        

}
