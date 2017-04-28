<?php

$access = 'administrator';

include(__DIR__.'/../../../engine/header.php');
require_once(__DIR__.'/../../../engine/modules/users/users.php');
require_once(__DIR__.'/../../../engine/modules/groups/groups.php');

$users        = new Users($db, $smarty, $config['user_types'], $config['security']['auth_salt']);
$groups       = new Groups($db, $users);
$id           = max((int)$_GET['id'], 0);
$group        = null;
$student_list = null;

try {
	$groups->handle_actions();
} catch (Exception $e) {
	$smarty->assign('error', $e->getMessage());
}

try {
	$group        = $groups->get_group($id);
	$student_list = $users->get_students_not_in_group($id);
} catch (Exception $e) {
	$smarty->assign('error', $e->getMessage());
}

$smarty->assign('group', $group);
$smarty->assign('student_list', $student_list);

$smarty->display('pages/administration/groups/students/add.tpl');

include(__DIR__.'/../../../engine/footer.php');

?>