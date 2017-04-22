<?php

require_once(__DIR__.'/config.php');
require_once(__DIR__.'/modules/smarty/Smarty.class.php');

$smarty = new Smarty();
$smarty->template_dir = __DIR__.'/templates/';
$smarty->compile_dir = __DIR__.'/templates_c/';
$smarty->assign('config', $config['template']);

ob_start();

?>