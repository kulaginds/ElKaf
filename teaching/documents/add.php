<?php

$access = 'teacher';

include(__DIR__.'/../../engine/header.php');
require_once(__DIR__.'/../../engine/modules/users/users.php');
require_once(__DIR__.'/../../engine/modules/disciplines/disciplines.php');
require_once(__DIR__.'/../../engine/modules/documents/documents.php');

$users           = new Users($db, $smarty, $config['user_types'], $config['security']['auth_salt']);
$disciplines     = new Disciplines($db, $users);
$documents       = new Documents($db, $auth, $users, $disciplines, $config['documents']['allowed_types'], $config['documents']['upload_dir']);
$discipline_list = null;
$discipline      = null;
$id              = max((int)$_GET['id'], 0);

try {
	$documents->handle_actions();
} catch (Exception $e) {
	$smarty->assign('error', $e->getMessage());
}

try {
	$discipline_list = $disciplines->get_teacher_discipline_list($auth->get_user()['id']);
} catch (Exception $e) {
	$smarty->assign('error', $e->getMessage());
}

try {
	$discipline = $disciplines->get_discipline($id);
	$smarty->assign('ydiscipline', $discipline);
} catch (Exception $e) {}

$smarty->assign('discipline_list', $discipline_list);
$smarty->assign('discipline', $documents->discipline);
$smarty->assign('max_file_size', min(ini_get('post_max_size'), ini_get('upload_max_filesize')));
$smarty->assign('allowed_types', array_keys($config['documents']['allowed_types']));

$smarty->display('pages/teaching/documents/add.tpl');

include(__DIR__.'/../../engine/footer.php');

?>