<?php

$access = 'administrator';

include(__DIR__.'/../../engine/header.php');
require_once(__DIR__.'/../../engine/modules/users/users.php');
require_once(__DIR__.'/../../engine/modules/groups/groups.php');

$users      = new Users($db, $smarty, $config['user_types'], $config['security']['auth_salt']);
$groups     = new Groups($db, $users);
$group      = null;
$student    = null;
$id         = max((int)$_GET['id'], 0);
$student_id = max((int)$_GET['student_id'], 0);

try {
	$groups->handle_actions();
} catch (Exception $e) {
	$smarty->assign('error', $e->getMessage());
}

try {
	$group   = $groups->get_group($id);
	$student = $users->get_student($student_id);
} catch (Exception $e) {
	$smarty->assign('error', $e->getMessage());
}

$smarty->assign('group', $group);
$smarty->assign('student', $student);

$smarty->display('pages/groups/students/delete.tpl');

include(__DIR__.'/../../engine/footer.php');

?>