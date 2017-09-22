<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {
	public function index()
	{
        if (!file_exists('application/config/config-local.php')) {
            redirect('/main/install');
        }

		$this->load->model('main_model');
        // Reciving emails
        $counter_arr = $this->get_mail();

        $data['new_mail_count'] = $counter_arr[1];
        if (isset($counter_arr[2])) {
            $data['del_item_count'] = $counter_arr[2];
        } else {
            $data['del_item_count'] = 0;
        }

        // Получение списка заданий
        $data['task'] = $this->main_model->get_task();
        // Получение списка копий
        $data['item'] = $this->main_model->get_item();
        // Получение списка серверов без заданий
        $data['empty_server'] = $this->main_model->get_empty_server();
        // Загружаем вид
        $this->load->view('header_view');
        $this->load->view('main_view', $data);
        // $this->load->view('main_view');
    }
    
    public function install()
    {
        if(count($this->input->post()) > 0){
            $db_name = 'cobianmonitoring';
                // Записываем изменения в файл config.php
            $string = read_file('application/config/config.php');
            $string_edit = str_replace("base_url'] = ''", "base_url'] = '" . $this->input->post('inputBaseUrl') . "'", $string);
            write_file('application/config/config-local.php', $string_edit);

                // Записываем изменения в database.php
            $string = read_file('application/config/database-example.php');
            $string = str_replace("'hostname' => 'localhost'", "'hostname' => '" . $this->input->post('inputDBServer') . "'", $string);
            $string = str_replace("'username' => ''", "'username' => '" . $this->input->post('inputDBLogin') . "'", $string);
            $string = str_replace("'password' => ''", "'password' => '" . $this->input->post('inputDBPassword') . "'", $string);
            write_file('application/config/database.php', $string);
            $this->load->database();

                // Создание БД с проверкой существования
            $this->load->model('main_model');
            if (!$this->main_model->check_db($db_name)){
                $this->main_model->create_db($db_name);
            }

                //Прописываем в database.php
            $string = read_file('application/config/database.php');
            $string = str_replace("'database' => ''", "'database' => '" . $db_name . "'", $string);
            write_file('application/config/database.php', $string);

                // Cоздание таблиц
            $this->main_model->create_table();

                // Создание файла constants.php
            $string = read_file('application/config/constants-example.php');
            $string = str_replace("'EMAIL_SERVER', ''", "'EMAIL_SERVER', '" . $this->input->post('inputEmailServer') . "'", $string);
            $string = str_replace("'EMAIL_POP3_PORT', ''", "'EMAIL_POP3_PORT', '" . $this->input->post('inputEmailPop3Port') . "'", $string);
            $string = str_replace("'EMAIL_USER', ''", "'EMAIL_USER', '" . $this->input->post('inputEmailUser') . "'", $string);
            $string = str_replace("'EMAIL_PASSWORD', ''", "'EMAIL_PASSWORD', '" . $this->input->post('inputEmailPassword') . "'", $string);
            write_file('application/config/constants.php', $string);
            // Переход на основную странтицу
            redirect('../');
        }
        else {
            $this->load->view('install_view');
        }
    }

    // Получение почты
    public function get_mail() {
        $this->load->model('main_model');
        return $this->main_model->add_item();
    }

    // Редактирование статуса заказа
    public function edit_item($status_html, $task_id, $date) {
            switch ($status_html) {
                case 0:
                    $status = '0';
                    break;
                case 1:
                    $status = '1';
                    break;
                case 2:
                    $status = '2';
                    break;
                case 3:
                    $status = '3';
                    break;
                case 4:
                    $status = '4';
                    break;
            }
            $this->load->model('main_model');
            $this->main_model->edit_item($status, $task_id, $date);
            redirect('..');
        }
}
