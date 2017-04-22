<?php

// инициализация конфига
$config = array();

/*
	Параметры шаблона
*/
$config['template'] = array();
$config['template']['title'] = 'Программная система "Электронная кафедра"';
$config['template']['header'] = array(
	'title' => 'Электронная кафедра',
	'slogan' => 'программная система',
);
$config['template']['menu'] = array(
	array(
		'href' => '#',
		'title' => 'Главная',
	),
	array(
		'href' => '#',
		'title' => 'Вход',
	),
	array(
		'href' => '#',
		'title' => 'Регистрация',
	),
);

?>