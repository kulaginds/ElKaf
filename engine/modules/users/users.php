<?php

class Users
{
	protected $db            = null;
	protected $smarty        = null;
	protected $user_types    = null;
	protected $auth_salt     = null;
	
	public $name             = null;
	public $type             = null;
	public $description      = null;
	public $password         = null;
	public $password_confirm = null;
	
	public $page             = 0;
	public $user_list_limit  = 10;
	public $user_list_count  = 0;

	function __construct($db, $smarty, $user_types, $auth_salt) {
		$this->db         = $db;
		$this->smarty     = $smarty;
		$this->user_types = $user_types;
		$this->auth_salt  = $auth_salt;
	}

	function handle_actions() {
		if (array_key_exists('action', $_POST)) {
			switch ($_POST['action']) {
				case 'password':
					$this->handle_password_form();
					break;
				case 'edit':
					$this->handle_edit_form();
					break;
				case 'delete':
					$this->handle_delete_form();
					break;
				case 'add':
					$this->handle_add_form();
					break;
			}
		}
	}

	function get_user_list() {
		$this->page = max((int)$_GET['page'], 1);
		$offset     = ($this->page - 1) * $this->user_list_limit;

		$this->set_user_list_count();

		$stmt       = $this->db->prepare('SELECT * FROM user LIMIT ?, ?');

		$stmt->bind_param('ii', $offset, $this->user_list_limit);

		if (!$stmt->execute()) {
			throw new Exception('Не удалось получить список пользователей.');
		}

		return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
	}

	function get_teachers_not_in_discipline($discipline_id) {
		$stmt = $this->db->prepare('SELECT * FROM user WHERE id NOT IN (SELECT user_id FROM user_discipline WHERE discipline_id=?) AND type=\'teacher\' ORDER BY name ASC');
		$stmt->bind_param('i', $discipline_id);

		if (!$stmt->execute()) {
			throw new Exception('Не удалось получить список преподавателей не ведущих дисциплину.');
		}

		return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
	}

	function get_teachers_in_discipline($discipline_id) {
		$stmt = $this->db->prepare('SELECT user.* FROM user_discipline JOIN user ON user_discipline.user_id=user.id WHERE user_discipline.discipline_id=? ORDER BY name ASC');
		$stmt->bind_param('i', $discipline_id);

		if (!$stmt->execute()) {
			throw new Exception('Не удалось получить список преподавателей дисциплины.');
		}

		return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
	}

	function get_authors_in_document($document_id) {
		$stmt = $this->db->prepare('SELECT user.* FROM user_document JOIN user ON user_document.user_id=user.id WHERE user_document.document_id=? ORDER BY name ASC');
		$stmt->bind_param('i', $document_id);

		if (!$stmt->execute()) {
			throw new Exception('Не удалось получить список авторов документа.');
		}

		return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
	}

	function get_authors_not_in_document($document_id) {
		$stmt = $this->db->prepare('SELECT * FROM user WHERE id NOT IN (SELECT user_id FROM user_document WHERE document_id=?) AND type=\'teacher\' ORDER BY name ASC');
		$stmt->bind_param('i', $document_id);

		if (!$stmt->execute()) {
			throw new Exception('Не удалось получить список авторов не создававших документ.');
		}

		return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
	}

	function get_teacher_list() {
		$stmt = $this->db->prepare('SELECT user.* FROM user_discipline JOIN user ON user_discipline.user_id=user.id ORDER BY name ASC');
		$stmt->bind_param('i', $discipline_id);

		if (!$stmt->execute()) {
			throw new Exception('Не удалось получить список преподавателей.');
		}

		return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
	}

	function get_students_in_group($group_id) {
		$stmt = $this->db->prepare('SELECT user.* FROM user_group JOIN user ON user_group.user_id=user.id WHERE user_group.group_id=? ORDER BY name ASC');
		$stmt->bind_param('i', $group_id);

		if (!$stmt->execute()) {
			throw new Exception('Не удалось получить список студентов группы.');
		}

		return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
	}

	function get_students_not_in_group($group_id) {
		$stmt = $this->db->prepare('SELECT * FROM user WHERE id NOT IN (SELECT DISTINCT user_id FROM user_group WHERE group_id=?) AND type=\'student\' ORDER BY name ASC');
		$stmt->bind_param('i', $group_id);

		if (!$stmt->execute()) {
			throw new Exception('Не удалось получить список студентов без группы.');
		}

		return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
	}

	function set_user_list_count() {
		$result = $this->db->query('SELECT COUNT(*) FROM user');
		$this->user_list_count = $result->fetch_array()[0];
	}

	function get_user($id) {
		$stmt = $this->db->prepare('SELECT * FROM user WHERE id=?');
		$stmt->bind_param('i', $id);

		if (!$stmt->execute()) {
			throw new Exception('Не удалось получить данные пользователя.');
		}

		$result = $stmt->get_result()->fetch_assoc();

		if (empty($result)) {
			throw new Exception('Пользователя не существует.');
		}

		return $result;
	}

