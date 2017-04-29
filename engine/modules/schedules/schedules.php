<?php

class Schedules
{
	protected $db               = null;
	protected $users            = null;
	protected $groups           = null;
	protected $disciplines      = null;
	protected $weekdays         = null;
	protected $couples          = null;
	
	public $name                = null;
	public $group               = null;
	public $discipline          = null;
	public $teacher             = null;
	public $auditory            = null;
	
	public $page                = 0;
	public $schedule_list_limit = 10;
	public $schedule_list_count = 0;

	function __construct($db, $users, $groups, $disciplines, $weekdays, $couples) {
		$this->db          = $db;
		$this->users       = $users;
		$this->groups      = $groups;
		$this->disciplines = $disciplines;
		$this->weekdays    = $weekdays;
		$this->couples     = $couples;
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
				case 'add_couple':
					$this->handle_add_couple_form();
					break;
				case 'edit_couple':
					$this->handle_edit_couple_form();
					break;
				case 'delete_couple':
					$this->handle_delete_couple_form();
					break;
			}
		}
	}

	function get_schedule_list() {
		$this->page = max((int)$_GET['page'], 1);
		$offset     = ($this->page - 1) * $this->schedule_list_limit;

		$this->set_schedule_list_count();

		$stmt       = $this->db->prepare('SELECT schedule.*, `group`.`name` AS `group` FROM schedule JOIN `group` ON `group`.`id`=schedule.group_id LIMIT ?, ?');

		$stmt->bind_param('ii', $offset, $this->schedule_list_limit);

		if (!$stmt->execute()) {
			throw new Exception('Не удалось получить список расписаний.');
		}

		return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
	}

	function set_schedule_list_count() {
		$result                    = $this->db->query('SELECT COUNT(*) FROM `schedule`');
		$this->schedule_list_count = $result->fetch_array()[0];
	}

	function handle_add_form() {
		$this->check_add_fields();
		$this->add();
	}

	function check_add_fields() {
		if (!array_key_exists('name', $_POST) || empty($_POST['name'])) {
			throw new Exception('Пожалуйста, заполните поле "название".');
		}

		$this->name  = trim(htmlspecialchars($_POST['name']));

		if (!array_key_exists('group', $_POST) || empty($_POST['group'])) {
			throw new Exception('Пожалуйста, заполните поле "группа".');
		}

		$this->group = (int)trim(htmlspecialchars($_POST['group']));

		$this->groups->get_group($this->group);
	}

	function add() {
		try {
			$stmt = $this->db->prepare('INSERT INTO schedule(name, group_id) VALUES(?, ?)');
			$stmt->bind_param('si', $this->name, $this->group);

			if (!$stmt->execute()) {
				throw new Exception('Не удалось добавить новое расписание.');
			}
		} catch (mysqli_sql_exception $e) {
			if (false !== strpos($e->getMessage(), 'Duplicate entry')) {
				throw new Exception('Для одной группы можно добавить не более 1 расписания.');
			} else {
				throw new Exception('Не удалось добавить новое расписание.');
			}
		}

		header('Location: /administration/schedules/index.php');
	}

	function get_schedule($id) {
		$stmt = $this->db->prepare('SELECT * FROM schedule WHERE id=?');
		$stmt->bind_param('i', $id);

		if (!$stmt->execute()) {
			throw new Exception('Не удалось получить данные расписания.');
		}

		$result = $stmt->get_result()->fetch_assoc();

		if (empty($result)) {
			throw new Exception('Расписания не существует.');
		}

		return $result;
	}

	function get_student_schedule($student_id) {
		$stmt = $this->db->prepare('SELECT schedule.* FROM user_group JOIN schedule ON schedule.group_id=user_group.group_id WHERE user_group.user_id = ?');
		$stmt->bind_param('i', $student_id);

		if (!$stmt->execute()) {
			throw new Exception('Не удалось получить данные расписания студента.');
		}

		$result = $stmt->get_result()->fetch_assoc();

		if (empty($result)) {
			throw new Exception('Расписания не существует.');
		}

		return $result;
	}

	function get_couple($id) {
		$stmt = $this->db->prepare('SELECT * FROM couple WHERE id=?');
		$stmt->bind_param('i', $id);

		if (!$stmt->execute()) {
			throw new Exception('Не удалось получить данные пары.');
		}

		$result = $stmt->get_result()->fetch_assoc();

		if (empty($result)) {
			throw new Exception('Пары не существует.');
		}

		return $result;
	}

	function handle_edit_form() {
		$this->check_add_fields();
		$this->edit();
	}

	function edit() {
		$id       = max((int)$_GET['id'], 0);
		$schedule = $this->get_schedule($id);

		if (!$this->diff_fields($schedule)) {
			throw new Exception('Ничего не изменилось.');
		}

		$stmt = $this->db->prepare('UPDATE schedule SET name=?, group_id=? WHERE id=?');
		$stmt->bind_param('sii', $this->name, $this->group, $id);

		if (!$stmt->execute()) {
			throw new Exception('Не удалось сохранить данные.');
		}

		header('Location: /administration/schedules/index.php');
		die();
	}

	function diff_fields($schedule) {
		return ($schedule['name'] != $this->name) || ($schedule['group_id'] != $this->group);
	}

	function handle_delete_form() {
		$id    = max((int)$_GET['id'], 0);
		$schedule = $this->get_schedule($id);

		$stmt = $this->db->prepare('DELETE FROM schedule WHERE id=?');
		$stmt->bind_param('i', $schedule['id']);

		if (!$stmt->execute()) {
			throw new Exception('Не удалось удалить расписание.');
		}

		header('Location: /administration/schedules/index.php');
		die();
	}

	function get_couple_weekday_list($schedule_id, $week) {
		$week_couple_list    = $this->get_week_couple_list($schedule_id, $week);
		$couple_weekday_list = $this->transpose_list($week_couple_list);

		return $couple_weekday_list;
	}

	function get_week_couple_list($schedule_id, $week) {
		$stmt = $this->db->prepare('SELECT couple.*, discipline.name AS discipline, discipline.id AS discipline_id, user.name AS teacher, user.id AS teacher_id FROM (couple JOIN discipline ON discipline.id=couple.discipline_id) JOIN user ON user.id=couple.user_id WHERE schedule_id=? AND week=?');
		$stmt->bind_param('is', $schedule_id, $week);

		if (!$stmt->execute()) {
			throw new Exception('Не удалось получить список пар у расписания.');
		}

		return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
	}

	function transpose_list($week_couple_list) {
		$couple_weekday_list = array();

		for ($i=0; $i<count($this->couples); $i++) {
			$tmp = array();

			for ($j=0; $j<count($this->weekdays); $j++) {
				$tmp[] = array();
			}

			$couple_weekday_list[] = $tmp;
		}

		foreach ($week_couple_list as $couple) {
			$i = $couple['couple_index'];
			$j = $couple['weekday_index'];

			$couple_weekday_list[$i][$j] = $couple;
		}

		return $couple_weekday_list;
	}

	function get_couple_list($schedule_id, $week, $weekday_index) {
		$weekday_couple_list = $this->get_weekday_couple_list($schedule_id, $week, $weekday_index);
		$couple_list         = array();

		for ($i=0; $i<count($this->couples); $i++) {
			$couple_list[] = null;
		}

		foreach ($weekday_couple_list as $couple) {
			$i = $couple['couple_index'];

			$couple_list[$i] = $couple;
		}

		return $couple_list;
	}

	function get_weekday_couple_list($schedule_id, $week, $weekday_index) {
		$stmt = $this->db->prepare('SELECT couple.*, discipline.name AS discipline, user.name AS teacher FROM (couple JOIN discipline ON discipline.id=couple.discipline_id) JOIN user ON user.id=couple.user_id WHERE schedule_id=? AND week=? AND weekday_index=? ORDER BY couple_index ASC');
		$stmt->bind_param('isi', $schedule_id, $week, $weekday_index);

		if (!$stmt->execute()) {
			throw new Exception('Не удалось получить список пар у дня расписания.');
		}

		return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
	}

	function get_teacher_couple_weekday_list($teacher_id, $week) {
		$week_couple_list    = $this->get_teacher_week_couple_list($teacher_id, $week);
		$couple_weekday_list = $this->transpose_list($week_couple_list);

		return $couple_weekday_list;
	}

	function get_teacher_week_couple_list($teacher_id, $week) {
		$stmt = $this->db->prepare('SELECT couple.*, discipline.name AS discipline, `group`.name AS `group` FROM ((couple JOIN discipline ON discipline.id=couple.discipline_id) JOIN schedule ON schedule.id=couple.schedule_id) JOIN `group` ON `group`.id=schedule.group_id WHERE couple.user_id=? AND couple.week=?');
		$stmt->bind_param('is', $teacher_id, $week);

		if (!$stmt->execute()) {
			throw new Exception('Не удалось получить список пар у преподавателя.');
		}

		return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
	}

	function handle_add_couple_form() {
		$this->check_add_couple_fields();
		$this->add_couple();
	}

	function check_add_couple_fields() {
		if (!array_key_exists('discipline', $_POST) || empty($_POST['discipline'])) {
			throw new Exception('Пожалуйста, заполните поле "дисциплина".');
		}

		$this->discipline = (int)trim(htmlspecialchars($_POST['discipline']));

		$this->disciplines->get_discipline($this->discipline);

		if (!array_key_exists('teacher', $_POST) || empty($_POST['teacher'])) {
			throw new Exception('Пожалуйста, заполните поле "преподаватель".');
		}

		$this->teacher = (int)trim(htmlspecialchars($_POST['teacher']));

		$this->users->get_teacher($this->teacher);

		if (!array_key_exists('auditory', $_POST)) {
			throw new Exception('Пожалуйста, заполните поле "название".');
		}

		$this->auditory = trim(htmlspecialchars($_POST['auditory']));
		$this->auditory = empty($this->auditory) ? null : $this->auditory;
	}

	function add_couple() {
		$id            = max((int)$_GET['id'], 0);
		$week          = trim(htmlspecialchars($_GET['week']));
		$weekday_index = max((int)$_GET['weekday_index'], 0);
		$couple_index  = max((int)$_GET['couple_index'], 0);

		$stmt = $this->db->prepare('INSERT INTO couple(discipline_id, user_id, schedule_id, auditory, week, weekday_index, couple_index) VALUES(?, ?, ?, ?, ?, ?, ?)');
		$stmt->bind_param('iiissii', $this->discipline, $this->teacher, $id, $this->auditory, $week, $weekday_index, $couple_index);

		if (!$stmt->execute()) {
			throw new Exception('Не удалось добавить пару в расписание.');
		}

		header('Location: /administration/schedules/couples/day/index.php?id='.$id.'&week='.$week.'&weekday_index='.$weekday_index);
		die();
	}

	function handle_edit_couple_form() {
		$this->check_add_couple_fields();
		$this->edit_couple();
	}

	function edit_couple() {
		$id     = max((int)$_GET['id'], 0);
		$couple = $this->get_couple($id);

		if (!$this->diff_couple_fields($couple)) {
			throw new Exception('Ничего не изменилось.');
		}

		$stmt = $this->db->prepare('UPDATE couple SET discipline_id=?, user_id=?, auditory=? WHERE id=?');
		$stmt->bind_param('iisi', $this->discipline, $this->teacher, $this->auditory, $id);

		if (!$stmt->execute()) {
			throw new Exception('Не удалось сохранить данные.');
		}

		header('Location: /administration/schedules/couples/day/index.php?id='.$couple['schedule_id'].'&week='.$couple['week'].'&weekday_index='.$couple['weekday_index']);
		die();
	}

	function diff_couple_fields($couple) {
		return ($couple['discipline_id'] != $this->discipline) || ($schedule['user_id'] != $this->teacher) || ($schedule['auditory'] != $this->auditory);
	}

	function handle_delete_couple_form() {
		$id     = max((int)$_GET['id'], 0);
		$couple = $this->get_couple($id);

		$stmt = $this->db->prepare('DELETE FROM couple WHERE id=?');
		$stmt->bind_param('i', $couple['id']);

		if (!$stmt->execute()) {
			throw new Exception('Не удалось удалить пару в расписании.');
		}

		header('Location: /administration/schedules/couples/day/index.php?id='.$couple['schedule_id'].'&week='.$couple['week'].'&weekday_index='.$couple['weekday_index']);
		die();
	}
}

?>