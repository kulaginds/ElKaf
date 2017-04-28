<?php

$access = 'administrator';

include(__DIR__.'/../../../engine/header.php');
require_once(__DIR__.'/../../../engine/modules/users/users.php');
require_once(__DIR__.'/../../../engine/modules/disciplines/disciplines.php');

$users       = new Users($db, $smarty, $config['user_types'], $config['security']['auth_salt']);
$disciplines = new Disciplines($db, $users);
$discipline  = null;
$teacher     = null;
$id          = max((int)$_GET['id'], 0);
$teacher_id  = max((int)$_GET['teacher_id'], 0);

try {
	$disciplines->handle_actions();
} catch (Exception $e) {
	$smarty->assign('error', $e->getMessage());
}

try {
	$discipline = $disciplines->get_discipline($id);
	$teacher    = $users->get_teacher($teacher_id);
} catch (Exception $e) {
	$smarty->assign('error', $e->getMessage());
}

$smarty->assign('discipline', $discipline);
$smarty->assign('teacher', $teacher);

$smarty->display('pages/administration/disciplines/teachers/delete.tpl');

include(__DIR__.'/../../../engine/footer.php');

?>