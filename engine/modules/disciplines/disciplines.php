<?php

class Disciplines
{
	protected $db                 = null;
	protected $users              = null;
	
	public $id                    = null;
	public $teacher_id            = null;
	public $name                  = null;
	public $description           = null;
	public $literature            = null;
	public $teachers              = null;
	
	public $page                  = 0;
	public $discipline_list_limit = 10;
	public $discipline_list_count = 0;

	function __construct($db, $users) {
		$this->db     = $db;
		$this->users  = $users;
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
				case 'add_teachers':
					$this->handle_add_teachers_form();
					break;
				case 'delete_teacher':
					$this->handle_delete_teacher_form();
					break;
			}
		}
	}

	function get_discipline_list() {
		$this->page = max((int)$_GET['page'], 1);
		$offset     = ($this->page - 1) * $this->discipline_list_limit;

		$this->set_discipline_list_count();

		$stmt       = $this->db->prepare('SELECT * FROM discipline LIMIT ?, ?');

		$stmt->bind_param('ii', $offset, $this->discipline_list_limit);

		if (!$stmt->execute()) {
			throw new Exception('Не удалось получить список дисциплин.');
		}

		return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
	}

	function set_discipline_list_count() {
		$result = $this->db->query('SELECT COUNT(*) FROM discipline');
		$this->discipline_list_count = $result->fetch_array()[0];
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

		if (!array_key_exists('description', $_POST)) {
			throw new Exception('Пожалуйста, заполните поле "описание".');
		}

		$this->description = trim(htmlspecialchars($_POST['description']));
		$this->description = empty($this->description) ? null : $this->description;

		if (!array_key_exists('literature', $_POST)) {
			throw new Exception('Пожалуйста, заполните поле "литература".');
		}

		$this->literature = trim(htmlspecialchars($_POST['literature']));
		$this->literature = empty($this->literature) ? null : $this->literature;
	}

	function add() {
		$stmt = $this->db->prepare('INSERT INTO discipline(name, description, literature) VALUES(?, ?, ?)');
		$stmt->bind_param('sss', $this->name, $this->description, $this->literature);

		if (!$stmt->execute()) {
			throw new Exception('Не удалось добавить новую дисциплину.');
		}

		header('Location: /disciplines/index.php');
	}

	function get_discipline($id) {
		$stmt = $this->db->prepare('SELECT * FROM discipline WHERE id=?');
		$stmt->bind_param('i', $id);

		if (!$stmt->execute()) {
			throw new Exception('Не удалось получить данные дисциплины.');
		}

		$result = $stmt->get_result()->fetch_assoc();

		if (empty($result)) {
			throw new Exception('Дисциплины не существует.');
		}

		return $result;
	}

	function handle_edit_form() {
		$this->check_add_fields();
		$this->edit();
	}

	function edit() {
		$id         = max((int)$_GET['id'], 0);
		$discipline = $this->get_discipline($id);

		if (!$this->diff_fields($discipline)) {
			throw new Exception('Ничего не изменилось.');
		}

		$stmt = $this->db->prepare('UPDATE discipline SET name=?, description=?, literature=? WHERE id=?');
		$stmt->bind_param('sssi', $this->name, $this->description, $this->literature, $id);

		if (!$stmt->execute()) {
			throw new Exception('Не удалось сохранить данные.');
		}

		header('Location: /disciplines/index.php');
		die();
	}

	function diff_fields($user) {
		return ($user['name'] != $this->name) || ($user['description'] != $this->description) || ($user['literature'] != $this->literature);
	}

	function handle_delete_form() {
		$id         = max((int)$_GET['id'], 0);
		$discipline = $this->get_discipline($id);

		$stmt = $this->db->prepare('DELETE FROM discipline WHERE id=?');
		$stmt->bind_param('i', $discipline['id']);

		if (!$stmt->execute()) {
			throw new Exception('Не удалось удалить дисциплину.');
		}

		header('Location: /disciplines/index.php');
		die();
	}

	function handle_add_teachers_form() {
		$this->check_add_teachers_fields();
		$this->add_teachers();
	}

	function check_add_teachers_fields() {
		if (!array_key_exists('teachers', $_POST) || !is_array($_POST['teachers'])) {
			throw new Exception('Пожалуйста, выберите хотя-бы одного преподавателя.');
		}

		$this->teachers = array();

		foreach ($_POST['teachers'] as $teacher_id) {
			$this->teachers[] = max((int)$teacher_id, 0);
		}
	}

	function add_teachers() {
		$discipline_id   = max((int)$_GET['id'], 0);

		$stmt = $this->db->prepare('INSERT IGNORE INTO user_discipline(user_id, discipline_id) VALUES(?, ?)');
		$stmt->bind_param('ii', $teacher_id, $discipline_id);

		foreach ($this->teachers as $teacher_id) {
			if (!$stmt->execute()) {
				throw new Exception('Не удалось добавить преподавателей в дисциплину.');
			}
		}

		header('Location: /disciplines/teachers/index.php?id='.$discipline_id);
		die();
	}

	function handle_delete_teacher_form() {
		$this->check_delete_teacher_fields();
		$this->delete_teacher();
	}

	function check_delete_teacher_fields() {
		if (!array_key_exists('id', $_GET) || empty($_GET['id'])) {
			throw new Exception('Пожалуйста, выберите дисциплину.');
		}

		$this->id = max((int)$_GET['id'], 0);

		if (!array_key_exists('teacher_id', $_GET) || empty($_GET['teacher_id'])) {
			throw new Exception('Пожалуйста, выберите преподавателя.');
		}

		$this->teacher_id = max((int)$_GET['teacher_id'], 0);

		$this->users->get_teacher($this->teacher_id);
		$this->get_discipline($this->id);
	}

	function delete_teacher() {
		$stmt = $this->db->prepare('DELETE FROM user_discipline WHERE user_id=? AND discipline_id=?');
		$stmt->bind_param('ii', $this->teacher_id, $this->id);

		if (!$stmt->execute()) {
			throw new Exception('Не удалось удалить преподавателя из дисциплины.');
		}

		header('Location: /disciplines/teachers/index.php?id='.$this->id);
		die();
	}
}

?>