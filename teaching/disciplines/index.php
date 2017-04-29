<?php

$access = 'teacher';

include(__DIR__.'/../../engine/header.php');
require_once(__DIR__.'/../../engine/modules/users/users.php');
require_once(__DIR__.'/../../engine/modules/disciplines/disciplines.php');

$users           = new Users($db, $smarty, $config['user_types'], $config['security']['auth_salt']);
$disciplines     = new Disciplines($db, $users);
$discipline_list = null;

try {
	$discipline_list = $disciplines->get_teacher_discipline_list($auth->get_user()['id']);
} catch (Exception $e) {
	$smarty->assign('error', $e->getMessage());
}

$smarty->assign('discipline_list', $discipline_list);
$smarty->assign('page', $disciplines->page);
$smarty->assign('count', $disciplines->discipline_list_count);
$smarty->assign('limit', $disciplines->discipline_list_limit);

$smarty->display('pages/teaching/disciplines/index.tpl');

include(__DIR__.'/../../engine/footer.php');

?>