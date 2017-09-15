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
				'order_id' => array('type' => 'INT', 'constraint' => 9, 'null' => TRUE,),
				'title' => array('type' =>'varchar', 'constraint' => 100),
			),
			'task' => array(
				'id' => array('type' => 'INT','constraint' => 9, 'unsigned' => TRUE, 'auto_increment' => TRUE),
				'order_id' => array('type' => 'INT', 'constraint' => 9, 'null' => TRUE,),
				'title' => array('type' =>'varchar', 'constraint' => 100),
				'server' => array('type' => 'INT', 'constraint' => 9, 'null' => TRUE,),
				'description' => array('type' =>'varchar', 'constraint' => 700, 'null' => TRUE,),
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

	// Чтение и парсинг письма
	function add_item() {
		// Создание функции подключения
		function get_data($pop_conn) {
			$data = "";
			// цикл с условием. feof - file end of file
			while (!feof($pop_conn)) {
			// Создание переменной buffer. chop - удаляет пробьельные символы в конце строки
			// fgets - прочитать строку из файла
				$buffer = chop(fgets($pop_conn, 1024));
				// добавляет к существующему значению $data ""$buffer\r\n""
				$data .= "$buffer<br>";
				if (trim($buffer) == ".")
					break;
			}
			return $data;
		}

		// Подключение к серверу. Получаем +OK Eserv/2.99 POP3 server ready
		$pop_conn = fsockopen(EMAIL_SERVER, EMAIL_POP3_PORT, $errno, $errstr, 10);
		$code = fgets($pop_conn, 1024);
// print $code . '<br>';

		// Отдаем логин. Получаем +OK Name accepted  
		fputs($pop_conn, "USER " . substr(EMAIL_USER, 0, strrpos(EMAIL_USER, "@")) . "\r\n");
		$code = fgets($pop_conn, 1024);
// print $code . '<br>';
		// Отдаем пароль. Получаем +OK User logged in
		fputs($pop_conn, "PASS " . EMAIL_PASSWORD . "\r\n");
		$code = fgets($pop_conn, 1024);
// print $code . '<br>';
		// Запрашиваем краткую сводк по письмам. Получаем +OK 2 3802 
		fputs($pop_conn, "STAT\r\n");
		$stat_cmd = fgets($pop_conn, 1024);
// print $stat_cmd . '<br>';
		preg_match('#^.+OK ([0-9]+).+$#', $stat_cmd, $mail_number);
		$mail_number_int = $mail_number[1];
// echo 'Новых писем - ' . $mail_number_int . '<br>';
	        // die();
		// Перебор писем
		for ($i = 1; $i <= $mail_number_int; $i++) {
			// Переменная для отбрасывания писем неправильного формата
			$valid_mail = TRUE;
			// Запрашиваем Содержимое каждого сообщения
			fputs($pop_conn, "RETR " . $i . "\r\n");
			$text_mail = get_data($pop_conn);
			// Временный вывод текста письма
// echo $text_mail . '<br><br>';
			// Парсинг названия задания
			preg_match('/^.+Общее время выполнения задания "([\w\s\(\.\)\,\-]+)".+$/isu', $text_mail, $task_name);
			if (!isset($task_name[1])) {
				$valid_mail = FALSE;
			}
// echo 'Название задания - ' . $task_name[1] . '<br>';
			
			// Определение индекса задания
			$this->db->where('title', $task_name[1]);
			$query = $this->db->get('task');
			$query_res = $query->result_array();
			if (!isset($query_res['0']['id'])) {
				// $valid_mail = FALSE;
				$data_task['title'] = $task_name[1];
				$data['task'] = $this->add_task($data_task);

				// echo 'Задания ' . $task_name[1] . ' нет в списке!<br>';
				// continue;
			} else {
				$data['task'] = $query_res['0']['id'];
			}
//echo '<xmp>'; print_r($query->result_array()); echo '</xmp>';
//echo $query_res['0']['id'] . '<br>';
			// Парсинг даты и времени
			preg_match('/^.+([0-9]{2})-([0-9]{2})-([0-9]{4}) ([0-9]{2}):([0-9]{2}) Общее время выполнения задания "([\w\s\(\.\)\,\-]+)".+$/isu', $text_mail, $date_time);
	           // echo '<xmp>'; print_r($date_time); echo '</xmp>';
			// Если время меньше 8 утра
			if ($date_time[4] < 8) {
				--$date_time[1];
			}
			$data['date'] = $date_time[3] . '-' . $date_time[2] . '-' . $date_time[1];
// echo $date_time[1] . '-' . $date_time[2] . '-' . $date_time[3] . '<br>';
// echo $date_time[4] . '-' . $date_time[5] . '<br>';
			// Определение типа архива (Полный или разностный)
			if (preg_match('#^.+(Полный).+$#', $text_mail)) {
// echo 'Тип архива - Полный <br>';
				$task_type = 1;
			} elseif (preg_match('#^.+(Разностный).+$#', $text_mail)) {
// echo 'Тип архива - Разностный <br>';
				$task_type = 2;
			}

			// Парсинг количества ошибок
			preg_match('#^[\S\s\n]+ Ошибок: ([0-9]+)[\S\s\n]+$#', $text_mail, $error);
// echo 'Ошибок - ' . $error[1] . '<br>';
			if ($error[1] > 0) {
				$task_type = 3;
			}
			if (!isset($task_type)) {
				$valid_mail = FALSE;
			} else {
				$data['status'] = $task_type;
			}
// echo '<br>'. $valid_mail;
			// Внесение в БД
			if ($valid_mail) {
				$this->db->insert('item', $data);
			}
			// Счетчик Удаленных заданий
			$counter[2] = $this->del_item($text_mail, $data['task']);
			// Удаление прочтеного письма
			// fputs($pop_conn, "DELE " . $i . "\r\n");
			// fgets($pop_conn);
		}
		// Счетчик новых писем
		$counter[1] = $mail_number_int;
		return $counter;
	}

	function del_item($text_mail, $task_id) {
		$n = 0;
	// Парсим строчки с удаленными копиями
		if (preg_match_all('/[0-9]{2}-[0-9]{2}-[0-9]{4} [0-9]{2}:[0-9]{2} Удаляемые файлы старых копий: [\:\(\)\-\;\$\s\w\.\\\\]+ ([0-9]{2}-[0-9]{2}-[0-9]{4} [0-9]{2};[0-9]{2};[0-9]{2})/u', $text_mail, $deleted)) {
	// Перебираем строки
			foreach ($deleted[1] as $item) {
				++$n;
	// Парсим Дату Месяц Год Час
				preg_match('/([0-9]{2})-([0-9]{2})-([0-9]{4}) ([0-9]{2});[0-9]{2};[0-9]{2}/u', $item, $deleted_date);
	// Дата - $deleted_date[1] 
	// Месяц - $deleted_date[2]
	// Год - $deleted_date[3]
	// Час - $deleted_date[4]
	// Обработка условия если задание до 8 утра на уменьшение индекса даты
				if ($deleted_date[4] < 9) {
					--$deleted_date[1];
				}
				$this->db->where('date', $deleted_date[3] . '-' . $deleted_date[2] . '-' . $deleted_date[1]);
				$this->db->where('task', $task_id);
				$this->db->delete('item');
			}
		}
		return $n;
	}

	function get_task() {
		$this->db->select('task.id');
		$this->db->select('task.description');
		$this->db->select('task.title AS task_title');
		$this->db->select('server.title AS server_title');
		$this->db->from('task');
		$this->db->join('server', 'task.server = server.id', 'left');
		$this->db->order_by('server.order_id', 'ASC');
		$this->db->order_by('task.order_id', 'ASC');
		$query = $this->db->get();
		return $query->result_array();
	}

	function get_item() {
		$this->db->select('item.id');
		$this->db->select('item.date');
		$this->db->select('item.task');
		$this->db->select('item.status');
	//$this->db->select('task.title AS task_title');
	//$this->db->select('server.title AS server_title');
		$this->db->from('item');
		$this->db->join('task', 'item.task = task.id');
	//$this->db->order_by('server.order_id', 'ASC');
		$query = $this->db->get();
		return $query->result_array();
	}

	function add_task($data) {
		$this->db->insert('task', $data);
		return $this->db->insert_id();
	}


}