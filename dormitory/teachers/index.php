<?php

$access = 'student';

include(__DIR__.'/../../engine/header.php');
require_once(__DIR__.'/../../engine/modules/users/users.php');

$users        = new Users($db, $smarty, $config['user_types'], $config['security']['auth_salt']);
$teacher_list = null;

try {
	$teacher_list = $users->get_teacher_list();
} catch (Exception $e) {
	$smarty->assign('error', $e->getMessage());
}

$smarty->assign('teacher_list', $teacher_list);

$smarty->display('pages/dormitory/teachers/index.tpl');

include(__DIR__.'/../../engine/footer.php');

?>