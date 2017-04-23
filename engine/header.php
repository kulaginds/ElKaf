<?php

require_once(__DIR__.'/config.php');
require_once(__DIR__.'/modules/smarty/Smarty.class.php');
require_once(__DIR__.'/modules/auth/auth.php');

// инициализирую подключение к БД
mysqli_report(MYSQLI_REPORT_ALL ^ MYSQLI_REPORT_STRICT);

$db = null;

try {
	$db = new mysqli($config['db']['host'], $config['db']['user'], $config['db']['password'], $config['db']['name']);
} catch (mysqli_sql_exception $e) {
	print "<b>Ошибка</b>: не удалось подключиться к БД.";
	die();
}

$db->set_charset('utf8');

// создам папку для скомпиленных шаблонов, если нужно
if (!is_dir(__DIR__.'/templates_c/')) {
	mkdir(__DIR__.'/templates_c/');
}

// инициализация шаблонизатора
$smarty = new Smarty();
$smarty->template_dir = __DIR__.'/templates/';
$smarty->compile_dir = __DIR__.'/templates_c/';

// инициализация меню
$menu = $config['template']['menu']['all'];

// инициализация модуля авторизации
try {
	$auth = new Auth($smarty, $db, $config['security']['auth_salt']);
	
	if ($auth->is_auth()) {
		$menu = array_merge($menu, $config['template']['menu'][$auth->get_user()['type']]);
	}
} catch (Exception $e) {
	$smarty->assign('error', $e->getMessage());
}

$config['template']['menu'] = $menu;

// подключаю параметры шаблона из конфига
$smarty->assign('config', $config['template']);

// включаю буферизацию вывода
ob_start();

?>