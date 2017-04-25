<?php

class Groups
{
	protected $db            = null;
	protected $users         = null;
	
	public $name             = null;
	public $students         = null;
	
	public $page             = 0;
	public $group_list_limit = 20;
	public $group_list_count = 0;

	function __construct($db, $users) {
		$this->db    = $db;
		$this->users = $users;
	}

	function handle_actions() {
		if (array_key_exists('action', $_POST)) {
			switch ($_POST['action']) {
				case 'add':
					$this->handle_add_form();
					break;
				case 'edit':
					$this->handle_edit_form();
					break;
				case 'delete':
					$this->handle_delete_form();
					break;
				case 'add_students':
					$this->handle_add_students_form();
					break;
				case 'delete_student':
					$this->handle_delete_student_form();
					break;
			}
		}
	}

	function get_group_list() {
		$this->page = max((int)$_GET['page'], 1);
		$offset     = ($this->page - 1) * $this->group_list_limit;

		$this->set_group_list_count();

		$stmt       = $this->db->prepare('SELECT * FROM `group` LIMIT ?, ?');

		$stmt->bind_param('ii', $offset, $this->group_list_limit);

		if (!$stmt->execute()) {
			throw new Exception('Не удалось получить список групп.');
		}

		return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
	}

	function set_group_list_count() {
		$result                 = $this->db->query('SELECT COUNT(*) FROM `group`');
		$this->group_list_count = $result->fetch_array()[0];
	}

	function handle_add_form() {
		$this->check_add_fields();
		$this->add();
	}

	function check_add_fields() {
		if (!array_key_exists('name', $_POST) || empty($_POST['name'])) {
			throw new Exception('Пожалуйста, заполните поле "название".');
		}

		$this->name = trim(htmlspecialchars($_POST['name']));
	}

	function add() {
		$stmt = $this->db->prepare('INSERT INTO `group`(name) VALUES(?)');
		$stmt->bind_param('s', $this->name);

		if (!$stmt->execute()) {
			throw new Exception('Не удалось добавить новую группу.');
		}

		header('Location: /groups/index.php');
	}

	function get_group($id) {
		$stmt = $this->db->prepare('SELECT * FROM `group` WHERE id=?');
		$stmt->bind_param('i', $id);

		if (!$stmt->execute()) {
			throw new Exception('Не удалось получить данные группы.');
		}

		$result = $stmt->get_result()->fetch_assoc();

		if (empty($result)) {
			throw new Exception('Группы не существует.');
		}

		return $result;
	}

	function handle_edit_form() {
		$this->check_add_fields();
		$this->edit();
	}

	function edit() {
		$id    = max((int)$_GET['id'], 0);
		$group = $this->get_group($id);

		if (!$this->diff_fields($group)) {
			throw new Exception('Ничего не изменилось.');
		}

		$stmt = $this->db->prepare('UPDATE `group` SET name=? WHERE id=?');
		$stmt->bind_param('si', $this->name, $id);

		if (!$stmt->execute()) {
			throw new Exception('Не удалось сохранить данные.');
		}

		header('Location: /groups/index.php');
		die();
	}

	function diff_fields($group) {
		return ($user['name'] != $this->name);
	}

	function handle_delete_form() {
		$id    = max((int)$_GET['id'], 0);
		$group = $this->get_group($id);

		$stmt = $this->db->prepare('DELETE FROM `group` WHERE id=?');
		$stmt->bind_param('i', $group['id']);

		if (!$stmt->execute()) {
			throw new Exception('Не удалось удалить группу.');
		}

		header('Location: /groups/index.php');
		die();
	}

	function handle_add_students_form() {
		$this->check_add_students_fields();
		$this->add_students();
	}

	function check_add_students_fields() {
		if (!array_key_exists('students', $_POST) || !is_array($_POST['students'])) {
			throw new Exception('Пожалуйста, выберите хотя-бы одного студента.');
		}

		$this->students = array();

		foreach ($_POST['students'] as $student_id) {
			$this->students[] = max((int)$student_id, 0);
		}
	}

	function add_students() {
		$group_id = max((int)$_GET['id'], 0);

		$stmt = $this->db->prepare('INSERT IGNORE INTO user_group(user_id, group_id) VALUES(?, ?)');
		$stmt->bind_param('ii', $student_id, $group_id);

		foreach ($this->students as $student_id) {
			if (!$stmt->execute()) {
				throw new Exception('Не удалось добавить студентов в группу.');
			}
		}

		header('Location: /groups/students/index.php?id='.$group_id);
		die();
	}

	function handle_delete_student_form() {
		$this->check_delete_student_fields();
		$this->delete_student();
	}

	function check_delete_student_fields() {
		if (!array_key_exists('id', $_GET) || empty($_GET['id'])) {
			throw new Exception('Пожалуйста, выберите группу.');
		}

		$this->id = max((int)$_GET['id'], 0);

		if (!array_key_exists('student_id', $_GET) || empty($_GET['student_id'])) {
			throw new Exception('Пожалуйста, выберите студента.');
		}

		$this->student_id = max((int)$_GET['student_id'], 0);

		$this->users->get_student($this->student_id);
		$this->get_group($this->id);
	}

	function delete_student() {
		$stmt = $this->db->prepare('DELETE FROM user_group WHERE user_id=? AND group_id=?');
		$stmt->bind_param('ii', $this->student_id, $this->id);

		if (!$stmt->execute()) {
			throw new Exception('Не удалось удалить студента из группы.');
		}

		header('Location: /groups/students/index.php?id='.$this->id);
		die();
	}
}

?>