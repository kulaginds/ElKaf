<?php

class Auth
{
	protected $smarty    = null;
	protected $db        = null;
	protected $auth_salt = null;
	
	protected $name      = null;
	protected $password  = null;

	function __construct($smarty, $db, $auth_salt) {
		$this->smarty    = $smarty;
		$this->db        = $db;
		$this->auth_salt = $auth_salt;

		session_start();
	}

	function handle_actions() {
		if (!$this->is_auth()) {
			if (array_key_exists('action', $_POST) && $_POST['action'] == 'login') {
				$this->handle_auth_form();
			}
		} else {
			$this->smarty->assign('user', $_SESSION['user']);
			if (array_key_exists('action', $_GET) && $_GET['action'] == 'logout') {
				$this->logout();
			}
		}
	}

	function is_auth() {
		return array_key_exists('user', $_SESSION) && !empty($_SESSION['user']);
	}

	function get_user() {
		return $this->is_auth() ? $_SESSION['user'] : null;
	}

	function handle_auth_form() {
		$this->check_fields();
		$this->try_login();
	}

	function check_fields() {
		if (!array_key_exists('name', $_POST) || empty($_POST['name'])) {
			throw new Exception('Пожалуйста, заполните поле "ФИО".');
		}

		$this->name = trim(htmlspecialchars($_POST['name']));

		$this->smarty->assign('name', $this->name);

		if (!array_key_exists('password', $_POST) || empty($_POST['password'])) {
			throw new Exception('Пожалуйста, заполните поле "Пароль".');
		}

		$this->password = trim(htmlspecialchars($_POST['password']));

		$this->smarty->assign('password', $this->password);
	}

	function try_login() {
		$name          = $this->name;
		$password_hash = md5($this->auth_salt.$this->password);
		$stmt          = $this->db->prepare('SELECT * FROM user WHERE name=?');

		$stmt->bind_param('s', $name);

		if (!$stmt->execute()) {
			throw new Exception('Не удалось войти.');
		}

		$result = $stmt->get_result()->fetch_assoc();

		if (empty($result)) {
			throw new Exception('Пользователя не существует.');
		}

		if ($result['password_hash'] !== $password_hash) {
			throw new Exception('Неверный пароль.');
		}

		$this->auth($result);
	}

	function auth($user) {
		$_SESSION['user'] = $user;

		$this->smarty->assign('user', $_SESSION['user']);
	}

	function logout() {
		session_destroy();
		header('Location: /index.php');
	}
}

?>