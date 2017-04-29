<?php

class Documents
{
	protected $db               = null;
	protected $auth             = null;
	protected $users            = null;
	protected $disciplines      = null;
	protected $allowed_types    = null;
	protected $upload_dir       = null;
	
	public $id                  = null;
	public $file                = null;
	public $discipline          = null;
	public $authors             = null;
	
	public $page                = 0;
	public $document_list_limit = 20;
	public $document_list_count = 0;

	function __construct($db, $auth, $users, $disciplines, $allowed_types, $upload_dir) {
		$this->db            = $db;
		$this->auth          = $auth;
		$this->users         = $users;
		$this->disciplines   = $disciplines;
		$this->allowed_types = $allowed_types;
		$this->upload_dir    = $upload_dir;

		if (!is_dir($this->upload_dir)) {
			mkdir($this->upload_dir);
		}
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
				case 'add_authors':
					$this->handle_add_authors_form();
					break;
				case 'delete_author':
					$this->handle_delete_author_form();
					break;
			}
		}
	}

	function get_document_list() {
		$this->page = max((int)$_GET['page'], 1);
		$offset     = ($this->page - 1) * $this->document_list_limit;

		$this->set_document_list_count();

		$stmt       = $this->db->prepare('SELECT document.*, discipline.name AS discipline FROM document JOIN discipline ON discipline.id=document.discipline_id ORDER BY document.name ASC LIMIT ?, ?');

		$stmt->bind_param('ii', $offset, $this->document_list_limit);

		if (!$stmt->execute()) {
			throw new Exception('Не удалось получить список документов.');
		}

		return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
	}

	function set_document_list_count() {
		$result                    = $this->db->query('SELECT COUNT(*) FROM document');
		$this->document_list_count = $result->fetch_array()[0];
	}

	function get_teacher_document_list($teacher_id) {
		$this->page = max((int)$_GET['page'], 1);
		$offset     = ($this->page - 1) * $this->document_list_limit;

		$this->set_teacher_document_list_count($teacher_id);

		$stmt       = $this->db->prepare('SELECT document.*, discipline.name AS discipline FROM (user_document JOIN document ON document.id=user_document.document_id) JOIN discipline ON discipline.id=document.discipline_id WHERE user_document.user_id=? ORDER BY name ASC LIMIT ?, ?');

		$stmt->bind_param('iii', $teacher_id, $offset, $this->document_list_limit);

		if (!$stmt->execute()) {
			throw new Exception('Не удалось получить список документов преподавателя.');
		}

		return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
	}

	function set_teacher_document_list_count($teacher_id) {
		$stmt = $this->db->prepare('SELECT COUNT(*) FROM (user_document JOIN document ON document.id=user_document.document_id) JOIN discipline ON discipline.id=document.discipline_id WHERE user_document.user_id=?');
		$stmt->bind_param('i', $teacher_id);

		if (!$stmt->execute()) {
			throw new Exception('Не удалось получить количество документов преподавателя.');
		}

		$result = $stmt->get_result();

		$this->document_list_count = $result->fetch_array()[0];
	}

	function get_discipline_document_list($discipline_id) {
		$this->page = max((int)$_GET['page'], 1);
		$offset     = ($this->page - 1) * $this->document_list_limit;

		$this->set_teacher_document_list_count($discipline_id);

		$stmt       = $this->db->prepare('SELECT document.*, user.name AS author, user.id AS author_id FROM ((user_document JOIN document ON document.id=user_document.document_id) JOIN discipline ON discipline.id=document.discipline_id) JOIN user ON user.id=user_document.user_id WHERE document.discipline_id = ? ORDER BY name ASC LIMIT ?, ?');

		$stmt->bind_param('iii', $discipline_id, $offset, $this->document_list_limit);

		if (!$stmt->execute()) {
			throw new Exception('Не удалось получить список документов дисциплины.');
		}

		return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
	}

	function set_discipline_document_list_count($discipline_id) {
		$stmt = $this->db->prepare('SELECT COUNT(*) FROM ((user_document JOIN document ON document.id=user_document.document_id) JOIN discipline ON discipline.id=document.discipline_id) JOIN user ON user.id=user_document.user_id WHERE document.discipline_id = ?');
		$stmt->bind_param('i', $discipline_id);

		if (!$stmt->execute()) {
			throw new Exception('Не удалось получить количество документов дисциплины.');
		}

		$result = $stmt->get_result();

		$this->document_list_count = $result->fetch_array()[0];
	}

	function get_document($id) {
		$stmt = $this->db->prepare('SELECT * FROM document WHERE id=?');
		$stmt->bind_param('i', $id);

		if (!$stmt->execute()) {
			throw new Exception('Не удалось получить информацию о документе.');
		}

		$result = $stmt->get_result()->fetch_assoc();

		if (empty($result)) {
			throw new Exception('Документа не существует.');
		}

		return $result;
	}

	function get_teacher_document($teacher_id, $document_id) {
		$stmt = $this->db->prepare('SELECT document.* FROM `user_document` JOIN document ON document.id=user_document.document_id WHERE user_document.user_id=? AND user_document.document_id=?');
		$stmt->bind_param('ii', $teacher_id, $document_id);

		if (!$stmt->execute()) {
			throw new Exception('Не удалось получить информацию о документе преподавателя.');
		}

		$result = $stmt->get_result()->fetch_assoc();

		if (empty($result)) {
			throw new Exception('Документа не существует либо вы не являетесь автором.');
		}

		return $result;
	}

	function handle_add_form() {
		$this->check_add_fields();
		$this->add();
	}

	function check_add_fields() {
		if (!array_key_exists('file', $_FILES) || empty($_FILES['file'])) {
			throw new Exception('Пожалуйста, заполните поле "файл".');
		}

		if (!in_array($_FILES['file']['type'], array_values($this->allowed_types))) {
			throw new Exception('Неверный формат файла.');
		}

		$this->file = $_FILES['file'];

		$this->check_edit_fields();
	}

	function add() {
		list($url, $name, $size) = $this->upload_file();

		$stmt = $this->db->prepare('INSERT INTO document(discipline_id, url, name, size) VALUES(?, ?, ?, ?)');
		$stmt->bind_param('issi', $this->discipline, $url, $name, $size);

		if (!$stmt->execute()) {
			throw new Exception('Не удалось загрузить документ.');
		}

		if ($this->auth->get_user()['type'] == 'teacher') {
			$this->authors[] = $this->auth->get_user()['id'];
			$this->id        = $stmt->insert_id;

			$this->add_authors();
		} else {
			header('Location: /administration/documents/index.php');
			die();
		}
	}

	function upload_file() {
		$tmp_name    = $this->file['tmp_name'];
		$url         = md5($tmp_name);
		$name        = basename($this->file['name']);
		$size        = $this->file['size'];
		$upload_file = $this->upload_dir.$url;

		if (!move_uploaded_file($tmp_name, $upload_file)) {
			throw new Exception('Не удалось переместить файл из временной папки.');
		}

		return array($url, $name, $size);
	}

	function download_file($id) {
		$document = $this->get_document($id);
		$file     = $this->upload_dir.$document['url'];

		if (!file_exists($file)) {
			throw new Exception('Файла не существует.');
		}

		header('Content-Description: File Transfer');
		header('Content-Type: application/octet-stream');
		header('Content-Disposition: attachment; filename="'.$document['name'].'"');
		header('Expires: 0');
		header('Cache-Control: must-revalidate');
		header('Pragma: public');
		header('Content-Length: '.$document['size']);
		readfile($file);
		die();
	}

	function delete_file($url) {
		$file = $this->upload_dir.$url;

		if (!file_exists($file)) {
			throw new Exception('Файла не существует.');
		}

		unlink($file);
	}

	function handle_edit_form() {
		$this->check_edit_fields();
		$this->edit();
	}

	function check_edit_fields() {
		if (!array_key_exists('discipline', $_POST) || empty($_POST['discipline'])) {
			throw new Exception('Пожалуйста, заполните поле "дисциплина".');
		}

		$this->discipline = (int)trim(htmlspecialchars($_POST['discipline']));

		$this->disciplines->get_discipline($this->discipline);
	}

	function edit() {
		$id       = max((int)$_GET['id'], 0);
		$document = $this->get_document($id);

		if (!$this->diff_fields($document)) {
			throw new Exception('Ничего не изменилось.');
		}

		$stmt = $this->db->prepare('UPDATE document SET discipline_id=? WHERE id=?');
		$stmt->bind_param('ii', $this->discipline, $id);

		if (!$stmt->execute()) {
			throw new Exception('Не удалось сохранить данные.');
		}

		if ($this->auth->get_user()['type'] == 'teacher') {
			header('Location: /teaching/documents/index.php');
		} else {
			header('Location: /administration/documents/index.php');
		}

		die();
	}

	function diff_fields($document) {
		return ($discipline['discipline_id'] != $this->discipline);
	}

	function handle_delete_form() {
		$id       = max((int)$_GET['id'], 0);
		$document = $this->get_document($id);

		$stmt = $this->db->prepare('DELETE FROM document WHERE id=?');
		$stmt->bind_param('i', $document['id']);

		if (!$stmt->execute()) {
			throw new Exception('Не удалось удалить документ.');
		}

		$this->delete_file($document['url']);

		if ($this->auth->get_user()['type'] == 'teacher') {
			header('Location: /teaching/documents/index.php');
		} else {
			header('Location: /administration/documents/index.php');
		}
		
		die();
	}

	function handle_add_authors_form() {
		$this->check_add_authors_fields();
		$this->add_authors();
	}

	function check_add_authors_fields() {
		if (!array_key_exists('authors', $_POST) || !is_array($_POST['authors'])) {
			throw new Exception('Пожалуйста, выберите хотя-бы одного автора.');
		}

		$this->authors = array();

		foreach ($_POST['authors'] as $author_id) {
			$this->authors[] = max((int)$author_id, 0);
		}
	}

	function add_authors() {
		if (!empty($this->id)) {
			$document_id = $this->id;
		} else {
			$document_id = max((int)$_GET['id'], 0);
		}

		$stmt = $this->db->prepare('INSERT IGNORE INTO user_document(user_id, document_id) VALUES(?, ?)');
		$stmt->bind_param('ii', $author_id, $document_id);

		foreach ($this->authors as $author_id) {
			if (!$stmt->execute()) {
				throw new Exception('Не удалось добавить авторов к документу.');
			}
		}

		if (!empty($this->id)) {
			header('Location: /teaching/documents/index.php');
		} else {
			header('Location: /administration/documents/authors/index.php?id='.$document_id);
		}

		die();
	}

	function handle_delete_author_form() {
		$this->check_delete_author_fields();
		$this->delete_author();
	}

	function check_delete_author_fields() {
		if (!array_key_exists('id', $_GET) || empty($_GET['id'])) {
			throw new Exception('Пожалуйста, выберите документ.');
		}

		$this->id = max((int)$_GET['id'], 0);

		$this->get_document($this->id);

		if (!array_key_exists('author_id', $_GET) || empty($_GET['author_id'])) {
			throw new Exception('Пожалуйста, выберите автора.');
		}

		$this->author_id = max((int)$_GET['author_id'], 0);

		$this->users->get_author($this->author_id);
	}

	function delete_author() {
		$stmt = $this->db->prepare('DELETE FROM user_document WHERE user_id=? AND document_id=?');
		$stmt->bind_param('ii', $this->author_id, $this->id);

		if (!$stmt->execute()) {
			throw new Exception('Не удалось удалить автора из документа.');
		}

		header('Location: /administration/documents/authors/index.php?id='.$this->id);
		die();
	}
}

?>