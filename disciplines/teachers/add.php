<?php

include(__DIR__.'/../../engine/header.php');
require_once(__DIR__.'/../../engine/modules/users/users.php');
require_once(__DIR__.'/../../engine/modules/disciplines/disciplines.php');

$users        = new Users($db, $smarty, $config['user_types'], $config['security']['auth_salt']);
$disciplines  = new Disciplines($db, $smarty, $users);
$id           = max((int)$_GET['id'], 0);
$discipline   = null;
$teacher_list = null;

try {
	$disciplines->handle_actions();
} catch (Exception $e) {
	$smarty->assign('error', $e->getMessage());
}

try {
	$discipline   = $disciplines->get_discipline($id);
	$teacher_list = $users->get_teachers_not_in_discipline($id);
} catch (Exception $e) {
	$smarty->assign('error', $e->getMessage());
}

$smarty->assign('discipline', $discipline);
$smarty->assign('teacher_list', $teacher_list);

$smarty->display('pages/disciplines/teachers/add.tpl');

include(__DIR__.'/../../engine/footer.php');

?>