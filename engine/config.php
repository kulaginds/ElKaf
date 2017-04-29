<?php

// инициализация конфига
$config = array();

/*
	Параметры подключения к БД
*/
$config['db']             = array();
$config['db']['host']     = 'localhost';
$config['db']['user']     = 'root';
$config['db']['password'] = '123456';
$config['db']['name']     = 'elkaf';

/*
	Параметры безопасности
*/
$config['security']['auth_salt'] = 'j1{1yGh9+$^+y=E_CQSzDM+(v#TAbGx-$yvup006r]M%w,!]nC[{vj7(!-C+^;Sm';

/*
	Типы пользователей
*/
$config['user_types'] = array(
	'administrator' => 'Администратор',
	'teacher'       => 'Преподаватель',
	'student'       => 'Студент',
);

/*
	Разделы пользователей
*/
$config['user_sections'] = array(
	'administrator' => '/administration/index.php',
	'teacher'       => '/teaching/index.php',
	'student'       => '/dormitory/index.php',
);

/*
	Настройки расписаний
*/
$config['schedules'] = array();
$config['schedules']['weeks'] = array(
	'odd'  => 'нечётная неделя',
	'even' => 'чётная неделя'
);
$config['schedules']['weekdays'] = array(
	'понедельник',
	'вторник',
	'среда',
	'четверг',
	'пятница',
	'суббота',
);
$config['schedules']['couples'] = array(
	array('08:30', '10:00'),
	array('10:10', '11:40'),
	array('11:50', '13:20'),
	array('14:00', '15:30'),
	array('15:40', '17:10'),
	array('17:20', '18:50'),
	array('19:00', '20:30'),
	array('20:40', '22:10'),
);

/*
	Настройки документов
*/
$config['documents']['allowed_types'] = array(
	'.pdf'  => 'application/pdf',
	'.doc'  => 'application/msword',
	'.ppt'  => 'application/vnd.ms-powerpoint',
	'.docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
	'.pptx' => 'application/vnd.openxmlformats-officedocument.presentationml.presentation',
	'.odt'  => 'application/vnd.oasis.opendocument.text',
	'.txt'  => 'text/plain',
);
$config['documents']['upload_dir'] = __DIR__.'/documents/';

/*
	Параметры шаблона
*/
$config['template']           = array();
$config['template']['title']  = 'Программная система "Электронная кафедра"';
$config['template']['header'] = array(
	'title'  => 'Электронная кафедра',
	'slogan' => 'программная система',
);
$config['template']['menu']   = array(
	'all' => array(
		array(
			'href'  => '/index.php',
			'title' => 'Главная',
		),
	),
	'administrator' => array(
		array(
			'href'  => '/administration/index.php',
			'title' => 'Главная',
		),
		array(
			'href'  => '/administration/users/index.php',
			'title' => 'Пользователи',
		),
		array(
			'href'  => '/administration/disciplines/index.php',
			'title' => 'Дисциплины',
		),
		array(
			'href'  => '/administration/groups/index.php',
			'title' => 'Группы',
		),
		array(
			'href'  => '/administration/schedules/index.php',
			'title' => 'Расписания',
		),
		array(
			'href'  => '/administration/documents/index.php',
			'title' => 'Документы',
		),
		array(
			'href'  => '/index.php?action=logout',
			'title' => 'Выйти',
		),
	),
	'teacher' => array(
		array(
			'href'  => '/teaching/index.php',
			'title' => 'Главная',
		),
		array(
			'href'  => '/teaching/schedule/index.php',
			'title' => 'Моё расписание',
		),
		array(
			'href'  => '/teaching/disciplines/index.php',
			'title' => 'Мои дисциплины',
		),
		array(
			'href'  => '/teaching/documents/index.php',
			'title' => 'Мои Документы',
		),
		array(
			'href'  => '/index.php?action=logout',
			'title' => 'Выйти',
		),
	),
	'student' => array(
		array(
			'href'  => '/dormitory/index.php',
			'title' => 'Главная',
		),
		array(
			'href'  => '/dormitory/schedule/index.php',
			'title' => 'Моё расписание',
		),
		array(
			'href'  => '/dormitory/teachers/index.php',
			'title' => 'Преподаватели кафедры',
		),
		array(
			'href'  => '/dormitory/disciplines/index.php',
			'title' => 'Дисциплины кафедры',
		),
		array(
			'href'  => '/index.php?action=logout',
			'title' => 'Выйти',
		),
	),
);

?>