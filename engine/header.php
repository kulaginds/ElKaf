<?php

require_once(__DIR__.'/config.php');
require_once(__DIR__.'/modules/smarty/Smarty.class.php');

// создам папку для скомпиленных шаблонов, если нужно
if (!is_dir(__DIR__.'/templates_c/')) {
	mkdir(__DIR__.'/templates_c/');
}

// инициализация шаблонизатора
$smarty = new Smarty();
$smarty->template_dir = __DIR__.'/templates/';
$smarty->compile_dir = __DIR__.'/templates_c/';

// подключаю параметры шаблона из конфига
$smarty->assign('config', $config['template']);

// включаю буферизацию вывода
ob_start();

?>