<?php

$access = 'administrator';

include(__DIR__.'/../../../engine/header.php');
require_once(__DIR__.'/../../../engine/modules/users/users.php');
require_once(__DIR__.'/../../../engine/modules/disciplines/disciplines.php');

$users        = new Users($db, $smarty, $config['user_types'], $config['security']['auth_salt']);
$disciplines  = new Disciplines($db, $users);
$discipline   = null;
$teacher_list = null;
$id           = max((int)$_GET['id'], 0);

try {
	$discipline   = $disciplines->get_discipline($id);
	$teacher_list = $users->get_teachers_in_discipline($id);
} catch (Exception $e) {
	$smarty->assign('error', $e->getMessage());
}

$smarty->assign('discipline', $discipline);
$smarty->assign('teacher_list', $teacher_list);
$smarty->assign('page', $disciplines->page);
$smarty->assign('count', $disciplines->discipline_list_count);
$smarty->assign('limit', $disciplines->discipline_list_limit);

$smarty->display('pages/administration/disciplines/teachers/index.tpl');

include(__DIR__.'/../../../engine/footer.php');

?>