	function get_teacher($id) {
		$stmt = $this->db->prepare('SELECT * FROM user WHERE id=? AND type=\'teacher\'');
		$stmt->bind_param('i', $id);

		if (!$stmt->execute()) {
			throw new Exception('Не удалось получить данные преподавателя.');
		}

		$result = $stmt->get_result()->fetch_assoc();

		if (empty($result)) {
			throw new Exception('Преподавателя не существует.');
		}

		return $result;
	}

	function get_author($id) {
		$stmt = $this->db->prepare('SELECT * FROM user WHERE id=? AND type=\'teacher\'');
		$stmt->bind_param('i', $id);

		if (!$stmt->execute()) {
			throw new Exception('Не удалось получить данные автора.');
		}

		$result = $stmt->get_result()->fetch_assoc();

		if (empty($result)) {
			throw new Exception('Автора не существует.');
		}

		return $result;
	}

	function get_student($id) {
		$stmt = $this->db->prepare('SELECT * FROM user WHERE id=? AND type=\'student\'');
		$stmt->bind_param('i', $id);

		if (!$stmt->execute()) {
			throw new Exception('Не удалось получить данные студента.');
		}

		$result = $stmt->get_result()->fetch_assoc();

		if (empty($result)) {
			throw new Exception('Студента не существует.');
		}

		return $result;
	}

	function handle_password_form() {
		$this->check_password_fields();
		$this->password();
	}

	function check_password_fields() {
		if (!array_key_exists('password', $_POST) || empty($_POST['password'])) {
			throw new Exception('Пожалуйста, заполните поле "пароль".');
		}

		$this->password = trim(htmlspecialchars($_POST['password']));

		if (!array_key_exists('password_confirm', $_POST) || empty($_POST['password_confirm'])) {
			throw new Exception('Пожалуйста, заполните поле "повтор пароля".');
		}

		$this->password_confirm = trim(htmlspecialchars($_POST['password_confirm']));

		if ($this->password != $this->password_confirm) {
			throw new Exception('Пароль и повтор пароля не одинаковые.');
		}
	}

	function password() {
		$id            = max((int)$_GET['id'], 0);
		$user          = $this->get_user($id);
		$password_hash = md5($this->auth_salt.$this->password);

		$stmt = $this->db->prepare('UPDATE user SET password_hash=? WHERE id=?');
		$stmt->bind_param('si', $password_hash, $id);

		if (!$stmt->execute()) {
			throw new Exception('Не удалось установить новый пароль.');
		}

		header('Location: /administration/users/index.php');
		die();
	}

	function handle_edit_form() {
		$this->check_edit_fields();
		$this->edit();
	}

	function check_edit_fields() {
		if (!array_key_exists('name', $_POST) || empty($_POST['name'])) {
			throw new Exception('Пожалуйста, заполните поле "ФИО".');
		}

		$this->name = trim(htmlspecialchars($_POST['name']));

		if (!array_key_exists('type', $_POST) || empty($_POST['type']) || !in_array($_POST['type'], array_keys($this->user_types))) {
			throw new Exception('Пожалуйста, заполните поле "тип".');
		}

		$this->type = trim(htmlspecialchars($_POST['type']));

		if (!array_key_exists('description', $_POST)) {
			throw new Exception('Пожалуйста, заполните поле "описание".');
		}

		$this->description = trim(htmlspecialchars($_POST['description']));
		$this->description = empty($this->description) ? null : $this->description;
	}

	function edit() {
		$id   = max((int)$_GET['id'], 0);
		$user = $this->get_user($id);

		if (!$this->diff_fields($user)) {
			throw new Exception('Ничего не изменилось.');
		}

		$stmt = $this->db->prepare('UPDATE user SET name=?, type=?, description=? WHERE id=?');
		$stmt->bind_param('sssi', $this->name, $this->type, $this->description, $id);

		if (!$stmt->execute()) {
			throw new Exception('Не удалось сохранить данные.');
		}

		header('Location: /administration/users/index.php');
		die();
	}

	function diff_fields($user) {
		return ($user['name'] != $this->name) || ($user['type'] != $this->type) || ($user['description'] != $this->description);
	}

	function handle_delete_form() {
		$id   = max((int)$_GET['id'], 0);
		$user = $this->get_user($id);

		$stmt = $this->db->prepare('DELETE FROM user WHERE id=?');
		$stmt->bind_param('i', $user['id']);

		if (!$stmt->execute()) {
			throw new Exception('Не удалось удалить пользователя.');
		}

		header('Location: /administration/users/index.php');
		die();
	}

	function handle_add_form() {
		$this->check_add_fields();
		$this->add();
	}

	function check_add_fields() {
		$this->check_edit_fields();
		$this->check_password_fields();
	}

	function add() {
		$password_hash = md5($this->auth_salt.$this->password);

		$stmt = $this->db->prepare('INSERT INTO user(name, password_hash, type, description) VALUES(?, ?, ?, ?)');
		$stmt->bind_param('ssss', $this->name, $password_hash, $this->type, $this->description);

		if (!$stmt->execute()) {
			throw new Exception('Не удалось добавить нового пользователя.');
		}

		header('Location: /administration/users/index.php');
		die();
	}
}

?>