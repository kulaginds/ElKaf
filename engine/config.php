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
			'href'  => '/users/index.php',
			'title' => 'Пользователи',
		),
		array(
			'href'  => '/disciplines/index.php',
			'title' => 'Дисциплины',
		),
		array(
			'href'  => '/groups/index.php',
			'title' => 'Группы',
		),
		array(
			'href'  => '/schedules/index.php',
			'title' => 'Расписания',
		),
		array(
			'href'  => '/documents/index.php',
			'title' => 'Документы',
		),
		array(
			'href'  => '/index.php?action=logout',
			'title' => 'Выйти',
		),
	),
	'teacher' => array(
		array(
			'href'  => '/index.php?action=logout',
			'title' => 'Выйти',
		),
	),
	'student' => array(
		array(
			'href'  => '/index.php?action=logout',
			'title' => 'Выйти',
		),
	),
);

?>